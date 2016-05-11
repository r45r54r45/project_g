<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="kr">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1. user-scalable = no">
	<meta name="description" content="">
	<meta name="author" content="">
  <meta name="apple-mobile-web-app-capable" content="yes">
	<title>TEST</title>
	<script type="text/javascript" src="https://code.jquery.com/jquery-2.2.3.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<!-- <link rel="stylesheet" href="/src/animate.css"  charset="utf-8"> -->
	<link rel="stylesheet" href="//cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css" charset="utf-8">
	<script src="//cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js" charset="utf-8"></script>
	<!-- AngularJS -->
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.min.js"></script>
	<!-- Firebase -->
	<script src="https://cdn.firebase.com/js/client/2.2.4/firebase.js"></script>
	<!-- AngularFire -->
	<script src="https://cdn.firebase.com/libs/angularfire/1.2.0/angularfire.min.js"></script>
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<style>
	.grad{

	}
	.c_button{
		width:500px;
		margin-top: -100px;
	}
	body{
		background: #f1f1f2;
		overflow-y: hidden;

	}
	.modal-content{
		height: 100%;
		background-size: cover !important;
		background-position-x: -15px !important;
	}
	.modal-dialog{
		width:90%;
		height:90%;
	}
	.modal.fade .modal-dialog {
		-webkit-transform: translate(0, 0%);
		-ms-transform: translate(0, 0%);
		transform: translate(0, 0%);
		-webkit-transition: -webkit-transform 0.3s ease-out;
		-moz-transition: -moz-transform 0.3s ease-out;
		-o-transition: -o-transform 0.3s ease-out;
		transition: transform 0.3s ease-out;
	}
	.back_button{
		width: 80%;
		margin-left: 50px;
		margin-top: 230px;
	}
	.purchase_button{
		width: 80%;
		margin-right: 50px;
		margin-top: 230px;
	}

	</style>

	<script>
	$(function(){
    $("body").css("height",$(window).height());
		$(".grad").css("height",$(".col-xs-3").width());
		$(".grad").css("margin-top",($(window).height()-$(".grad").height())/3);
		$(".c_button").css("margin-left",($(window).width()-500)/2);
	});
	</script>
