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

/* 설문 영역 */
input[type=checkbox], input[type=radio] { margin-right: 0.3rem; border: 1px solid #cacece; -ms-transform: scale(1.2); -moz-transform: scale(1.2); -webkit-transform: scale(1.2); transform: scale(1.2); }
div.survey-container { padding: 1rem; display: none; }
div.survey-container p { text-align: left !important; }
div.survey-container li { text-align: left !important; }
span.qst-no { width: 1.4rem; height: 1.4rem; line-height: 1.4rem; background: <?= $project['APPL_BTN_COLOR'] ?>; color: #fff; border: 1px solid <?= $project['APPL_BTN_COLOR'] ?>; border-radius: 4px; text-align: center; vertical-align: middle; font-weight: 700; }
p.qst-title { line-height: 1.4rem; }
li.survey-qst-item { margin-bottom: 1rem; }
ul.qst-choice-list { margin-top: 0.6rem; }
ul.qst-choice-list li { margin-top: 0.2rem; }
label.choice-label input { margin-right: 0.4rem; }

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

			<div>
				<button type="button" class="btn-main agenda" style="background: <?= $project['APPL_BTN_COLOR'] ?>" onclick="toggleAgenda();">아젠다확인</button>
				<button type="button" class="btn-main agenda open-survey ml10" style="background: <?= $project['APPL_BTN_COLOR'] ?>" onclick="openSurvey();">설문조사</button>
			</div>
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
	<section>
        <div class="survey-container">
			<ul class="survey-qst-list mt20">
			</ul>
			<div class="tr">
                <button type="button" class="btn-main" style="background: <?= $project['APPL_BTN_COLOR'] ?>" onclick="saveAnswer();">설문답변 저장</button>
            </div>
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

let surveyQstList = [];
let surveyQstChoiceList = [];

// 초기화
function fnInit () {
    showSpinner(300);

	// modal1('타이틀', '메세지람시롱');
	surveyQstList = <?php echo json_encode($surveyQstList) ?>;
	surveyQstChoiceList = <?php echo json_encode($surveyQstChoiceList) ?>;
	// console.log(`surveyQstList - ${JSON.stringify(surveyQstList)}`);
	// console.log(`surveyQstChoiceList - ${JSON.stringify(surveyQstChoiceList)}`);

	$('.survey-qst-list').empty();

	surveyQstList.forEach(item => {
		let html = '';

		html += '<li QST_NO="'+item.QST_NO+'" QST_TP="'+item.QST_TP+'" QST_MULTI_YN="'+item.QST_MULTI_YN+'" class="survey-qst-item d-flex align-items-start justify-content-around">';
		html += '	<div style="text-align: left !important; min-width: 2rem">';
		html += '		<span class="qst-no">'+item.QST_NO+'</span>';
		html += '	</div>';
		html += '	<div class="w100">';
		html += '		<p class="qst-title">'+item.QST_TITLE+'</p>';

		if (item.QST_TP == '객관식') {
			html += '		<ul class="qst-choice-list">';
			html += '		</ul>';
		} else if (item.QST_TP == '주관식') {
			html += '		<textarea class="common-textarea w100 mt10 mb10" name="ASW_'+item.QST_NO+'" maxlength="100" rows="4"></textarea>';
		}

		html += '	</div>';
		html += '</li>';

		$('.survey-qst-list').append(html);
	});

	surveyQstChoiceList.forEach(item => {
		let html = '';

		html += '<li>';
		html += '	<span class="choice">';
		html += '		<label class="choice-label">';

		if (item.QST_MULTI_YN == 1) {
			html += '			<input type="checkbox" name="ASW_'+item.QST_NO+'" value="'+item.CHOICE_NO+'" />';
		} else if (item.QST_MULTI_YN == 0) {
			html += '			<input type="radio" name="ASW_'+item.QST_NO+'" value="'+item.CHOICE_NO+'" />';
		}

		html += '			'+item.CHOICE;
		html += '		</label>';
		html += '	</span>';
		html += '</li>';

		$('.survey-qst-list li[QST_NO='+item.QST_NO+'] ul.qst-choice-list').append(html);
	});
}

// 설문목록 열기
function openSurvey () {
	$('.survey-container').slideToggle();
}

// 설문 답변 저장
function saveAnswer () {
	// validation 및 값 저장
	const surveyAswItem = {
		PRJ_SEQ: <?= $project['PRJ_SEQ'] ?>,
		REQR_SEQ: <?= $reqrSeq ?>
	};

	let valMsg = '';
	$('li.survey-qst-item').each(function () {
		// 답변이 없는거 체크
		const qstNo = $(this).attr('QST_NO');

		if ($(this).attr('QST_TP') === '객관식') {
			// console.log(`${qstNo} : ${$(this).find('input[name=ASW_'+qstNo+']:checked').val()}`);
			// validation
			if (isEmpty($(this).find('input[name=ASW_'+qstNo+']:checked').val())) {
				valMsg += `${qstNo}번 질문에 답변을 입력해주세요.\n`;
			}

			// 값 설정 (checkbox인 경우 추가처리 필요)
			if ($(this).attr('QST_MULTI_YN') == '0') {
				surveyAswItem[`ASW_${qstNo}`] = $(this).find('input[name=ASW_'+qstNo+']:checked').val();
			} else {
				let aswArr = $(this).find('input[name=ASW_'+qstNo+']:checked').map(function () {return this.value;}).get().join(',');
				surveyAswItem[`ASW_${qstNo}`] = aswArr;
			}
		} else {
			// console.log(`${qstNo} : ${$(this).find('textarea[name=ASW_'+qstNo+']').val()}`);
			// validation
			if (isEmpty($(this).find('textarea[name=ASW_'+qstNo+']').val())) {
				valMsg += `${qstNo}번 질문에 답변을 입력해주세요.\n`;
			}

			// 값 설정
			surveyAswItem[`ASW_${qstNo}`] = $(this).find('textarea[name=ASW_'+qstNo+']').val();
		}
	});

	if (valMsg !== '') {
		alert(valMsg);
		return;
	}
	console.log(`surveyAswItem - ${JSON.stringify(surveyAswItem)}`);

    showSpinner();

    $.ajax({
    	type: 'POST',
    	url: '/stream/surveyAsw',
    	dataType: 'json',
    	cache: false,
    	data: {
            surveyAswItem
        },

    	success: function(data) {
    		// console.log(data)
    		if ( data.resCode == '0000' ) {
                alert('설문 답변이 등록되었습니다.\n참여해주셔서 대단히 감사합니다.');

				$('div.survey-container').hide();
				$('button.open-survey').hide();
    		} else {
    			alert('설문 답변 등록 도중 오류가 발생했습니다.\n관리자에게 문의해주세요.\n\n코드(resCode) : '+data.resCode+'\n메세지(resMsg) : '+data.resMsg);
    		}
    	},
    	error: function (xhr, ajaxOptions, thrownError) {
    		console.error(xhr);
    		alert('설문 답변 등록 도중 오류가 발생했습니다.\n관리자에게 문의해주세요.\n\n코드 : '+xhr.status+'\n메세지 : '+thrownError);
    	},
    	complete : function () {
    		hideSpinner();
    	}
    });
}

// agenda toggle
function toggleAgenda () {
    $('.agenda-container').slideToggle();
}

// 질문 저장
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
