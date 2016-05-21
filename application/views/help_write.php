<div class="container" ng-controller="help_write">
  <div class="page-header">
    <h1>새 건의사항</h1>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <div class="input-group"  style="margin-bottom:10px;">
        <span class="input-group-addon">제목</span>
        <input type="text" class="form-control" name="title" ng-model="help.TITLE">
      </div>
      <div class="input-group"  style="margin-bottom:10px;">
        <span class="input-group-addon">비밀번호</span>
        <input type="password" class="form-control" name="title" placeholder="답변을 확인할 비밀번호를 입력해주세요" ng-model="help.PASSWORD">
      </div>
      <div id="help"></div>
      <script>
      $(document).ready(function() {
        $('#help').summernote({
          height: 300,
        });
      });
      </script>

      <!-- <div class="input-group">
        <span class="input-group-btn">
          <span class="btn btn-primary btn-file">
            첨부파일 <input type="file" name="file">
          </span>
        </span>
        <input type="text" class="form-control" readonly>
      </div> -->

      <button class="btn btn-block btn-default"  style="margin-top:10px;" ng-click="send()">제출</button>

    </div>
  </div>
</div>
<script type="text/javascript">
$(document).on('change', '.btn-file :file', function() {
var input = $(this),
    numFiles = input.get(0).files ? input.get(0).files.length : 1,
    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
input.trigger('fileselect', [numFiles, label]);
});

$(document).ready( function() {
  $('.btn-file :file').on('fileselect', function(event, numFiles, label) {

      var input = $(this).parents('.input-group').find(':text'),
          log = numFiles > 1 ? numFiles + ' files selected' : label;

      if( input.length ) {
          input.val(log);
      } else {
          if( log ) alert(log);
      }

  });
});
</script>
