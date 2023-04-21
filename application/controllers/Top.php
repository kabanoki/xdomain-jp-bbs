<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Top extends MY_public_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->view_dir = 'top/';

        $this->load->model('Model_user', 'user');
        $this->load->model('Model_thread', 'thread');
        $this->load->model('Model_message', 'message');
        $this->load->library('pagination');
    }

	public function index()
	{
        $config['base_url'] = site_url();
        $config['total_rows'] = count($this->thread->get_items());
        $config['per_page'] = $this->thread->get_pagination_max_row();
        $config['num_links'] = 3;
        $config['page_query_string'] = TRUE;
        $config['use_page_numbers'] = TRUE;
        $config['full_tag_open'] = '<nav aria-label="navigation"><ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active" aria-current="page"><span class="page-link">';
        $config['cur_tag_close'] = '</span><li>';
        $config ['attributes']  =  array ( 'class'  =>  'page-link' );

        $this->pagination->initialize($config);

		$this->load->view($this->view_dir.'index');
	}
}
