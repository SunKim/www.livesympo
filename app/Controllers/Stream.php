<?php namespace App\Controllers;

class Stream extends BaseController {
	public function index () {
		return $this->wrongAccess();
	}

	// 신청화면
	public function apply ($prjUri = '') {
		$data['session'] = $this->session->get('reqr');
		// return view('stream/enter_form', $data);
	}

	// 아젠다화면
	public function agenda ($prjUri = '') {
		$data['session'] = $this->session->get('reqr');
		// return view('stream/enter_form', $data);
	}

	// 스트림시청화면
	public function watch ($prjUri = '') {
		$data['session'] = $this->session->get('reqr');
		// return view('stream/enter_form', $data);
	}

	// 잘못된 접근
	public function wrongAccess ($prjUri = '') {
		$data['errTitle'] = '잘못된 접근';

		$html  = '';
		$html .= '잘못된 접근입니다.';
		$html .= '<br />';
		$html .= '프로젝트 URL을 확인해주세요.';
		$html .= '<br />';
		$html .= '<br />';
		$html .= '문의 이메일 : <a href="mailto:nabdo@naver.com">nabdo@naver.com</a>';
		$html .= '<br />';
		$html .= '문의 휴대폰 : <a href="tel:nabdo@naver.com">+82-10-4782-6737</a>';

		$data['errHtml'] = $html;

		return view('errors/common_error.php', $data);
	}
}
