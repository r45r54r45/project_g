var app = angular.module("app", ["firebase","ngCookies","ngSanitize"]);
app
.service('levelService',function(){
  this.findLevel=function(level_point){
    var dist=[100,200,300,400,500,600,700,800,900,1000,1200,1400,1600,1800,2000,2200,2400,2600,2800,3000,3300,3600,3900,4200,4500,4800,5100,5400,5700,6000,6400,6800,7200,7600,8000,8400,8800,9200,9600,10000,10500,11000,11500,12000,12500,13000,13500,14000,14500,15000,15600,16200,16800,17400,18000,18600,19200,19800,20400,21000,21700,22400,23100,23800,24500,25200,25900,26600,27300,28000,28800,29600,30400,31200,32000,32800,33600,34400,35200,36000,36900,37800,38700,39600,40500,41400,42300,43200,44100,45000,46000,47000,48000,49000,50000,51000,52000,53000,54000];

    var level=dist.findIndex(function(num){
      return num>level_point;
    });
    return level;
  }
  this.findDN=function(level){
    if(level<10)return 1;
    else if(level<30)return 2;
    else if(level<60)return 3;
    else if(level<90)return 4;
    else{
      return 5;
    }
  }
})
.controller("nav",function($scope, $firebaseObject,$firebaseArray,$http,$cookies,$rootScope,levelService){

  $scope.init=function(){
    console.log("logined: "+$scope.uid);
    if($scope.uid!=''){
      $("#userDropdown").css("width",'200px').css("padding","5px 5px");
      $http.get("/data/get_user_info/"+$scope.uid).then(function(res){
        $scope.userName=res.data.NAME;
        $scope.userTime=new Date(res.data.TIME);
      });
      var ref = new Firebase("https://projectg2016.firebaseio.com/user");
      $scope.user=$firebaseObject(ref.child($scope.uid));
      $scope.user.$loaded().then(function(data){
        $scope.user.level=levelService.findLevel(data.level_point);
      });

      //alarm 부분
      var ref = new Firebase("https://projectg2016.firebaseio.com/user").child($cookies.get('uid')).child("alert");
      $scope.alarm=$firebaseArray(ref.orderByChild('read').equalTo(false));
      $scope.alarm.$loaded(function(res){
        $scope.alarm.sort(function (a, b) {
          if (a.$priority < b.$priority) {
            return 1;
          }
          if (a.$priority > b.$priority) {
            return -1;
          }
          return 0;
        });
        $scope.alarmArr=[];
        for(var i=0; i<$scope.alarm.length; i++){
          $http.get("/data/get_user_info_with_index/"+$scope.alarm[i].uid+"/"+i).then(function(res){
            $scope.alarmArr[res.data.index]=res.data.NAME;
          });
        }

      });
      $scope.alarm.$watch(function(){
        $scope.alarm.sort(function (a, b) {
          if (a.$priority < b.$priority) {
            return 1;
          }
          if (a.$priority > b.$priority) {
            return -1;
          }
          return 0;
        });
        $scope.alarmArr=[];
        for(var i=0; i<$scope.alarm.length; i++){
          $http.get("/data/get_user_info_with_index/"+$scope.alarm[i].uid+"/"+i).then(function(res){
            $scope.alarmArr[res.data.index]=res.data.NAME;
          });
        }
      });
      $scope.deleteAlarm=function(idx){
        var target=$scope.alarm[idx];
        var ref = new Firebase("https://projectg2016.firebaseio.com/user").child($cookies.get('uid')).child("alert").child(target.$id).child("read").transaction(function(data){
          return !data;
        });
      }
      $scope.clickAlarm=function(ala,idx){
        $scope.deleteAlarm(idx);
        location.href="/reply/alarm?pid="+ala.pid+"&rid="+ala.rid+"#reply_start";
      }
      $scope.hint=[];
      $http.get("/data/get_all_people_name").then(function(res){
        $scope.hintArr=res.data;
        for(var i in $scope.hintArr){
          $scope.hint.push($scope.hintArr[i].NAME);
        }

        $('#test').autocomplete({
          source: $scope.hint,
          select: function (event, ui) {
            //아이템 선택시 처리 코드
            var result=$.grep($scope.hintArr, function(e){ return e.NAME == ui.item.value; });
            if (result.length == 0) {
              // not found
            } else if (result.length == 1) {                  location.href="/"+result[0].NAME_ENG+"/"+result[0].NAME;
          } else {
            // multiple items found
          }
        },
        selectFirst: true,
        minLength: 1,
        open: function () {
          $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
        },
        close: function () {
          $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
        }
      });


    });
  }else{
    // $scope.user.level="00";
  }
}


$scope.ng_login=function(){
  if($scope.id!=""&&$scope.pw!=""){
    $http.get("/func/login_data_func/"+$scope.id+"/"+$scope.pw).then(function(res){
      if(res.data.UID){
        $cookies.put("uid",res.data.UID);
        if($scope.check==true){
          $cookies.put("auto_login",res.data.UID,{expires: new Date('Sun May 01 2033 20:04:09 GMT+0900')});
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
$scope.getOut=function(){
  //TODO 탈퇴기능
  confirm("탈퇴하시면 포인트가 모두 삭제됩니다. 그래도 탈퇴하시겠습니까?");
}
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
    if($scope.password==$scope.password2&&$scope.double_check==false&&$scope.password!=""&&$scope.join.name!=""&&$scope.join.sex&&$scope.join.age!=''&&$scope.join.age){
      $scope.join.pw=$scope.password;
      $http.get('http://api.ipinfodb.com/v3/ip-city/?key=c95fb579c19c79692a707cec2512bbd880733a8f4fe2fcd6e81457d456eea70f&format=json').then(function(res){
        $scope.join.loc=res.data.regionName;
        var data=JSON.stringify($scope.join);
        console.log(data);
        $http.post("/func/join_func",data).then(function(res){
          // console.log(res.data);
          var uid=res.data.UID;
          var ref = new Firebase("https://projectg2016.firebaseio.com/user");
          ref.child(uid).set({
            "level_point":100,
            "vote_point":0
          });
          alert('회원가입이 완료되었습니다. 로그인해주세요.');
          location.href="/";
        });
      });
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
.controller("vote",function($scope,$http,$firebaseObject,$cookieStore,$cookies){
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


    var uid;
    if($cookies.get("uid")){
      uid=$cookies.get("uid")
    }else{
      uid=0;
    }

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
      "uid": uid,
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

    //투표했으니 VOTE_POINT 올려주기
    var ref = new Firebase("https://projectg2016.firebaseio.com/user");
    ref.child(uid).child('vote_point').transaction(function(vote) {
      return vote+0.1;
    });
    //다음꺼 준비
    setTimeout(reload,3000);
  }

  $scope.giveHeart=function(pid){
    $scope.heartModal={};
    $scope.heartModal.pid=pid;
    var ref = new Firebase("https://projectg2016.firebaseio.com/user");
    ref.child($cookieStore.get("uid")).child("vote_point").once("value",function(snapshot){
      $scope.heartModal.maxPoint=Math.floor(snapshot.val());
      $("#heartModal").modal('show');
    });
  }
  $scope.giveX=function(pid){
    $scope.XModal={};
    $scope.XModal.pid=pid;
    var ref = new Firebase("https://projectg2016.firebaseio.com/user");
    ref.child($cookieStore.get("uid")).child("vote_point").once("value",function(snapshot){
      $scope.XModal.maxPoint=Math.floor(snapshot.val());
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
    if(sendPoint<1){
      alert('올바른 숫자를 입력해주세요');
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
    if(sendPoint<1){
      alert('올바른 숫자를 입력해주세요');
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
  $http.get("/data/get_bs_byorder").then(function(res){
    $scope.bsList=res.data;
    for(var i=0; i< $scope.bsList.length;i++){
      var bsid=$scope.bsList[i].BSID;
      $http.get("/data/get_ss_byorder/"+bsid).then(function(res){
        var index=$scope.bsList.findIndex(function(x){
          return x.BSID==res.data[0].BSID;
        });
        $scope.bsList[index].ssList=res.data;
      });
    }
  })
})
.controller("sitemap",function($scope,$http,$firebaseObject){
  $http.get("/data/get_bs_byorder").then(function(res){
    $scope.bsList=res.data;
    for(var i=0; i< $scope.bsList.length;i++){
      var bsid=$scope.bsList[i].BSID;
      $http.get("/data/get_ss_byorder/"+bsid).then(function(res){
        var index=$scope.bsList.findIndex(function(x){
          return x.BSID==res.data[0].BSID;
        });
        $scope.bsList[index].ssList=res.data;
      });
    }
  });
})
.controller("person",function($scope,$http,$firebaseObject,$cookieStore,$cookies,levelService,$firebaseArray){
  var customStat=false;
  var renderWinLose=function(win,lose){
    if(win+lose==0){
      $scope.dataLoss=true;
    }else{
      $scope.dataLoss=false;
    }
    $scope.WinLose={};
    $scope.WinLose.winPercent=Math.floor(win/(win+lose)*100);
    $scope.WinLose.losePercent=100-$scope.WinLose.winPercent;
  }
  $scope.prevReplyNum;
  var normalReply=function(num,from){
    var ref = new Firebase("https://projectg2016.firebaseio.com/reply").child($scope.pid);
    if(from==0){
      console.log("first data loaded");
      $scope.replies=$firebaseArray(ref.orderByPriority().limitToFirst(num));
      $scope.replies.$loaded(function(res){
        $scope.prevReplyNum=parseInt(res[res.length-1].$priority);
        // console.log($scope.prevReplyNum);
      });
    }else{
      var tempArr=$firebaseArray(ref.orderByPriority().startAt(from).limitToFirst(num));
      tempArr.$loaded(function(res){
        if(res.length==0)return;
        for(var i=0; i<res.length; i++){
          $scope.replies.push(res[i]);
        }
        $scope.prevReplyNum=parseInt(res[res.length-1].$priority);
      });

    }
  }
  $(window).scroll(function() {
    if($(window).scrollTop() == $(document).height() - $(window).height()) {
      console.log("retrieving new data");
      normalReply(15,$scope.prevReplyNum+1);
    }
  });
  $scope.init=function(){
    $http.get("/data/get_auth_profile/"+$scope.pid).then(function(res){
      console.log(res.data);
      if(res.data.uid==$cookieStore.get("uid")){
        $scope.userAssess_auth=true;
      }else{
        $scope.userAssess_auth=false;
      }
    });
    $http.get("/data/get_person_rank/"+$scope.pid).then(function(res){
      $scope.rankingInfo=res.data;
    });
    var ref = new Firebase("https://projectg2016.firebaseio.com/person");
    $scope.personInfo=$firebaseObject(  ref.child($scope.pid));
    $scope.personInfo.$loaded()
    .then(function(data) {
      renderWinLose($scope.personInfo.win,$scope.personInfo.lose);
      $("#loading").hide();
    });
    $scope.personInfo.$watch(function(){
      if(!customStat){
        renderWinLose($scope.personInfo.win,$scope.personInfo.lose);
      }
    });
    $scope.statData={
      sex:'',
      age:'',
      loc:'',
      pid:$scope.pid
    };
    $scope.wholeFlag=true;
    $http.get("/data/get_profile/"+$scope.pid).then(function(res){
      $("#profile_body").html(res.data.profile);
      // $scope.user_assess=res.data.user_assess;
      $("#user_access_body").html(res.data.user_assess);
      $scope.user_assess_name=res.data.name;
    });
    //베댓불러오기
    $http.get("/reply/getBest/"+$scope.pid).then(function(res){
      $scope.bestReplies=res.data;
      var ref = new Firebase("https://projectg2016.firebaseio.com/reply");
      for(var i=0; i<res.data.length; i++){
        $scope.bestReplies[i].data=$firebaseObject(ref.child($scope.pid).child(res.data[i].RID));
      }
    });

    // 일댓불러오기
    normalReply(15,0);
  }

  var updateStatInfo=function(){
    var jsonData= JSON.stringify($scope.statData);
    var jjsonData=JSON.parse(jsonData);
    if(jjsonData.sex.length==0 && jjsonData.age.length==0 && jjsonData.loc.length==0){
      $scope.wholeFlag=true;
    }else{
      $scope.wholeFlag=false;
    }
    $http.post('/data/get_stat_by_info',jsonData).then(function(res){
      renderWinLose(parseInt(res.data.win),parseInt(res.data.lose));
    });
  }
  var level=3; //임시 레벨
  var levelCheck=function(){
    //TODO 레벨 가져오는거 구현 필요
    if(level<2){
      alert('레벨 2 이상의 회원만 열람가능합니다.');
      return false;
    }
    return true;
  }
  $scope.selectSex=function(sex){
    if(!levelCheck())return;
    $scope.statData.sex=sex;
    updateStatInfo();
  }
  $scope.selectAge=function(age){
    if(!levelCheck())return;
    $scope.statData.age=age;
    updateStatInfo();
  }
  $scope.selectLoc=function(loc){
    if(!levelCheck())return;
    $scope.statData.loc=loc;
    updateStatInfo();
  }

  $scope.edit_user_assess=function(){
    $("#user_assess").html($("#user_access_body").html());
    $('#user_assess').summernote('destroy');
    $('#user_assess').summernote({
      height: 300,
      focus: true,
      maxHeight: 300
    });
    $("#user_assess_edit_modal").modal('show');
  }
  $scope.save_user_assess=function(){
    //저장 프로세스
    //mysql 에 저장
    var data={
      pid:$scope.pid,
      assess:$('#user_assess').summernote('code'),
      uid:$cookieStore.get("uid")
    };
    $http.post("/data/update_user_assess",data);
    $('#user_assess').summernote('destroy');
    $("#user_access_body").html($('#user_assess').summernote('code'));
    $("#user_assess_edit_modal").modal('hide');
    alert('유저평을 업데이트 했습니다');
    location.reload();
  }
  $scope.change_profile_picture=function(){
    $("#profile_pic_edit_modal").modal('show');
  }
  var file,fr;
  $scope.handleFileSelect=function(){
    if (!window.File || !window.FileReader || !window.FileList || !window.Blob) {
      alert('The File APIs are not fully supported in this browser.');
      return;
    }
    input = document.getElementById('fileinput');
    if (!input) {
      alert("Um, couldn't find the fileinput element.");
    }
    else if (!input.files) {
      alert("This browser doesn't seem to support the `files` property of file inputs.");
    }
    else if (!input.files[0]) {
      alert("Please select a file before clicking 'Load'");
    }
    else {
      file = input.files[0];
      fr = new FileReader();
      fr.onload = function(){
        var ref = new Firebase("https://projectg2016.firebaseio.com/person");
        ref.child($scope.pid).update({url:fr.result});
      }
      //fr.readAsText(file);
      fr.readAsDataURL(file);
    }
    alert('프로필 사진을 변경했습니다');
    $("#profile_pic_edit_modal").modal('hide');
  }

  $scope.giveHeart=function(pid){
    $scope.heartModal={};
    $scope.heartModal.pid=pid;
    var ref = new Firebase("https://projectg2016.firebaseio.com/user");
    ref.child($cookieStore.get("uid")).child("vote_point").once("value",function(snapshot){
      $scope.heartModal.maxPoint=Math.floor(snapshot.val());
      $("#heartModal").modal('show');
    });
  }
  $scope.giveX=function(pid){
    $scope.XModal={};
    $scope.XModal.pid=pid;
    var ref = new Firebase("https://projectg2016.firebaseio.com/user");
    ref.child($cookieStore.get("uid")).child("vote_point").once("value",function(snapshot){
      $scope.XModal.maxPoint=Math.floor(snapshot.val());
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
    if(sendPoint<1){
      alert('올바른 숫자를 입력해주세요');
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
    location.reload();
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
    if(sendPoint<1){
      alert('올바른 숫자를 입력해주세요');
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
    location.reload();
  }

  $scope.uploadReply=function(){
    if(!$cookies.get('uid')){
      alert('로그인 해주세요');
      return;
    }
    if($scope.reply_data==''){
      alert('내용을 입력하세요');
      return;
    }
    var data={
      pid: $scope.pid,
      prid: 0,
      uid: $cookies.get('uid')
    };
    $http.post("/reply/insert_reply",JSON.stringify(data)).then(function(res){
      console.log(res.data);
      var data=res.data;
      // Object {PID: "2", RID: "2", PRID: "0"}
      var ref = new Firebase("https://projectg2016.firebaseio.com/reply");
      ref.child(data.PID).child(data.RID).setWithPriority({
        'data': $scope.reply_data,
        'up':0,
        'down':0,
        'rid':data.RID,
        'prid':data.PRID,
        'uid': $cookies.get('uid'),
        'time':new Date().getTime(),
        'child_reply_count':0,
        'name': data.NAME
      },-1*parseInt(data.RID));
      $scope.reply_data="";
      var ref = new Firebase("https://projectg2016.firebaseio.com/user").child($cookies.get('uid'));
      ref.child("level_point").transaction(function(point){
        return point+1;
      });

    });
  }

  $scope.boomUpDown=function(rid,side,uid){
    //이 rid에 대해 내가 붐업다운 한적이 있는지 확인
    var ref = new Firebase("https://projectg2016.firebaseio.com/user").child($cookies.get('uid'));
    ref.child("boomUpDown").once("value",function(ss){
      if(ss.child(rid).exists()){
        alert('이미 추천/비추천을 하셨습니다');
        return;
      }else{
        //기록에 없을 때

        //자기 레벨 포인트 0.1점 추가
        new Firebase("https://projectg2016.firebaseio.com/user").child($cookies.get('uid')).child("level_point").transaction(function(count){
          return count+0.1;
        });

        var ref = new Firebase("https://projectg2016.firebaseio.com/user").child($cookies.get('uid')).child("level_point").once("value",function(res){
          //레벨 포인트로 얼마나 추천할건지
          var level=levelService.findLevel(res.val());
          var DN=levelService.findDN(level);
          var ref = new Firebase("https://projectg2016.firebaseio.com/reply").child($scope.pid).child(rid);
          if(side=="up"){
            ref.child("up").transaction(function(cnt){
              return cnt+DN;
            });
            new Firebase("https://projectg2016.firebaseio.com/user").child(uid).child('level_point').transaction(function(point){
              return point+1;
            });
            var data={
              rid:rid,
              up:1,
              down:0
            };
            $http.post("/reply/boomUpDown",JSON.stringify(data));
          }else{
            ref.child("down").transaction(function(cnt){
              return cnt+DN;
            });
            new Firebase("https://projectg2016.firebaseio.com/user").child(uid).child('level_point').transaction(function(point){
              if(point-1>=0){
                return point-1;
              }else{
                return point;
              }
            });
            var data={
              rid:rid,
              up:0,
              down:1
            };
            $http.post("/reply/boomUpDown",JSON.stringify(data));
          }
          var ref = new Firebase("https://projectg2016.firebaseio.com/user").child($cookies.get('uid'));
          ref.child("boomUpDown").child(rid).set({
            true:''
          });


        });


      }
    });
  }
  $scope.child_reply=[];
  $scope.add_child_reply=function(prid){
    // console.log($scope.child_reply[prid]);
    var data={
      pid: $scope.pid,
      prid: prid,
      uid: $cookies.get("uid")
    };
    $http.post("/reply/add_child_reply",data).then(function(res){
      var ref = new Firebase("https://projectg2016.firebaseio.com/child_reply").child(res.data.PRID);
      ref.child(res.data.RID).setWithPriority({
        'data': $scope.child_reply[prid],
        'up':0,
        'down':0,
        'rid':res.data.RID,
        'prid':res.data.PRID,
        'uid': $cookies.get('uid'),
        'time':new Date().getTime(),
        'name': res.data.NAME
      },-1*parseInt(res.data.RID));
      new Firebase("https://projectg2016.firebaseio.com/reply").child($scope.pid).child(res.data.PRID).child('child_reply_count').transaction(function(count){
        return count+1;
      });

      var ref = new Firebase("https://projectg2016.firebaseio.com/user").child($cookies.get('uid'));
      ref.child("level_point").transaction(function(point){
        return point+1;
      });
      //TODO 댓글의 주인에게 알람 주기
      $http.get("/data/get_user_by_rid/"+res.data.PRID).then(function(resq){
        var data={
          rid: resq.data.RID,
          pid: resq.data.PID,
          data: $scope.child_reply[prid],
          uid: $cookies.get("uid"),
          read: false,
          '.priority': new Date().getTime()
        };
        var ref = new Firebase("https://projectg2016.firebaseio.com/user");
        ref.child(resq.data.UID).child("alert").push(data);
        $scope.child_reply[prid]="";
      });
    });
  }
  $scope.child_replies=[];
  $scope.show_child_reply=function(prid){
    //TODO 열려져 있는 상황이면 연결 끊어주는거 필요
    //HACK 일단은 안함.
    // if()
    var ref = new Firebase("https://projectg2016.firebaseio.com/child_reply").child(prid);
    $scope.child_replies[prid]=$firebaseArray(ref.orderByPriority());
  }
  $scope.child_boomUpDown=function(rid,prid,side,uid){
    //이 rid에 대해 내가 붐업다운 한적이 있는지 확인
    var ref = new Firebase("https://projectg2016.firebaseio.com/user").child($cookies.get('uid'));
    ref.child("boomUpDown").once("value",function(ss){
      if(ss.child(rid).exists()){
        alert('이미 추천/비추천을 하셨습니다');
        return;
      }else{
        //기록에 없을 때

        //자기 레벨 포인트 0.1점 추가
        new Firebase("https://projectg2016.firebaseio.com/user").child($cookies.get('uid')).child("level_point").transaction(function(count){
          return count+0.1;
        });

        var ref = new Firebase("https://projectg2016.firebaseio.com/user").child($cookies.get('uid')).child("level_point").once("value",function(res){
          //레벨 포인트로 얼마나 추천할건지
          var level=levelService.findLevel(res.val());
          var DN=levelService.findDN(level);
          var ref = new Firebase("https://projectg2016.firebaseio.com/child_reply").child(prid).child(rid);
          if(side=="up"){
            ref.child("up").transaction(function(cnt){
              return cnt+DN;
            });
            new Firebase("https://projectg2016.firebaseio.com/user").child(uid).child('level_point').transaction(function(point){
              return point+1;
            });
            var data={
              rid:rid,
              up:1,
              down:0
            };
            $http.post("/reply/boomUpDown",JSON.stringify(data));
          }else{
            ref.child("down").transaction(function(cnt){
              return cnt+DN;
            });
            new Firebase("https://projectg2016.firebaseio.com/user").child(uid).child('level_point').transaction(function(point){
              if(point-1>=0){
                return point-1;
              }else{
                return point;
              }
            });
            var data={
              rid:rid,
              up:0,
              down:1
            };
            $http.post("/reply/boomUpDown",JSON.stringify(data));
          }
          var ref = new Firebase("https://projectg2016.firebaseio.com/user").child($cookies.get('uid'));
          ref.child("boomUpDown").child(rid).set({
            true:''
          });


        });


      }
    });
  }
  $scope.rerereply=function(prid,name){
    $scope.child_reply[prid]=name+" | ";
    $("#child_reply_"+prid).focus();
  }
  $scope.keydown=function(event){
    if(event.keyCode==13){
      $scope.uploadReply();
    }
  }
  $scope.childKeydown=function(event,rid){
    if(event.keyCode==13){
      $scope.add_child_reply(rid);
    }
  }
  $scope.userInfo=[];
  $scope.loadUserInfo=function(rid,uid){
    console.log(rid+" "+uid);
    $scope.userInfo[rid]={};
    var user=$scope.userInfo[rid];
    var ref = new Firebase("https://projectg2016.firebaseio.com/user").child(uid).once("value",function(ss){
      user.vote=ss.child("level_point").val();
      user.level=ss.child("vote_point").val();
      user.reply_count="로딩중... ";
      $http.get("/data/get_reply_count/"+uid).then(function(res){
        user.reply_count=res.data.count;
        console.log();
      });
    });
  }







})

;
