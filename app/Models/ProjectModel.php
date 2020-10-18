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

class ProjectModel extends Model {
	// 프로젝트 상세
	public function detail ($prjUri) {
		$strQry  = "";

		$strQry .= "SELECT	\n";
		$strQry .= "	P.PRJ_SEQ, P.PRJ_TITLE, P.PRJ_TITLE_URI	\n";
		$strQry .= "	, IF( (CONN_ROUTE_1 IS NOT NULL AND CONN_ROUTE_1 <> '') OR (CONN_ROUTE_2 IS NOT NULL AND CONN_ROUTE_2 <> '') OR (CONN_ROUTE_3 IS NOT NULL AND CONN_ROUTE_3 <> ''), 1, 0) AS CONN_ROUTE_YN	\n";
		$strQry .= "	, P.STREAM_URL, P.MAIN_IMG_URI, P.AGENDA_IMG_URI, P.FOOTER_IMG_URI	\n";
        $strQry .= "	, CONCAT('".$_ENV['app.baseURL']."', P.MAIN_IMG_URI) AS MAIN_IMG_URL	\n";
        $strQry .= "	, CONCAT('".$_ENV['app.baseURL']."', P.AGENDA_IMG_URI) AS AGENDA_IMG_URL	\n";
        $strQry .= "	, CONCAT('".$_ENV['app.baseURL']."', P.FOOTER_IMG_URI) AS FOOTER_IMG_URL	\n";
		$strQry .= "	, P.APPL_BTN_COLR, P.ENT_THME_COLR, P.AGENDA_PAGE_YN	\n";
		$strQry .= "	, P.ST_DTTM, P.ED_DTTM	\n";
		$strQry .= "	, DATE_FORMAT(P.ST_DTTM, '%Y-%m-%d') AS ST_DATE	\n";
        $strQry .= "	, DATE_FORMAT(P.ST_DTTM, '%H:%i') AS ST_TIME	\n";
		$strQry .= "	, DATE_FORMAT(P.ED_DTTM, '%Y-%m-%d') AS ED_DATE	\n";
        $strQry .= "	, DATE_FORMAT(P.ED_DTTM, '%H:%i') AS ED_TIME	\n";
		$strQry .= "	, CONN_ROUTE_1, CONN_ROUTE_2, CONN_ROUTE_3	\n";
        $strQry .= "	, ENT_INFO_EXTRA_1, ENT_INFO_EXTRA_PHOLDER_1, ENT_INFO_EXTRA_REQUIRED_1	\n";
        $strQry .= "	, ENT_INFO_EXTRA_2, ENT_INFO_EXTRA_PHOLDER_2, ENT_INFO_EXTRA_REQUIRED_2	\n";
		$strQry .= "FROM TB_PRJ_M AS P	\n";
		$strQry .= "WHERE 1=1	\n";
		$strQry .= "	AND P.PRJ_TITLE_URI = ".$this->db->escape($prjUri)."	\n";

		$strQry .= ";";
		// log_message('info', "projectModel - list. Qry - \n$strQry");

		return $this->db->query($strQry)->getRowArray();
	}

	// 프로젝트 입장가이드 목록
public function enterGuideList ($prjSeq) {
	$strQry    = "";

	$strQry .= "SELECT *	\n";
	$strQry .= "FROM TB_PRJ_ENT_GUIDE_M AS EG	\n";
	$strQry .= "WHERE 1=1	\n";
	$strQry .= "	AND EG.DEL_YN = 0	\n";
	$strQry .= "	AND EG.PRJ_SEQ = ".$this->db->escape($prjSeq)."	\n";
	$strQry .= "ORDER BY SERL_NO	\n";

	$strQry .= ";";

	// log_message('info', "ProjectModel - checkTitleUri. Qry - \n$strQry");
	return $this->db->query($strQry)->getResultArray();
}
}
