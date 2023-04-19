<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Top extends MY_public_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->view_dir = 'top/';

        $this->load->model('Model_user', 'user');
//        $this->load->model('Model_thread', 'thread');
    }

	public function index()
	{
		$this->load->view($this->view_dir.'index');
	}
}
