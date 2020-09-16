<?php
/**
 * Stream.php
 *
 * Livesympo 스트림 Controller
 *
 * @package    App
 * @subpackage Controller
 * @author     20200914. SUN.
 * @copyright  Livesympo
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link
 * @see
 * @since      2020.09.14
 * @deprecated
 */
namespace App\Controllers;

use App\Models\ProjectModel;
use App\Models\TestModel;

class Stream extends BaseController {
	public function __construct() {
    	$this->projectModel = new ProjectModel();
		$this->testModel = new TestModel();
  	}

	public function index () {
		return $this->wrongAccess();
	}

	// 테스트용
	public function dbInsertQuery () {
		$insertedId = $this->testModel->dbInsertQuery(1, 'one');
		echo "insertedId : $insertedId";
	}

	// 신청화면
	public function apply ($prjUri = '') {
		if ($prjUri == '') {
			return $this->wrongAccess();
			return false;
		}

		// get이면 사전등록 화면. post면 사전등록 신청
		if ($this->request->getMethod() == 'get') {
			// 프로젝트 정보 가져오기
			$project = $this->projectModel->detail($prjUri);

			// 정상 URI면 신청화면 불러오기. 비정상이면 wrongAccess
			if (isset($project)) {
				$data['project'] = $project;
				$data['session'] = $this->session->get('reqr');

				return view('stream/apply_form.php', $data);
			} else {
				return $this->wrongAccess();
			}
		} else if ($this->request->getMethod() == 'post') {
			echo 'post';
		}
	}

	// 아젠다화면
	public function agenda ($prjUri = '') {
		if ($prjUri == '') {
			return $this->wrongAccess();
		}

		$data['session'] = $this->session->get('reqr');
		// return view('stream/enter_form', $data);
	}

	// 스트림시청화면
	public function stream ($prjUri = '') {
		if ($prjUri == '') {
			return $this->wrongAccess();
			return false;
		}

		$data['session'] = $this->session->get('reqr');
		// return view('stream/enter_form', $data);
	}

	// 잘못된 접근
	public function wrongAccess () {
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
