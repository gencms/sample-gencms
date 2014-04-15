<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends MX_Controller {

	public $language = "sw";

    public function __construct() {
	
        parent::__construct();
		$this->load->library("session");
		$this->load->library('user_agent');
		$this->load->helper('cookie');

		# Clear the browser cache
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
        # End

    }

    public function main_template_view($view, $data) {
        $data['main_content'] = $view;
        $this->load->view('common/template', $data);
    }
}

/* End of file MY_Controller.php */
/* Location: ./app/core/MY_Controller.php */