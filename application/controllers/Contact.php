<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . '/core/MY_Controller.php';
class Contact extends MY_Controller {
    
    function __construct() {
        parent::__construct();
        
        $this->load->model(array(
            'cache/main_model'
        ));
        
        $this->load->library(array('pagination','breadcrumb','ion_auth'));
        $this->breadcrumb->__construct(array(
            'tag_open' => '<ul class="breadcrumb">',
            'tag_close' => '</ul>'
        ));
        $this->breadcrumb->append_crumb('<i class="fa fa-home"></i>', site_url());
        
        $this->data = array();
        
        $web_setting = $this->main_model->_Get_Setting();
        $this->template->_Set_Config($web_setting);
        
    }    
    
    public function index() {
        $data = array();
        if($this->input->post()) {
            $post = $this->input->post();
            $this->load->library('form_validation');
            $this->form_validation->set_rules('fullname', 'Họ tên', 'required|max_length[50]');
            $this->form_validation->set_rules('email', 'Email', 'required|max_length[50]|valid_email');
            $this->form_validation->set_rules('phone', 'Số điện thoại', 'required|max_length[20]|is_numeric');
            $this->form_validation->set_rules('message', 'Nội dung', 'required|max_length[2000]');
            if($this->form_validation->run()) {
                $this->load->database();
                $this->db->insert('contacts', array(
                    'fullname' => trim($post['fullname']),
                    'email' => trim($post['email']),
                    'phone' => trim($post['phone']),
                    'message' => trim($post['message']),
                    'create_time' => date('Y-m-d H:i:s', time()) 
                ));
                if($this->db->insert_id()) {
                    $this->load->library('send_email');
                    $subject = 'Thông tin liên hệ';
                    $body = "<p>Họ tên: $post[email]</p>";
                    $body .="<p>Số điện thoại: $post[phone]</p>";
                    $body .="<p>Email: $post[email]</p>";
                    $body .="<p>Nội dung: $post[message]</p>";
                    $this->send_email->_Send($subject, $body, $post['email'], $this->main_model->_Get_Setting('emails'));
                    $this->session->set_flashdata('success', true);
                }
            }
            
            redirect(site_url('lien-he'));
        }
        $data['page_content'] = $this->main_model->_Get_Page_By_Id(16);
        $this->breadcrumb->append_crumb($data['page_content']['title'], site_url('lien-he'));
        $schema = $this->load->view('default/schema', array(), true);
        $this->template->_Set_Config($data['page_content']);
        $this->template->_Set_Data('schema', $schema);
        $this->template->_Set_Data('cur_page', 'contact');
        $this->template->_Set_View('contact', $data);
        $this->template->_Render();
    }
}