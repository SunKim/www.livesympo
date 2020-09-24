<?php
	if ( !isset($session['reqrSeq']) || $session['reqrSeq'] < 0) {
		echo "<script>alert('로그인 정보가 없거나 만료되었습니다.\\이전 화면으로 이동합니다.');history.back();</script>";
	} else {
		// echo "<script>alert('로그인 세션존재.');</script>";
		//echo "<script>console.log('Coil Donation Helper 관리자님 환영합니다.');</script>";
	}
?>
