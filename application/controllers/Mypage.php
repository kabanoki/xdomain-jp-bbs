<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mypage extends MY_public_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_user', 'user');
    }

	public function index()
	{
		$this->load->view('mypge/index');
	}

    public function profile()
    {
        $this->load->view('mypge/index');
    }
}
