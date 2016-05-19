<div class="container" ng-controller="notice">
  <div class="page-header">
    <h1>공지사항</h1>
  </div>
  <div class="row">
    <div class="col-xs-12" ng-repeat="notice in notices">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">{{notice.TITLE}} ({{notice.TIME}})</h3>
        </div>
        <div class="panel-body" ng-bind-html="notice.BODY">
        </div>
      </div>
    </div>
  </div>
</div>
