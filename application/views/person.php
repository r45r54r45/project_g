<div class="container" style="margin-top:20px;">
  <div class="row">
    <div class="col-sm-3 col-xs-12">
      <img src="http://www.khcanada.com/data/file/sportsnews/1369538022_pDLnl2dF_20130702022415_0.jpg" class="img img-responsive img-thumbnail">
    </div>
    <div class="col-sm-9 col-xs-12">
      <div class="row">
        <div class="col-xs-12 col-sm-6">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">전체 순위 (--기준)</h3>
            </div>
            <div class="panel-body">
              00등
            </div>
          </div>
        </div>
        <div class="col-xs-12 col-sm-6">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">축구선수 순위 (--기준)</h3>
            </div>
            <div class="panel-body">
              00등
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
              000승 / 000패
              <p>(서울 30% 경기 30% 기타 40%)</p>
              <div class="alert alert-info" role="alert">회원에게만 공개됩니다</div>
            </div>
          </div>
        </div>
        <div class="col-xs-12 col-sm-6">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">총점</h3>
            </div>
            <div class="panel-body">
              000 p
              <div class="alert alert-info" role="alert">회원에게만 공개됩니다</div>
            </div>
          </div>
        </div>
        <div class="col-xs-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">프로필 <i class="glyphicon glyphicon-heart c_gly" data-toggle="modal" data-target="#point_heart"></i>000 <i class="glyphicon glyphicon-remove c_gly" data-toggle="modal" data-target="#point_remove"></i>000</h3>
            </div>
            <div class="panel-body">
              프로필
            </div>
          </div>
          <div class="modal fade" tabindex="-1" role="dialog" id="point_heart">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">수정권한 포인트</h4>
                </div>
                <div class="modal-body">
                  <form>
                    <div class="form-group">
                      <label for="point_give"><i class="glyphicon glyphicon-heart c_gly" data-toggle="modal" data-target="#point_heart"></i>에 기부할 포인트</label>
                      <div class="input-group" id="point_give">
                        <input type="number" class="form-control" aria-describedby="basic-addon2">
                        <span class="input-group-addon" id="basic-addon2">포인트</span>
                      </div>
                    </div>
                  </div>
                </form>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">취소</button>
                  <button type="button" class="btn btn-primary">기부하기</button>
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
          </div><!-- /.modal -->
          <div class="modal fade" tabindex="-1" role="dialog" id="point_remove">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">수정권한 포인트</h4>
                </div>
                <div class="modal-body">
                  <form>
                    <div class="form-group">
                      <label for="point_give"><i class="glyphicon glyphicon-remove c_gly" data-toggle="modal" data-target="#point_remove"></i>에 기부할 포인트</label>
                      <div class="input-group" id="point_give">
                        <input type="number" class="form-control" aria-describedby="basic-addon2">
                        <span class="input-group-addon" id="basic-addon2">포인트</span>
                      </div>
                    </div>
                  </div>
                </form>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">취소</button>
                  <button type="button" class="btn btn-primary">기부하기</button>
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
      <div class="jumbotron">
        <h3>유저평 (by 닉네임) <span class="label label-warning" data-toggle="modal" data-target="#user_assess_edit">수정하기</span></h3>
        <p>...</p>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="user_assess_edit">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">유저평 수정</h4>
            </div>
            <div class="modal-body">
              <div id="user_assess"></div>
              <script>
              $(document).ready(function() {
                $('#user_assess').summernote();
              });
              </script>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">취소</button>
              <button type="button" class="btn btn-primary">수정하기</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->
    </div>
  </div>
  <!-- 투표페이지의 리플모음 -->
  <div class="row" style="margin-top:0px;">
    <div class="col-xs-12">
      <div class="page-header" style="margin: 20px 0 20px;">
        <strong>리플</strong>
      </div>
    </div>
    <div class="col-xs-12">
      <div class="input-group">
        <span class="input-group-addon">리플</span>
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
            <span class="pull-left"><span class="label label-primary">베플</span>
            <span class="dropdown">
              <button class="dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                닉네임
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                <li><a href="#">투표 p: 000</a></li>
                <li><a href="#">레벨 p: 000</a></li>
                <li><a href="#">리플: 30개</a></li>
              </ul>
            </span>
            시간 지역 </span>
            <div class="clearfix"></div>
          </h3>
        </div>
        <div class="panel-body" style="padding-bottom:0;">
          <p>ddd</p>
        </div>
        <div class="panel-footer reply-footer">
          <span class="pull-left"><span class="label label-default" data-toggle="collapse" href="#rereply" aria-expanded="false" aria-controls="rereply">답글</span> 00</span>
          <span class="pull-right">
            <i class="glyphicon glyphicon-thumbs-up"></i> 00
            <i class="glyphicon glyphicon-thumbs-down"></i>00
          </span>
          <div class="clearfix"></div>
        </div>
        <ul class="list-group collapse" id="rereply">
          <li class="list-group-item">
            <div class="input-group">
              <span class="input-group-addon">답글</span>
              <input type="text" class="form-control" aria-label="...">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button">등록</button>
              </span>
            </div><!-- /input-group -->
          </li>
          <li class="list-group-item">
            <!--  -->
            <div class="pull-left">&#8735; <strong>김우현</strong>&nbsp<span>시간 지역</span>&nbsp<span class="label label-default"><i class="glyphicon glyphicon-pencil"></i>답글</span></div>
            <div class="pull-right">  <i class="glyphicon glyphicon-thumbs-up"></i> 00
              <i class="glyphicon glyphicon-thumbs-down"></i>00</div>
              <div class="clearfix"></div>
              <div class="pull-left" style="padding-left: 17px;">내용내용</div>
              <div class="clearfix"></div>
            </li>

            <li class="list-group-item">
              <nav>
                <ul class="pagination pagination-sm" style="margin:0;">
                  <!-- <li>
                  <a href="#" aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
                </a>
              </li> -->
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
        </li>
      </ul>
    </div>
  </div>
</div>
</div>
