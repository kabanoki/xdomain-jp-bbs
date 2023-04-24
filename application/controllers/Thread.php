<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Thread extends MY_public_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->view_dir = 'thread/';

        $this->load->model('Model_thread', 'thread');
        $this->load->model('Model_message', 'message');

        $this->load->library( array('form_validation') );
        $this->load->helper( array('form') );
    }

	public function post($no=0)
	{
	    $this->thread->set_itemNo($no);

        if($this->thread->get_itemNo() != $no)
            show_404();

        $item = $this->thread->get_author_item();
        $this->thread->set_item($item);

        if($this->thread->get_itemNo() != 0 && !$this->thread->has_author())
            show_404();

        $config = $this->thread->get_validate_rule(); // バリデーションのルール設定
        $this->form_validation->set_rules($config); // バリデーションの設定

        if($this->form_validation->run())
        {
            $this->thread->set_post_data();

            if($this->thread->get_itemNo() == 0){
                $no = $this->thread->insert();
                redirect(site_url($this->view_dir.'detail/' . $this->thread->get_itemNo()));
            } else {
                $this->thread->update();
                $this->thread->set_message('<div class="alert alert-success" role="alert">変更完了</div>');
                redirect(site_url($this->view_dir.'post/' . $this->thread->get_itemNo()));
            }
        }

        $this->load->view($this->view_dir.'post');
	}

    public function detail($no=0)
    {
        $this->thread->set_itemNo($no);

        if($this->thread->get_itemNo() != $no)
            show_404();

        $item = $this->thread->get_item();
        $this->thread->set_item($item);

        if(!$this->thread->has_item())
            show_404();

        $this->load->view('thread/detail');
    }

    public function add_message($no)
    {
        if(!$this->user->is_login())
            show_404();

        $this->thread->set_itemNo($no);

        if($this->thread->get_itemNo() != $no)
            show_404();

        $item = $this->thread->get_item();
        $this->thread->set_item($item);

        if(!$this->thread->has_item())
            show_404();

        $config = $this->message->get_validate_rule(); // バリデーションのルール設定
        $this->form_validation->set_rules($config); // バリデーションの設定

        if($this->form_validation->run())
        {
            $this->message->set_post_data();
            $no = $this->message->insert();
            $this->message->set_message('<div class="alert alert-success" role="alert">投稿完了</div>');
        } else {
            $this->message->set_message('<div class="alert alert-danger" role="alert">投稿失敗</div>');
        }

        redirect(site_url($this->view_dir.'detail/' . $this->thread->get_itemNo()));
    }


    public function delete_message($thread_no=0, $message_no=0)
    {
        // スレッドが存在するのか
        $this->thread->set_itemNo($thread_no);

        if($this->thread->get_itemNo() != $thread_no)
            show_404();

        $item = $this->thread->get_item();
        $this->thread->set_item($item);

        if(!$this->thread->has_item())
            show_404();

        // メッセージが存在するのか
        $this->message->set_itemNo($message_no);

        if($this->message->get_itemNo() != $message_no)
            show_404();

        $item = $this->message->get_author_item();
        $this->message->set_item($item);

        if(!$this->message->has_item())
            show_404();

        try{
            $this->db->trans_start();

            $res = array(
                'status' => 'success',
                'message' => '削除しました。',
                'data'=> array(
                    'del_no' => $this->message->get_itemNo()
                )
            );

            if (!$this->message->delete() || $this->db->trans_status() === FALSE)
                throw new Exception("DBでエラーが発生しました");

            $this->message->set_message('<div class="alert alert-success" role="alert">削除完了</div>');

            $this->db->trans_complete();

        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_message('error', $e->getMessage());

            $res['status'] = 'error';
            $res['message'] = $e->getMessage();

            $this->message->set_message('<div class="alert alert-danger" role="alert">'.$e->getMessage().'</div>');
        }

        redirect(site_url($this->view_dir.'detail/' . $this->thread->get_itemNo()));
    }
}
