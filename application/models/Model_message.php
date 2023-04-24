<?php

class Model_message extends CI_Model{

    private $table = 'message';
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
            $this->get_prefix().'text'    => array(
                'field'   => $this->get_prefix().'text',
                'label'   => 'メッセージ',
                'rules'   => 'required|max_length[500]|xss_clean',
            ),
        );

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        return $config;
    }

//----------------------------------------------
    function get_item($arg=array())
    {
        $default_data = array(
            'select' => array(
                $this->table.'.no AS no ',
                $this->table.'.text AS text ',
                $this->table.'.thread AS thread ',
                'thread.title AS thread_title',
                $this->table.'.author AS author ',
                'user.name AS author_name',
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
        $this->db->join('thread', "thread.no = {$this->table}.thread", 'left');
        $this->db->join('user', "user.no = {$this->table}.author", 'left');

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
                $this->table.'.text AS text ',
                $this->table.'.thread AS thread ',
                'thread.title AS thread_title',
                $this->table.'.author AS author ',
                'user.name AS author_name',
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
        $this->db->join('thread', "thread.no = {$this->table}.thread", 'left');
        $this->db->join('user', "user.no = {$this->table}.author", 'left');

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

    function get_thread_item($arg=array())
    {
        $this->db->where(array(
            $this->table.'.thread' => $this->thread->get_itemNo()
        ));

        return $this->get_item($arg);
    }
    function get_thread_items($arg=array())
    {
        $this->db->where(array(
            $this->table.'.thread' => $this->thread->get_itemNo()
        ));

        return $this->get_items($arg);
    }

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

    function get_last_thread_item($arg=array())
    {
        $this->db->where(array(
            $this->table.'.thread' => $this->thread->get_itemNo()
        ));

        $arg = array(
            'where' => array(
                $this->table.'.thread' => $this->thread->get_itemNo()
            ),
            'orderby'    => array(
                array(
                    'order' => $this->table.'.no',
                    'sort' => 'desc'
                )
            ),
        );
        $this->db->limit(1);

        return $this->get_item($arg);
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

        $post_data['thread'] = $this->thread->get_itemNo();
        $post_data['author'] = $this->user->get_login_user('no');
        $post_data['created_date'] = date('Y-m-d H:i:s');

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