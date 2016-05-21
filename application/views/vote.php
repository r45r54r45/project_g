<div class="container" >
  <div class="row" style="margin-top:30px;">
    <div class="col-sm-9 col-xs-12" ng-controller="vote" ng-init="vote={};vote.ssid=<?=$ssid?>;vote.leftPID='<?=$left['PID']?>';vote.rightPID='<?=$right['PID']?>'; voteFlag=true; init()">
      <div class="row" >
        <div class="col-xs-12" style="text-align:center;">
          <span class="" style="font-size:30px;">KOREAN100 누적 투표수 {{vote.totalVote.$value}}회</span>
        </div>
        <div class="col-xs-12" style="text-align:center; border:1px solid #D3D3D3; margin-top:10px;">
          <span class="pull-left" >투표 > {{vote.SSNAME}}</span>
          <span class="pull-right"><a ng-href="/?ssid={{otherSS.SSID}}">{{otherSS.NAME_KOR}}</a>에도 투표해주세요</span>
        </div>
        <div class="col-xs-12 c_center" style="margin-top:10px;margin-bottom:20px;">
          <span ng-show="vote.vote_result.show">{{before.winner}} 승 {{before.loser}} 패, {{vote.vote_result.PERCENTAGE}}%가 당신의 결정과 같습니다.</span>
        </div>
        <div class="col-xs-5 c_center">
          <img id="leftIMG" ng-click="select(vote.leftPID,'left')" ng-src="{{vote.left.url}}" class="vote_img img img-thumbnail animated zoomIn">
          <div style="margin-top:10px;">
            <span class="pull-left"><a ng-href="/{{vote.SSNAME_ENG}}/{{vote.left.name}}">{{vote.left.name}}</a></span>
            <span class="pull-right"><i ng-click="giveHeart(vote.leftPID)" class="glyphicon glyphicon-heart c_gly"></i>{{vote.left.heart}} <i ng-click="giveX(vote.leftPID)"  class="glyphicon glyphicon-remove c_gly"></i>{{vote.left.x}}</span>
          </div>
        </div>

        <div class="col-xs-2 " style="text-align:center;    padding-top: 100px;
        font-size: 30px;">vs</div>
        <div class="col-xs-5 c_center" >
          <img id="rightIMG" ng-click="select(vote.rightPID,'right')" ng-src="{{vote.right.url}}" class="vote_img img img-thumbnail  animated zoomIn">
          <div style="margin-top:10px;">
            <span class="pull-left"><a ng-href="/{{vote.SSNAME_ENG}}/{{vote.right.name}}">{{vote.right.name}}</a></span>
            <span class="pull-right"><i ng-click="giveHeart(vote.rightPID)"  class="glyphicon glyphicon-heart c_gly"></i>{{vote.right.heart}} <i ng-click="giveX(vote.rightPID)"  class="glyphicon glyphicon-remove c_gly"></i>{{vote.right.x}}</span>
          </div>
        </div>
      </div>
      <div class="modal fade" id="heartModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" ng-init=heartModal={};>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-body">
              <div class="form-group">
                <label>기부할 포인트 (보유 포인트:          {{heartModal.maxPoint}})</label>
                <input ng-model="heartModal.point" type="number" class="form-control">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">닫기</button>
              <button type="button" class="btn btn-primary" ng-click="sendHeart()">기부하기</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="XModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" ng-init=XModal={};>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-body">
              <div class="form-group">
                <label>기부할 포인트 (보유 포인트:          {{XModal.maxPoint}})</label>
                <input ng-model="XModal.point" type="number" class="form-control">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">닫기</button>
              <button type="button" class="btn btn-primary" ng-click="sendX()">기부하기</button>
            </div>
          </div>
        </div>
      </div>
      <!-- 투표페이지의 리플모음 -->
      <div class="row" style="margin-top:20px;">
        <div class="col-xs-12">
          <div class="page-header" style="margin: 20px 0 20px;">
            <strong>"{{vote.SSNAME}}" 리플</strong>
          </div>
        </div>
        <div class="col-xs-12">
          <div class="input-group">
            <div class="input-group-btn">
              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">선택 <span class="caret"></span></button>
              <ul class="dropdown-menu">
                <li><a ng-click="vote_reply_select(vote.leftPID,vote.left.name)">{{vote.left.name}}</a></li>
                <li><a ng-click="vote_reply_select(vote.rightPID,vote.right.name)">{{vote.right.name}}</a></li>
              </ul>
            </div><!-- /btn-group -->
            <span class="input-group-addon" id="selected_one">{{reply_for_vote.selectedName}}</span>
            <input type="text" class="form-control" aria-label="..." ng-model="reply_data">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button" ng-click="uploadReply()">등록</button>
            </span>
          </div><!-- /input-group -->
        </div>
      </div>

      <!-- 댓글 시작 -->
      <div class="row" style="margin-top:10px;">
        <div class="col-xs-12" ng-repeat="reply in replies">
          <div class="panel panel-default">
            <div class="panel-heading" style="padding:0 15px">
              <h3 class="panel-title">
                <span class="pull-left">
                  <span class="dropdown btn" style="    padding: 6px 12px 6px 0px;">
                    <span class="dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" ng-click="loadUserInfo(reply.realtime.rid,reply.realtime.uid)">
                      <strong>{{reply.realtime.name}}</strong>
                    </span>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1" >
                      <li><a href="">투표 p: {{userInfo[reply.realtime.rid].vote|number:0}}</a></li>
                      <li><a href="">레벨 p: {{userInfo[reply.realtime.rid].level|number:0}}</a></li>
                      <li><a href="">리플: {{userInfo[reply.realtime.rid].reply_count}}개</a></li>
                    </ul>
                  </span>
                  <span class="reply_info">{{reply.realtime.time| date:'yyyy년 MM월 dd일 HH시 mm분 ss초'}}</span>
                </span>
                <div class="clearfix"></div>
              </h3>
            </div>
            <div class="panel-body" style="padding-bottom:0;">
                <a ng-href="/{{reply.ss_name}}/{{reply.pname}}"><strong>"{{reply.pname}}"</strong></a>
              <p>{{reply.realtime.data}}</p>
            </div>
            <div class="panel-footer reply-footer">
              <span class="pull-left"><button class="label label-default" data-toggle="collapse" ng-href="#rereply_{{reply.realtime.rid}}" aria-expanded="false" aria-controls="rereply" ng-click="show_child_reply(reply.realtime.rid);">답글</button> {{reply.realtime.child_reply_count}}</span>
              <span class="pull-right">
                <i ng-click="boomUpDown(reply.pid,reply.realtime.rid,'up',reply.realtime.uid)"  class="glyphicon glyphicon-thumbs-up"></i> {{reply.realtime.up}}
                <i ng-click="boomUpDown(reply.pid,reply.realtime.rid,'down',reply.realtime.uid)" class="glyphicon glyphicon-thumbs-down"></i>{{reply.realtime.down}}
              </span>
              <div class="clearfix"></div>
            </div>
            <ul class="list-group collapse" id="rereply_{{reply.realtime.rid}}">
              <li class="list-group-item">
                <div class="input-group">
                  <span class="input-group-addon">답글</span>
                  <input type="text" class="form-control" aria-label="..." id="child_reply_{{reply.realtime.rid}}" ng-model="child_reply[reply.realtime.rid]"
                  ng-keydown="childKeydown(reply.pid,$event,reply.realtime.rid)">
                  <span class="input-group-btn">
                    <button class="btn btn-default" type="button" ng-click="add_child_reply(reply.pid,reply.realtime.rid)">등록</button>
                  </span>
                </div><!-- /input-group -->
              </li>
              <li class="list-group-item" ng-repeat="child_reply in  child_replies[reply.realtime.rid]">
                <!--  -->
                <div class="pull-left">&#8735; <strong>{{child_reply.name}}</strong>&nbsp<span><span class="reply_info">{{child_reply.time| date:'yyyy년 MM월 dd일 HH시 mm분 ss초'}}</span></span>&nbsp<span class="label label-default" ng-click="rerereply(child_reply.prid,child_reply.name)"><i class="glyphicon glyphicon-pencil"></i>답글</span></div>
                <div class="pull-right">  <i class="glyphicon glyphicon-thumbs-up" ng-click="child_boomUpDown(child_reply.rid,child_reply.prid,'up',child_reply.uid)"></i> {{child_reply.up}}
                  <i class="glyphicon glyphicon-thumbs-down" ng-click="child_boomUpDown(child_reply.rid,child_reply.prid,'down',child_reply.uid)"></i>{{child_reply.down}}</div>
                  <div class="clearfix"></div>
                  <div class="pull-left" style="padding-left: 17px;">{{child_reply.data}}</div>
                  <div class="clearfix"></div>
                </li>
                <!-- <li class="list-group-item">
                <nav>
                <ul class="pagination pagination-sm" style="margin:0;">
                <li>
                <a href="#" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </a>
            </li>
            <li class="active"><a href="#">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li><a href="#">5</a></li>
            <li>
            <a href="#" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
          </a>
        </li>
      </ul>
      </nav>
      </li> -->
      </ul>
      </div>
      </div>
      </div>





    </div>
    <!-- 우측 사이드 -->
    <div class="col-sm-3 hidden-xs">
      <div class="list-group" ng-controller="notice">
        <a href="/notice" class="list-group-item">
          <h4 class="list-group-item-heading">공지사항</h4>
        </a>
        <!-- 공지 시작 -->
        <a href="/notice" class="list-group-item" ng-repeat="notice in notices">
          <h4 class="list-group-item-heading">{{notice.TITLE}}</h4>
          <!-- <p class="list-group-item-text" ng-bind-html="notice.BODY"></p> -->
        </a>
      </div>
      <div class="list-group">
        <!-- 현재 소주제의 랭킹 1위 ~ 10위  -->
        <a href="/write" class="list-group-item">
          <div class="btn btn-default btn-block">건의하기</div>
        </a>
        <a href="#" class="list-group-item">
          <h4 class="list-group-item-heading"> 배너 위치</h4>
        </a>
        <!-- ... -->
      </div>


    </div>
  </div>

</div>
