var app = angular.module("app", ["firebase","ngCookies","ngSanitize"]);
app
.service('levelService',function(){
  this.findLevel=function(level_point){
    var dist=[100,200,300,400,500,600,700,800,900,1000,1200,1400,1600,1800,2000,2200,2400,2600,2800,3000,3300,3600,3900,4200,4500,4800,5100,5400,5700,6000,6400,6800,7200,7600,8000,8400,8800,9200,9600,10000,10500,11000,11500,12000,12500,13000,13500,14000,14500,15000,15600,16200,16800,17400,18000,18600,19200,19800,20400,21000,21700,22400,23100,23800,24500,25200,25900,26600,27300,28000,28800,29600,30400,31200,32000,32800,33600,34400,35200,36000,36900,37800,38700,39600,40500,41400,42300,43200,44100,45000,46000,47000,48000,49000,50000,51000,52000,53000,54000];

    var level=dist.findIndex(function(num){
      return num>level_point;
    });
    return level+1;
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
    if($scope.admin&&!$cookies.get('admin')){
      // var time=new Date();
      // time.setDays()
      $cookies.put("admin","admin",{expires: "Session"});
    }

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
      //투표권 부분 - 로그인 했을때
      var now = new Date();
      var expire = new Date();

      expire.setFullYear(now.getFullYear());
      expire.setMonth(now.getMonth());
      expire.setDate(now.getDate()+2);
      expire.setHours(-24);
      expire.setMinutes(0);
      expire.setSeconds(0);

      if(!$cookies.get('vote_left')){
        $cookies.put('vote_left',20,{expires: expire});
      }
      // vote_left 쿠키가 path에 따라 다르게 생기는거 해결함.
      console.log("10초마다 투표권이 증가합니다.");
      setInterval(function(){
        $cookies.put('vote_left',parseInt($cookies.get('vote_left'))+1,{expires: expire});
        $rootScope.vote_left=parseInt($cookies.get('vote_left'));
        $rootScope.$apply();
      }, 10000);
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

    //투표권 - 로그인 안했을 때
    var now = new Date();
    var expire = new Date();

    expire.setFullYear(now.getFullYear());
    expire.setMonth(now.getMonth());
    expire.setDate(now.getDate()+2);
    expire.setHours(-24);
    expire.setMinutes(0);
    expire.setSeconds(0);

    if(!$cookies.get('vote_left')){
      console.log("로그인 안했을때 20개가 주어집니다.");
      //TODO 문제가 setHour가 제대로 안먹히는데 있었음.
      $cookies.put("vote_left",20,{expires: expire});
    }else if($cookies.get('vote_left')=="NaN"){
      console.log("NaN이 뜨는 경우+로그인 안했을때 20개가 주어집니다.");
      $cookies.put("vote_left",20,{expires: expire});
    }
  }
  $rootScope.vote_left=$cookies.get('vote_left');
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
  // 탈퇴기능
  var uid=$cookies.get('uid');
  if(confirm("탈퇴하시면 포인트가 모두 삭제됩니다. 그래도 탈퇴하시겠습니까?")==true){
    $cookies.remove('uid');
    location.href="/func/exit_user/"+uid;
  }
}
$scope.LogOut=function(){
  var uid=$cookies.get('uid');
  $cookies.remove('uid');
  $cookies.remove('auto_login');
  $cookies.remove('vote_left');
  $cookies.remove('admin');
  location.href="/func/logout_user/";
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
          console.log(uid);
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
  $scope.ss_reset=function(ss){
    if(confirm('정말로 초기화 하시겠습니까?')){
      $http.get("/data/get_people/"+ss.SSID).then(function(res){
        console.log(res);
        var data=res.data;
        for(var i=0; i<data.length; i++){
          var pid=data[i].PID;
          var ref = new Firebase("https://projectg2016.firebaseio.com/person");
          ref.child(pid).update({
            lose: 0,
            win: 0,
            total:0,
            heart:0,
            x:0
          });
          $http.get("/data/reset_person/"+pid);
        }
      });
      alert('초기화되었습니다.');
    }
  }
  $scope.bs_edit=function(bs){
    var name=prompt('대주제 명칭(한글)을 입력해주세요');
    if(name==null)return;
    var data={
      "bsid": bs.BSID,
      "name": name
    };
    $http.post("/data/edit_bs",JSON.stringify(data));

    alert('수정되었습니다');
    location.reload();
  }
  $scope.delete_person=function(person){
    $http.get("/data/delete_person/"+person.PID);
    alert("삭제 되었습니다.");
    location.reload();
  }
  $scope.person_edit_flag=true;
  var current_edit_person;
  $scope.edit_person=function(person){
    $scope.person_modal={};
    $scope.person_edit_flag=false;
    console.log(person);
    current_edit_person=person;
    $('#profile').summernote('destroy');
    $("#profile").html(person.PROFILE);
    $('#profile').summernote({
      height: 300,
      maxHeight: 300
    });
    $scope.person_modal.name=person.NAME;
    $("#user_add_modal").modal('show');
  }
  $scope.change_edit_flag=function(){
    $scope.person_edit_flag=true;
  }
  $scope.edit_person_submit=function(person){
    person.profile=$("#profile").summernote('code');
    person.ssid=$scope.currentVote.small.SSID;
    var data={
      name:$scope.person_modal.name,
      profile:$('#profile').summernote('code'),
      pid: current_edit_person.PID
    };
    //프로필 사진
    var file,input,fr;
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
      return;
    }
    else if (!input.files[0]) {
      $http.post("/data/edit_person",JSON.stringify(data));
    }
    else {
      file = input.files[0];
      fr = new FileReader();
      fr.readAsDataURL(file);
      fr.onload = function(){
        console.log(data);
        $http.post("/data/edit_person",JSON.stringify(data));
        var ref = new Firebase("https://projectg2016.firebaseio.com/person");
        ref.child(current_edit_person.PID).update({
          url: fr.result
        });
      }
    }
    $("#user_add_modal").modal('hide');
    alert("인물 수정 완료");
    $("#profile").html("");
    $("#profile").summernote('reset');
    $("#fileinput").val(null);
    $scope.person_modal={};
    $scope.person_edit_flag=true;
  }
  $scope.ss_edit=function(ss){
    var name_kor=prompt('소주제 명칭(한글)을 입력해주세요');
    if(name_kor==null)return;
    var name_eng=prompt('소주제 영문(url로 사용)을 입력해주세요');
    if(name_eng==null)return;
    var data={
      "ssid": ss.SSID,
      "name_kor": name_kor,
      "name_eng": name_eng
    };
    $http.post("/data/edit_ss",JSON.stringify(data));

    alert('수정되었습니다');
    location.reload();
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

    //프로필 사진
    var file,input,fr;
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
      return;
    }
    else if (!input.files[0]) {
      alert("Please select a file before clicking 'Load'");
      return;
    }
    else {
      file = input.files[0];
      fr = new FileReader();
      fr.readAsDataURL(file);
      fr.onload = function(){
        $http.post("/func/add_person",person).then(function(res){
          var pid=res.data.pid;
          var name=res.data.name;
          var ref = new Firebase("https://projectg2016.firebaseio.com/person");
          ref.child(pid).set({
            heart:0,
            lose:0,
            win:0,
            x:0,
            name:name,
            total:0,
            url: fr.result
          });
          render_person();
        });

      }
    }
    $("#user_add_modal").modal('hide');
    alert("인물 추가 완료");
    $("#profile").summernote('reset');
    $scope.person_modal={};
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
.controller("help",function($scope,$http,$cookies){
  // $http.get("/data/get_help").then(function(res){
  //   $scope.helps=res.data;
  // });
  $scope.init=function(){
    var table= $('#help_table').DataTable({
      "ajax": '/data/get_help',
      "columns": [
        { "data": "TITLE","width": "70%" },
        { "data": "TIME" }
      ],
      "createdRow": function ( row, data, index ) {
        // console.log(row);
        // console.log(data);
        // console.log(index);
      }
    });
    $scope.selectedOne="";
    $('#help_table tbody').on('click', 'tr', function () {
      var data=table.row(this).data();
      console.log(data);
      if(!$cookies.get("admin")){
        var pw = prompt("등록한 비밀번호를 입력해주세요");
        if(pw==data.PASSWORD){
          if(data.RESPONSE==""){
            alert('아직 답변이 달리지 않았습니다.');
          }else{
            $scope.my_question=data.BODY;
            $scope.response_received=data.RESPONSE;
            $("#response").modal('show');
          }
        }else{
          alert("비밀번호가 일치하지 않습니다.");
        }
      }else{
        if(data.RESPONSE!=""){
          $scope.my_question=data.BODY;
          $scope.response_received=data.RESPONSE;
          $("#response").modal('show');
        }else{
          $scope.selectedOne=data.HID;
          $scope.question=data.BODY;
          $("#response_write").summernote({
            height: 300
          });
          $("#write_res").modal('show');
        }
      }
      $scope.$apply();


    });
  }

  $scope.send=function(){
    var target=$scope.selectedOne;
    var res=$("#response_write").summernote('code');
    var data={
      RESPONSE: res,
      HID: target
    };

    $http.post("/data/add_response",JSON.stringify(data)).then(function(res){
      location.reload();
    });
  }
})
.controller("help_write",function($scope,$http){
  $scope.help={};
  $scope.send=function(){
    if(!$scope.help.TITLE||!$scope.help.PASSWORD||$('#help').summernote('code')==""){
      alert('제목과 내용을 확인해주세요');
      return;
    }
    $scope.help.BODY=$('#help').summernote('code');
    var data=JSON.stringify($scope.help);
    $http.post("/data/add_help",data);
    alert('감사합니다. 확인 후 답변드리겠습니다.');
    location.href="/help";
  }
})
.controller("notice",function($scope,$http){
  $http.get("/data/get_notice").then(function(res){
    $scope.notices=res.data.data;
  });
})
.controller("vote",function($scope,$http,$firebaseObject,$cookies,$rootScope,$firebaseArray,levelService){
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

    //vote 페이지 댓글
    $http.get("/data/get_recent_reply_by_ssid/"+$scope.vote.ssid).then(function(res){
      $scope.temp_data_reply=res.data;
      $scope.replies=[];
      var data=res.data;
      for(var i=0; i<data.length; i++){
        var rid=data[i].rid;
        var pid=data[i].pid;
        var ref = new Firebase("https://projectg2016.firebaseio.com/reply");
        $scope.replies[i]={};
        $scope.replies[i].realtime=$firebaseObject(ref.child(pid).child(rid));
        $scope.replies[i].realtime.$loaded(function(res){
          var i;
          for(var j=0; j<$scope.replies.length; j++){
            if($scope.replies[j].realtime===res){
              i=j;
              break;
            }
          }
          // console.log($scope.replies);
          // console.log(i);
          $.extend($scope.replies[i],{pname:$scope.temp_data_reply[i].pname});
          $.extend($scope.replies[i],{ss_name:$scope.temp_data_reply[i].ss_name});
          $.extend($scope.replies[i],{pid:data[i].pid});
        });
        // $.extend(data[i],;
      }


    });
    $http.get("/data/get_people_pid/"+$scope.vote.ssid).then(function(res){
      var data=res.data;
      for(var i=0; i<data.length; i++){
        var pid=data[i].pid;
        var ref = new Firebase("https://projectg2016.firebaseio.com/reply");
        ref.child(pid).orderByChild('time').startAt(Date.now()).on("child_added",function(ss){
          var rid=ss.val().rid;
          var ref = new Firebase("https://projectg2016.firebaseio.com/reply");
          var data={};
          $http.get("/data/get_ssinfo_with_rid/"+rid).then(function(res){
            data.pname=res.data.pname;
            data.ss_name=res.data.ss_name;
            data.pid=res.data.pid;
            console.log(data.pid+" : "+rid);
            data.realtime=$firebaseObject(ref.child(data.pid).child(rid));
            data.realtime.$loaded(function(res){
              console.log(res);
              $scope.replies.unshift(data);
              console.log(data);
            });
          });
        });
      }
    });

  }

  $scope.vote_reply_select=function(pid,name){
    $scope.reply_for_vote={};
    $scope.reply_for_vote.selectedName=name;
    $scope.reply_for_vote.pid=pid;
  }



  $scope.uploadReply=function(){
    if(!$cookies.get('uid')){
      alert('로그인 해주세요');
      return;
    }
    if(typeof $scope.reply_for_vote==="undefined"){
      alert('댓글을 달 인물을 선택해주세요');
      return;
    }
    if($scope.reply_data==''||typeof $scope.reply_data ==="undefined"){
      alert('내용을 입력하세요');
      return;
    }
    var reply_data=$scope.reply_data;
    $scope.reply_data="";
    var data={
      pid: $scope.reply_for_vote.pid,
      prid: 0,
      uid: $cookies.get('uid')
    };
    $http.post("/reply/insert_reply",JSON.stringify(data)).then(function(res){
      var data=res.data;
      var ref = new Firebase("https://projectg2016.firebaseio.com/reply");
      ref.child(data.PID).child(data.RID).setWithPriority({
        'data': reply_data,
        'up':0,
        'down':0,
        'rid':data.RID,
        'prid':data.PRID,
        'uid': $cookies.get('uid'),
        'time':new Date().getTime(),
        'child_reply_count':0,
        'name': data.NAME
      },-1*parseInt(data.RID));

      var ref = new Firebase("https://projectg2016.firebaseio.com/user").child($cookies.get('uid'));
      ref.child("level_point").transaction(function(point){
        return point+1;
      });

    });
  }

  $scope.boomUpDown=function(pid,rid,side,uid){
    if(!$cookies.get('uid')){
      alert('로그인 해주세요');
      return;
    }
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
          var ref = new Firebase("https://projectg2016.firebaseio.com/reply").child(pid).child(rid);
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
  $scope.add_child_reply=function(pid,prid){
    if(!$cookies.get('uid')){
      alert('로그인 해주세요');
      return;
    }
    // console.log($scope.child_reply[prid]);
    var child_reply=$scope.child_reply[prid];
    $scope.child_reply[prid]="";
    if(child_reply==""){
      alert('내용을 입력해주세요');
      return;
    }
    var data={
      pid:  pid,
      prid: prid,
      uid: $cookies.get("uid")
    };
    $http.post("/reply/add_child_reply",data).then(function(res){

      console.log("ddd: "+res.data);
      var ref = new Firebase("https://projectg2016.firebaseio.com/child_reply").child(res.data.PRID);
      ref.child(res.data.RID).setWithPriority({
        'data': child_reply,
        'up':0,
        'down':0,
        'rid':res.data.RID,
        'prid':res.data.PRID,
        'uid': $cookies.get('uid'),
        'time':new Date().getTime(),
        'name': res.data.NAME
      },-1*parseInt(res.data.RID));
      new Firebase("https://projectg2016.firebaseio.com/reply").child(pid).child(res.data.PRID).child('child_reply_count').transaction(function(count){
        return count+1;
      });

      var ref = new Firebase("https://projectg2016.firebaseio.com/user").child($cookies.get('uid'));
      ref.child("level_point").transaction(function(point){
        return point+1;
      });
      // 댓글의 주인에게 알람 주기
      $http.get("/data/get_user_by_rid/"+res.data.PRID).then(function(resq){
        var data={
          rid: resq.data.RID,
          pid: resq.data.PID,
          data: child_reply,
          uid: $cookies.get("uid"),
          read: false,
          '.priority': new Date().getTime()
        };
        var ref = new Firebase("https://projectg2016.firebaseio.com/user");
        ref.child(resq.data.UID).child("alert").push(data);

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
    if(!$cookies.get('uid')){
      alert('로그인 해주세요');
      return;
    }
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
  $scope.childKeydown=function(pid,event,rid){
    if(event.keyCode==13){
      $scope.add_child_reply(pid,rid);
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






















  $scope.select=function(pid,side){
    if($scope.voteFlag==false)return;
    //투표권 있는지 확인
    if(parseInt($cookies.get('vote_left'))<1){
      //로그인한 상태인지 아닌지
      if($cookies.get("uid")){
        alert('투표권이 부족합니다. 10초마다 1개씩 투표권이 생성됩니다.');
        return;
      }else{
        alert('투표권이 부족합니다. 회원가입 해주세요');
        return;
      }
    }
    //투표권 감소
    var now = new Date();
    var expire = new Date();

    expire.setFullYear(now.getFullYear());
    expire.setMonth(now.getMonth());
    expire.setDate(now.getDate()+2);
    expire.setHours(-24);
    expire.setMinutes(0);
    expire.setSeconds(0);
    $cookies.put('vote_left',parseInt($cookies.get('vote_left'))-1,{expires: expire});


    if ($rootScope.$$phase == '$apply' || $rootScope.$$phase == '$digest' ) {
      $rootScope.vote_left=parseInt($cookies.get('vote_left'));
    } else {
      $rootScope.$apply(function() {
        $rootScope.vote_left=parseInt($cookies.get('vote_left'));
      });
    }


    //누가 투표하는 것인지
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
    if(!$cookies.get("uid")){
      alert('로그인 하셔야 이용가능합니다');
      return;
    }
    $scope.heartModal={};
    $scope.heartModal.pid=pid;
    var ref = new Firebase("https://projectg2016.firebaseio.com/user");
    ref.child($cookies.get("uid")).child("vote_point").once("value",function(snapshot){
      $scope.heartModal.maxPoint=Math.floor(snapshot.val());
      $("#heartModal").modal('show');
    });
  }
  $scope.giveX=function(pid){
    if(!$cookies.get("uid")){
      alert('로그인 하셔야 이용가능합니다');
      return;
    }
    $scope.XModal={};
    $scope.XModal.pid=pid;
    var ref = new Firebase("https://projectg2016.firebaseio.com/user");
    ref.child($cookies.get("uid")).child("vote_point").once("value",function(snapshot){
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
    ref.child($cookies.get("uid")).child("vote_point").transaction(function(point) {
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
      "uid":$cookies.get("uid"),
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
    ref.child($cookies.get("uid")).child("vote_point").transaction(function(point) {
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
      "uid":$cookies.get("uid"),
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
    for(var i =0;i<res.data.length;i++){
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
.controller("person",function($scope,$http,$firebaseObject,$cookies,levelService,$firebaseArray){
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
      if(res.data.uid==$cookies.get("uid")){
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
      uid:$cookies.get("uid")
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
    if(!$cookies.get("uid")){
      alert('로그인 하셔야 이용가능합니다');
      return;
    }
    $scope.heartModal={};
    $scope.heartModal.pid=pid;
    var ref = new Firebase("https://projectg2016.firebaseio.com/user");
    ref.child($cookies.get("uid")).child("vote_point").once("value",function(snapshot){
      $scope.heartModal.maxPoint=Math.floor(snapshot.val());
      $("#heartModal").modal('show');
    });
  }
  $scope.giveX=function(pid){
    if(!$cookies.get("uid")){
      alert('로그인 하셔야 이용가능합니다');
      return;
    }
    $scope.XModal={};
    $scope.XModal.pid=pid;
    var ref = new Firebase("https://projectg2016.firebaseio.com/user");
    ref.child($cookies.get("uid")).child("vote_point").once("value",function(snapshot){
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
    ref.child($cookies.get("uid")).child("vote_point").transaction(function(point) {
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
      "uid":$cookies.get("uid"),
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
    ref.child($cookies.get("uid")).child("vote_point").transaction(function(point) {
      return point-sendPoint;
    });
    var ref = new Firebase("https://projectg2016.firebaseio.com/person");
    ref.child($scope.XModal.pid).child("x").transaction(function(point) {
      return point+sendPoint;
    });
    ref.child($scope.XModal.pid).child("total").transaction(function(point) {
      return point-sendPoint;
    });
    var data={
      "uid":$cookies.get("uid"),
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
    var reply_data=$scope.reply_data;
    $scope.reply_data="";
    var data={
      pid: $scope.pid,
      prid: 0,
      uid: $cookies.get('uid')
    };
    $http.post("/reply/insert_reply",JSON.stringify(data)).then(function(res){
      var data=res.data;
      var ref = new Firebase("https://projectg2016.firebaseio.com/reply");
      ref.child(data.PID).child(data.RID).setWithPriority({
        'data': reply_data,
        'up':0,
        'down':0,
        'rid':data.RID,
        'prid':data.PRID,
        'uid': $cookies.get('uid'),
        'time':new Date().getTime(),
        'child_reply_count':0,
        'name': data.NAME
      },-1*parseInt(data.RID));

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
    var child_reply=$scope.child_reply[prid];
    $scope.child_reply[prid]="";
    if(child_reply==""){
      alert('내용을 입력해주세요');
      return;
    }
    var data={
      pid: $scope.pid,
      prid: prid,
      uid: $cookies.get("uid")
    };
    $http.post("/reply/add_child_reply",data).then(function(res){
      var ref = new Firebase("https://projectg2016.firebaseio.com/child_reply").child(res.data.PRID);
      ref.child(res.data.RID).setWithPriority({
        'data': child_reply,
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
          data: child_reply,
          uid: $cookies.get("uid"),
          read: false,
          '.priority': new Date().getTime()
        };
        var ref = new Firebase("https://projectg2016.firebaseio.com/user");
        ref.child(resq.data.UID).child("alert").push(data);

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
