<?php
 /**
  * SurveyModel.php
  *
  * @package	App
  * @subpackage Models
  * @author	    20201011. SUN.
  * @copyright  Livesympo
  * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
  * @link
  * @see
  * @since		2020.09.14
  * @deprecated
  */

namespace App\Models;

use CodeIgniter\Model;

class SurveyModel extends Model {
	protected $table = 'TB_SURVEY_QST_M';

	// 하나의 프로젝트에 딸린 설문질문 list.
	public function surveyQstList($prjSeq) {
		$strQry  = "";

		$strQry .= "SELECT SURVEY_QST_SEQ, PRJ_SEQ, QST_NO, QST_TITLE, QST_TP, QST_MULTI_YN	\n";
		$strQry .= "FROM TB_SURVEY_QST_M	\n";
		$strQry .= "WHERE 1=1	\n";
		$strQry .= "	AND PRJ_SEQ = ".$this->db->escape($prjSeq)."	\n";
		$strQry .= "ORDER BY QST_NO	\n";

		$strQry .= ";";
		// log_message('info', "SurveyModel - surveyQstList. Qry - \n$strQry");

		return $this->db->query($strQry)->getResultArray();
	}

	// 하나의 프로젝트에 딸린 설문질문에 대한 보기 list
	public function surveyQstChoiceList($prjSeq) {
		$strQry  = "";

		$strQry .= "SELECT SQC.SURVEY_QST_CHOICE_SEQ, SQC.SURVEY_QST_SEQ, SQC.PRJ_SEQ, SQC.QST_NO, SQC.CHOICE_NO, SQC.CHOICE	\n";
		$strQry .= "	, SQ.QST_MULTI_YN	\n";
		$strQry .= "FROM TB_SURVEY_QST_CHOICE_D AS SQC	\n";
		$strQry .= "INNER JOIN TB_SURVEY_QST_M AS SQ	\n";
		$strQry .= "		ON SQC.SURVEY_QST_SEQ = SQ.SURVEY_QST_SEQ	\n";
		$strQry .= "WHERE 1=1	\n";
		$strQry .= "	AND SQC.PRJ_SEQ = ".$this->db->escape($prjSeq)."	\n";
		$strQry .= "ORDER BY SQC.QST_NO, SQC.CHOICE_NO	\n";

		$strQry .= ";";
		// log_message('info', "SurveyModel - surveyQstChoiceList. Qry - \n$strQry");

		return $this->db->query($strQry)->getResultArray();
	}

	// 이미 설문 참여했는지 확인
	public function checkSurveyd ($prjSeq, $reqrSeq) {
		$strQry  = "";

		$strQry .= "SELECT IFNULL(COUNT(1), 0) AS SURVEYED_YN	\n";
		$strQry .= "FROM TB_SURVEY_ASW_REQR_H	\n";
		$strQry .= "WHERE PRJ_SEQ = ".$this->db->escape($prjSeq)." 	\n";
		$strQry .= "	AND REQR_SEQ = ".$this->db->escape($reqrSeq)."	\n";

		$strQry .= ";";
		// log_message('info', "projectModel - list. Qry - \n$strQry");

		return $this->db->query($strQry)->getRowArray()['SURVEYED_YN'];
	}

	// 설문 답변(TB_SURVEY_ASW_REQR_H) insert
    public function insertSurveyAswReqr ($data) {
		$this->db->table('TB_SURVEY_ASW_REQR_H')->insert($data);
        return $this->db->insertID();
	}
}
