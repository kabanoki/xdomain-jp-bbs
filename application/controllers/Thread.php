<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Thread extends MY_public_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_user', 'user');
        $this->load->model('Model_thread', 'thread');
    }

	public function post($id=0)
	{
		$this->load->view('thread/post');
	}

    public function detail($id=0)
    {
        $this->load->view('thread/detail');
    }
}
