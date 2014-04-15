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

		    $rResult = $this->news_category_model->run_sql($sQuery);
		    

		    /* Data set length after filtering */
		    $sQuery = "
		        SELECT FOUND_ROWS() as total
		    ";

		    $rResultFilterTotal = $this->news_category_model->run_sql($sQuery);

		    $iFilteredTotal = $rResultFilterTotal->row()->total;
		    
		    /* Total data set length */
		    $sQuery = "
		        SELECT COUNT(".$sIndexColumn.") as total
		        FROM   $sTable
		    ";

		    $rResultTotal = $this->news_category_model->run_sql($sQuery);
		    

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
	