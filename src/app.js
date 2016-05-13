var app = angular.module("app", ["firebase","ngCookies"]);
app
.controller("nav",function($scope, $firebaseObject,$http,$cookieStore){
  $scope.ng_login=function(){
    if($scope.id!=""&&$scope.pw!=""){
      $http.get("/func/login_data_func/"+$scope.id+"/"+$scope.pw).then(function(res){
        if(res.data.UID){
          $cookieStore.put("uid",res.data.UID);
          if($scope.check==true){
            $cookieStore.put("auto_login",res.data.UID);
          }
          location.href="/func/login_func/"+res.data.UID;
        }else{
          alert("닉네임과 비밀번호를 확인해주세요");
        }
      });
    }
    // $scope.id $scope.pw
  }
  $http.get("/data/get_vote_menu").then(function(res){
    $scope.category=res.data;
  });
})
.controller("join",function($scope, $http){
  $scope.name_check=function(){
    $scope.double_check=false;
    $http.get("/func/name_check/"+$scope.name).then(function(res){
      if(res.data.result){
        $scope.name_check_result=true;
      }else{
        $scope.name_check_result=false;
      }
    });
  }
  $scope.ng_submit=function(){
    if($scope.password==$scope.password2&&$scope.double_check==false&&$scope.password!=""&&$scope.name!=""){
      $("form").submit();
    }
  }
}).controller("admin.vote",function($scope,$http){
  var render_big_subject=function(){
    $http.get("/data/get_big_subjects").then(function(res){
      $scope.big_subjects=res.data;
    });
  }
  var render_small_subject=function(){
    var bs=$scope.currentVote.big;
    $http.get("/data/get_small_subjects/"+bs.BSID).then(function(res){
      $scope.small_subjects=res.data;
    });
  }
  var render_person=function(){
    if(!$scope.currentVote.small){
      $scope.people={};
      return;
    }
    var ssid=$scope.currentVote.small.SSID;
    $http.get("/data/get_people/"+ssid).then(function(res){
      $scope.people=res.data;
    });
  }
  $scope.add_big_subject=function(){
    $http.get("/func/add_big_subject/"+$scope.big_subject);
    $scope.big_subject="";
    render_big_subject();
    alert("대주제 추가 완료");
  }
  $scope.bs_select=function(bs){
    $scope.currentVote={};
    $scope.currentVote.big=bs;
    render_small_subject();
    render_person();
  }
  $scope.ss_select=function(ss){
    $scope.currentVote.small=ss;
    render_person();
  }
  $scope.add_small_subject=function(ss_modal){
    $http.get("/func/add_small_subject/"+$scope.currentVote.big.BSID+"/"+ss_modal.name_ko+"/"+ss_modal.name_eng+"/"+(ss_modal.check==true?true:false));
    $scope.ss_modal={};
    $("#small_modal").modal('hide');
    render_small_subject();
    alert("소주제 추가 완료");
  }
  $scope.add_person=function(person){
    person.profile=$("#profile").summernote('code');
    person.ssid=$scope.currentVote.small.SSID;
    $http.post("/func/add_person",person).then(function(res){
      console.log(res.data);
    });
    $("#user_add_modal").modal('hide');
    alert("인물 추가 완료");
    $("#profile").summernote('reset');
    $scope.person_modal={};
    render_person();
  }
  render_big_subject();
})
.controller("admin.notice",function($scope,$http){
  $scope.addNotice=function(notice){
    notice.body=$("#notice_input").summernote('code');
    $http.post("/func/add_notice",notice);
    $("#notice_modal").modal('hide');
    alert("공지 업로드 완료");
    $("#notice_input").summernote('reset');
    // render_notice();
  }
  var render_notice=function(){
    $(document).ready(function(){
      $('.notice_table').DataTable({
        ordering:  false,
        "ajax": '/data/get_notice',
        "columns": [
          { "data": "TITLE" },
          { "data": "BODY" },
          { "data": "TIME" }
        ]
      });
    });
  }
  render_notice();
})
.controller("notice",function($scope,$http){
  $http.get("/data/get_notice").then(function(res){
    $scope.notices=res.data.data;
  });
})
.controller("vote",function($scope,$http,$firebaseObject,$cookieStore){
  var connectVoteInfo=function(){
    var ref = new Firebase("https://projectg2016.firebaseio.com/person");
    $scope.vote.left=$firebaseObject(ref.child($scope.vote.leftPID));
    $scope.vote.right=$firebaseObject(ref.child($scope.vote.rightPID));
  };
  var reload=function(){
    $http.get("/data/get_random_2/"+$scope.vote.ssid).then(function(res){
      $scope.vote.left=res.data[0];
      $scope.vote.leftPID=$scope.vote.left.PID;
      $scope.vote.right=res.data[1];
      $scope.vote.rightPID=$scope.vote.right.PID;
      $("#leftIMG").removeClass('fadeOut').removeClass('pulse').addClass('zoomIn');
      $("#rightIMG").removeClass('fadeOut').removeClass('pulse').addClass('zoomIn');
      connectVoteInfo();
      $scope.voteFlag=true;
    });
  };
  $scope.init=function(){
    $http.get("/data/get_ssid_info/"+$scope.vote.ssid).then(function(res){
      $scope.vote.SSNAME=res.data.NAME_KOR;
      $scope.vote.SSNAME_ENG=res.data.NAME_ENG;
    });
    $http.get("/data/get_random_ssid_all").then(function(res){
      $http.get("/data/get_ssid_info/"+res.data.SSID).then(function(res){
        $scope.otherSS=res.data;
      });
    });
    connectVoteInfo();
    var ref = new Firebase("https://projectg2016.firebaseio.com/totalVote");
    $scope.vote.totalVote=$firebaseObject(ref);
  }
  $scope.select=function(pid,side){
    if($scope.voteFlag==false)return;

    //누가 이겼는지
    var winner=pid;
    var loser;
    if($scope.vote.leftPID==pid){
      loser=$scope.vote.rightPID;
    }else{
      loser=$scope.vote.leftPID;
    }

    //투표 통계
    $scope.voteFlag=false;
    var result={
      "pid1": Math.min($scope.vote.leftPID,$scope.vote.rightPID),
      "pid2": Math.max($scope.vote.leftPID,$scope.vote.rightPID),
      "result": pid
    };
    $http.post("/data/get_result_stat",result).then(function(res){
      res.data.show=true;
      $scope.vote.vote_result=res.data;
      $scope.before={};
      if($scope.vote.leftPID==pid){
        $scope.before.winner=$scope.vote.left.name;
        $scope.before.loser=$scope.vote.right.name;
      }else{
        $scope.before.loser=$scope.vote.left.name;
        $scope.before.winner=$scope.vote.right.name;
      }

    });

    //선택효과
    if(side=='left'){
      $("#leftIMG").removeClass('zoomIn').addClass('pulse');
      $("#rightIMG").removeClass('zoomIn').addClass('fadeOut');
    }
    if(side=='right'){
      $("#rightIMG").removeClass('zoomIn').addClass('pulse');
      $("#leftIMG").removeClass('zoomIn').addClass('fadeOut');
    }

    //결과 전송
    var result={
      "uid": $cookieStore.get("uid"),
      "lid": "12",
      "ssid": $scope.vote.ssid,
      "pid1": Math.min($scope.vote.leftPID,$scope.vote.rightPID),
      "pid2": Math.max($scope.vote.leftPID,$scope.vote.rightPID),
      "result": pid
    };
    $http.post("/func/add_vote_result",result);

    //총투표수 증가
    var ref = new Firebase("https://projectg2016.firebaseio.com/totalVote");
    ref.transaction(function(vote) {
      return vote+1;
    });
    //승자의 포인트 증가
    var ref = new Firebase("https://projectg2016.firebaseio.com/person");
    ref.child(winner).child("win").transaction(function(vote) {
      return vote+1;
    });
    ref.child(winner).child("total").transaction(function(vote) {
      return vote+1;
    });
    //패자의 포인트 증감
    ref.child(loser).child("lose").transaction(function(vote) {
      return vote+1;
    });
    ref.child(loser).child("total").transaction(function(vote) {
      return vote-1;
    });

    //mysql total에 업데이트
    $http.get("/data/minus_to_total/"+loser+"/1");
    $http.get("/data/add_to_total/"+winner+"/1");

    //다음꺼 준비
    setTimeout(reload,3000);
  }

  $scope.giveHeart=function(pid){
    $scope.heartModal={};
    $scope.heartModal.pid=pid;
    var ref = new Firebase("https://projectg2016.firebaseio.com/user");
    ref.child($cookieStore.get("uid")).child("vote_point").once("value",function(snapshot){
      $scope.heartModal.maxPoint=snapshot.val();
      $("#heartModal").modal('show');
    });
  }
  $scope.giveX=function(pid){
    $scope.XModal={};
    $scope.XModal.pid=pid;
    var ref = new Firebase("https://projectg2016.firebaseio.com/user");
    ref.child($cookieStore.get("uid")).child("vote_point").once("value",function(snapshot){
      $scope.XModal.maxPoint=snapshot.val();
      $("#XModal").modal('show');
    });
  }
  $scope.sendHeart=function(){
    if($scope.heartModal.point>$scope.heartModal.maxPoint){
      alert('최대 기부 가능 포인트를 초과했습니다');
      return;
    }
    var sendPoint=$scope.heartModal.point;
    if(!$.isNumeric(sendPoint)){
      alert('숫자만 입력해주세요');
      return;
    }
    var ref = new Firebase("https://projectg2016.firebaseio.com/user");
    ref.child($cookieStore.get("uid")).child("vote_point").transaction(function(point) {
      return point-sendPoint;
    });
    var ref = new Firebase("https://projectg2016.firebaseio.com/person");
    ref.child($scope.heartModal.pid).child("heart").transaction(function(point) {
      return point+sendPoint;
    });
    ref.child($scope.heartModal.pid).child("total").transaction(function(point) {
      return point+sendPoint;
    });
    var data={
      "uid":$cookieStore.get("uid"),
      "pid":$scope.heartModal.pid,
      "point":sendPoint,
      "plus":1 //true
    };
    $http.post("/data/give_donation",data);
    $http.get("/data/add_to_total/"+$scope.heartModal.pid+"/"+sendPoint);
    $scope.heartModal={};
    $("#heartModal").modal('hide');
    alert('기부가 완료되었습니다');
  }
  $scope.sendX=function(){
    if($scope.XModal.point>$scope.XModal.maxPoint){
      alert('최대 기부 가능 포인트를 초과했습니다');
      return;
    }
    var sendPoint=$scope.XModal.point;
    if(!$.isNumeric(sendPoint)){
      alert('숫자만 입력해주세요');
      return;
    }
    var ref = new Firebase("https://projectg2016.firebaseio.com/user");
    ref.child($cookieStore.get("uid")).child("vote_point").transaction(function(point) {
      return point-sendPoint;
    });
    var ref = new Firebase("https://projectg2016.firebaseio.com/person");
    ref.child($scope.XModal.pid).child("x").transaction(function(point) {
      return point+sendPoint;
    });
    ref.child($scope.XModal.pid).child("total").transaction(function(point) {
      return point+sendPoint;
    });
    var data={
      "uid":$cookieStore.get("uid"),
      "pid":$scope.XModal.pid,
      "point":sendPoint,
      "plus":0 //false
    };
    $http.post("/data/give_donation",data);
    $http.get("/data/minus_to_total/"+$scope.XModal.pid+"/"+sendPoint);
    $scope.XModal={};
    $("#XModal").modal('hide');
    alert('기부가 완료되었습니다');
  }
})
.controller("ranking_all",function($scope,$http,$firebaseObject){
  var ref = new Firebase("https://projectg2016.firebaseio.com/person");
  $scope.gotoPerson=function(ss,name){
    location.href="/"+ss+"/"+name;
  }
  var count=0;
  $http.get("/data/get_all_rank/"+count).then(function(res){
    for(var i in res.data){
      if(i=="contains")continue;
      res.data[i].realtime={};
      res.data[i].realtime=$firebaseObject(ref.child(res.data[i].pid));
    }
    $scope.table=res.data;
  });
  $scope.loadMore=function(){
    count=count+20;
    $http.get("/data/get_all_rank/"+count).then(function(res){
      for(var i in res.data){
        if(i=="contains")continue;
        res.data[i].realtime={};
        res.data[i].realtime=$firebaseObject(ref.child(res.data[i].pid));
      }
      $scope.table=$scope.table.concat(res.data);
    });
  }
  $(window).scroll(function() {
    if($(window).scrollTop() == $(document).height() - $(window).height()) {
      console.log("retrieving new data");
      $scope.loadMore();
    }
  });



})
.controller("ranking_ss",function($scope,$http,$firebaseObject){
  var ref = new Firebase("https://projectg2016.firebaseio.com/person");
  $scope.gotoPerson=function(ss,name){
    location.href="/"+ss+"/"+name;
  }
  var count=0;
  $scope.init=function(){
    $http.get("/data/get_ss_rank/"+$scope.ssid+"/"+count).then(function(res){
      for(var i in res.data){
        if(i=="contains")continue;
        res.data[i].realtime={};
        res.data[i].realtime=$firebaseObject(ref.child(res.data[i].pid));
      }
      $scope.table=res.data;
    });
  }

  $scope.loadMore=function(){
    count=count+20;
    $http.get("/data/get_ss_rank/"+$scope.ssid+"/"+count).then(function(res){
      for(var i in res.data){
        if(i=="contains")continue;
        res.data[i].realtime={};
        res.data[i].realtime=$firebaseObject(ref.child(res.data[i].pid));
      }
      $scope.table=$scope.table.concat(res.data);
    });
  }
  $(window).scroll(function() {
    if($(window).scrollTop() == $(document).height() - $(window).height()) {
      console.log("retrieving new data");
      $scope.loadMore();
    }
  });
})
.controller("ss_sitemap",function($scope,$http,$firebaseObject){



})
.controller("person",function($scope,$http,$firebaseObject,$cookieStore){
  $scope.init=function(){
    $http.get("/data/get_auth_profile/"+$scope.pid).then(function(res){
      console.log(res.data);
      if(res.data.uid==$cookieStore.get("uid")){
        $scope.userAssess_auth=true;
      }else{
        $scope.userAssess_auth=false;
      }
    });
  }




});
