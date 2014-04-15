<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	/**
	 * News Model
	 *
	 * This is the model for the News module
	 *
	 * @package			News_platform
	 * @subpackage		News_platform/News
	 * @author         	generateCMS
	 * @website 		http://www.generatecms.com
	 * @email		support@generatecms.com
	 */
	class News_model extends CMS_Model {

		private $table_name			= "news";
		private $pk_field			= "news_id";
		private $status_field		= "active";
		
		function __construct()
		{
			parent::__construct();
			$this->load->database();
		}
		
		/*
	     * This function returns an empty news object.
	     *
	    */
	    public function get_new_news_object()
	    {
	        $news_object = new stdClass(); 
			$news_object->news_id = "";
			$news_object->title = "";
			$news_object->summary = "";
			$news_object->content = "";
			$news_object->picture = "";
			$news_object->news_category = "";
			$news_object->news_date = "";
			$news_object->active = "";
	    return $news_object;
	    }
		
	}

	/* End of file news_model.php */
	/* File generated by http://www.generatecms.com on 04/11/2014 09:09:44 pm */
	/* Location: ./app/modules/news/models/news_model.php */
	