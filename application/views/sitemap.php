<div class="container" ng-controller="sitemap">
  <div class="page-header">
    <h1>투표 전체보기</h1>
  </div>
  <div class="row">


    <div class="col-xs-12 col-sm-4" ng-repeat="bs in bsList">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">{{bs.NAME}}</h3>
        </div>
        <div class="list-group" ng-repeat="ss in bs.ssList">
          <a ng-href="/?ssid={{ss.SSID}}" class="list-group-item">
            {{ss.NAME_KOR}}
          </a>
        </div>
      </div>
    </div>


  </div>
</div>
