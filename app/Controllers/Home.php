<?php namespace App\Controllers;

class Home extends BaseController
{
	public function index ()
	{
		return $this->enter_form();
	}

	public function enter_form () {
		$data['session'] = $this->session->get('reqr');
		return view('stream/enter_form', $data);
	}

}
