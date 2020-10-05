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

<title>Live Sympo - <?= $project['PRJ_TITLE'] ?></title>

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
header { padding: 1rem 0; }
div { text-align: center; }
form { display: inline-block; width: 100%; max-width: 100%;}
button { border: 0; color: #fff; }

video { width: 100%; }
.fcplayer_wrapper { width: 100% !important; height: 100% !important; }

div.container { padding-left: 0 !important; padding-right: 0 !important;}

/* 로고 영역 */
div.logo-container { display: flex; justify-content: space-between; align-items: center; }

/* 어젠다 영역 */
div.agenda-container { display: none; margin-bottom: 1rem; }
button.agenda {}
img.agenda-img { width: 100%; }

/* 768px 이하 -> 모바일 */
@media (max-width: 768px) {
    div.logo-container { padding: 0 1rem; }
    img.logo { width: 40%; }
    button.agenda { width: 6rem; }

    div.quest-container { padding: 10px; }
}

/* 768~1200 -> 태블릿 */
@media (min-width: 769px) {
    img.logo { width: 20%; }
}

/* 1200px 이상 -> PC */
@media (min-width: 1200px) {
    img.logo { width: 20%; }
}
</style>
<!-- END) 메인 css -->

</head>

<body>

<!-- 세션체크 -->
<?php include_once APPPATH.'Views/template/check_session.php'; ?>

<?php
    // print_r($session);
    $reqrSeq =  isset($session['reqrSeq']) ? $session['reqrSeq'] : 0;
    $reqrNm =  isset($session['reqrNm']) ? $session['reqrNm'] : '';
    $mbilno =  isset($session['mbilno']) ? $session['mbilno'] : '';
?>

<div class="container">
    <header>
        <div class="logo-container">
            <!-- <img class="logo" src="/images/logo/logo_type1.png" /> -->
            <span>&nbsp;</span>

            <button type="button" class="btn-main agenda" style="background: <?= $project['APPL_BTN_COLOR'] ?>" onclick="toggleAgenda();">아젠다</button>
        </div>
    </header>
    <section>
        <div class="agenda-container">
            <img class="agenda-img" src="<?= $project['AGENDA_IMG_URL'] ?>" />
        </div>
        <div>
			<?= $project['STREAM_URL'] ?>
        </div>
    </section>
    <hr class="mt20" style="background: #bbb;" />
    <section>
        <div class="quest-container">
            <p class="tl">* Q&A - 질문을 남겨주시면 강의 후 답변드립니다.</p>
            <textarea id="qstDesc" maxlength="400" rows="4" class="common-textarea w100 mt10 mb10" style="padding: 4px;"></textarea>
            <div class="tr">
                <button type="button" class="btn-main" style="background: <?= $project['APPL_BTN_COLOR'] ?>" onclick="saveQuest();">질문등록</button>
            </div>
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

<script src="/js/sun.common.20200914.js"></script>

<!-- 메인 script -->
<script language="javascript">

// 초기화
function fnInit () {
    showSpinner(300);

    // modal1('타이틀', '메세지람시롱');
}

// agenda toggle
function toggleAgenda () {
    $('.agenda-container').slideToggle();
}

function saveQuest () {
    // validation
    if (isEmpty($('#qstDesc').val())) {
        alert('질문내용을 입력해주세요.');
        $('#qstDesc').focus();
        return;
    }

    showSpinner();

    $.ajax({
    	type: 'POST',
    	url: '/stream/quest',
    	dataType: 'json',
    	cache: false,
    	data: {
            prjSeq: <?= $project['PRJ_SEQ'] ?>,
            reqrSeq: <?= $reqrSeq ?>,
            qstDesc: $('#qstDesc').val()
        },

    	success: function(data) {
    		// console.log(data)
    		if ( data.resCode == '0000' ) {
                alert('질문이 등록되었습니다. 감사합니다.');
                $('#qstDesc').val('');
    		} else {
    			alert('질문 등록 도중 오류가 발생했습니다.\n관리자에게 문의해주세요.\n\n코드(resCode) : '+data.resCode+'\n메세지(resMsg) : '+data.resMsg);
    		}
    	},
    	error: function (xhr, ajaxOptions, thrownError) {
    		console.error(xhr);
    		alert('질문 등록 도중 오류가 발생했습니다.\n관리자에게 문의해주세요.\n\n코드 : '+xhr.status+'\n메세지 : '+thrownError);
    	},
    	complete : function () {
    		hideSpinner();
    	}
    });
}

$(document).ready(function () {
    fnInit();
});

</script>

</body>

</html>
