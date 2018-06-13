<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'core/MY_Admin.php';
class City extends MY_Admin {
    public $title = 'Tỉnh thành';
    function __construct() {
        parent::__construct();
        $this->load->model('city_model');
        $this->load->library(array('pagination', 'form_validation'));
		$this->breadcrumb->append_crumb('Trang chủ', admin_url());
        $this->form_validation->set_rules('title', 'Title', 'required');
    }
    
    function index($page=0) {
		$per_page = 100;
		if($this->input->post()) {
            foreach($this->input->post('sort_order') as $id => $value) {
                $this->city_model->_Update_Sort($id, $value);
            }
            $this->session->set_flashdata('message', 'Cập nhật thành công!');
            redirect(current_url());
        }
		
        $data = array();
        
		$base_url = admin_url($this->uri->segment(2) . '/p');
        $total_rows = $this->city_model->_Count_All();
        $data['category'] = $this->city_model->_Get_All($per_page, $page);
        
		$data['total'] = $total_rows;
        $data['total_page'] = ceil($total_rows/$per_page);
		$data['pagination'] = admin_pagination($base_url, $total_rows, $per_page, $page);
        $data['title'] = $this->title;
		$this->breadcrumb->append_crumb($this->title, admin_url($this->uri->segment(2)));
        
        $this->template->_Set_View('city/view_all', $data);
        $this->template->_Render();
    }
    
    function add() {
        $data = array();
        $data['title'] = $this->title;
        if($this->input->post()) {
            $data['post'] = $this->input->post();
            
            $this->form_validation->set_rules('title', 'Title', 'required');
            
            if($this->form_validation->run()) {
                $this->city_model->_Add($data['post']);
                $this->session->set_flashdata('message', 'Success!');
                redirect(admin_url($this->uri->segment(2)));
            }
        }
        $this->template->_Set_View('city/form', $data);
        $this->template->_Render();
    }
    
    function change($id) {
        $data = array();
        $data['title'] = $this->title;
        $data['post'] = $this->city_model->_Get_By_Id($id);
        $data['id'] = $id;
        if($this->input->post()) {
            $data['post'] = $this->input->post();
            
            if($this->form_validation->run()) {
                $this->city_model->_Update($data['post'], $id);
                $this->session->set_flashdata('message', 'Success!');
                redirect(admin_url($this->uri->segment(2)));
            }
        }
        
        $this->template->_Set_View('city/form', $data);
        $this->template->_Render();
    }
    
    function delete($id) {
        $this->city_model->_Delete($id);
        redirect(admin_url($this->uri->segment(2)));
    }
}