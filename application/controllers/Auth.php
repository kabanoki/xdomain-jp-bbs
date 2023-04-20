<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_public_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->view_dir = 'auth/';

        $this->load->model('Model_user', 'user');
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

    public function profile()
    {
        if(!$this->user->is_login())
            show_404();

        $config = $this->user->get_validate_rule(); // バリデーションのルール設定

        unset($config[$this->user->get_prefix().'password']);

        $this->form_validation->set_rules($config); // バリデーションの設定

        if($this->form_validation->run())
        {
            $this->user->set_post_data();
            $this->user->update();

            $this->user->set_message('<div class="alert alert-success" role="alert">変更完了</div>');

            redirect(site_url($this->view_dir.'profile'));
        }

        $this->load->view($this->view_dir.'profile');
    }

    public function change_password()
    {
        if(!$this->user->is_login())
            show_404();

        $config = $this->user->get_validate_rule(); // バリデーションのルール設定

        unset($config[$this->user->get_prefix().'name']);
        unset($config[$this->user->get_prefix().'email']);

        $this->form_validation->set_rules($config); // バリデーションの設定

        if($this->form_validation->run())
        {
            $this->user->set_SQL_data(array(
                'password' => password_hash(set_value($this->user->get_prefix().'password'), PASSWORD_DEFAULT)
            ));
            $this->user->update();

            $this->user->set_message('<div class="alert alert-success" role="alert">変更完了</div>');

            redirect(site_url($this->view_dir.'change_password'));
        }

        $this->load->view($this->view_dir.'change_password');
    }

    public function logout()
    {
        if($this->user->is_login())
        {
            $this->session->unset_userdata('user_no');
        }
        redirect(site_url());
    }
}
