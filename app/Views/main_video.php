<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
	<meta http-equiv="Content-Script-Type" content="text/javascript" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<meta http-equiv="last-modified" content="mon,14 sep 2020 19:38:00">
	<meta name="viewport"
		content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, width=device-width" />

	<!-- Web Application. Independent Browser -->
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="mobile-web-app-capable" content="yes">

	<meta name="subject" content="영상기획 위드 홈페이지">
	<meta name="title" content="">
	<meta name="description" content="Live Sympo, 영상기획 위드" />
	<meta name="keywords" content="위드, 실시간, 심포지엄" />
	<meta name="author" content="Sun Kim">
	<meta name="other agent" content="Sun Kim">
	<meta name="reply-to(email)" content="sjmarine97@gmail.com">
	<meta name="location" content="Seoul, Korea">
	<meta name="distribution" content="Sun Kim">
	<!-- <meta name="robots" content="noindex,nofollow"> -->
	<meta name="robots" content="all">

	<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">

	<title>영상기획 위드 Live Sympo</title>

	<!-- START) 메인 css -->
	<style type="text/css">
	*,
	::before,
	::after {
		box-sizing: border-box;
		margin: 0;
		padding: 0;
	}

	body {
		font-family: roboto, sans-serif;
	}

	.home {
		height: 100vh;
		position: relative;
	}

	video {
		position: absolute;
		width: 100%;
		height: 100%;
		object-fit: cover;
	}

	.home-content {
		position: relative;
		padding-top: 150px;
		color: #fff;
		text-align: center;
	}

	h1 {
		font-family: Playfair Display, serif;
		font-size: clamp(45px, 7vw, 130px);
		line-height: 1.1;
	}

	.home p {
		font-size: clamp(25px, 4vw, 40px);
		margin-top: 10px;
	}

	.home-content button,
	.home-content a {
		display: block;
		font-size: clamp(14px, 1.5vw, 18px);
		border: 1px solid #f1f1f1;
		border-radius: 5px;
		background: transparent;
		color: #fff;
		margin: 50px auto 0;
		padding: 12px 20px;
		cursor: pointer;
		max-width: 40%;
	}

	/* 768px 이하 -> 모바일 */
	@media (max-width: 768px) {}

	/* 768~1200 -> 태블릿 */
	@media (min-width: 769px) {}

	/* 1200px 이상 -> PC */
	@media (min-width: 1200px) {}
	</style>
	<!-- END) 메인 css -->

</head>

<body>
	<div class="home">
		<video id="videoPlayer" muted loop autoplay>
			<source src="/videos/with_main3.mp4" type="video/mp4">
		</video>
		<!-- <div class="home-content">
			<h1>WITH</h1>
			<p>영상기획</p>

			<!-- <button>nabdo@naver.com</button> --
			<a href="mailto:nabdo@naver.com">nabdo@naver.com</a>
			<a href="tel:010-4782-6737">010-4782-6737</a>
		</div> -->
	</div>

	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
	<!-- <script src="/js/bootstrap.min.js"></script> -->
	<!-- <script src="/js/sun.common.20200914.js"></script> -->

	<!-- 메인 script -->
	<!-- <script language="javascript">
	$(document).ready(function() {

	});
	</script> -->

	<script>
	function changeVideoSource() {
		var videoPlayer = document.getElementById('videoPlayer');
		if (window.innerWidth < 768) { // 가정: 768px 이하는 모바일로 간주
			videoPlayer.src = '/videos/with_main3_m.mp4';
		} else {
			videoPlayer.src = '/videos/with_main3.mp4';
		}
	}

	// 화면 크기 변경 시 비디오 소스 변경
	window.addEventListener('resize', changeVideoSource);

	// 페이지 로드 시 비디오 소스 설정
	changeVideoSource();
	</script>

</body>

</html>