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
		/* box-sizing: border-box; */
		margin: 0;
		padding: 0;
	}

	video.fullscreen {
		position: absolute;
		z-index: 0;
		object-fit: cover;
		width: 100%;
		height: 100%;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);

		&::-webkit-media-controls {
			display: none !important;
		}
	}

	.container {
		position: relative;
		display: grid;
		place-items: center;
		height: 100dvh;
		width: 100dvw;
		margin: 0 auto;
		background: #ccc;
	}

	.content {
		z-index: 1;
	}

	body {
		height: 100dvh;
		display: grid;
		place-items: center;
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
	<section class="container">
		<video id="videoPlayer" class="fullscreen" playsinline autoplay muted loop>
			<source src="/videos/with_main3.mp4" type="video/mp4">
		</video>

		<!-- <div class="content">
			<h1>Headline</h1>
		</div> -->

	</section>

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