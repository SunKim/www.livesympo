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

div.container { padding-left: 0 !important; padding-right: 0 !important;}

/* 로고 영역 */
div.logo-container { text-align: left; }

/* 메인이미지 영역 */
div.main-img-container { }
img.main-img { display: block; width: 100%; }
button.btn-apply { display: inline-block; font-weight: 700; color: #FFF; border: 0; }
button.btn-enter { border: 0; font-size: 1.2rem; font-weight: 600; }

/* 입장폼 및 어젠다 영역 */
img.agenda-img { width: 100%; }
section.form { margin-top: 0.6rem; }
div.form-container { color: #fff; padding: 0.6rem; }

form.enter-form table { width: 100%; }
form.enter-form td { padding: 0.6rem; }
form.enter-form td.td-input { width: 70%; }
form.enter-form td.td-input span { width: 5rem; }
form.enter-form td.td-input input { width: calc(100% - 7rem); color: #333; }
form.enter-form td.td-btn { width: 30%; }
button.btn-enter { width: 100%; height: 100%; font-size: 1rem;  }
div.chrome-guide { padding: 0.6rem; }
ul.enter-guide li::before { content: "-"; margin-right: 0.5rem; }
div.chrome-guide p { text-align: left; }

/* 하단 footer 영역 */
img.footer-img { width: 100%; }

/* 사전등록 입력 모달 영역 */
table.table-apply th.required::after { content: '*'; display: inline-block; margin-left: 3px; font-size: 15px; color: #E12222; }

/* 768px 이하 -> 모바일 */
@media (max-width: 768px) {

    div.logo-container { padding: 0 1rem; }
    img.logo { width: 30%; }
    div.apply-btn-container { text-align: center; margin-top: 0.6rem; }
    button.btn-apply { width: 20rem; height: 2.4rem; font-size: 1.2rem; padding: 0.2rem; }

    div.agenda-container { display: block; }
    div.form-container { display: block; }
    div.form-container form.enter-form { margin: 0 auto; }
}

/* 768~1200 -> 태블릿 */
@media (min-width: 769px) {
    img.logo { width: 20%; }

    div.apply-btn-container { text-align: right; margin-top: 0.6rem; }
    button.btn-apply { width: 20rem; height: 3rem; font-size: 1.2rem; padding: 0.2rem; }

    div.agenda-container { display: block; }
    div.form-container { display: block; }
    div.form-container .enter-form { width: 768px; }
}

/* 1200px 이상 -> PC */
@media (min-width: 1200px) {
    img.logo { width: 20%; }

    div.apply-btn-container { text-align: right; margin-top: 10px; }
    /* button.btn-apply { float: right; width: 330px; height: 70px; font-size: 24px; letter-spacing : 0.2em; } */
    button.btn-apply { width: 28rem; height: 3.4rem; font-size: 1.2rem; padding: 0.2rem; }

    section.form { display: flex; align-items: stretch; justify-content: space-between; }
    div.agenda-container { display: inline-block; width: 50%; }
    div.form-container { display: inline-block; width: 50%; }
}
</style>
<!-- END) 메인 css -->

</head>

<body>

<!-- 세션체크 -->
<!-- <?php include_once APPPATH.'Views/template/check_session.php'; ?> -->

<div class="container">
    <header>
        <div class="logo-container">
            <img class="logo" src="/images/logo/logo_type1.png" />
        </div>
    </header>
    <section class="main">
        <div class="main-img-container">
            <img class="main-img" src="<?= $project['MAIN_IMG_URL'] ?>" />
        </div>
        <div class="apply-btn-container">
            <button class="btn-apply" style="background: <?= $project['APPL_BTN_COLOR'] ?>" onclick="openApply();">사전등록</button>
        </div>
    </section>
    <section class="form">
        <div class="agenda-container">
            <img class="agenda-img" src="<?= $project['AGENDA_IMG_URL'] ?>" />
        </div>
        <div class="form-container" style="background: <?= $project['ENT_THME_COLOR'] ?>">
            <form class="enter-form" method="post">
                <table>
                    <tr>
                        <td class="td-input">
                            <p>
                                <span style="font-size: 1.1rem">성&nbsp;&nbsp;&nbsp;명</span>
                                <input type="text" id="reqrNm" class="common-input ml10" placeholder="" />
                            </p>
                            <p class="mt6">
                                <span style="font-size: 1.1rem">휴대폰</span>
                                <input type="text" id="mbilno" class="common-input ml10" placeholder="- 없이 입력해주세요" />
                            </p>
                        </td>
                        <td class="td-btn">
                            <button type="button" class="btn-enter" style="font-size: 1.1rem; background: <?= $project['APPL_BTN_COLOR'] ?>" onclick="enter();">심포지엄<br />입장</button>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="tl">
                            <ul class="enter-guide">
                                <li>사전등록시 입력하신 선생님의 성명과 연락처를 입력해주세요.</li>
                                <li>현장등록시 사전등록이 안되신 분은 사전등록 후 이용해주세요.</li>
                            </ul>
                        </td>
                    </tr>
                </table>
                <hr />

                <div class="chrome-guide">
                    <p>인터넷 익스플로러에서는 동영상재생이 원활하지 않을 수 있습니다. 가급적 크롬을 이용하여 시청해주세요.</p>
                    <p>
                        <a href="https://www.google.co.kr/chrome" target="_chrome">[크롬 브라우저 설치]</a>
                    </p>
                </div>
            </form>
        </div>
    </section>
</div>
<div class="container">
    <footer>
        <img class="footer-img" src="<?= $project['FOOTER_IMG_URL'] ?>" />
    </footer>
</div>

<!-- 사전등록 Modal -->
<div id="applyModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="applyModalTitle" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title tl" id="applyModalTitle">사전등록</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
			</div>
			<div class="modal-body">
				<table class="table-apply">
                    <tbody>
<?php
    foreach($entInfoList as $entInfoItem) {
        echo '<tr PRJ_ENT_INFO_SEQ="'.$entInfoItem['PRJ_ENT_INFO_SEQ'].'" SERL_NO="'.$entInfoItem['SERL_NO'].'">';
        echo '	<th '.($entInfoItem['REQUIRED_YN'] == 1 ? 'class="required"' : '').'>'.$entInfoItem['ENT_INFO_TITLE'].'</th>';
        echo '	<td '.($entInfoItem['REQUIRED_YN'] == 1 ? 'class="required"' : '').'>';
        echo '		<input type="text" class="ent-info common-input w100" placeholder="'.$entInfoItem['ENT_INFO_PHOLDR'].'" value="" />';
        echo '	</td>';
        echo '</tr>';
    }
?>
                    </tbody>
                </table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">취소</button>
                <button type="button" class="btn btn-info" onclick="test();">테스트</button>
				<button type="button" class="btn btn-primary" onclick="apply();">확인</button>
			</div>
		</div>
	</div>
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

// 사전등록 창 열기
function openApply () {
    $('#applyModal').modal('show');
}

// 사전등록 테스트용 데이터
function test () {
    $('.table-apply tbody tr').each(function() {
        // validation
        const _td = $(this).find('td:first');
        const _input = $(_td).find('input:first');

        if ($(this).attr('SERL_NO') == '1') {
            $(_input).val('김성명');
        } else if ($(this).attr('SERL_NO') == '2') {
            $(_input).val('010-1111-2222');
        } else if ($(this).attr('SERL_NO') == '3') {
            $(_input).val('제주감귤대학병원');
        } else if ($(this).attr('SERL_NO') == '4') {
            $(_input).val('오징어감별과');
        }
    });

    $('#reqrNm').val('김성명');
    $('#mbilno').val('010-1111-2222');
}

// 사전등록 신청
function apply () {
    // validation
    let msg = '';
    const entInfoList = [];
    $('.table-apply tbody tr').each(function() {
        // validation
        const _th = $(this).find('th:first');
        const _td = $(this).find('td:first');
        const _input = $(_td).find('input:first');
        const _val = $(_input).val();
        // alert('val : ' + _val);

        // 필수인데 비어있으면 alert
        if ($(_td).hasClass('required') && isEmpty(_val)) {
            msg = (`${$(_th).text()} 항목은 필수입니다.`);
        }

        // 2번은 연락처 고정이므로 숫자만 return
        entInfoList.push({
            PRJ_SEQ: <?= $project['PRJ_SEQ'] ?>,
            PRJ_ENT_INFO_SEQ: $(this).attr('PRJ_ENT_INFO_SEQ'),
            SERL_NO: $(this).attr('SERL_NO'),
            INPUT_VAL: parseInt($(this).attr('SERL_NO')) == 2 ? numberfy(_val) : _val
        });
    });
    // console.log(`entInfoList - ${JSON.stringify(entInfoList)}`);

    // validation에 걸린게 있으면
    if (msg !== '') {
        alert(msg);
        return;
    }

    showSpinner();

    $.ajax({
    	type: 'POST',
    	url: '/stream/save/<?= $project['PRJ_SEQ'] ?>',
    	dataType: 'json',
    	cache: false,
    	data: {
            entInfoList
        },

    	success: function(data) {
    		console.log(data)
    		if ( data.resCode == '0000' ) {
                alert('사전등록 신청정보를 저장했습니다.');
    		} else {
    			// modal1('경고', '프로젝트 목록을 가져오는 도중 오류가 발생했습니다. 관리자에게 문의해주세요.<br><br>코드(resCode):'+data.resCode+'<br>메세지(resMsg):'+data.resMsg);
    			// centerModal1('경고', '프로젝트 목록을 가져오는 도중 오류가 발생했습니다. 관리자에게 문의해주세요.<br><br>코드(resCode):'+data.resCode+'<br>메세지(resMsg):'+data.resMsg);
    			alert('사전등록 신청 도중 오류가 발생했습니다.\n관리자에게 문의해주세요.\n\n코드(resCode):'+data.resCode+'\n메세지(resMsg):'+data.resMsg);
    			// hideSpinner();
    		}
    	},
    	error: function (xhr, ajaxOptions, thrownError) {
    		console.error(xhr);
    		// modal1('경고', '프로젝트 목록을 가져오는 도중 오류가 발생했습니다.\n관리자에게 문의해주세요.\n\n코드:'+xhr.status+'\n메세지:'+thrownError);
    		// centerModal1('경고', '프로젝트 목록을 가져오는 도중 오류가 발생했습니다.\n관리자에게 문의해주세요.\n\n코드:'+xhr.status+'\n메세지:'+thrownError);
    		alert('사전등록 신청 도중 오류가 발생했습니다.\n관리자에게 문의해주세요.\n\n코드:'+xhr.status+'\n메세지:'+thrownError);
    		// hideSpinner();
    	},
    	complete : function () {
    		hideSpinner();
            $('#applyModal').modal('hide');
    	}
    });
}

// 입장버튼 클릭
function enter () {
    // validation
    if (isEmpty($('#reqrNm').val())) {
        alert('성명을 입력해주세요.');
        $('#reqrNm').focus();
        return;
    }
    if (!checkMobile( simplifyMobile($('#mbilno').val()) )) {
        alert('연락처를 형식에 맞게 입력해주세요.(- 제외)');
        $('#mbilno').focus();
        return;
    }

    showSpinner();

    $.ajax({
    	type: 'POST',
    	url: '/stream/enter/<?= $project['PRJ_TITLE_URI'] ?>',
    	dataType: 'json',
    	cache: false,
    	data: {
            reqrNm: $('#reqrNm').val(),
            mbilno: simplifyMobile($('#mbilno').val())
        },

    	success: function(data) {
    		console.log(data)
    		if ( data.resCode == '0000' ) {
                location.href = '/stream/<?= $project['PRJ_TITLE_URI'] ?>';
    		} else {
    			alert('심포지엄 입장 도중 오류가 발생했습니다.\n관리자에게 문의해주세요.\n\n코드(resCode) : '+data.resCode+'\n메세지(resMsg) : '+data.resMsg);
    		}
    	},
    	error: function (xhr, ajaxOptions, thrownError) {
    		console.error(xhr);
    		alert('심포지엄 입장 도중 오류가 발생했습니다.\n관리자에게 문의해주세요.\n\n코드 : '+xhr.status+'\n메세지 : '+thrownError);
    	},
    	complete : function () {
    		hideSpinner();
    	}
    });
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
