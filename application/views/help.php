<div class="container" ng-controller="help" ng-init="init()">
  <div class="page-header">
    <h1>건의사항 <a href="/write"><button class="btn">작성</button></a></h1>
  </div>
  <div class="row" id="help">

    <div class="col-xs-12">
      <table id="help_table" class="table ">
        <thead>
          <tr>
            <th>제목</th>
            <th>시간</th>
          </tr>
        </thead>


      </table>

      <div class="modal fade" id="response" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">답변</h4>
            </div>
            <div class="modal-body">
              <h4>건의 내용</h4>
              <div class="well" ng-bind-html="my_question"></div>
              <h4>답변</h4>
              <div class="well" ng-bind-html="response_received"></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">닫기</button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="write_res" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="">답변하기</h4>
            </div>
            <div class="modal-body">
              <div class="well" ng-bind-html="question">

              </div>
              <div id="response_write">

              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal" ng-click="send()">전송</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
