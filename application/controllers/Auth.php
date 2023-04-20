<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_public_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->view_dir = 'auth/';

        $this->load->library( array('form_validation') );
        $this->load->helper( array('form') );
    }

    public function register()
    {
        $config = $this->user->get_validate_rule(); // バリデーションのルール設定
        $this->form_validation->set_rules($config); // バリデーションの設定

        if($this->form_validation->run())
        {
            $this->user->set_post_data();
            $no = $this->user->insert();
            $this->session->set_userdata('user_no', $no);
            redirect(site_url());
        }

        $this->load->view($this->view_dir.'register');
    }
}
