<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'core/MY_Admin.php';
class Category extends MY_Admin {
    public $title = 'Nhóm danh mục';
    function __construct() {
        parent::__construct();
        $this->load->model('category_model');
        $this->load->library(array('pagination', 'form_validation'));
		$this->breadcrumb->append_crumb('Trang chủ', admin_url());
    }
    
    function index($page=0) {
		
		if($this->input->post()) {
            foreach($this->input->post('sort_order') as $id => $value) {
                $this->category_model->_Update_Sort($id, $value);
            }
            $this->session->set_flashdata('message', 'Cập nhật thành công!');
            redirect(current_url());
        }
		
        $data = array();
        
		$base_url = admin_url($this->uri->segment(2) . '/index');
        $total_rows = $this->category_model->_Count_All();
        $data['category'] = $this->category_model->_Get_All_Lv();
        
		$data['total'] = $total_rows;
        $data['total_page'] = ceil($total_rows/PER_PAGE);
		$data['pagination'] = admin_pagination($base_url, $total_rows, PER_PAGE, $page);
		$this->breadcrumb->append_crumb($this->title, admin_url($this->uri->segment(2)));
        $data['heading_title'] = $this->title;
        $this->template->_Set_View('category/view_all', $data);
        $this->template->_Render();
    }
    
    function add() {
        $data = array();
        
        $data['dropdown_category'] = $this->category_model->_Dropdown_Category();
        
        if($this->input->post()) {
            $data['post'] = $this->input->post();
            
            $this->form_validation->set_rules('title', 'Title', 'required');
            
            if($this->form_validation->run()) {
                
                
                $this->category_model->_Add($data['post']);
                $this->session->set_flashdata('message', 'Success!');
                redirect(admin_url($this->uri->segment(2)));
            }
        }
        $data['heading_title'] = $this->title;
        $this->template->_Set_View('category/form', $data);
        $this->template->_Render();
    }
    
    function change($id) {
        $data = array();
        $data['dropdown_category'] = $this->category_model->_Dropdown_Category();
        $data['post'] = $this->category_model->_Get_By_Id($id);
        $data['id'] = $id;
        if($this->input->post()) {
            $data['post'] = $this->input->post();
            
            $this->form_validation->set_rules('title', 'Title', 'required');
            
            
            if($this->form_validation->run()) {
                $this->category_model->_Update($data['post'], $id);
                $this->session->set_flashdata('message', 'Success!');
                redirect(admin_url($this->uri->segment(2)));
            }
        }
        $data['heading_title'] = $this->title;
        $this->template->_Set_View('category/form', $data);
        $this->template->_Render();
    }
    
    function delete($id) {
        $this->category_model->_Delete($id);
        redirect(admin_url($this->uri->segment(2)));
    }
}