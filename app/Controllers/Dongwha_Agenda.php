<?php
namespace App\Controllers;

use App\Models\SettingModel;

class Dongwha_Agenda extends BaseController {
	public function __construct() {
		$this->settingModel = new SettingModel();
  	}

	public function index () {
		return $this->dw202105();
	}

	public function dw202105 () {
		$data['DONGWHA_202105_LEC1_READY_YN'] = $this->settingModel->value('DONGWHA_202105_LEC1_READY_YN');
		$data['DONGWHA_202105_LEC2_READY_YN'] = $this->settingModel->value('DONGWHA_202105_LEC2_READY_YN');
		$data['DONGWHA_202105_LEC3_READY_YN'] = $this->settingModel->value('DONGWHA_202105_LEC3_READY_YN');
		$data['DONGWHA_202105_LEC4_READY_YN'] = $this->settingModel->value('DONGWHA_202105_LEC4_READY_YN');

		$data['DONGWHA_202105_LEC1_FILE_NM'] = $this->settingModel->value('DONGWHA_202105_LEC1_FILE_NM');
		$data['DONGWHA_202105_LEC2_FILE_NM'] = $this->settingModel->value('DONGWHA_202105_LEC2_FILE_NM');
		$data['DONGWHA_202105_LEC3_FILE_NM'] = $this->settingModel->value('DONGWHA_202105_LEC3_FILE_NM');
		$data['DONGWHA_202105_LEC4_FILE_NM'] = $this->settingModel->value('DONGWHA_202105_LEC4_FILE_NM');

		return view('dongwha/dongwha_202105.php', $data);
	}

	public function dw202012 () {
		$data['DONGWHA_202012_LEC1_READY_YN'] = $this->settingModel->value('DONGWHA_202012_LEC1_READY_YN');
		$data['DONGWHA_202012_LEC2_READY_YN'] = $this->settingModel->value('DONGWHA_202012_LEC2_READY_YN');
		$data['DONGWHA_202012_LEC3_READY_YN'] = $this->settingModel->value('DONGWHA_202012_LEC3_READY_YN');
		$data['DONGWHA_202012_LEC4_READY_YN'] = $this->settingModel->value('DONGWHA_202012_LEC4_READY_YN');

		$data['DONGWHA_202012_LEC1_FILE_NM'] = $this->settingModel->value('DONGWHA_202012_LEC1_FILE_NM');
		$data['DONGWHA_202012_LEC2_FILE_NM'] = $this->settingModel->value('DONGWHA_202012_LEC2_FILE_NM');
		$data['DONGWHA_202012_LEC3_FILE_NM'] = $this->settingModel->value('DONGWHA_202012_LEC3_FILE_NM');
		$data['DONGWHA_202012_LEC4_FILE_NM'] = $this->settingModel->value('DONGWHA_202012_LEC4_FILE_NM');

		return view('dongwha/dongwha_202012.php', $data);
	}
}
