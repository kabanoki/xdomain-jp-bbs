<?php

class Model_thread extends CI_Model{

    private $table = 'thread';
    protected $prefix = 'input_';
    protected $item = array();
    protected $login_user = array();
    protected $itemNo = 0;
    protected $sql_data = array();
    protected $message = array();


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
            $this->get_prefix().'title'     => array(
                'field'   => $this->get_prefix().'title',
                'label'   => 'タイトル',
                'rules'   => 'required|max_length[100]|xss_clean',
            ),
            $this->get_prefix().'description'    => array(
                'field'   => $this->get_prefix().'description',
                'label'   => '概要',
                'rules'   => 'max_length[500]|xss_clean',
            ),
        );

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        return $config;
    }

    private function _join_last_message()
    {
        $subquery_init = $this->load->database('', TRUE);

        $messageSubQuery = $subquery_init
            ->select(join(',', array(
                "MAX(message.no) AS no"
            )), FALSE)
            ->from('message')
            ->group_by('message.thread')
            ->get_compiled_select();

        $subquery_init->reset_query();

        $subQuery = $subquery_init
            ->select(join(',', array(
                "message.no",
                "message.text",
                "message.author",
                "message.thread",
                "user.name",
                "message.created_date",
            )), FALSE)
            ->from('message')
            ->join("($messageSubQuery) AS subMsg", "message.no = subMsg.no", FALSE)
            ->join("user", "user.no = message.author", 'left')
            ->get_compiled_select();

        $this->db->join("($subQuery) AS last_message", "last_message.thread = {$this->table}.no", 'left', FALSE);
    }

//----------------------------------------------
    function get_item($arg=array())
    {
        $default_data = array(
            'select' => array(
                $this->table.'.no AS no ',
                $this->table.'.title AS title ',
                $this->table.'.description AS description ',
                $this->table.'.author AS author ',
                'user.name AS author_name',
                'last_message.name AS last_message_author_name',
                'last_message.created_date AS last_message_created_date',
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
        $this->db->join('user', "user.no = {$this->table}.author", 'left');
        $this->_join_last_message();

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
                $this->table.'.title AS title ',
                $this->table.'.description AS description ',
                $this->table.'.author AS author ',
                'user.name AS author_name',
                'last_message.name AS last_message_author_name',
                'last_message.created_date AS last_message_created_date',
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
        $this->db->join('user', "user.no = {$this->table}.author", 'left');
        $this->_join_last_message();

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


//----------------------------------------------



    function get_author_item($arg=array())
    {
        $this->db->where(array(
            $this->table.'.author' => $this->user->get_login_user('no')
        ));

        return $this->get_item($arg);
    }

    function get_author_items($arg=array())
    {
        $this->db->where(array(
            $this->table.'.author' => $this->user->get_login_user('no')
        ));

        return $this->get_items($arg);
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

        $post_data['author'] = $this->user->get_login_user('no');

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

    function has_author()
    {
        return $this->has_item()
               && $this->user->get_login_user('no') == $this->extract_item('author');
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