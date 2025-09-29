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
		$strQry .= "	, IF( (CONN_ROUTE_1 IS NOT NULL AND CONN_ROUTE_1 <> '') OR (CONN_ROUTE_2 IS NOT NULL AND CONN_ROUTE_2 <> '') OR (CONN_ROUTE_3 IS NOT NULL AND CONN_ROUTE_3 <> '') OR (CONN_ROUTE_4 IS NOT NULL AND CONN_ROUTE_4 <> '') OR (CONN_ROUTE_5 IS NOT NULL AND CONN_ROUTE_5 <> '') OR (CONN_ROUTE_6 IS NOT NULL AND CONN_ROUTE_6 <> ''), 1, 0) AS CONN_ROUTE_YN	\n";
		$strQry .= "	, P.STREAM_URL, P.ONAIR_YN, P.ONAIR_ENT_TRM, P.MAIN_IMG_URI, P.AGENDA_IMG_URI, P.STREAM_AGENDA_IMG_URI, P.STREAM_AGENDA_LINK_URL, P.FOOTER_IMG_URI	\n";
        $strQry .= "	, CONCAT('".$_ENV['app.cmsURL']."', P.MAIN_IMG_URI) AS MAIN_IMG_URL	\n";
        $strQry .= "	, CONCAT('".$_ENV['app.cmsURL']."', P.AGENDA_IMG_URI) AS AGENDA_IMG_URL	\n";
		$strQry .= "	, CONCAT('".$_ENV['app.cmsURL']."', P.STREAM_AGENDA_IMG_URI) AS STREAM_AGENDA_IMG_URL	\n";
        $strQry .= "	, CONCAT('".$_ENV['app.cmsURL']."', P.FOOTER_IMG_URI) AS FOOTER_IMG_URL	\n";
		$strQry .= "	, CONCAT('".$_ENV['app.cmsURL']."', P.MDRTOR_IMG_URI) AS MDRTOR_IMG_URL	\n";
		$strQry .= "	, P.ST_DTTM, P.ED_DTTM	\n";
		$strQry .= "	, DATE_FORMAT(P.ST_DTTM, '%Y-%m-%d') AS ST_DATE	\n";
        $strQry .= "	, DATE_FORMAT(P.ST_DTTM, '%H:%i') AS ST_TIME	\n";
		$strQry .= "	, DATE_FORMAT(P.ED_DTTM, '%Y-%m-%d') AS ED_DATE	\n";
        $strQry .= "	, DATE_FORMAT(P.ED_DTTM, '%H:%i') AS ED_TIME	\n";
		$strQry .= "	, P.EXT_SURVEY_YN, P.EXT_SURVEY_URL, P.NTC_DESC, P.QNA_TEXT	\n";
		$strQry .= "	, P.CONN_ROUTE_TEXT, P.CONN_ROUTE_1, P.CONN_ROUTE_2, P.CONN_ROUTE_3, P.CONN_ROUTE_4, P.CONN_ROUTE_5, P.CONN_ROUTE_6	\n";
		$strQry .= "	, P.AGENDA_BTN_TEXT, P.SURVEY_BTN_TEXT, P.QST_BTN_TEXT	\n";
		$strQry .= "	, P.APPL_BODY_COLR, P.APPL_BTN_BG_COLR, P.APPL_BTN_FONT_COLR, P.APPL_BTN_ALIGN, P.APPL_BTN_ROUND_YN, P.ENT_THME_COLR, P.ENT_THME_FONT_COLR, P.ENT_THME_HEIGHT, P.ENT_BTN_TEXT, P.ENT_BTN_BG_COLR, P.ENT_BTN_FONT_COLR, P.ENT_BTN_ROUND_YN	\n";
		$strQry .= "	, P.STREAM_BODY_COLR, P.STREAM_BTN_BG_COLR, P.STREAM_BTN_FONT_COLR, P.STREAM_QA_BG_COLR, P.STREAM_QA_FONT_COLR	\n";
		$strQry .= "	, ANONYM_USE_YN, APPL_BTN_HIDE_YN	\n";
		$strQry .= "	, ENT_INFO_EXTRA_1, ENT_INFO_EXTRA_PHOLDER_1, ENT_INFO_EXTRA_REQUIRED_1	\n";
        $strQry .= "	, ENT_INFO_EXTRA_2, ENT_INFO_EXTRA_PHOLDER_2, ENT_INFO_EXTRA_REQUIRED_2	\n";
		$strQry .= "	, ENT_INFO_EXTRA_3, ENT_INFO_EXTRA_PHOLDER_3, ENT_INFO_EXTRA_REQUIRED_3	\n";
		$strQry .= "	, ENT_INFO_EXTRA_4, ENT_INFO_EXTRA_PHOLDER_4, ENT_INFO_EXTRA_REQUIRED_4	\n";
		$strQry .= "	, ENT_INFO_EXTRA_5, ENT_INFO_EXTRA_PHOLDER_5, ENT_INFO_EXTRA_REQUIRED_5	\n";
		$strQry .= "	, ENT_INFO_EXTRA_6, ENT_INFO_EXTRA_PHOLDER_6, ENT_INFO_EXTRA_REQUIRED_6	\n";
		$strQry .= "FROM TB_PRJ_M AS P	\n";
		$strQry .= "WHERE 1=1	\n";
		$strQry .= "	AND P.DEL_YN = 0	\n";
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