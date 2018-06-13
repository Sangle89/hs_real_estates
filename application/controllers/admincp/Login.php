<?php
class Login extends CI_Controller {
    
    function __construct() {
        
		$this->authenticate();
        
        parent::__construct();
        $this->load->library(array('ion_auth','form_validation'));
		$this->load->helper(array('url','language','functions'));
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
		$this->lang->load('auth');
    }
    function authenticate() {
        // Status flag:
		$LoginSuccessful = false;
		 
		// Check username and password:
		if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])){
		 
			$Username = $_SERVER['PHP_AUTH_USER'];
			$Password = $_SERVER['PHP_AUTH_PW'];
		 
			if ($Username == 'AdminHS' && $Password == '123@123'){
				$LoginSuccessful = true;
			}
		}
		
		if (!$LoginSuccessful){
			header('WWW-Authenticate: Basic realm="Secret page"');
			header('HTTP/1.0 401 Unauthorized');
			die("Login failed!\n");
		}
    }
    
    function index()
	{
		$this->data['title'] = $this->lang->line('login_heading');
		//validate form input
		$this->form_validation->set_rules('identity', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
		$this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');
		if ($this->form_validation->run() == true)
		{
			// check to see if the user is logging in
			// check for "remember me"
			$remember = (bool) $this->input->post('remember');
			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
			{
				//if the login is successful
				//redirect them back to the home page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect(admin_url(), 'refresh');
			}
			else
			{
				// if the login was un-successful
				// redirect them back to the login page
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect(admin_url('login'), 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
			}
		}
		else
		{
			// the user is not logging in so display the login page
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->data['identity'] = array('name' => 'identity',
				'id'    => 'username',
				'type'  => 'text',
				'class' => 'form-control',
                'placeholder' => 'Tên đăng nhập',
				'value' => $this->form_validation->set_value('identity'),
			);
			$this->data['password'] = array('name' => 'password',
				'id'   => 'password',
                'placeholder' => 'Mật khẩu',
				'class' => 'form-control',
				'type' => 'password',
			);
			$this->load->view(ADMIN_FOLDER . '/login', $this->data);
		}
	}
    
}