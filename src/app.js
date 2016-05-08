var app = angular.module("app", ["firebase","ngCookies"]);
app
.controller("nav",function($scope, $firebaseObject,$http,$cookieStore){
  $scope.ng_login=function(){
    if($scope.id!=""&&$scope.pw!=""){
      $http.get("/func/login_data_func/"+$scope.id+"/"+$scope.pw).then(function(res){
        console.log(res.data.UID);
        if(res.data.UID){
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
    console.log(res.data);
    $scope.notices=res.data.data;
  });
});
