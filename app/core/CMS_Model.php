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

    public function get_items($sql_data) {

        #Extract the variables in the provided arrays
        extract($sql_data);

        /* 
         * Paging
         */
        $sLimit = "";
        if ( isset( $iDisplayStart ) && $iDisplayLength != "-1" )
        {
            $sLimit = "LIMIT ".mysql_real_escape_string( $iDisplayStart ).", ".
                               mysql_real_escape_string( $iDisplayLength );
        }



        /*
         * Ordering
         */
        if ( isset( $iSortCol_0 ) )
        {
            $sOrder = "ORDER BY  ";
            for ( $i=0 ; $i<intval( $iSortingCols ) ; $i++ )
            {
                if ( $this->input->post( "bSortable_".intval($this->input->post("iSortCol_".$i, true) ), true ) == "true" )
                {
                    $sOrder .= $aColumns[ intval( $this->input->post("iSortCol_".$i) ) ]." ".mysql_real_escape_string( $this->input->post("sSortDir_".$i) ) .", ";                      
                }
            }
            
            $sOrder = substr_replace( $sOrder, "", -2 );
            if ( $sOrder == "ORDER BY" )
            {
                $sOrder = "";
            }
        }
        


        /* 
         * Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. Its possible to do here, but concerned about efficiency
         * on very large tables, and MySQLs regex functionality is very limited
         */
      
        if ( $sSearch != "" )
        {
            $sWhere .= "WHERE (";
            for ( $i=0 ; $i<$numColumns ; $i++ )
            {
                $sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string( $sSearch )."%' OR ";
            }
            $sWhere = substr_replace( $sWhere, "", -3 );
            $sWhere .= ")";
        }

        
        /* Individual column filtering */
        for ( $i=0 ; $i<$numColumns ; $i++ )
        {
            if ( $this->input->post("bSearchable_".$i) == "true" && $this->input->post("sSearch_".$i) != "" )
            {
                if ( $sWhere == "" )
                {
                    $sWhere = "WHERE ";
                }
                else
                {
                    $sWhere .= " AND ";
                }
                $sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string($this->input->post("sSearch_".$i))."%' ";
            }
        }

        /*
         * Joins
         */
        if (!empty($join_items)) {
            $sJoins = "";
            foreach ($join_items as $item) {
                $tbl = $item["table"];
                $mapped = $item["mapped_field"];
                $key = $item["key_field"];
                $join = $item["join_type"];

                $sJoins .= " $join JOIN $tbl ON $sTable.$mapped = $tbl.$key ";
            }
        }

        /*
         * SQL queries
         * Get data to display
         */
        $sQuery = "
            SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
            FROM   $sTable
            $sJoins
            $sWhere
            $sOrder
            $sLimit
        ";

        $rResult = $this->run_sql($sQuery);
        

        /* Data set length after filtering */
        $sQuery = "
            SELECT FOUND_ROWS() as total
        ";

        $rResultFilterTotal = $this->run_sql($sQuery);

        $iFilteredTotal = $rResultFilterTotal->row()->total;
        
        /* Total data set length */
        $sQuery = "
            SELECT COUNT(".$sIndexColumn.") as total
            FROM   $sTable
        ";

        $rResultTotal = $this->run_sql($sQuery);
        

        $iTotal = $rResultTotal->row()->total;


        /*
         * Output
         */
        $output = array(
            "sEcho" => intval($sEcho),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iFilteredTotal,
            "aaData" => array()
        );
        

        foreach ($rResult->result_array() as $aRow) {
            $row = array();             
            for ( $i=0 ; $i<$numColumns ; $i++ )
            {
                if ( $aColumns[$i] == "version" )
                {
                    /* Special output formatting for "version" column */
                    $row[] = ($aRow[ $aColumns[$i] ]=="0") ? "-" : $aRow[ $aColumns[$i] ];
                }
                else if ( $aColumns[$i] != " " )
                {
                    /* General output */
                    $row[] = $aRow[ $aColumns[$i] ];
                }
            }
            $output["aaData"][] = $row;
        }
    return $output;    
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
