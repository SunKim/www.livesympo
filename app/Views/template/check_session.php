<?php
	if ( $session['logged_in'] != 1) {
		echo "<script>alert('등록정보가 없거나 만료되었습니다. 입장 화면으로 이동합니다.');location.href='/home';</script>";
	} else {
		//echo "<script>alert('로그인 세션존재.');</script>";
		//echo "<script>console.log('Coil Donation Helper 관리자님 환영합니다.');</script>";
	}
?>