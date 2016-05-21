<div class="container-fluid" style="margin-top:20px">
  <div class="row">
    <div class="col-xs-3">
      <div class="list-group" style="position: fixed; width: 23%; top: 70px;">
        <a href="#vote" class="list-group-item active">투표 관리</a>
        <a href="#user" class="list-group-item">회원 관리</a>
        <a href="#reply" class="list-group-item">리플 보기</a>
        <a href="#notice" class="list-group-item">공지 관리</a>
      </div>
    </div>
    <div class="col-xs-9 admin-row" ng-cloak>
      <div class="row" id="vote" ng-controller="admin.vote">
        <div class="col-xs-12">
          <blockquote>
            <strong>투표 관리</strong>
          </blockquote>
          <div class="row">
            <div class="col-xs-12">
              <ol class="breadcrumb" ng-init="currentVote={}">
                <li>{{currentVote.big.NAME}}</li>
                <li ng-show="currentVote.small">{{currentVote.small.NAME_KOR}} ({{currentVote.small.NAME_ENG}})</li>
              </ol>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-4">
              <div class="list-group">
                <a href="#" class="list-group-item disabled text-center">
                  대주제
                </a>
                <li class="list-group-item" ng-repeat="bs in big_subjects"><a ng-click="bs_select(bs)" >{{bs.NAME}}</a><a ng-click="bs_edit(bs)"><button class="label label-warning pull-right">수정
                </button></li>
              </a>
              <li class="list-group-item">
                <div class="input-group">
                  <input type="text" class="form-control" ng-model="big_subject">
                  <span class="input-group-btn">
                    <button ng-click="add_big_subject()" class="btn btn-default" type="button">추가</button>
                  </span>
                </div><!-- /input-group -->
              </li>
            </div>
          </div>
          <div class="col-xs-4">
            <ul class="list-group">
              <a href="#" class="list-group-item disabled text-center">
                소주제
              </a>

              <li class="list-group-item" ng-repeat="ss in small_subjects">
                <a ng-click="ss_select(ss)">{{ss.NAME_KOR}}</a><a ng-click="ss_reset(ss)"><span class="label label-danger pull-right">초기화
                </span></a><a ng-click="ss_edit(ss)"><span class="label label-warning pull-right">수정
                </span></a>
              </li>


              <li class="list-group-item">
                <div class="input-group">
                  <span class="input-group-btn">
                    <button ng-show="currentVote.big" class="btn btn-default btn-block" type="button" data-toggle="modal" data-target="#small_modal">추가</button>
                  </span>
                </div><!-- /input-group -->
              </li>
            </ul>
          </div>
          <!-- 소주제 모달 -->
          <div class="modal fade" tabindex="-1" role="dialog" id="small_modal" ng-init="ss_modal={}">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">소주제 추가/수정</h4>
                </div>
                <div class="modal-body">
                  <form>
                    <div class="form-group">
                      <label for="name_ko">한글명</label>
                      <input type="text" class="form-control" id="name_ko" ng-model="ss_modal.name_ko">
                    </div>
                    <div class="form-group">
                      <label for="url">영어명</label>
                      <input type="text" class="form-control" id="url" ng-model="ss_modal.name_eng">
                    </div>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" ng-model="ss_modal.check"> 투표메뉴 노출
                      </label>
                    </div>
                  </form>
                </div>

                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">닫기</button>
                  <button type="button" class="btn btn-primary" ng-click="add_small_subject(ss_modal)">저장</button>
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
          </div><!-- /.modal -->
          <div class="col-xs-4">
            <ul class="list-group">
              <a href="#" class="list-group-item disabled text-center">
                인물
              </a>
              <li class="list-group-item" ng-repeat="person in people">
                {{person.NAME}}<a ng-click="delete_person(person)"><span class="label label-danger pull-right">삭제
                </span></a><a ng-click="edit_person(person)"><span class="label label-warning pull-right">수정
                </span></a>
              </li>
              <li class="list-group-item">
                <div class="input-group">
                  <span class="input-group-btn">
                    <button ng-show="currentVote.small" class="btn btn-default btn-block" type="button" data-toggle="modal" data-target="#user_add_modal">추가</button>
                  </span>
                </div><!-- /input-group -->
              </li>
            </ul>
          </div>
          <!-- 인물 추가를 위한 모달 -->
          <div class="modal fade" id="user_add_modal" tabindex="-1" role="dialog" ng-init="person_modal={}">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">인물 추가/수정</h4>
                </div>
                <div class="modal-body">
                  <h4><span class="label label-default">인물 이름</span></h4>
                  <div class="input-group">
                    <input type="text" class="form-control" ng-model="person_modal.name">
                  </div>
                  <h4><span class="label label-default">프로필 내용</span></h4>
                  <div id="profile"></div>
                  <script>
                  $(document).ready(function() {
                    $('#profile').summernote();
                  });
                  </script>
                  <h4><span class="label label-default">사진</span></h4>
                  <div class="input-group">
                    <input type="file" id="fileinput" accept="image/*" />
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal" ng-click="change_edit_flag()">닫기</button>
                  <button ng-show="person_edit_flag" type="button" class="btn btn-primary" ng-click="add_person(person_modal)">저장</button>
                  <button ng-show="!person_edit_flag" type="button" class="btn btn-primary" ng-click="edit_person_submit(person_modal)">수정</button>
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
          </div><!-- /.modal -->
        </div>

      </div>
    </div>


    <!-- <div class="row" id="rating">
    <div class="col-xs-12">
    <blockquote>
    <strong>순위 관리</strong>
  </blockquote>
