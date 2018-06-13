<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'core/MY_Admin.php';
class Modules extends MY_Admin {
    public $title = 'Module';
    function __construct() {
        parent::__construct();
        $this->load->model('module_model');
        $this->load->library(array('pagination', 'form_validation'));
		$this->breadcrumb->append_crumb('Trang chủ', admin_url());
        $this->form_validation->set_rules('title', 'Title', 'required');
    }
    
    function install() {
        $data = array();
        $data['title'] = $this->title;
        if($this->input->post()) {
            $this->module_model->_Add_Module($this->input->post());
            redirect(admin_url($this->uri->segment(2)));
        }
        $this->template->_Set_View('module/install', $data);
        $this->template->_Render();
    }
    
    function index($page=0) {
        
		if($this->input->post()) {
            foreach($this->input->post('sort_order') as $id => $value) {
                $this->module_model->_Update_Sort($id, $value);
            }
            $this->session->set_flashdata('message', 'Cập nhật thành công!');
            redirect(current_url());
        }
		
        $data = array();
        
		$base_url = admin_url($this->uri->segment(2) . '/index');
        $total_rows = $this->module_model->_Count_All();
        $data['category'] = $this->module_model->_Get_All(12, $page);
        
		$data['total'] = $total_rows;
        $data['total_page'] = ceil($total_rows/PER_PAGE);
		$data['pagination'] = admin_pagination($base_url, $total_rows, PER_PAGE, $page);
        $data['title'] = $this->title;
		$this->breadcrumb->append_crumb($this->title, admin_url($this->uri->segment(2)));
        
        $this->template->_Set_View('module/view_all', $data);
        $this->template->_Render();
    }
}