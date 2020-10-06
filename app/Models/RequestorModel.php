<?php
 /**
  * ProjectModel.php
  *
  * @package	App
  * @subpackage Models
  * @author	    20200914. SUN.
  * @copyright  Livesympo
  * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
  * @link
  * @see
  * @since		2020.09.14
  * @deprecated
  */

namespace App\Models;

use CodeIgniter\Model;

class RequestorModel extends Model {
	// 기존에 등록한 신청자인지 확인. 존재하면 REQR_SEQ. 없으면 0
	public function checkReqr ($reqrNm, $mbilno) {
		$strQry  = "";

		$strQry .= "SELECT IFNULL(MAX(REQR_SEQ), 0) AS REQR_SEQ	\n";
		$strQry .= "FROM TB_REQR_M	\n";
		$strQry .= "WHERE 1=1	\n";
		$strQry .= "	AND REQR_NM = ".$this->db->escape($reqrNm)."	\n";
		$strQry .= "    AND MBILNO = ".$this->db->escape($mbilno)."	\n";

		$strQry .= ";";
		// log_message('info', "projectModel - list. Qry - \n$strQry");

		return $this->db->query($strQry)->getRowArray()['REQR_SEQ'];
	}

	// 기존에 사전등록을 신청했었는지 확인
	public function checkApplied ($prjSeq, $reqrSeq) {
		$strQry  = "";

		$strQry .= "SELECT IFNULL(COUNT(1), 0) AS APPLIED_YN	\n";
		$strQry .= "FROM TB_PRJ_ENT_INFO_REQR_H	\n";
		$strQry .= "WHERE PRJ_SEQ = ".$this->db->escape($prjSeq)." 	\n";
		$strQry .= "	AND REQR_SEQ = ".$this->db->escape($reqrSeq)."	\n";

		$strQry .= ";";
		// log_message('info', "projectModel - list. Qry - \n$strQry");

		return $this->db->query($strQry)->getRowArray()['APPLIED_YN'];
	}

	// 신청자마스터 (TB_REQR_M) insert
    public function insertReqr ($data) {
		$this->db->table('TB_REQR_M')->insert($data);
        return $this->db->insertID();
	}

	// 입장정보신청자등록이력 (TB_PRJ_ENT_INFO_REQR_H) insert
    public function insertEntInfoReqr ($data) {
		$this->db->table('TB_PRJ_ENT_INFO_REQR_H')->insert($data);
        return $this->db->insertID();
	}
}
