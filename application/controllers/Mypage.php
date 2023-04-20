<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mypage extends MY_public_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->view_dir = 'mypage/';

        $this->load->model('Model_thread', 'thread');
        $this->load->model('Model_message', 'message');

        $this->load->library( array('form_validation') );
        $this->load->helper( array('form') );

        if(!$this->user->is_login())
            show_404();
    }

    public function index()
    {
        $this->load->view($this->view_dir.'index');
    }

    public function profile()
    {
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
        $this->session->unset_userdata('user_no');

        redirect(site_url('login'));
    }

    public function delete_thread($no = 0)
    {
        // メッセージが存在するのか
        $this->thread->set_itemNo($no);

        if($this->thread->get_itemNo() != $no)
            show_404();

        $item = $this->thread->get_author_item();
        $this->thread->set_item($item);

        if(!$this->thread->has_item())
            show_404();

        try{
            $this->db->trans_start();

            $res = array(
                'status' => 'success',
                'message' => '削除しました。',
                'data'=> array(
                    'del_no' => $this->thread->get_itemNo()
                )
            );

            //メッセージの削除
            foreach ($this->message->get_thread_items() AS $message)
            {
                $this->message->set_itemNo($message['no']);

                if (!$this->message->delete())
                    throw new Exception("メッセージの削除でエラーが発生しました");
            }

            //スレッドの削除
            if (!$this->thread->delete() || $this->db->trans_status() === FALSE)
                throw new Exception("スレッドの削除でエラーが発生しました");

            $this->thread->set_message('<div class="alert alert-success" role="alert">削除完了</div>');

            $this->db->trans_complete();

        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_message('error', $e->getMessage());

            $res['status'] = 'error';
            $res['message'] = $e->getMessage();

            $this->thread->set_message('<div class="alert alert-danger" role="alert">'.$e->getMessage().'</div>');
        }

        redirect(site_url($this->view_dir));
    }
}
