<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	/**
	 * News_category Controller
	 *
	 * This is the controller for the News_category module
	 *
	 * @package			News_platform
	 * @subpackage		News_platform/News_category
	 * @author	        generateCMS
	 * @website 		http://www.generatecms.com
	 * @email 		support@generatecms.com
	 */
	class News_category extends CMS_Controller {
		
		function __construct() {

			parent::__construct();

			$this->load->helper(array('form', 'url'));
			$this->load->library(array('form_validation', 'pagination'));
			$this->load->model("news_category_model");		
		}
	
	
		/**
		 * This method is responsible for listing all news_category items
		 * @view   	  : list.php
		 */
		function index() {				
			$data["active_page"] = "news_category";
			#Define page specific assets
			$data["css"] = '<link href="'.base_url().'assets/css/jquery.dataTables.css" rel="stylesheet">'
						  .'<link href="'.base_url().'assets/css/DT_bootstrap.css" rel="stylesheet">';


			$table_id = "cms_listing_tbl";
			$data["js"] .= '
				<script>
				$(function() {
					$("#'.$table_id.'").dataTable({
			              "sDom": "<\'row\'<\'span8\'l><\'span8\'f>r>t<\'row\'<\'span8\'i><\'span8\'p>>",              
			              "sPaginationType": "bootstrap",
			              "oLanguage": {
								"sLengthMenu": "show _MENU_ records per page"
						  },
			              "bProcessing": true,
			              "bServerSide": true,
			              "sServerMethod": "POST",
			              "sAjaxSource": "'.site_url().'/news_category/items/",
			              "aoColumnDefs": [ 
			                          
							{
			                    "fnRender": function ( oObj ) {
			                      return \'<a href="'.site_url().'/news_category/edit/\'+oObj.aData[0]+\'">Edit</a> | <a class="delete" href="'.site_url().'/news_category/delete/\'+oObj.aData[0]+\'">Delete</a>\' ;
			                    },
			                    "aTargets": [ 2 ]
			                }
						
			                        ]
			      	});
				});
				</script>
			';

			$data["table_id"] = $table_id;
	       
			$view = "list";
			$this->main_template_view($view, $data);	
		}

		
		/**
		 * This method is responsible for fetching data for the ajax requests
		 * @return   	  : json_data
		 */

		function items() {					
			$aColumns = array(news_category_id,category_name,1);	

			/* Indexed column (used for fast and accurate table cardinality) */
			$sIndexColumn = "news_category_id";

			$sTable = "news_category";

			#Get post variables and add them to the sql_data array to pass to the model		    
			$sql_data = array(
				 "iDisplayStart"	=>	$this->input->post("iDisplayStart", true)
				,"iDisplayLength"	=>	$this->input->post("iDisplayLength", true)
				,"iSortCol_0"	=>	$this->input->post("iSortCol_0", true)
				,"iSortingCols"	=>	$this->input->post("iSortingCols", true)
				,"sSearch"	=>	$this->input->post("sSearch", true)
				,"sEcho"	=>	$this->input->post("sEcho",  true)
				,"numColumns"	=>	count($aColumns)
				,"sTable"	=>	$sTable
				,"sIndexColumn"	=>	$sIndexColumn
				,"aColumns"	=>	$aColumns
				,"join_items"	=>	$join_items
			);

			$output = $this->news_category_model->get_items($sql_data);

			echo json_encode( $output );				        										       
		}	


		
		/**
		 * This method is responsible for creating/updating a news_category item
		 * @param $id : int
		 * @view   	  : edit.php
		 */
		public function edit($id = NULL)
		{  		
			$data = array();
			$error_messages = "";

	        $data["title"] = "Manage News_category";

			# Define form validation rules 
			$this->form_validation->set_rules("news_category_id", "news_category_id", "trim|xss_clean");
			$this->form_validation->set_rules("category_name", "Category Name", "trim|xss_clean|required");			

	        if(!$this->form_validation->run()) {
				#validation failed
				$error_messages .= validation_errors();
			}
			else {						 

				$news_category_data = $this->news_category_model->array_from_post(array(
								"news_category_id",
								"category_name"
				));

									
				
				if(empty($error_messages)){
					$news_category_id = $this->input->post("news_category_id");
			        $saved = $this->news_category_model->save("news_category","news_category_id" ,$news_category_data, $news_category_id);

			        #If saved successfully, redirect to listing page
			        if($saved) redirect("news_category");
			    }
			}

			

			if(!empty($id)){
				$data["details"] = $this->news_category_model->get("news_category", $id, "news_category_id", "news_category_id");
			}
			else {
				$data["details"] = $this->news_category_model->get_new_news_category_object();	
			}

			$data["id"] = $id;

	        $data["message"] = $error_messages;
			$view = "edit";
			$this->main_template_view($view, $data);	
		}	

		
		/**
		 * This method is responsible for deleting a news_category item
		 * @param $item_id : int
		 * @redirects_to   : index_method
		 */
		function delete($item_id = 0){
			if($item_id < 1) return;
			 $redirect_to =  $this->agent->referrer();
		
			$this->news_category_model->delete("news_category", "news_category_id", $item_id);
			
			#If deleted successfully, redirect to previous page
	      	redirect($redirect_to);
		}
		
		
	}

	/* End of file news_category.php */
	/* File generated by http://www.generatecms.com on 04/11/2014 09:09:44 pm */
	/* Location: ./app/modules/news_category/controllers/news_category.php */
	