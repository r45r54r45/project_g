<style>
.td1{
  width:70px;
}
.td2{
  width:70px;
}
.td3{
  width:50px;
}
.td4{
  width:70px;
}
.td5{
  width:100px;
}
.td6{
  width:90px;
}

</style>
<div class="container" ng-controller="ranking_ss" ng-init="ssid=<?=$ssid?>; init();">
  <div class="page-header">
    <h1>"<?=$target?>" 분야 순위</h1>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <table class="table table-hover ranking">
        <thead>
          <th>분야 순위</th>
          <th>전체 순위</th>
          <th>사진</th>
          <th>이름</th>
          <th>승패 기록</th>
          <th>총점</th>
        </thead>
        <tbody>
          <tr ng-click="gotoPerson(tuple.ss_eng,tuple.name)" ng-repeat="tuple in table">
            <td class="td1">{{tuple.ss_rank}}위</td>
            <td class="td2">전체 {{tuple.all_rank}}위</td>
            <td class="td3"><img ng-src="{{tuple.url}}" class="img img-thumbnail"></td>
            <td class="td4">{{tuple.name}}</td>
            <td class="td5">{{tuple.realtime.win}}승 {{tuple.realtime.lose}}패</td>
            <td class="td6">{{tuple.realtime.total}}점</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
