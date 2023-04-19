<?php
class Model_login extends CI_Model{

    protected $message = array();
    protected $prefix = 'input_';

    function __construct()
    {
        parent::__construct();
    }


    function get_prefix()
    {
        return $this->prefix;
    }

    function get_validate_rule()
    {
        $config = array(
            $this->get_prefix().'email'    => array(
                'field'   => $this->get_prefix().'email',
                'label'   => 'メールアドレス',
                'rules'   => 'required|valid_email|max_length[255]|xss_clean',
            ),
            $this->get_prefix().'password' => array(
                'field'   => $this->get_prefix().'password',
                'label'   => 'パスワード',
                'rules'   => 'required|min_length[8]|max_length[16]|xss_clean',
            ),
        );

        $this->form_validation->set_error_delimiters('<p>', '</p>');

        return $config;
    }


//----------------------------------------------

    public function is_login()
    {
        $users = $this->user->get_login_items();
        if(!empty($users))
        {
            foreach ($users AS $user)
            {
                if(password_verify(set_value($this->prefix.'password'), $user['password'])){
                    $this->user->set_item($user);
                    return TRUE;
                }
            }
        }

        return FALSE;
    }

    public function set_item($data){
        $this->item = $data;
    }

    public function extract_item($key)
    {
        if(isset($this->item[$key]) && !empty($this->item[$key]))
        {
            return $this->item[$key];
        }

        return FALSE;
    }


//----------------------------------------------

    /**
     * @param $title
     * @param $message
     * @param string $type [danger,info,success,warning]
     */
    public function set_message($message="", $type="danger")
    {
        array_push($this->message, sprintf('<div class="alert alert-danger" role="alert">%s</div>', $message));
    }
    public function get_message()
    {
        if(!empty($this->message))
            return join($this->message);
    }

//----------------------------------------------

}
?>