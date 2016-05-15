<div class="container" ng-controller="ss_sitemap">
  <div class="page-header">
    <h1>분야별 순위</h1>
  </div>
  <div class="row">


    <div class="col-xs-12 col-sm-4" ng-repeat="bs in bsList">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">{{bs.NAME}}</h3>
        </div>
        <div class="list-group" ng-repeat="ss in bs.ssList">
          <a ng-href="/ranking/{{ss.NAME_ENG}}" class="list-group-item">
            {{ss.NAME_KOR}}
          </a>
        </div>
      </div>
    </div>


  </div>
</div>
