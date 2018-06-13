<?php
class Logout extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->library(array('ion_auth','form_validation'));
		$this->load->helper(array('url','language'));
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
		$this->lang->load('auth');
    }
    
    function index()
	{
		$this->data['title'] = "Logout";
		// log the user out
		$logout = $this->ion_auth->logout();
		// redirect them to the login page
		$this->session->set_flashdata('message', $this->ion_auth->messages());
		redirect(ADMIN_FOLDER.'/login', 'refresh');
	}
    
}