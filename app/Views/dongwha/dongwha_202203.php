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

<meta name="subject" content="동화약품 - LiveSympo">
<meta name="title" content="동화약품 - LiveSympo">
<meta name="description" content="Live Sympo 개인정보 수집/이용 동의" />
<meta name="keywords" content="실시간, 심포지엄" />
<meta name="author" content="Sun Kim">
<meta name="other agent" content="Sun Kim">
<meta name="reply-to(email)" content="sjmarine97@gmail.com">
<meta name="location" content="Seoul, Korea">
<meta name="distribution" content="Sun Kim">
<meta name="robots" content="noindex,nofollow">
<!-- meta name="robots" content="all" -->

<title>동화약품</title>

<!-- stylesheets -->
<link href="/css/bootstrap.min.css" rel="stylesheet">
<link href="/css/sun.common.20200914.css" rel="stylesheet">
<link href="/css/livesympo.css" rel="stylesheet">

<!-- START) 메인 css -->
<style type="text/css">
body { background: #000; }
section.header { margin: 1rem 0; color: #5B4AFF; font-weight: 700; }
area { cursor: pointer; }
img#img-agenda { width: 100%; height: 100%; }

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
		<!-- <h2>동화약품 심포지엄</h2> -->
    </section>
    <section class="content">
        <!-- <img src="/images/dongwha/livesympo_dongwha_20210503.jpeg" usemap="#imgmap" style="width: 100%;" />

        <map name="imgmap">
            <area shape="rect" coords="210,270,320,350" onclick="openLecture('lec1.pdf')">
            <area shape="rect" coords="210,365,320,390" onclick="openLecture('lec2.pdf')">
            <area shape="rect" coords="210,405,320,430" onclick="openLecture('lec3.pdf')">
            <area shape="rect" coords="210,657,320,682" onclick="openLecture('lec1.pdf')">
        </map> -->

        <!-- <img id="my_image" style="display: none;" src="/images/dongwha/livesympo_dongwha_20210503.jpeg" width="1140" height="859" border="0" usemap="#map" /> -->
        <img id="my_image" src="/images/dongwha/livesympo_dongwha_202203_01.jpg" width="1140" height="855" border="0" usemap="#map" />
		<!-- <img id="my_image" src="/images/dongwha/livesympo_dongwha_202203_02.jpg" width="1140" height="855" border="0" usemap="#map2" style="margin-top: 40px;margin-bottom: 40px;" /> -->

        <map name="map" id="map">
            <!-- <area shape="rect" coords="310,84,552,150" onclick="goToStream()"> -->
            <area shape="rect" coords="186,270,270,294" onclick="openLecture('<?= $DONGWHA_202203_LEC1_FILE_NM ?>', '<?= $DONGWHA_202203_LEC1_READY_YN ?>')">
            <area shape="rect" coords="186,304,270,328" onclick="openLecture('<?= $DONGWHA_202203_LEC2_FILE_NM ?>', '<?= $DONGWHA_202203_LEC2_READY_YN ?>')">
            <area shape="rect" coords="186,338,270,362" onclick="openLecture('<?= $DONGWHA_202203_LEC3_FILE_NM ?>', '<?= $DONGWHA_202203_LEC3_READY_YN ?>')">
            <area shape="rect" coords="186,424,270,448" onclick="openLecture('<?= $DONGWHA_202203_LEC4_FILE_NM ?>', '<?= $DONGWHA_202203_LEC4_READY_YN ?>')">
			<area shape="rect" coords="186,600,270,624" onclick="openLecture('<?= $DONGWHA_202203_LEC5_FILE_NM ?>', '<?= $DONGWHA_202203_LEC5_READY_YN ?>')">
			<area shape="rect" coords="186,680,270,704" onclick="openLecture('<?= $DONGWHA_202203_LEC6_FILE_NM ?>', '<?= $DONGWHA_202203_LEC6_READY_YN ?>')">
        </map>
		<!-- <map name="map2" id="map2">
            <area shape="rect" coords="380,560,1060,640" onclick="goToStream()">
        </map> -->
    </section>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/js/bootstrap.min.js"></script>
<script src="/js/sun.common.20200914.js"></script>

<!-- 메인 script -->
<script language="javascript">
var image_is_loaded = false;

// 초기화
function fnInit () {
    // cf) https://stackoverflow.com/a/23929444/796772
    $("#my_image").on('load',function() {
        $(this).data('width', $(this).attr('width')).data('height', $(this).attr('height'));
        $($(this).attr('usemap')+" area").each(function(){
            $(this).data('coords', $(this).attr('coords'));
        });

        $(this).css('width', '100%').css('height','auto').show();

        image_is_loaded = true;
        $(window).trigger('resize');
    });
}

function openLecture (fileNm, isReady) {
    // window.open(`/etc/dongwha_202203/${fileNm}`, '_blank');

    if (isReady == '1') {
        alert('준비중입니다.');
    } else {
        window.open(`/uploads/etc/dongwha_202203/${fileNm}`, '_blank');
    }
}

function goToStream () {
	window.open(`https://livesympo.kr/DONGWHA`, '_stream');
}

$(document).ready(function () {
    fnInit();
});

$(window).on('resize', function(){
    if (image_is_loaded) {
        var img = $("#my_image");
        var ratio = img.width()/img.data('width');

        $(img.attr('usemap')+" area").each(function(){
            // console.log('1: '+$(this).attr('coords'));
            $(this).attr('coords', ratioCoords($(this).data('coords'), ratio));
        });
    }
});

function ratioCoords (coords, ratio) {
    coord_arr = coords.split(",");

    for(i=0; i < coord_arr.length; i++) {
        coord_arr[i] = Math.round(ratio * coord_arr[i]);
    }

    return coord_arr.join(',');
}

</script>

</body>

</html>
