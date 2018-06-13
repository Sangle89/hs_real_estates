<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'core/MY_Admin.php';
class Content_category extends MY_Admin {
    public $title = 'Nhóm danh mục';
    function __construct() {
        parent::__construct();
        $this->load->model('content_category_model');
        $this->load->library(array('pagination', 'form_validation'));
		$this->breadcrumb->append_crumb('Trang chủ', admin_url());
    }
    
    function index($page=0) {
		
		if($this->input->post()) {
            foreach($this->input->post('sort_order') as $id => $value) {
                $this->content_category_model->_Update_Sort($id, $value);
            }
            $this->session->set_flashdata('message', 'Cập nhật thành công!');
            redirect(current_url());
        }
		
        $data = array();
        
		$base_url = admin_url($this->uri->segment(2) . '/index');
        $total_rows = $this->content_category_model->_Count_All_Category();
        $data['category'] = $this->content_category_model->_Get_All_Category(12, $page);
        
		$data['total'] = $total_rows;
        $data['total_page'] = ceil($total_rows/PER_PAGE);
		$data['pagination'] = admin_pagination($base_url, $total_rows, PER_PAGE, $page);
		$this->breadcrumb->append_crumb($this->title, admin_url($this->uri->segment(2)));
        
        $this->template->_Set_View('content_category/view_all', $data);
        $this->template->_Render();
    }
    
    function add() {
        $data = array();
        $main_category = $this->content_category_model->_Get_All_Category_Main();
        $data['main_category'][0] = 'Danh mục gốc';
        foreach ($main_category as $val) {
            $data['main_category'][$val['id']] = $val['title'];
        }
        
        if($this->input->post()) {
            $data['post'] = $this->input->post();
            
            $this->form_validation->set_rules('title', 'Title', 'required');
           
            if($this->form_validation->run()) {
                
                
                $this->content_category_model->_Add_Category($data['post']);
                $this->session->set_flashdata('message', 'Success!');
                redirect(admin_url($this->uri->segment(2)));
            }
        }
        $this->template->_Set_View('content_category/add', $data);
        $this->template->_Render();
    }
    
    function change($id) {
        $data = array();
        $main_category = $this->content_category_model->_Get_All_Category_Main();
        $data['main_category'][0] = 'Danh mục gốc';
        foreach ($main_category as $val) {
            $data['main_category'][$val['id']] = $val['title'];
        }
        $data['post'] = $this->content_category_model->_Get_Category_By_Id($id);
        
        if($this->input->post()) {
            $data['post'] = $this->input->post();
            
            $this->form_validation->set_rules('title', 'Title', 'required');
            
          //  $data['post']['image'] = _Upload_Image('image', UPLOAD_IMAGE);
            
            if($this->form_validation->run()) {
                $this->content_category_model->_Update_Category($data['post'], $id);
                $this->session->set_flashdata('message', 'Success!');
                redirect(admin_url($this->uri->segment(2)));
            }
        }
        
        $this->template->_Set_View('content_category/change', $data);
        $this->template->_Render();
    }
    
    function delete($id) {
        $this->content_category_model->_Delete_Category($id);
        redirect(admin_url($this->uri->segment(2)));
    }
}