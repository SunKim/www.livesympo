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

class QuestionModel extends Model {
	// 질문마스터 (TB_QST_M) insert
    public function insertQst ($data) {
		$this->db->table('TB_QST_M')->insert($data);
        return $this->db->insertID();
	}
}
