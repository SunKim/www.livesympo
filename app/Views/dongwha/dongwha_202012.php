<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko">
<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="last-modified" content="thu,3 dec 2020 19:38:00">
<meta name="viewport" content="user-scalable=yes, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, width=device-width" />

<!-- Web Application. Independent Browser -->
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="mobile-web-app-capable" content="yes">

<meta name="subject" content="동화제약 - LiveSympo">
<meta name="title" content="동화제약 - LiveSympo">
<meta name="description" content="Live Sympo 개인정보 수집/이용 동의" />
<meta name="keywords" content="실시간, 심포지엄" />
<meta name="author" content="Sun Kim">
<meta name="other agent" content="Sun Kim">
<meta name="reply-to(email)" content="sjmarine97@gmail.com">
<meta name="location" content="Seoul, Korea">
<meta name="distribution" content="Sun Kim">
<meta name="robots" content="noindex,nofollow">
<!-- meta name="robots" content="all" -->

<title>동화제약</title>

<!-- stylesheets -->
<link href="/css/bootstrap.min.css" rel="stylesheet">
<link href="/css/sun.common.20200914.css" rel="stylesheet">
<link href="/css/livesympo.css" rel="stylesheet">

<!-- START) 메인 css -->
<style type="text/css">
body { background: #000; }
section.header { margin: 1rem 0; color: #5B4AFF; font-weight: 700; }
area { cursor: pointer; }

/* 768px 이하 -> 모바일 */
@media (max-width: 768px) {
}

/* 768~1200 -> 태블릿 */
@media (min-width: 769px) {
}

/* 1200px 이상 -> PC */
@media (min-width: 1200px) {
}
</style>
<!-- END) 메인 css -->

</head>

<body>

<div class="container">
    <section class="header">
		<h2>제목영역</h2>
    </section>
    <section class="content">
        <img src="/images/dongwha/livesympo_dongwha_20201203.jpeg" usemap="#imgmap" style="width: 100%;" />

        <map name="imgmap">
            <area shape="rect" coords="210,324,320,350" onclick="openLecture('a')">
        </map>
    </section>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/js/bootstrap.min.js"></script>

<script src="/js/sun.common.20200914.js"></script>

<!-- 메인 script -->
<script language="javascript">

// 초기화
function fnInit () {
}

function openLecture (lectureId) {
    alert('openLecture')
}

$(document).ready(function () {
    fnInit();
});

</script>

</body>

</html>
