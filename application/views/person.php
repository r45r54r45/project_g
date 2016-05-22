<style>
#loading {
  position: absolute; width: 100%; height: 100%;
  z-index:9000;
  background:url("/src/spin.svg") no-repeat center center;
}
</style>
<div id="loading"></div>
<div class="container" style="margin-top:20px;" ng-controller="person" ng-init="pid=<?=$pid?>;userAssess_auth=false; isLoginedUser=false; init();">
  <div class="row">
    <div class="col-sm-3 col-xs-12" class="profile_image_div">
      <img ng-src="{{personInfo.url}}" class="img img-responsive img-thumbnail" style="width: 100%;">
      <div class="profile_edit_button btn btn-warning" ng-show="userAssess_auth" ng-click="change_profile_picture()">수정하기</div>
    </div>
    <div class="modal fade" id="profile_pic_edit_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="">프로필 사진 수정</h4>
          </div>
          <div class="modal-body">
            <input type="file" id="fileinput" accept="image/*" />
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">닫기</button>
            <button type="button" class="btn btn-primary" ng-click='handleFileSelect();'>저장</button>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-9 col-xs-12">
      <div class="row">
        <div class="col-xs-12 col-sm-6">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">순위</h3>
            </div>
            <div class="panel-body">
              전체 {{rankingInfo.total_rank}}등
              <?=$ssname?> {{rankingInfo.ss_rank}}등
            </div>
          </div>
        </div>
        <div class="col-xs-12 col-sm-6">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">총점</h3>
            </div>
            <div class="panel-body">
              <span  ng-show="isLoginedUser">{{personInfo.total}} p</span>
              <div class="alert alert-info" role="alert"  ng-show="!isLoginedUser">회원에게만 공개됩니다</div>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-xs-12 col-sm-6">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">승패</h3>
            </div>
            <div class="panel-body">
              <span  ng-show="isLoginedUser">
              {{personInfo.win}}승 / {{personInfo.lose}}패
            </span>

              <div class="alert alert-info" role="alert" ng-show="!isLoginedUser">회원에게만 공개됩니다</div>
            </div>
          </div>
        </div>
        <div class="col-xs-12 col-sm-6">
          <div class="panel panel-default">
            <div class="panel-heading">
              <span class="panel-title">통계</span>
              <div class="btn-group" role="group" aria-label="..." style="margin-top: -4px;" ng-show="isLoginedUser">
                <div class="btn-group" role="group">
                  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="    padding: 0px 12px;">
                    성별
                    <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    <li><a ng-click="selectSex('')">전체</a></li>
                    <li><a ng-click="selectSex('남')">남</a></li>
                    <li><a ng-click="selectSex('여')">여</a></li>
                  </ul>
                </div>
                <div class="btn-group" role="group">
                  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="    padding: 0px 12px;">
                    연령별
                    <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    <li><a ng-click="selectAge('')">전체</a></li>
                    <li><a ng-click="selectAge('10대')">10대</a></li>
                    <li><a ng-click="selectAge('20대')">20대</a></li>
                    <li><a ng-click="selectAge('30대')">30대</a></li>
                    <li><a ng-click="selectAge('40대')">40대</a></li>
                    <li><a ng-click="selectAge('50대 이상')">50대 이상</a></li>
                  </ul>
                </div>
                <div class="btn-group" role="group">
                  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="    padding: 0px 12px;">
                    지역별
                    <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    <li><a ng-click="selectLoc('')">전체</a></li>
                    <li ng-repeat="loc in locList"><a ng-click="selectLoc(loc.name)">{{loc.name}}</a></li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="panel-body" style="padding-top:5px;">
              <span class="label label-primary" ng-show="wholeFlag&&isLoginedUser" >전체</span>
              <span class="label label-primary" ng-bind="statData.sex"></span>
              <span class="label label-primary" ng-bind="statData.age"></span>
              <span class="label label-primary" ng-bind="statData.loc"></span>

              <div class="winlose" ng-show="!dataLoss&&isLoginedUser"  style="margin-top:10px;  background: -webkit-linear-gradient(left, #ff5e3a 0%,#ff5e3a {{WinLose.winPercent}}%,#34aadc {{WinLose.winPercent}}%,#34aadc 100%);
              background: linear-gradient(to right, #ff5e3a 0%,#ff5e3a {{WinLose.winPercent}}%,#34aadc {{WinLose.winPercent}}%,#34aadc 100%);">
              <div class="pull-left c_wl">
                승 {{WinLose.winPercent}}%
              </div>
              <div class="pull-right c_wl">
                패 {{WinLose.losePercent}}%
              </div>
            </div>
            <div class="alert alert-warning" ng-show="dataLoss&&isLoginedUser">데이터가 존재하지 않습니다</div>
            <div class="alert alert-info" role="alert"  ng-show="!isLoginedUser">회원에게만 공개됩니다</div>
          </div>
        </div>
      </div>
      <div class="col-xs-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">프로필 <i class="glyphicon glyphicon-heart c_gly"    ng-click="giveHeart(pid)"></i>{{personInfo.heart}} <i class="glyphicon glyphicon-remove c_gly" ng-click="giveX(pid)" ></i>{{personInfo.x}}
             기부 횟수: {{personInfo.giveCount}}</h3>

          </div>
          <div class="panel-body" id="profile_body">

          </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="heartModal">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">수정권한 포인트</h4>
              </div>
              <div class="modal-body">
                <form>
                  <div class="form-group">
                    <label for="point_give"><i class="glyphicon glyphicon-heart c_gly" data-toggle="modal" data-target="#point_heart"></i>에 기부할 포인트 (최대:{{heartModal.maxPoint}})</label>
                    <div class="input-group" id="point_give">
                      <input type="number" class="form-control" aria-describedby="basic-addon2" ng-model="heartModal.point">
                      <span class="input-group-addon" id="basic-addon2">포인트</span>
                    </div>
                  </div>
                </div>
              </form>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">취소</button>
                <button type="button" class="btn btn-primary" ng-click="sendHeart()">기부하기</button>
              </div>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <div class="modal fade" tabindex="-1" role="dialog" id="XModal">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">수정권한 포인트</h4>
              </div>
              <div class="modal-body">
                <form>
                  <div class="form-group">
                    <label for="point_give"><i class="glyphicon glyphicon-remove c_gly" data-toggle="modal" data-target="#point_remove"></i>에 기부할 포인트 (최대:{{XModal.maxPoint}})</label>
                    <div class="input-group" id="point_give">
                      <input type="number" class="form-control" aria-describedby="basic-addon2" ng-model="XModal.point">
                      <span class="input-group-addon" id="basic-addon2">포인트</span>
                    </div>
                  </div>
                </div>
              </form>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">취소</button>
                <button type="button" class="btn btn-primary" ng-click="sendX()">기부하기</button>
              </div>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-xs-12">
    <div class="jumbotron" style="padding:15px !important;"  >
      <h4>유저평 (by {{user_assess_name}}) <span class="label label-warning" ng-click="edit_user_assess()"  ng-show="userAssess_auth">수정하기</span></h4>
      <div id="user_access_body" style="font-size:14px;"></div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="user_assess_edit_modal">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">유저평 수정</h4>
          </div>
          <div class="modal-body">
            <div id="user_assess"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">취소</button>
            <button type="button" class="btn btn-primary" ng-click="save_user_assess()">수정하기</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  </div>
</div>
<!-- 투표페이지의 리플모음 -->
<div class="row" style="margin-top:0px;" id="reply_start">
  <div class="col-xs-12">
    <div class="page-header" style="margin: 20px 0 20px;">
      <strong>리플</strong>
    </div>
  </div>
  <div class="col-xs-12">
    <div class="input-group">
      <span class="input-group-addon">리플</span>
      <input type="text" class="form-control" aria-label="..." ng-model="reply_data" ng-keydown="keydown($event)">
      <span class="input-group-btn">
        <button ng-click="uploadReply()" class="btn btn-default" type="button">등록</button>
      </span>
    </div><!-- /input-group -->
  </div>
</div>
<div class="row" style="margin-top:10px;">
  <div class="col-xs-12" ng-repeat="reply in bestReplies">
    <div class="panel panel-default">
      <div class="panel-heading" style="padding:0 15px">
        <h3 class="panel-title">
          <span class="pull-left">
            <span class="label label-primary">베플</span>
            <span class="dropdown btn">
              <span class="dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" ng-click="loadUserInfo(reply.data.rid,reply.data.uid)">
                <strong>{{reply.data.name}}</strong>
              </span>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                <li><a href="">투표 p: {{userInfo[reply.data.rid].vote|number:0}}</a></li>
                <li><a href="">레벨 p: {{userInfo[reply.data.rid].level|number:0}}</a></li>
                <li><a href="">리플: {{userInfo[reply.data.rid].reply_count}}개</a></li>
              </ul>
            </span>
            <span class="reply_info">{{reply.data.time| date:'yyyy년 MM월 dd일 HH시 mm분 ss초'}}</span>
          </span>
          <div class="clearfix"></div>
        </h3>
      </div>
      <div class="panel-body" style="padding-bottom:0;">
        <p>{{reply.data.data}}</p>
      </div>
      <div class="panel-footer reply-footer">
        <span class="pull-left"><button class="label label-default" data-toggle="collapse" ng-href="#best_rereply_{{reply.RID}}" aria-expanded="false" aria-controls="rereply" ng-click="show_child_reply(reply.RID);">답글</button> {{reply.data.child_reply_count}}</span>
        <span class="pull-right">
          <i ng-click="boomUpDown(reply.RID,'up',reply.UID)"  class="glyphicon glyphicon-thumbs-up"></i> {{reply.data.up}}
          <i ng-click="boomUpDown(reply.RID,'down',reply.UID)" class="glyphicon glyphicon-thumbs-down"></i>{{reply.data.down}}
        </span>
        <div class="clearfix"></div>
      </div>
      <ul class="list-group collapse" id="best_rereply_{{reply.RID}}">
        <li class="list-group-item">
          <div class="input-group">
            <span class="input-group-addon" >답글</span>
            <input type="text" class="form-control" aria-label="..." id="child_reply_{{reply.RID}}"  ng-model="child_reply[reply.RID]">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button" ng-click="add_child_reply(reply.RID)">등록</button>
            </span>
          </div><!-- /input-group -->
        </li>
        <li class="list-group-item" ng-repeat="child_reply in  child_replies[reply.RID]">
          <!--  -->
          <div class="pull-left">&#8735; <strong>{{child_reply.name}}</strong>&nbsp<span><span class="reply_info">{{ child_reply.time| date:'yyyy년 MM월 dd일 HH시 mm분 ss초'}}</span></span>&nbsp<span ng-click="rerereply(child_reply.prid,child_reply.name)" class="label label-default"><i class="glyphicon glyphicon-pencil"></i>답글</span></div>
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

<!-- 일반 댓글 -->
<div class="row" style="margin-top:10px;">
  <div class="col-xs-12" ng-repeat="reply in replies">
    <div class="panel panel-default">
      <div class="panel-heading" style="padding:0 15px">
        <h3 class="panel-title">
          <span class="pull-left">
            <span class="dropdown btn" style="    padding: 6px 12px 6px 0px;">
              <span class="dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" ng-click="loadUserInfo(reply.rid,reply.uid)">
                <strong>{{reply.name}}</strong>
              </span>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenu1" >
                <li><a href="">투표 p: {{userInfo[reply.rid].vote|number:0}}</a></li>
                <li><a href="">레벨 p: {{userInfo[reply.rid].level|number:0}}</a></li>
                <li><a href="">리플: {{userInfo[reply.rid].reply_count}}개</a></li>
              </ul>
            </span>
            <span class="reply_info">{{reply.time| date:'yyyy년 MM월 dd일 HH시 mm분 ss초'}}</span>
          </span>
          <div class="clearfix"></div>
        </h3>
      </div>
      <div class="panel-body" style="padding-bottom:0;">
        <p>{{reply.data}}</p>
      </div>
      <div class="panel-footer reply-footer">
        <span class="pull-left"><button class="label label-default" data-toggle="collapse" ng-href="#rereply_{{reply.rid}}" aria-expanded="false" aria-controls="rereply" ng-click="show_child_reply(reply.rid);">답글</button> {{reply.child_reply_count}}</span>
        <span class="pull-right">
          <i ng-click="boomUpDown(reply.rid,'up',reply.uid)"  class="glyphicon glyphicon-thumbs-up"></i> {{reply.up}}
          <i ng-click="boomUpDown(reply.rid,'down',reply.uid)" class="glyphicon glyphicon-thumbs-down"></i>{{reply.down}}
        </span>
        <div class="clearfix"></div>
      </div>
      <ul class="list-group collapse" id="rereply_{{reply.rid}}">
        <li class="list-group-item">
          <div class="input-group">
            <span class="input-group-addon">답글</span>
            <input type="text" class="form-control" aria-label="..." id="child_reply_{{reply.rid}}" ng-model="child_reply[reply.rid]"
            ng-keydown="childKeydown($event,reply.rid)">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button" ng-click="add_child_reply(reply.rid)">등록</button>
            </span>
          </div><!-- /input-group -->
        </li>
        <li class="list-group-item" ng-repeat="child_reply in  child_replies[reply.rid]">
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
