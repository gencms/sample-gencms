<?php

class CMS_Controller extends MX_Controller {

	public $data = array();

    public function __construct() {
	
        parent::__construct();
        $this->load->library('ion_auth');
		$this->load->library("session");
		$this->load->library('user_agent');
		$this->load->library('pagination');		
		$this->load->helper('cookie');
		
		if(version_compare(CI_VERSION,'2.1.0','<')){
			$this->load->library('security');
		}
		
		if (!$this->ion_auth->logged_in())
        {
            redirect('user/auth/login');
        }
    }

    public function main_template_view($view, $data) {
        $data['main_content'] = $view;
        $this->load->view('common/template', $data);
    }
}