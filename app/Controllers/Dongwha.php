<?php
namespace App\Controllers;

use App\Models\SettingModel;

class Dongwha extends BaseController {
	public function __construct() {
		$this->settingModel = new SettingModel();
  	}

	public function index () {
		$data['DONGWHA_202012_LEC1_READY_YN'] = $this->settingModel->value('DONGWHA_202012_LEC1_READY_YN');
		$data['DONGWHA_202012_LEC2_READY_YN'] = $this->settingModel->value('DONGWHA_202012_LEC2_READY_YN');
		$data['DONGWHA_202012_LEC3_READY_YN'] = $this->settingModel->value('DONGWHA_202012_LEC3_READY_YN');
		$data['DONGWHA_202012_LEC4_READY_YN'] = $this->settingModel->value('DONGWHA_202012_LEC4_READY_YN');

		return view('dongwha/dongwha_202012.php', $data);
	}
}
