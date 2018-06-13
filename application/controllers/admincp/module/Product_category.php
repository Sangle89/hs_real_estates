<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'core/MY_Admin.php';
class Product_category extends MY_Admin {
   public $title = 'Module Product Category';
   private $module_id = 1;
   private $module_controller = 'product_category';
   function __construct() {
        parent::__construct();
        $this->load->model(array('module_content_model', 'product_category_model'));
        $this->load->library(array('pagination', 'form_validation'));
		$this->breadcrumb->append_crumb('Trang chủ', admin_url());
        $this->form_validation->set_rules('content[title]', 'Title', 'required');
    }
    
    
    function index($page=0) {
        
        if($this->input->post()) {
            foreach($this->input->post('sort_order') as $id => $value) {
                $this->module_content_model->_Update_Sort($id, $value);
            }
            $this->session->set_flashdata('message', 'Cập nhật thành công!');
            redirect(current_url());
        }
		
        $data = array();
        
		$base_url = admin_url($this->uri->segment(2) . '/index');
        $total_rows = $this->module_content_model->_Count_All();
        $data['category'] = $this->module_content_model->_Get_All(12, $page);
        
		$data['total'] = $total_rows;
        $data['total_page'] = ceil($total_rows/PER_PAGE);
		$data['pagination'] = admin_pagination($base_url, $total_rows, PER_PAGE, $page);
        $data['title'] = $this->title;
		$this->breadcrumb->append_crumb($this->title, admin_url($this->uri->segment(2)));
        
        $this->template->_Set_View('module/' . $this->module_controller . '/view_all', $data);
        $this->template->_Render();
    }
    
    function add() {
        $data = array();
        $data['title'] = $this->title;
        $data['product_category'] = $this->product_category_model->_Dropdown_Category();
        if($this->input->post()) {
            $data['post'] = $this->input->post();
            $data['post']['module_id'] = $this->module_id;
            
            $banner1 = _Upload_Image('banner1', UPLOAD_IMAGE, 850,310);
            if($banner1) 
                $data['post']['content']['banner1'] = $banner1;
            else 
                $data['post']['content']['banner1'] = '';
            
            $banner2 = _Upload_Image('banner2', UPLOAD_IMAGE,320,310);
            if($banner2) 
                $data['post']['content']['banner2'] = $banner2;
            else 
                $data['post']['content']['banner2'] = '';
            
            if($this->form_validation->run()) {
                $this->module_content_model->_Add($data['post']);
                $this->session->set_flashdata('message', 'Success!');
                redirect(admin_url('module/' . $this->module_controller));
            }
        }
        $this->template->_Set_View('module/' . $this->module_controller . '/add', $data);
        $this->template->_Render();
    }
    
    function change($id) {
        $data = array();
        $data['title'] = $this->title;
        $data['product_category'] = $this->product_category_model->_Dropdown_Category();
        $module = $this->module_content_model->_Get_By_Id($id);
        $module_content = unserialize($module['content']);
        
        $data['post'] = array_merge($module, $module_content);
        
        if($this->input->post()) {
            $data['post'] = $this->input->post();
            
            $banner1 = _Upload_Image('banner1', UPLOAD_IMAGE, 850,310);
            if($banner1) 
                $data['post']['content']['banner1'] = $banner1;
            
            $banner2 = _Upload_Image('banner2', UPLOAD_IMAGE, 320,310);
            if($banner2) 
                $data['post']['content']['banner2'] = $banner2;
            
            if($this->form_validation->run()) {
                $this->module_content_model->_Update($id, $data['post']);
                $this->session->set_flashdata('message', 'Success!');
                redirect(admin_url('module/' . $this->module_controller));
            }
        }
        $this->template->_Set_View('module/' . $this->module_controller . '/change', $data);
        $this->template->_Render();
    }
    
    function delete($id) {
        $this->module_content_model->_Delete($id);
        $this->session->set_flashdata('message', 'Success!');
        redirect(admin_url('module/' . $this->module_controller));
        
    }
}