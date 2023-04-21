<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_public_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->view_dir = 'login/';
        $this->load->model($this->manage_path.'Model_login', 'login');
        $this->load->library( array('form_validation') );
        $this->load->helper( array('form') );
    }

    public function index()
    {
        $config = $this->login->get_validate_rule(); // バリデーションのルール設定
        $this->form_validation->set_rules($config); // バリデーションの設定

        if($this->form_validation->run())
        {
            if($this->login->is_login())
            {
                $this->session->set_userdata(array(
                    'user_no' => $this->user->extract_item('no'),
                ));

                redirect(site_url('mypage'));
            }

            $this->login->set_message('メールアドレスもしくはパスワードが間違っています');
        }

        $this->load->view($this->view_dir.'index');
    }
}
