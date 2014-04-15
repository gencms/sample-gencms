<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	/**
	 * News Controller
	 *
	 * This is the controller for the News module
	 *
	 * @package			News_platform
	 * @subpackage		News_platform/News
	 * @author	        generateCMS
	 * @website 		http://www.generatecms.com
	 * @email 		support@generatecms.com
	 */
	class News extends CMS_Controller {
		
		function __construct() {

			parent::__construct();

			$this->load->helper(array('form', 'url'));
			$this->load->library(array('form_validation', 'pagination'));
			$this->load->model("news_model");		
		}
	
	
		/**
		 * This method is responsible for listing all news items
		 * @view   	  : list.php
		 */
		function index() {				
			$data["active_page"] = "news";
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
			              "sAjaxSource": "'.site_url().'/news/items/",
			              "aoColumnDefs": [ 
			                          
							{
			                    "fnRender": function ( oObj ) {
			                      return \'<a href="'.base_url().'/uploads/news/\'+oObj.aData[2]+\'" class="zoomify" title="Picture"><img src="'.base_url().'/uploads/news/\'+oObj.aData[2]+\'" class="thumb"></a>\' ;
			                    },
			                    "aTargets": [ 2 ]
			                }
						,
							{
			                    "fnRender": function ( oObj ) {
			                      return \'<a href="'.site_url().'/news/edit/\'+oObj.aData[0]+\'">Edit</a> | <a class="delete" href="'.site_url().'/news/delete/\'+oObj.aData[0]+\'">Delete</a>\' ;
			                    },
			                    "aTargets": [ 6 ]
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

								
			        $join_items[] = array(
			                 "table"        =>  "news_category"
			                ,"key_field"    =>  "news_category_id"
			                ,"mapped_field" =>  "news_category"
			                ,"join_type"    =>  "inner"
			        );
				
				$aColumns = array(news_id,title,picture,category_name,news_date,active,1);	
    
		    /* Indexed column (used for fast and accurate table cardinality) */
		    $sIndexColumn = "news_id";

		    $sTable = "news";

		    /* 
		     * Paging
		     */
		    $sLimit = "";
		    if ( isset( $_POST["iDisplayStart"] ) && $_POST["iDisplayLength"] != "-1" )
		    {
		        $sLimit = "LIMIT ".mysql_real_escape_string( $_POST["iDisplayStart"] ).", ".
		            		       mysql_real_escape_string( $_POST["iDisplayLength"] );

		        $sql_data["offset"]  = mysql_real_escape_string( $_POST["iDisplayStart"] );
		        $sql_data["perpage"] = mysql_real_escape_string( $_POST["iDisplayLength"] );    		       

		    }

		    /*
		     * Ordering
		     */
		    if ( isset( $_POST["iSortCol_0"] ) )
		    {
		        $sOrder = "ORDER BY  ";
		        for ( $i=0 ; $i<intval( $_POST["iSortingCols"] ) ; $i++ )
		        {
		            if ( $_POST[ "bSortable_".intval($_POST["iSortCol_".$i]) ] == "true" )
		            {
		                $sOrder .= $aColumns[ intval( $_POST["iSortCol_".$i] ) ]." ".mysql_real_escape_string( $_POST["sSortDir_".$i] ) .", ";		                
		            }
		        }
		        
		        $sOrder = substr_replace( $sOrder, "", -2 );
		        if ( $sOrder == "ORDER BY" )
		        {
		            $sOrder = "";
		        }
		        $sql_data["order"] = $sOrder;
		    }


		    /* 
		     * Filtering
		     * NOTE this does not match the built-in DataTables filtering which does it
		     * word by word on any field. Its possible to do here, but concerned about efficiency
		     * on very large tables, and MySQLs regex functionality is very limited
		     */
		  
		    if ( $_POST["sSearch"] != "" )
		    {
		        $sWhere .= "WHERE (";
		        for ( $i=0 ; $i<count($aColumns) ; $i++ )
		        {
		            $sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string( $_POST["sSearch"] )."%' OR ";
		        }
		        $sWhere = substr_replace( $sWhere, "", -3 );
		        $sWhere .= ")";
		    }

		    
		    /* Individual column filtering */
		    for ( $i=0 ; $i<count($aColumns) ; $i++ )
		    {
		        if ( $_POST["bSearchable_".$i] == "true" && $_POST["sSearch_".$i] != "" )
		        {
		            if ( $sWhere == "" )
		            {
		                $sWhere = "WHERE ";
		            }
		            else
		            {
		                $sWhere .= " AND ";
		            }
		            $sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string($_POST["sSearch_".$i])."%' ";
		        }
		    }
		    $sql_data["where"] = $sWhere;


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

		    $rResult = $this->news_model->run_sql($sQuery);
		    

		    /* Data set length after filtering */
		    $sQuery = "
		        SELECT FOUND_ROWS() as total
		    ";

		    $rResultFilterTotal = $this->news_model->run_sql($sQuery);

		    $iFilteredTotal = $rResultFilterTotal->row()->total;
		    
		    /* Total data set length */
		    $sQuery = "
		        SELECT COUNT(".$sIndexColumn.") as total
		        FROM   $sTable
		    ";

		    $rResultTotal = $this->news_model->run_sql($sQuery);
		    

		    $iTotal = $rResultTotal->row()->total;


		    /*
		     * Output
		     */
		    $output = array(
		        "sEcho" => intval($_POST["sEcho"]),
		        "iTotalRecords" => $iTotal,
		        "iTotalDisplayRecords" => $iFilteredTotal,
		        "aaData" => array()
		    );
		    

		    foreach ($rResult->result_array() as $aRow) {
		    	$row = array();		    	
		    	for ( $i=0 ; $i<count($aColumns) ; $i++ )
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
		    
		    echo json_encode( $output );				        										       
		}	


		
		/**
		 * This method is responsible for creating/updating a news item
		 * @param $id : int
		 * @view   	  : edit.php
		 */
		public function edit($id = NULL)
		{  		
			$data = array();
			$error_messages = "";

	        $data["title"] = "Manage News";

			# Define form validation rules 
			$this->form_validation->set_rules("news_id", "news_id", "trim|xss_clean");
			$this->form_validation->set_rules("title", "News Title", "trim|xss_clean|required");
			$this->form_validation->set_rules("summary", "Summary", "trim|xss_clean");
			$this->form_validation->set_rules("content", "Content", "trim|xss_clean|required");
			$this->form_validation->set_rules("news_category", "News Category", "trim|xss_clean|required");
			$this->form_validation->set_rules("news_date", "News Date", "trim|xss_clean|required");
			$this->form_validation->set_rules("active", "Published", "trim|xss_clean|required");			

	        if(!$this->form_validation->run()) {
				#validation failed
				$error_messages .= validation_errors();
			}
			else {						 

				$news_data = $this->news_model->array_from_post(array(
								"news_id",
								"title",
								"summary",
								"content",
								"news_category",
								"news_date",
								"active"
				));

			$news_id = $this->input->post("news_id");	

			if ( isset($_FILES["picture"]["name"]) && !empty($_FILES["picture"]["name"]) ) {
					$config["upload_path"] = "uploads/news";
		            $config["allowed_types"] = "gif|jpg|png";
		            $config["max_size"]	= "0";
		            $config["overwrite"] = FALSE;
		            //$config["encrypt_name"] = TRUE;
	            	$this->load->library("upload", $config);
	            	$this->upload->initialize($config);

	                if ( ! $this->upload->do_upload("picture"))
	                {	                	
	                    #errors during uploading
	                    $error_messages .= $this->upload->display_errors();	                    
	                }
	                else {                	                  	
				    	$current_logo = $this->input->post("current_picture");
	                	$file_url = $this->upload->file_name;                	

						if( !empty($file_url) ) {								
							unlink("uploads/news/".$current_logo);
							$news_data["picture"] = $file_url;
						}
	                }//end ifelse success upload                
	        }else {
	        	if( empty($news_id) )
	        		;
	        	
	        }
	    						
				
				if(empty($error_messages)){					
			        $saved = $this->news_model->save("news","news_id" ,$news_data, $news_id);

			        #If saved successfully, redirect to listing page
			        if($saved) redirect("news");
			    }
			}

			
				$data["news_category_options"] = $this->news_model->get_dropdown_options("news_category","news_category_id","category_name");
			

			if(!empty($id)){
				$data["details"] = $this->news_model->get("news", $id, "news_id", "news_id");
			}
			else {
				$data["details"] = $this->news_model->get_new_news_object();	
			}

			$data["id"] = $id;

	        $data["message"] = $error_messages;
			$view = "edit";
			$this->main_template_view($view, $data);	
		}	

		
		/**
		 * This method is responsible for deleting a news item
		 * @param $item_id : int
		 * @redirects_to   : index_method
		 */
		function delete($item_id = 0){
			if($item_id < 1) return;
			 $redirect_to =  $this->agent->referrer();
		
			$this->news_model->delete("news", "news_id", $item_id);
			
			#If deleted successfully, redirect to previous page
	      	redirect($redirect_to);
		}
		
		
	}

	/* End of file news.php */
	/* File generated by http://www.generatecms.com on 04/11/2014 09:09:44 pm */
	/* Location: ./app/modules/news/controllers/news.php */
	