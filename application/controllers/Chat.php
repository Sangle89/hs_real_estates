<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . '/core/MY_Controller.php';
class Chat extends MY_Controller {

	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->model('cache/chat_model');
    } 
	public function index()
	{
        if($this->ion_auth->logged_in()) {
            $user = $this->ion_auth->user()->row();
            $data['user_id'] = $user->id;
            $data['username'] = $user->email;
            $data['users'] = $this->ion_auth->users()->result_array();
            $this->load->view('chatlist',$data);
        } else {
            redirect('dang-nhap');
        }
	}
    
	public function chatRoom($user_id)
	{
		if($user_id)
		{
			$result=$this->welcome_mdl->getUser($user_id);
			$data['user_id']=$result['user_id'];
			$data['username']=$result['username'];
			$this->load->view('chatpage',$data);
		}
		else
		{
			redirect('');
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */