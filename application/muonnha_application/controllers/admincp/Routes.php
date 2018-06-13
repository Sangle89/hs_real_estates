<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'core/MY_Admin.php';
class Routes extends MY_Admin {
    public $title = 'Hình ảnh slide';
    function __construct() {
        parent::__construct();
        $this->load->model('routes_model');
        $this->load->library(array('pagination', 'form_validation'));
		$this->breadcrumb->append_crumb('Trang chủ', admin_url());
        $this->form_validation->set_rules('title', 'Title', 'required');
    }
    
    function index($page=0) {
		
		if($this->input->post()) {
            foreach($this->input->post('sort_order') as $id => $value) {
                $this->routes_model->_Update_Sort($id, $value);
            }
            $this->session->set_flashdata('message', 'Cập nhật thành công!');
            redirect(current_url());
        }
		
        $data = array();
        
		$base_url = admin_url($this->uri->segment(2) . '/p');
        $total_rows = $this->routes_model->_Count_All();
        $data['category'] = $this->routes_model->_Get_All(12, $page);
        
		$data['total'] = $total_rows;
        $data['total_page'] = ceil($total_rows/PER_PAGE);
		$data['pagination'] = admin_pagination($base_url, $total_rows, PER_PAGE, $page);
        $data['title'] = $this->title;
		$this->breadcrumb->append_crumb($this->title, admin_url($this->uri->segment(2)));
        
        $this->template->_Set_View('routes/view_all', $data);
        $this->template->_Render();
    }
    
    function add() {
        $data = array();
        $data['title'] = $this->title;
        if($this->input->post()) {
            $data['post'] = $this->input->post();
            
            $this->form_validation->set_rules('title', 'Title', 'required');
            
            $data['post']['image'] = _Upload_Image('image', UPLOAD_IMAGE,850,340);
           
            if($this->form_validation->run()) {
                $this->routes_model->_Add($data['post']);
                $this->session->set_flashdata('message', 'Success!');
                redirect(admin_url($this->uri->segment(2)));
            }
        }
        $this->template->_Set_View('routes/add', $data);
        $this->template->_Render();
    }
    
    function change($id) {
        $data = array();
        $data['title'] = $this->title;
        $data['post'] = $this->routes_model->_Get_By_Id($id);
        
        if($this->input->post()) {
            $data['post'] = $this->input->post();
            
            $data['post']['image'] = _Upload_Image('image', UPLOAD_IMAGE, 850, 340);
            
            if($this->form_validation->run()) {
                $this->routes_model->_Update($data['post'], $id);
                $this->session->set_flashdata('message', 'Success!');
                redirect(admin_url($this->uri->segment(2)));
            }
        }
        
        $this->template->_Set_View('routes/change', $data);
        $this->template->_Render();
    }
    
    function delete($id) {
        $this->routes_model->_Delete($id);
        redirect(admin_url($this->uri->segment(2)));
    }
}