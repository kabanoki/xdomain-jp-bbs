<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public $base_path
         , $directry_path
         , $local_file_path
         , $view_title = '株式会社'
         , $manage_path = '';

	function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->library( array('encryption', 'session') );
		$this->load->helper( array('url', 'security') );

		date_default_timezone_set("Asia/Tokyo");
	}
}

// --------------------------------------------------------------------

class MY_public_Controller extends MY_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->helper('cookie', 'string');

		$this->load->model('Model_user', 'user');
	}
}