</head>
<body >
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-3">
				<img class="grad" onclick="$('#modal1').modal('show')"  src="https://lh6.googleusercontent.com/MvzxufOhCgwa3R-swOCjA-EJCXqKEpnm5j-nicrsghNE81D_5ke1lQdVtqrfB-oYMtu3CA=w2512-h1216">
			</div>
			<div class="col-xs-3">
				<img class="grad" onclick="$('#modal2').modal('show')"  src="https://lh5.googleusercontent.com/hA0ZDcx_3Lk2hk6NnnxnfVCwAAYtLm2vlq7-vb3Q5VT5LfMP76JsibHY75hGEzCqH-RYYA=w2512-h1218">
			</div>
			<div class="col-xs-3">
				<img class="grad" onclick="$('#modal3').modal('show')"  src="https://lh3.googleusercontent.com/QcJRkp7EQfBSVYq1CFbdIfNaoG4E_rtL9QMqAS1Dx3dI9eqIuCkr9R9sH1QhymuD327vkQ=w2512-h1218">
			</div>
			<div class="col-xs-3">
				<img class="grad" onclick="$('#modal4').modal('show')"  src="https://lh4.googleusercontent.com/rkXlsMsAm0mLn2vtiNP_Ci9mfUHduYiJkJPldkPZ_3jkVQx8a9iQE_lgYv88wNmAIoo-aQ=w2512-h1218">
			</div>
		</div>
		<div class="row">
			<div class="col-xs-3 offset-xs-3">
				<img  src="https://lh3.googleusercontent.com/KejFqT0svI_NCpjpF3A8ByiYjWebipMf8Y3l9nnUAELkGGSSxMTzx-sDPiWP6AfTA13nUQ=w2512-h1218" class="c_button">
			</div>
		</div>


	</div>

	<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content" style="background:url('https://lh6.googleusercontent.com/nuLvLutI7r-ic8fLh8G3kB-RQSlx7Z1NQYJ61NJ5Ihyegay_eOtSbWSi_eFE4luAg0siTA=w2512-h1218')">
				<div class="row">
					<div class="col-xs-3">
						<img class="img back_button" onclick="$('#modal1').modal('hide')"  src="https://lh6.googleusercontent.com/IBJaD_1wCS-6bUvL2mmNKKm_eNRZteRCGh-8ekIk5B2tvsncirn_0Y9qurGh_FH5N5QZgA=w2512-h1218">
					</div>
					<div class="col-xs-6">
					</div>
					<div class="col-xs-3">
						<img class="img purchase_button" onclick="$('#modal1').modal('hide')"  src="https://lh5.googleusercontent.com/m3z3t4xqtFYVD_FAJGgm-BUCLmr08f6Da3AsINbqjrq-9fZRZ9BNRXqIv7eNXLJwxRrdTw=w2512-h1218">
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal2" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content" style="background:url('https://lh6.googleusercontent.com/iwzRGW6Adtiug_PnW8fqZjjhEq-dF7lpsoWkt-2QT2PfYY62bIp8uoWCj_9Pfn2kaugnuw=w2512-h1218')">
				<div class="row">
					<div class="col-xs-3">
						<img class="img back_button" onclick="$('#modal2').modal('hide')"  src="https://lh6.googleusercontent.com/IBJaD_1wCS-6bUvL2mmNKKm_eNRZteRCGh-8ekIk5B2tvsncirn_0Y9qurGh_FH5N5QZgA=w2512-h1218">
					</div>
					<div class="col-xs-6">
					</div>
					<div class="col-xs-3">
						<img class="img purchase_button" onclick="$('#modal2').modal('hide')"  src="https://lh5.googleusercontent.com/m3z3t4xqtFYVD_FAJGgm-BUCLmr08f6Da3AsINbqjrq-9fZRZ9BNRXqIv7eNXLJwxRrdTw=w2512-h1218">
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal3" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content" style="background:url('https://lh4.googleusercontent.com/Cf6AVWgpkdbYZhv1Ecl4QFMW8l2ZjaLUNNvKYK1CS_5DzQ10kCGXn406F_TQWFXrOMxaBg=w2512-h1218')">
				<div class="row">
					<div class="col-xs-3">
						<img class="img back_button" onclick="$('#modal3').modal('hide')"  src="https://lh6.googleusercontent.com/IBJaD_1wCS-6bUvL2mmNKKm_eNRZteRCGh-8ekIk5B2tvsncirn_0Y9qurGh_FH5N5QZgA=w2512-h1218">
					</div>
					<div class="col-xs-6">
					</div>
					<div class="col-xs-3">
						<img class="img purchase_button" onclick="$('#modal3').modal('hide')"  src="https://lh5.googleusercontent.com/m3z3t4xqtFYVD_FAJGgm-BUCLmr08f6Da3AsINbqjrq-9fZRZ9BNRXqIv7eNXLJwxRrdTw=w2512-h1218">
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal4" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content" style="background:url('https://lh5.googleusercontent.com/4VPdhU-ZdPVZaJMyVw0EQtgLzgCJ0o_8q6vV8zmpABAz5PDhQcfL9u529RzT3V2UtS0k0A=w2512-h1218')">
				<div class="row">
					<div class="col-xs-3">
						<img class="img back_button" onclick="$('#modal4').modal('hide')"  src="https://lh6.googleusercontent.com/IBJaD_1wCS-6bUvL2mmNKKm_eNRZteRCGh-8ekIk5B2tvsncirn_0Y9qurGh_FH5N5QZgA=w2512-h1218">
					</div>
					<div class="col-xs-6">
					</div>
					<div class="col-xs-3">
						<img class="img purchase_button" onclick="$('#modal4').modal('hide')"  src="https://lh5.googleusercontent.com/m3z3t4xqtFYVD_FAJGgm-BUCLmr08f6Da3AsINbqjrq-9fZRZ9BNRXqIv7eNXLJwxRrdTw=w2512-h1218">
					</div>
				</div>
			</div>
		</div>
	</div>

</body>
</html>
