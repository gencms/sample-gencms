<?php if (!defined('BASEPATH')) exit('No direct script access allowed');



class MY_Form_validation extends CI_Form_validation {

    function MY_Form_validation($rules = array())
    {
        parent::__construct($rules);
    }
    
    
    /**
    * This function will make sure the value is not already in the database (you can specify table and column).
    **/
    function is_unique($str, $field)
    {
    	$update_data = $this->CI->input->post('update_data');

    	list($table, $field)=explode('.', $field);
		$this->CI->db->limit(1)
					 ->where(array($field => $str));
		if( !empty($update_data) ){
			list($id_field, $value) = explode('.', $update_data);
			$this->CI->db->where($id_field." != ",$value);	
		}		
		$query = $this->CI->db->get($table);	 
		
		return $query->num_rows() === 0;
    }


    /**
    * This function will make sure the value for scheme provided isn't already saved for the same permit.
    **/
    function is_unique_scheme_for_permit($str, $field)
    {
    	$update_data = $this->CI->input->post('update_data');
    	$permit_id = $this->CI->input->post('permit_id');    	

    	list($table, $field)=explode('.', $field);
    	$this->CI->form_validation->set_message("is_unique_scheme_for_permit", 'The scheme should be unique for a particular permit.');

		$this->CI->db->limit(1)
					 ->where(array($field => $str))
					 ->where("permit_id",$permit_id);
		if( !empty($update_data) ){
			list($id_field, $value) = explode('.', $update_data);
			$this->CI->db->where($id_field." != ",$value);	
		}		
		$query = $this->CI->db->get($table);	 
		
		return $query->num_rows() === 0;
    }
} 

/* End of file form_validation.php */
/* Location: ./engine/libraries/form_validation.php */