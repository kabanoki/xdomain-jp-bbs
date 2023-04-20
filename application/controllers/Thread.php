<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Thread extends MY_public_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->view_dir = 'thread/';

        $this->load->model('Model_thread', 'thread');

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
}
