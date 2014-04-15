<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	/**
	 * News_category Model
	 *
	 * This is the model for the News_category module
	 *
	 * @package			News_platform
	 * @subpackage		News_platform/News_category
	 * @author         	generateCMS
	 * @website 		http://www.generatecms.com
	 * @email		support@generatecms.com
	 */
	class News_category_model extends CMS_Model {

		private $table_name			= "news_category";
		private $pk_field			= "news_category_id";
		private $status_field		= "active";
		
		function __construct()
		{
			parent::__construct();
			$this->load->database();
		}
		
		/*
	     * This function returns an empty news_category object.
	     *
	    */
	    public function get_new_news_category_object()
	    {
	        $news_category_object = new stdClass(); 
			$news_category_object->news_category_id = "";
			$news_category_object->category_name = "";
	    return $news_category_object;
	    }
		
	}

	/* End of file news_category_model.php */
	/* File generated by http://www.generatecms.com on 04/11/2014 09:09:44 pm */
	/* Location: ./app/modules/news_category/models/news_category_model.php */
	