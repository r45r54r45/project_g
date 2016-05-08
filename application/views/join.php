<div class="container" style="margin-top:20px;" ng-controller="join" ng-init="double_check=true">
  <div class="page-header">
    <h1>회원가입</h1>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <form method="post" action="/func/join_func">
        <div class="form-group">
          <label for="name">닉네임</label>
          <div class="input-group">
            <input ng-model="name" type="text" class="form-control" name="name">
            <span class="input-group-btn">
              <button ng-click="name_check()" class="btn btn-default btn-primary" type="button">중복확인</button>
            </span>
          </div><!-- /input-group -->
        </div>
        <div ng-show="name_check_result&&!double_check" class="alert alert-success" role="alert">닉네임을 사용할 수 있습니다</div>
        <div ng-show="!name_check_result&&!double_check" class="alert alert-danger" role="alert">중복된 닉네임입니다</div>
        <div ng-show="double_check" class="alert alert-danger" role="alert">중복확인을 해주세요</div>
        <div class="form-group">
          <label for="pw">비밀번호</label>
          <input ng-model="password" type="password" class="form-control" name="pw">
        </div>
        <div class="form-group">
          <label for="pw">비밀번호 확인</label>
          <input type="password" ng-model="password2" class="form-control">
        </div>
        <div ng-show="password!=password2" class="alert alert-danger" role="alert">비밀번호를 확인해주세요</div>
        <button ng-click="ng_submit()" type="button" class="btn btn-default">가입하기</button>
      </form>
    </div>
  </div>
</div>
