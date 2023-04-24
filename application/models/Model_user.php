<?php

class Model_user extends CI_Model{

    private $table = 'user';
    protected $prefix = 'input_';
    protected $item = array();
    protected $login_user = array();
    protected $itemNo = 0;
    protected $sql_data = array();
    protected $message = array();


    function __construct()
    {
        parent::__construct();

        // ユーザー情報をセット
        if($this->session->has_userdata('user_no')){
            $this->set_itemNo($this->session->userdata('user_no'));
            $this->login_user = $this->get_item();
        }
    }

    function get_prefix()
    {
        return $this->prefix;
    }

    function get_validate_rule()
    {
        $config = array(
            $this->get_prefix().'name'     => array(
                'field'   => $this->get_prefix().'name',
                'label'   => '名前',
                'rules'   => 'required|max_length[100]|xss_clean',
            ),
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

        if(!$this->is_login())
            $config[$this->get_prefix().'email']['rules'] = $config[$this->get_prefix().'email']['rules']."|is_unique[{$this->table}.email]";

        $this->form_validation->set_message('is_unique', "その%sは既に登録済みです。");

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        return $config;
    }

//----------------------------------------------
    function get_item($arg=array())
    {
        $default_data = array(
            'select' => array(
                $this->table.'.no AS no ',
                $this->table.'.name AS name',
                $this->table.'.email AS email',
                $this->table.'.password AS password',
                $this->table.'.created_date AS created_date',
                $this->table.'.update_date AS update_date'
            ),
            'orderby'    => array(
                array(
                    'order' => $this->table.'.no',
                    'sort' => 'asc'
                )
            ),
            'where'   => array(
                $this->table.'.no' => $this->get_itemNo(),
            )
        );

        $arg = array_merge($default_data, $arg);

        $this->db->select(join(', ', $arg['select']), FALSE);
        $this->db->from($this->table);

        $this->db->where($arg['where']);

        // 並び順
        if(!empty($arg['orderby'])){
            foreach ($arg['orderby'] AS $orderby){
                $this->db->order_by($orderby['order'], $orderby['sort']);
            }
        }

        $query = $this->db->get();

        $result = $query->result_array();

        return $result ? $result[0] : array();
    }

    function set_item($data){
        $this->item = $data;
    }


//----------------------------------------------

    function get_items($arg=array())
    {
        $default_data = array(
            'select' => array(
                $this->table.'.no AS no ',
                $this->table.'.name AS name',
                $this->table.'.email AS email',
                $this->table.'.password AS password',
                $this->table.'.created_date AS created_date',
                $this->table.'.update_date AS update_date'
            ),
            'orderby'    => array(
                array(
                    'order' => $this->table.'.no',
                    'sort' => 'asc'
                )
            ),
            'where'   => array()
        );

        $arg = array_merge($default_data, $arg);

        $this->db->select(join(', ', $arg['select']), FALSE);
        $this->db->from($this->table);

        if(!empty($arg['where'])){
            foreach ($arg['where'] AS $where){
                $this->db->where($where);
            }
        }

        // 並び順
        if(!empty($arg['orderby'])){
            foreach ($arg['orderby'] AS $orderby){
                $this->db->order_by($orderby['order'], $orderby['sort']);
            }
        }

        $query = $this->db->get();

        $result = $query->result_array();

        return $result ? $result : array();
    }

    function get_login_items($arg=array())
    {
        $this->db->where(array(
            $this->table.'.email' => set_value($this->login->get_prefix().'email'),
        ));
        return $this->get_items();
    }

//----------------------------------------------

    function get_login_user($key)
    {
        if(isset($this->login_user[$key]) && !empty($this->login_user[$key]))
            return $this->login_user[$key];

        return FALSE;
    }

//----------------------------------------------

    function extract_item($key)
    {
        if(isset($this->item[$key]) && !empty($this->item[$key]))
        {
            return $this->item[$key];
        }


        return FALSE;
    }


//----------------------------------------------

    function insert()
    {
        $post_data = $this->get_SQL_data();

        $post_data['created_date'] = date('Y-m-d H:i:s');
        $post_data['password'] = password_hash($post_data['password'], PASSWORD_DEFAULT);

        $sql = $this->db->insert_string($this->table, $post_data);

        $this->db->query($sql);

        $this->set_itemNo($this->db->insert_id());

        return $this->db->insert_id();
    }

    function update()
    {
        $post_data = $this->get_SQL_data();

        $sql = $this->db->update_string(
            $this->table,
            $post_data,
            array('no' => $this->get_itemNo())
        );

        $this->db->query($sql);
    }

    function delete()
    {
        $item = $this->get_item();

        if(empty($item))
            return FALSE;

        $this->db->delete($this->table, array('no' => $item['no']));

        return TRUE;
    }

//----------------------------------------------

    function set_post_data()
    {
        $post_data = array();

        foreach( $this->input->post() AS $key => $val )
        {
            if(strval($val) == '')
                continue;

            if( preg_match("/{$this->prefix}/", trim($key)) )
            {
                if( is_array($val) )
                    $post_data[str_replace( $this->prefix, '', trim($key) )] = implode( ',', $val );
                else
                    $post_data[str_replace( $this->prefix, '', trim($key) )] = set_value($key);
            }
        }
        $this->set_SQL_data($post_data);
    }

    function set_SQL_data($data=array())
    {
        $this->sql_data = $data;
    }

    function get_SQL_data()
    {
        return $this->sql_data;
    }

//----------------------------------------------

    function is_login()
    {
        return !empty($this->login_user);
    }

    function has_item()
    {
        return !empty($this->item);
    }


//----------------------------------------------
//----------------------------------------------

    function get_itemNo()
    {
        return $this->itemNo;
    }

    function set_itemNo($no)
    {
        if(preg_match('/^[\-+]?[0-9]*\.?[0-9]+$/', $no))
            $this->itemNo = $no;
    }


    /**
     * @param $message
     * @param string $type [danger,info,success,warning]
     */
    public function set_message($message="", $type="danger")
    {
        array_push($this->message, $message);

        $this->session->set_flashdata($this->table.'_message', $this->message);
    }
    public function get_message()
    {
        $tmp = $this->session->flashdata($this->table.'_message');

        if(!empty($tmp))
            return join($tmp);
    }


}
?>