</div>
<div class="col-xs-12">
<div class="btn-group btn-group-justified" role="group" aria-label="...">
<div class="btn-group" role="group">
<button type="button" class="btn btn-default active">매시간 정각</button>
</div>
<div class="btn-group" role="group">
<button type="button" class="btn btn-default">하루 네번 (6,12,18,24)</button>
</div>
<div class="btn-group" role="group">
<button type="button" class="btn btn-default">하루 두번 (12,24)</button>
</div>
<div class="btn-group" role="group">
<button type="button" class="btn btn-default">하루 한번 (24)</button>
</div>
</div>
</div>
</div> -->

<div class="row" id="user">
  <div class="col-xs-12">
    <blockquote>
      <strong>회원 관리</strong>
    </blockquote>
  </div>
  <div class="col-xs-12">
    <div class="well">
      <table class="table user_table">
        <thead>
          <tr>
            <th>닉네임</th>
            <th>투표 p</th>
            <th>레벨 p</th>
            <th>레벨</th>
            <th>수정</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>홍길동</td>
            <td>1234</td>
            <td>1234</td>
            <td>12</td>
            <td>
              <button class="btn">수정</button>
            </td>
          </tr>
        </tbody>
      </table>
      <script>
      $(document).ready(function(){
        $('.user_table').DataTable();
      });
      </script>
    </div>
  </div>
</div>

<div class="row" id="reply">
  <div class="col-xs-12">
    <blockquote>
      <strong>리플 보기</strong>
    </blockquote>
  </div>
  <div class="col-xs-12">
    <div class="well">
      <table class="table reply_table">
        <thead>
          <tr>
            <th>소주제</th>
            <th>닉네임</th>
            <th>리플내용</th>
            <th>이동</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>홍길동</td>
            <td>1234</td>
            <td>1234</td>
            <td>
              <button class="btn">이동</button>
            </td>
          </tr>
        </tbody>
      </table>
      <script>
      $(document).ready(function(){
        $('.reply_table').DataTable({
          ordering:  false
        });
      });
      </script>
    </div>
  </div>
</div>

<div class="row" id="notice" ng-controller="admin.notice">
  <div class="col-xs-12">
    <blockquote>
      <strong>공지 관리</strong>
    </blockquote>
  </div>
  <div class="col-xs-12" style="margin-bottom:10px;">
    <button class="btn btn-block btn-info" data-toggle="modal" data-target="#notice_modal">공지 쓰기</button>
  </div>
  <div class="modal fade" tabindex="-1" role="dialog" id="notice_modal" ng-init="new_notice={}">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">공지 쓰기</h4>
        </div>
        <div class="modal-body">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">제목</button>
            </span>
            <input type="text" class="form-control" ng-model="new_notice.title">
          </div><!-- /input-group -->
          <div id="notice_input"></div>
          <script>
          $(document).ready(function() {
            $('#notice_input').summernote({
              height:300
            });
          });
          </script>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" ng-click="addNotice(new_notice)">게재</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  <div class="col-xs-12">
    <div class="well">
      <table class="table notice_table">
        <thead>
          <tr>
            <th>제목</th>
            <th>내용</th>
            <th>시간</th>
          </tr>
        </thead>
      </table>

    </div>
  </div>
</div>



</div>
</div>
</div>
