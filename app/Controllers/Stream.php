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
use App\Models\RequestorModel;
use App\Models\TestModel;

class Stream extends BaseController {
	public function __construct() {
    	$this->projectModel = new ProjectModel();
		$this->requestorModel = new RequestorModel();
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

		// 프로젝트 정보 가져오기
		$project = $this->projectModel->detail($prjUri);
		$entInfoList = $this->projectModel->entInfoList($project['PRJ_SEQ']);

		// 정상 URI면 신청화면 불러오기. 비정상이면 wrongAccess
		if (isset($project)) {
			$data['project'] = $project;
			$data['entInfoList'] = $entInfoList;
			$data['session'] = $this->session->get('reqr');

			return view('stream/apply_form.php', $data);
		} else {
			return $this->wrongAccess();
		}
	}

	// ajax - 신청 저장
	public function save ($prjSeq = 0) {
		if ($prjSeq === 0) {
			$res['resCode'] = '9998';
			$res['resMsg'] = '프로젝트시퀀스가 올바르지 않습니다.';

			return $this->response->setJSON($res);
		}

		$entInfoList = $this->request->getPost('entInfoList');

		// 우선 신청자가 기존에 존재하는지 체크. post 데이터의 0은 무조건 성명, 1은 연락처
		$reqrNm = $entInfoList[0]['INPUT_VAL'];
		$mbilno = $entInfoList[1]['INPUT_VAL'];
		$reqrSeq = $this->requestorModel->checkReqr($reqrNm, $mbilno);
		log_message('info', "Stream.php - save. reqrNm: $reqrNm, mbilno: $mbilno, reqrSeq: $reqrSeq");

		/************************************
		* START) Transaction 처리
		************************************/
		$db = \Config\Database::connect();
		$db->transStart();

		// 존재하지 않으면 신청자마스터 (TB_REQR_M) insert
		if ($reqrSeq == 0) {
			$reqrData = array(
				'REQR_NM' => $reqrNm
				, 'MBILNO' => $mbilno
			);
			$reqrSeq = $this->requestorModel->insertReqr($reqrData);
			log_message('info', "Stream.php - save. 없어서 insert한 reqrSeq: $reqrSeq");
		}

		// 이미 사전등록 신청했는지 체크
		$appliedYn = $this->requestorModel->checkApplied($prjSeq, $reqrSeq);
		if ($appliedYn > 0) {
			$res['resCode'] = '9997';
			$res['resMsg'] = '동일한 이름 및 연락처로 이미 사전등록을 하셨습니다.';

			return $this->response->setJSON($res);
		}

		// 사전등록 신청정보 저장 (TB_PRJ_ENT_INFO_REQR_H)
		foreach ($entInfoList as $entInfoItem) {
			// front에서 PRJ_ENT_INFO_SEQ, INPUT_VAL 는 이미 넘어왔음
			$entInfoItem['REQR_SEQ'] = $reqrSeq;

			$prjEntInfoReqrSeq = $this->requestorModel->insertEntInfoReqr($entInfoItem);
		}

		$db->transComplete();
		/************************************
		* END) Transaction 처리
		************************************/

		if ($db->transStatus() === FALSE) {
			// generate an error... or use the log_message() function to log your error
			log_message('error', 'Stream.php - save : 트랜잭션 처리 에러');

			$res['resCode'] = '9999';
			$res['resMsg'] = '사전신청정보 저장에 실패했습니다.';
		} else {
			$res['resCode'] = '0000';
			$res['resMsg'] = '정상적으로 처리되었습니다.';
		}

		return $this->response->setJSON($res);
	}

	// 아젠다화면
	public function agenda ($prjUri = '') {
		if ($prjUri == '') {
			return $this->wrongAccess();
		}

		$data['session'] = $this->session->get('reqr');
		echo "agenda 화면";
		// return view('stream/enter_form', $data);
	}

	// 스트림시청화면
	public function watch ($prjUri = '') {
		if ($prjUri == '') {
			return $this->wrongAccess();
			return false;
		}

		$data['session'] = $this->session->get('reqr');
		echo "시청화면";
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
