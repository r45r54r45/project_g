<div class="container" style="margin-top:20px;">
  <div class="page-header">
    <h1>회원가입</h1>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <form>
        <div class="form-group">
          <label for="name">닉네임</label>
          <div class="input-group">
            <input type="text" class="form-control" id="name">
            <span class="input-group-btn">
              <button class="btn btn-default btn-primary" type="button">중복확인</button>
            </span>
          </div><!-- /input-group -->
        </div>
        <div class="alert alert-success" role="alert">닉네임을 사용할 수 있습니다</div>
        <div class="alert alert-danger" role="alert">중복된 닉네임입니다</div>

        <div class="form-group">
          <label for="pw">비밀번호</label>
          <input type="password" class="form-control" id="pw">
        </div>
        <div class="form-group">
          <label for="pw">비밀번호 확인</label>
          <input type="password" class="form-control" id="pw">
        </div>
        <button type="submit" class="btn btn-default">가입하기</button>
      </form>
    </div>
  </div>
</div>
