<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko">
<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="last-modified" content="mon,14 sep 2020 19:38:00">
<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, width=device-width" />

<!-- Web Application. Independent Browser -->
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="mobile-web-app-capable" content="yes">

<meta name="subject" content="Live Sympo">
<!-- TODO title DB에서 -->
<meta name="title" content="">
<meta name="description" content="Live Sympo 입장" />
<meta name="keywords" content="실시간, 심포지엄" />
<meta name="author" content="Sun Kim">
<meta name="other agent" content="Sun Kim">
<meta name="reply-to(email)" content="sjmarine97@gmail.com">
<meta name="location" content="Seoul, Korea">
<meta name="distribution" content="Sun Kim">
<meta name="robots" content="noindex,nofollow">
<!-- meta name="robots" content="all" -->

<!-- TODO title DB에서 -->
<title>Live Sympo - </title>

<!-- stylesheets -->
<link href="/css/bootstrap.min.css" rel="stylesheet">
<link href="/css/sun.common.20200914.css" rel="stylesheet">
<link href="/css/livesympo.css" rel="stylesheet">

<!-- loading spinner를 위한 font-awesome. <span class="fa fa-spinner fa-spin fa-3x". ></span>. 아이콘 참고 - https://fontawesome.com/v4.7.0/icons/ -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<!-- Bootstrap-select. cf) https://silviomoreto.github.io/bootstrap-select -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">

<!-- START) 메인 css -->
<style type="text/css">
div.main-img-container { position: relative; }
img.main-img { display: block; width: 100%; }
button.btn-apply { display: inline-block; font-weight: 700; color: #FFF; }

/* 768px 이하 -> 모바일 */
@media (max-width: 768px) {
	/* button.btn-apply { bottom: 0px; left: calc(100vw - 240px / 2 - 0.1em); width: 240px; font-size: 16px; } */
	button.btn-apply { left: calc((100% - 60%) / 2); width: 60%; font-size: 16px; padding: 0.2em; }
}
/* 768~1140 -> 태블릿 */
@media (min-width: 769px) {
	button.btn-apply { bottom: 20px; right: 100px; width: 280px; font-size: 20px; }
}
/* 1140px 이상 -> PC */
@media (min-width: 1200px) {
	button.btn-apply { float: right; width: 330px; height: 70px; font-size: 24px; letter-spacing : 0.2em; }
}
</style>
<!-- END) 메인 css -->

</head>

<body>

<!-- 세션체크 -->
<!-- <?php include_once APPPATH.'Views/template/check_session.php'; ?> -->

<?php
	$reqrSeq =  $session['reqrSeq'];
	$reqrNm =  $session['reqrNm'];
?>

<div class="container">
	<section class="main-img">
		<div class="main-img-container">
			<img class="main-img" src="<?php echo $project['MAIN_IMG_URI']; ?>" />
		</div>
		<div class="apply-btn-container">
			<button class="btn-apply" style="background: <?php echo $project['APPL_BTN_COLOR']; ?>">사전등록</button>
		</div>
	</section>
</div>

<!-- 공통모달 -->
<?php include_once APPPATH.'Views/template/common_modal.php'; ?>

<!-- 토스트 -->
<?php include_once APPPATH.'Views/template/common_toast.php'; ?>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/js/bootstrap.min.js"></script>

<!-- Bootstrap-select -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>

<!-- <script src="/js/sun.common.20190313.js"></script>
<script src="/js/autofit.js"></script> -->

<!-- 메인 script -->
<script language="javascript">

// 초기화
function fnInit () {
	showSpinner(1000);

	// modal1('타이틀', '메세지랑께');
}

$(document).ready(function () {
	fnInit();

	//submit 되기 전 처리
	$('form').submit(function( event ) {

	});
});

</script>

</body>

</html>
