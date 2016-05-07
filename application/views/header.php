<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="kr">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Repute</title>


  <script type="text/javascript" src="https://code.jquery.com/jquery-2.2.3.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
  <link href="/src/common.css" rel="stylesheet">
  <script src="/src/jquery.easy-autocomplete.min.js" charset="utf-8"></script>
  <link rel="stylesheet" href="/src/easy-autocomplete.min.css"  charset="utf-8">
  <link rel="stylesheet" href="/src/easy-autocomplete.themes.min.css"  charset="utf-8">
  <link rel="stylesheet" href="/src/animate.css"  charset="utf-8">
  <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.1/summernote.css" rel="stylesheet">
  <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.1/summernote.js"></script>
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css" charset="utf-8">
  <script src="//cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js" charset="utf-8"></script>
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body>
  <nav role="navigation" class="navbar navbar-default navbar-fixed-top" ng-controller="navbar">
    <div class="container">
      <div class="navbar-header pull-left">
        <a href="/" class="navbar-brand">Repute</a>
      </div>
      <!-- 'Sticky' (non-collapsing) right-side menu item(s) -->
      <div class="navbar-header pull-right">
        <ul class="nav pull-left">
          <li class="dropdown pull-right">
            <a href="#" class="dropdown-toggle nav-dropdown-a" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
              <div class="nav-i-wrapper">
                <i class="nav-gly glyphicon glyphicon-user"></i>
              </div>
            </a>
            <ul class="dropdown-menu pull-right" style="padding: 10px 15px;">
              <form>
                <div class="form-group">
                  <label for="exampleInputEmail1">닉네임</label>
                  <div class="input-group">
                    <input type="text" class="form-control">
                  </div>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">비밀번호</label>
                  <div class="input-group">
                    <input type="text" class="form-control">
                  </div>
                </div>
                <div class="checkbox">
                  <label class="control-label">
                    <input type="checkbox" value="">로그인 유지
                  </label>
                </div>
                <button type="submit" class="btn btn-default btn-block">로그인</button>
                <a href="/join" role="button" class="btn btn-default btn-block">회원가입</a>
              </form>
            </ul>
          </li>
          <li class="dropdown pull-right">
            <a href="#" class="dropdown-toggle nav-dropdown-a" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
              <div class="nav-i-wrapper">
                <i class="nav-gly glyphicon glyphicon-comment"></i>
                <span class="badge" id="alarm-badge">4</span>
              </div>
            </a>
            <ul class="list-group dropdown-menu ">
              <!-- alert 메세지 리스트 나오는 부분 -->
              <li class="">
                <a href="#" class="c_alarm_list">
                  <div>
                    <i class="fa fa-comment fa-fw"></i>
                    <span>new co</span>
                    <span class="pull-right">2분전</span>
                  </div>
                </a>
                <div class="divider"></div>
              </li>
            </ul>
          </li>
          <li class="dropdown  pull-right" style="margin-left: 10px;">
            <a href="#" class="dropdown-toggle nav-dropdown-a" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
              <div class="nav-i-wrapper">
                <i class="nav-gly glyphicon glyphicon-search"></i>
              </div>
            </a>
            <ul class="dropdown-menu pull-right" style=" padding:0;">
              <form class="form-group" style="margin-bottom:0;">
                <input class="form-control" id="searchName">
                <script>
                var options = {
                  url: "/data/searchName",
                  list: {
                    match: {
                      enabled: true
                    }
                  },
                  theme: "square"
                };
                $("#searchName").easyAutocomplete(options);
                </script>
                <button class="btn btn-success btn-block" style="border-radius:0;">검색</button>
              </form>
            </ul>
          </li>
        </ul>
        <!-- Required bootstrap placeholder for the collapsed menu -->
        <button type="button" data-toggle="collapse" data-target=".navbar-collapse" class="navbar-toggle"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
        </button>
      </div>

      <!-- The Collapsing items -->
      <div class="visible-xs-block clearfix"></div>
      <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">투표</a>
            <ul class="dropdown-menu">
              <li ng-repeat="categories in category"><a ng-href="{{categories.url}}">{{categories.name}}</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="/sitemap">전체보기</a></li>
            </ul>
          </li>
          <li  class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">순위</a>
            <ul class="dropdown-menu">
              <li><a href="/ranking">전체 순위</a></li>
              <li><a href="/ranking/field">분야별 순위</a></li>
            </ul>
          </li>
          <li  class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">공지</a>
            <ul class="dropdown-menu">
              <li><a href="/notice">공지</a></li>
              <li><a href="/help">건의</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
