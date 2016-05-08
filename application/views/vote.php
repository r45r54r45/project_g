<div class="container" >
  <div class="row" style="margin-top:30px;">
    <div class="col-sm-9 col-xs-12">
      <div class="row" ng-controller="vote" ng-init="vote={};vote.ssid=<?=$ssid?>;vote.leftPID='<?=$left['PID']?>';vote.rightPID='<?=$right['PID']?>'; voteFlag=true; init()">
        <div class="col-xs-12" style="text-align:center;">
          <span class="" style="font-size:30px;">KOREAN100 누적 투표수 {{vote.totalVote.$value}}회</span>
        </div>
        <div class="col-xs-12" style="text-align:center; border:1px solid #D3D3D3; margin-top:10px;">
          <span class="pull-left" >투표 > {{vote.SSNAME}}</span>
          <span class="pull-right"><a ng-href="/?ssid={{otherSS.SSID}}">{{otherSS.NAME_KOR}}</a>에도 투표해주세요</span>
        </div>
        <div class="col-xs-12 c_center" style="margin-top:10px;margin-bottom:20px;">
          <span ng-show="vote.vote_result.show">{{vote.vote_result.TOTAL}}명 중 {{vote.vote_result.SAME}}명, {{vote.vote_result.PERCENTAGE}}%가 당신의 결정과 같습니다.</span>
        </div>
        <div class="col-xs-5 c_center">
          <img id="leftIMG" ng-click="select(vote.leftPID,'left')" ng-src="{{vote.left.url}}" class="vote_img img img-thumbnail animated zoomIn">
          <div style="margin-top:10px;">
            <span class="pull-left"><a ng-href="{{vote.left.page}}">{{vote.left.name}}</a></span>
            <span class="pull-right"><i class="glyphicon glyphicon-heart c_gly"></i>{{vote.left.heart}} <i class="glyphicon glyphicon-remove c_gly"></i>{{vote.left.x}}</span>
          </div>
        </div>
        <div class="col-xs-2 " style="text-align:center;    padding-top: 100px;
        font-size: 30px;">vs</div>
        <div class="col-xs-5 c_center" >
          <img id="rightIMG" ng-click="select(vote.rightPID,'right')" ng-src="{{vote.right.url}}" class="vote_img img img-thumbnail  animated zoomIn">
          <div style="margin-top:10px;">
            <span class="pull-left"><a ng-href="{{vote_2.url}}">{{vote.right.name}}</a></span>
            <span class="pull-right"><i class="glyphicon glyphicon-heart c_gly"></i>{{vote.right.heart}} <i class="glyphicon glyphicon-remove c_gly"></i>{{vote.right.x}}</span>
          </div>
        </div>
      </div>
      <!-- 투표페이지의 리플모음 -->
      <div class="row" style="margin-top:20px;">
        <div class="col-xs-12">
          <div class="page-header" style="margin: 20px 0 20px;">
            <strong>"축구선수" 리플</strong>
          </div>
        </div>
        <div class="col-xs-12">
          <div class="input-group">
            <div class="input-group-btn">
              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">선택 <span class="caret"></span></button>
              <ul class="dropdown-menu">
                <li><a href="#"><?=$left['NAME']?></a></li>
                <li><a href="#"><?=$right['NAME']?></a></li>
              </ul>
            </div><!-- /btn-group -->
            <span class="input-group-addon" id="selected_one">박지성</span>
            <input type="text" class="form-control" aria-label="...">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">등록</button>
            </span>
          </div><!-- /input-group -->
        </div>
      </div>
      <div class="row" style="margin-top:10px;">
        <div class="col-xs-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">
                <span class="pull-left">닉네임 시간 지역</span>
                <div class="clearfix"></div>
              </h3>
            </div>
            <div class="panel-body" style="padding-bottom:0;">
              <a ng-href="#"><strong>"박지성"</strong></a>
              <p>ddd</p>
            </div>
            <div class="panel-footer reply-footer">
              <span class="pull-left"><span class="label label-default">답글</span> 00</span>
              <span class="pull-right">
                <i class="glyphicon glyphicon-thumbs-up"></i> 00
                <i class="glyphicon glyphicon-thumbs-down"></i>00
              </span>
              <div class="clearfix"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- 우측 사이드 -->
    <div class="col-sm-3 hidden-xs">
      <div class="list-group" ng-controller="notice">
        <!-- 공지 시작 -->
        <a href="/notice" class="list-group-item" ng-repeat="notice in notices">
          <h4 class="list-group-item-heading">{{notice.TITLE}}</h4>
          <p class="list-group-item-text">{{notice.BODY}}</p>
        </a>
      </div>
      <div class="list-group">
        <!-- 현재 소주제의 랭킹 1위 ~ 10위  -->
        <a href="#" class="list-group-item">
          <h4 class="list-group-item-heading"> 몇 위</h4>
        </a>
        <a href="#" class="list-group-item">
          <h4 class="list-group-item-heading"> 몇 위</h4>
        </a>
        <a href="#" class="list-group-item">
          <h4 class="list-group-item-heading"> 몇 위</h4>
        </a>
        <!-- ... -->
      </div>


    </div>
  </div>

</div>
