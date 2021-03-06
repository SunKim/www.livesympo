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
use App\Models\QuestionModel;
use App\Models\SurveyModel;
use App\Models\TestModel;
use App\Models\AdminModel;

class Stream extends BaseController {
	public function __construct() {
    	$this->projectModel = new ProjectModel();
		$this->requestorModel = new RequestorModel();
		$this->questionModel = new QuestionModel();
		$this->surveyModel = new SurveyModel();
		$this->testModel = new TestModel();
		$this->adminModel = new AdminModel();
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
		$prjItem = $this->projectModel->detail($prjUri);
		$entGuideList = $this->projectModel->enterGuideList($prjItem['PRJ_SEQ']);

		// 정상 URI면 신청화면 불러오기. 비정상이면 wrongAccess
		if (isset($prjItem)) {
			$data['project'] = $prjItem;
			$data['entGuideList'] = $entGuideList;

			return view('stream/apply_form.php', $data);
		} else {
			return $this->wrongAccess();
		}
	}

	// 스트림시청화면
	public function watch ($prjUri = '') {
		if ($prjUri == '') {
			return $this->wrongAccess();
			return false;
		}

		// 프로젝트 정보 가져오기
		$prjItem = $this->projectModel->detail($prjUri);

		// client의 IP주소
		// $ipAddr = $_SERVER["REMOTE_ADDR"];
		$ipAddr = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];

