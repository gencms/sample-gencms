<?php
class CMS_Model extends CI_Model {

    protected $_table_name = '';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = '';
    public    $rules = array();
    protected $_timestamps = FALSE;

    function __construct() {
        parent::__construct();
    }

    function run_sql($sql = NULL) {
        return ( !empty($sql) )? $this->db->query($sql) : NULL;
    }

    public function array_from_post($fields){
        $data = array();
        foreach ($fields as $field) {
            $data[$field] = $this->input->post($field);
        }
        return $data;
    }

    public function get($table_name ,$id = NULL, $primary_key = '', $order_by = '',$per_page = 0, $offset = 0, $single = FALSE){

        if ($id != NULL) {
            $filter = $this->_primary_filter;
            $id = $filter($id);
            $this->db->where($primary_key, $id);
            $method = 'row';
        }
        elseif($single == TRUE) {
            $method = 'row';
        }
        else {
            $method = 'result';
            if($per_page > 0) $this->db->limit($per_page, $offset);
        }

        if (!count($this->db->ar_orderby)) {
            $this->db->order_by($order_by);
        }
        return $this->db->get($table_name)->$method();
    }

    public function get_joins($select_fields = "", $table_name = "", $join_items = array(), $per_page = 0, $offset = 0 ) {
        
        $this->db->select($table_name.".*, ".$select_fields);

        foreach ($join_items as $item) {
            $tbl = $item['table'];
            $mapped = $item['mapped_field'];
            $key = $item['key_field'];
            $join = $item['join_type'];

            $this->db->join($tbl, "$table_name.$mapped = $tbl.$key",$join);
        }

        if($per_page > 0) $this->db->limit($per_page, $offset);

        $sql = $this->db->get($table_name);
    return $sql->result();
    }

    public function get_by($where, $single = FALSE){
        $this->db->where($where);
        return $this->get(NULL, $single);
    }

    public function save($table_name = '', $primary_key = '',$data, $id = NULL){
        // Set timestamps
        if ($this->_timestamps == TRUE) {
            $now = date('Y-m-d H:i:s');
            $id || $data['created'] = $now;
            $data['modified'] = $now;
        }

        // Insert
        if ( !($id > 0) ) {

            !isset($data[$primary_key]) || $data[$primary_key] = NULL;
            $this->db->set($data);
            $this->db->insert($table_name);
            $id = $this->db->insert_id();
        }
        // Update
        else {
            $filter = $this->_primary_filter;
            $id = $filter($id);
            $this->db->set($data);
            $this->db->where($primary_key, $id);
            $this->db->update($table_name);
        }

        return $id;
    }

    public function delete($table_name, $primary_key, $id){
        if (!$id) {
            return FALSE;
        }
        $this->db->where($primary_key, $id);
        $this->db->limit(1);
        $this->db->delete($table_name);
    }


    public function publish($table_name, $primary_key, $status_field, $id){
        if (!$id) {
            return FALSE;
        }
        $this->db->where($primary_key, $id);
        $this->db->set($status_field, 1);
        $this->db->update($table_name);
    }


    public function unpublish($table_name, $primary_key, $status_field, $id){
	if (!$id) {
            return FALSE;
        }
        $this->db->where($primary_key, $id);
        $this->db->set($status_field, 0);
        $this->db->update($table_name);
    }


    public function record_count($table_name){
        return $this->db->count_all($table_name);
    }


    public function get_dropdown_options($table_name, $key_field, $label_field){
        $options[""] = " -- Select --";
        $sql = $this->db->select("$key_field as id, $label_field as name")
                        ->get($table_name);

        if ($sql->num_rows() > 0) {            
            foreach ($sql->result() as $item) {
                $options[$item->id] = ucfirst($item->name);
            }
        }
    return $options;                    
    }

}
