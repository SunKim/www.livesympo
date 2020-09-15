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

		$strQry .= "SELECT *	\n";
		$strQry .= "FROM TB_PRJ_M	\n";
		$strQry .= "WHERE 1=1	\n";
		$strQry .= "	AND PRJ_TITLE_URI = ".$this->db->escape($prjUri)."	\n";

		$strQry .= ";";
		// log_message('info', "projectModel - list. Qry - \n$strQry");

		return $this->db->query($strQry)->getRowArray();
	}
}