		// 정상 URI면 시청화면 불러오기. 비정상이면 wrongAccess
		if (isset($prjItem)) {
			$data['project'] = $prjItem;
			$data['project']['IP_ADDR'] = $ipAddr;
			$data['surveyQstList'] = $this->surveyModel->surveyQstList($prjItem['PRJ_SEQ']);
			$data['surveyQstChoiceList'] = $this->surveyModel->surveyQstChoiceList($prjItem['PRJ_SEQ']);

			// 세션정보 가져오기
			$data['session'] = $this->session->get();

			return view('stream/watch.php', $data);
		} else {
			return $this->wrongAccess();
		}
	}

	// 개인정보 동의 상세내용 화면
	public function agreePrvInfo () {
		return view('agree/prvInfo.php');
	}

	// 마케팅 동의 상세내용 화면
	public function agreeMarketing () {
		return view('agree/marketing.php');
	}

	// ajax - 신청 저장
	public function save ($prjSeq = 0) {
		if ($prjSeq === 0) {
			$res['resCode'] = '9998';
			$res['resMsg'] = '프로젝트시퀀스가 올바르지 않습니다.';

			return $this->response->setJSON($res);
		}

		$data['REQR_NM'] = $this->request->getPost('REQR_NM');
		$data['MBILNO'] = $this->request->getPost('MBILNO');
		// $data['HSPTL_NM'] = $this->request->getPost('HSPTL_NM');
		// $data['SBJ_NM'] = $this->request->getPost('SBJ_NM');
		$data['ENT_INFO_EXTRA_VAL_1'] = $this->request->getPost('ENT_INFO_EXTRA_VAL_1');
		$data['ENT_INFO_EXTRA_VAL_2'] = $this->request->getPost('ENT_INFO_EXTRA_VAL_2');
		$data['ENT_INFO_EXTRA_VAL_3'] = $this->request->getPost('ENT_INFO_EXTRA_VAL_3');
		$data['ENT_INFO_EXTRA_VAL_4'] = $this->request->getPost('ENT_INFO_EXTRA_VAL_4');
		$data['ENT_INFO_EXTRA_VAL_5'] = $this->request->getPost('ENT_INFO_EXTRA_VAL_5');
		$data['ENT_INFO_EXTRA_VAL_6'] = $this->request->getPost('ENT_INFO_EXTRA_VAL_6');
		$data['ENT_INFO_EXTRA_VAL_7'] = $this->request->getPost('ENT_INFO_EXTRA_VAL_7');
		$data['ENT_INFO_EXTRA_VAL_8'] = $this->request->getPost('ENT_INFO_EXTRA_VAL_8');

		$data['CONN_ROUTE_VAL'] = $this->request->getPost('CONN_ROUTE_VAL');

		// 우선 신청자가 기존에 존재하는지 체크
		$reqrSeq = $this->requestorModel->checkReqr($data['REQR_NM'], $data['MBILNO']);
		// log_message('info', "Stream.php - save. reqrNm: $reqrNm, mbilno: $mbilno, reqrSeq: $reqrSeq");

		/************************************
		* START) Transaction 처리
		************************************/
		$db = \Config\Database::connect();
		$db->transStart();

		// 존재하지 않으면 신청자마스터 (TB_REQR_M) insert
		if ($reqrSeq == 0) {
			$reqrData = array(
				'REQR_NM' => $data['REQR_NM']
				, 'MBILNO' => $data['MBILNO']
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

		// 받아온 정보 외에 입력할 필수정보들
		$data['PRJ_SEQ'] = $prjSeq;
		$data['REQR_SEQ'] = $reqrSeq;

		// 사전등록 신청정보 저장 (TB_PRJ_ENT_INFO_REQR_H)
		$prjEntInfoReqrSeq = $this->requestorModel->insertEntInfoReqr($data);

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

	// ajax - 입장 시도
	public function enter ($prjUri = '') {
		// 프로젝트 정보 가져오기
		$prjItem = $this->projectModel->detail($prjUri);
		$prjSeq = $prjItem['PRJ_SEQ'];

		// 비정상이면 error response
		if (!isset($prjItem)) {
			$errRes['resCode'] = '9998';
			$errRes['resMsg'] = '프로젝트 URI가 올바르지 않습니다.';
			return $this->response->setJSON($errRes);
		}

		$reqrNm = $this->request->getPost('reqrNm');
		$mbilno = $this->request->getPost('mbilno');
		// log_message('info', "Stream.php - enter. prjSeq: $prjSeq, reqrNm: $reqrNm, mbilno: $mbilno");

		// 신청자 정보 확인
		$reqrSeq = $this->requestorModel->checkReqr($reqrNm, $mbilno);

		// 신청자 정보가 없으면
		if ($reqrSeq == 0) {
			$errRes['resCode'] = '9996';
			$errRes['resMsg'] = '사전등록 정보가 없습니다. 사전등록을 먼저 진행해주세요.';

			return $this->response->setJSON($errRes);
		}

		// 신청자 정보가 있으면 해당 project에 사전등록 신청했는지 확인
		// log_message('info', "Stream.php - enter. prjSeq: $prjSeq, reqrNm: $reqrNm, mbilno: $mbilno, reqrSeq: $reqrSeq");
		$appliedYn = $this->requestorModel->checkApplied($prjSeq, $reqrSeq);
		if ($appliedYn == 0) {
			$errRes['resCode'] = '9996';
			$errRes['resMsg'] = '사전등록 정보가 없습니다. 사전등록을 먼저 진행해주세요.';

			return $this->response->setJSON($errRes);
		}

		// 프로젝트 시작/종료시간 맞는지 체크
		$now = date('Y-m-d H:i:s');
		$onairEntTerm = date('Y-m-d H:i:s', strtotime("+".$prjItem['ONAIR_ENT_TRM']." minutes"));

		// 온에어가 설정되어있고 아직 시간이 안된 경우
		if ($prjItem['ONAIR_YN'] == 1 && $prjItem['ST_DTTM'] > $onairEntTerm) {
			// log_message('info', "Stream.php - enter. prjSeq: $prjSeq, ST_DTTM: ".$prjItem['ST_DTTM']. ", now : $now");
			$res['resCode'] = '8001';
			$res['resMsg'] = '행사시작 '.$prjItem['ONAIR_ENT_TRM'].'분전부터 방송 참여가 가능합니다.';
		} else if ($prjItem['ED_DTTM'] < $now) {
			$res['resCode'] = '8002';
			$res['resMsg'] = '스트리밍 종료시간이 이미 지났습니다. ('.$prjItem['ED_DTTM'].' 까지)';
		} else {
			$res['resCode'] = '0000';
			$res['resMsg'] = '정상적으로 처리되었습니다.';

			// 세션 처리
			$sessData = array(
				'reqrSeq' => $reqrSeq
				, 'anonymYn' => 0
				, 'reqrNm' => $reqrNm
				, 'mbilno' => $mbilno
				, 'entDttm' => $now
				, 'adminSeq' => 0
			);

			$this->session->set($sessData);
		}
		return $this->response->setJSON($res);
	}

	// 관리자 입장
	public function enterAdmin ($prjUri = '') {
		// 프로젝트 정보 가져오기
		$prjItem = $this->projectModel->detail($prjUri);
		$prjSeq = $prjItem['PRJ_SEQ'];

		// 비정상이면 error response
		if (!isset($prjItem)) {
			$errRes['resCode'] = '9998';
			$errRes['resMsg'] = '프로젝트 URI가 올바르지 않습니다.';
			return $this->response->setJSON($errRes);
		}

		// 정상적인 관리자인지 체크 (lvl 관계없이 모든 관리자 입장 가능)
		$email = $this->request->getPost('admEmail');
		$pwd = $this->request->getPost('admPwd');

		//ID, PWD 체크 로직
		$adminData = $this->adminModel->checkLogin($email);
		$now = date('Y-m-d H:i:s');

		//정상이면 세션처리 하고 ok
		if (isset($adminData)) {
			if ( $adminData['DEL_YN'] == 1 ) {
				$resData['resCode'] = '1020';
				$resData['resMsg'] = '삭제된 사용자입니다.';
			} else if (!password_verify($pwd, $adminData['PWD'])) {
				$resData['resCode'] = '1030';
				$resData['resMsg'] = '패스워드가 맞지 않습니다.';
			} else {
				// 세션 처리
				$sessData = array(
					'reqrSeq' => 0
					, 'anonymYn' => 0
					, 'reqrNm' => $adminData['ADM_NM']
					, 'mbilno' => '01000000000'
					, 'entDttm' => $now
					, 'adminSeq' => $adminData['ADM_SEQ']
				);

				$this->session->set($sessData);

				$resData['resCode'] = '0000';
				$resData['resMsg'] = '정상적으로 처리되었습니다.';
			}
		} else {
			$resData['resCode'] = '1010';
			$resData['resMsg'] = '이메일(아이디)가 존재하지 않습니다.';
		}

		return $this->response->setJSON($resData);
	}

	// ajax - 익명입장(비사전등록) 입장 시도
	public function enterAnonym ($prjUri = '') {
		// 프로젝트 정보 가져오기
		$prjItem = $this->projectModel->detail($prjUri);
		$prjSeq = $prjItem['PRJ_SEQ'];

		// 비정상이면 error response
		if (!isset($prjItem)) {
			$errRes['resCode'] = '9998';
			$errRes['resMsg'] = '프로젝트 URI가 올바르지 않습니다.';
			return $this->response->setJSON($errRes);
		}

		// 익명입장은 무조건 anonym으로 REQR_M에 insert
		$reqrData = array(
			'ANONYM_YN' => 1
		);
		$reqrSeq = $this->requestorModel->insertReqr($reqrData);

		// 익명입장(비사전등록입장)은 입장시도시 TB_PRJ_ENT_INFO_REQR_H에 insert
		$entInfoData = array(
			'PRJ_SEQ' => $prjSeq
			, 'REQR_SEQ' => $reqrSeq
			, 'ANONYM_YN' => 1
		);
		$prjEntInfoReqrSeq = $this->requestorModel->insertEntInfoReqr($entInfoData);

		// 프로젝트 시작/종료시간 맞는지 체크
		$now = date('Y-m-d H:i:s');
		$onairEntTerm = date('Y-m-d H:i:s', strtotime("+".$prjItem['ONAIR_ENT_TRM']." minutes"));

		// 온에어가 설정되어있고 아직 시간이 안된 경우
		if ($prjItem['ONAIR_YN'] == 1 && $prjItem['ST_DTTM'] > $onairEntTerm) {
			// log_message('info', "Stream.php - enter. prjSeq: $prjSeq, ST_DTTM: ".$prjItem['ST_DTTM']. ", now : $now");
			$res['resCode'] = '8001';
			$res['resMsg'] = '행사시작 '.$prjItem['ONAIR_ENT_TRM'].'분전부터 방송 참여가 가능합니다.';
		} else if ($prjItem['ED_DTTM'] < $now) {
			$res['resCode'] = '8002';
			$res['resMsg'] = '스트리밍 종료시간이 이미 지났습니다. ('.$prjItem['ED_DTTM'].' 까지)';
		} else {
			$res['resCode'] = '0000';
			$res['resMsg'] = '정상적으로 처리되었습니다.';

			// 세션 처리
			$sessData = array(
				'reqrSeq' => $reqrSeq
				, 'anonymYn' => 1
				, 'entDttm' => $now
				, 'adminSeq' => 0
			);

			$this->session->set($sessData);
		}
		return $this->response->setJSON($res);
	}

	// ajax - 질문저장
	public function quest () {
		$data['PRJ_SEQ'] = $this->request->getPost('prjSeq');
		$data['REQR_SEQ'] = $this->request->getPost('reqrSeq');
		$data['QST_DESC'] = $this->request->getPost('qstDesc');
		// log_message('info', "Stream.php - enter. prjSeq: $prjSeq, reqrNm: $reqrNm, mbilno: $mbilno");

		$qstSeq = $this->questionModel->insertQst($data);

		// 신청자 정보가 없으면
		if ($qstSeq > 0) {
			$res['resCode'] = '0000';
			$res['resMsg'] = '정상적으로 처리되었습니다.';
		} else {
			$res['resCode'] = '7001';
			$res['resMsg'] = '질문 저장 도중 DB 에러가 발생했습니다.';
		}
		return $this->response->setJSON($res);
	}

	// ajax - 설문답변 저장
	public function surveyAsw () {
		$data = $this->request->getPost('surveyAswItem');
		// log_message('info', "Stream.php - surveyAsw. prjSeq: ".$data['PRJ_SEQ'].", reqrSeq: ".$data['REQR_SEQ'].", ASW_1: ".$data['ASW_1']);

		// 이미 참여했는지 체크
		$surveyedYn = $this->surveyModel->checkSurveyd($data['PRJ_SEQ'], $data['REQR_SEQ']);
		if ($surveyedYn > 0) {
			$res['resCode'] = '9997';
			$res['resMsg'] = '이미 설문조사에 참여하셨습니다.';

			return $this->response->setJSON($res);
		}

		$surveyAswSeq = $this->surveyModel->insertSurveyAswReqr($data);

		if ($surveyAswSeq > 0) {
			$res['resCode'] = '0000';
			$res['resMsg'] = '정상적으로 처리되었습니다.';
		} else {
			$res['resCode'] = '6001';
			$res['resMsg'] = '설문답변 저장 도중 DB 에러가 발생했습니다.';
		}
		return $this->response->setJSON($res);
	}

	// ajax - 신청자 입장/퇴장 로그 기록
	public function logReqrAction () {
		$data['PRJ_SEQ'] = $this->request->getPost('prjSeq');
		$data['REQR_SEQ'] = $this->request->getPost('reqrSeq');
		$data['LOG_GB'] = $this->request->getPost('logGb');
		$data['DVC_GB'] = $this->request->getPost('dvcGb');
		$data['IP_ADDR'] = $this->request->getPost('ipAddr');
		// log_message('info', "Stream.php - logReqrAction. prjSeq: ".$data['PRJ_SEQ'].", reqrSeq: ".$data['REQR_SEQ'].", logGb: ".$data['LOG_GB']);

		$reqrLogSeq = $this->requestorModel->insertReqrLog($data);

		$res['resCode'] = '0000';
		$res['resMsg'] = '정상적으로 처리되었습니다.';
		return $this->response->setJSON($res);
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
