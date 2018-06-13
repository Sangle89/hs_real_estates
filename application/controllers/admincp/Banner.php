<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'core/MY_Admin.php';
class Banner extends MY_Admin {
    
    public $_title = 'Banner';
    private $_controller = 'banner';
    private $_folder_upload = 'banners';
    
    function __construct() {
        parent::__construct();
        $this->load->model('banner_model', 'category');
        $this->load->library(array(
            'pagination', 
            'form_validation',
            'sangmaster'
        ));
        $this->breadcrumb->append_crumb('Trang ch?', admin_url());
        $this->breadcrumb->append_crumb($this->_title, admin_url($this->_controller));
        $this->message = array();
    }
	
	function task() {
		$data['task_add'] = base_url(ADMIN_FOLDER . '/' . $this->_controller . '/add/');
		$data['task_change'] = base_url(ADMIN_FOLDER . '/' . $this->_controller . '/change/' );
		$data['task_delete'] = base_url(ADMIN_FOLDER . '/' . $this->_controller . '/delete/' );
		$data['task_list'] = $this->session->userdata("CALLBACK_URL") ? $this->session->userdata("CALLBACK_URL") : base_url(ADMIN_FOLDER . '/' . $this->_controller . '/p/');
		$data['task_status'] = base_url(ADMIN_FOLDER . '/' . $this->_controller . '/status/' );
        return $data;
	}
	
	function index() {
		$this->p(0);
	}
    
    function p($page=0) {
	
        $data = array();
        
        $data['heading_title'] = $this->_title;
		$data['controller'] = $this->_controller;
        $data['task'] = $this->task();
        
        if($this->input->post()) {
            if($this->input->post('update_sort')) {
                $this->update_sort();
                
            }
            if($this->input->post('delete_checked')) {
                $this->delete_checked();
            }
            $this->sangmaster->_Add_Msg(UPDATE_SUCCESS);
                
            redirect($data['task']['task_list']);
        }
        
        $total_rows = $this->category->_Count_All();
        
        $data['results'] = $this->category->_Get_All(PER_PAGE, $page);
        
        $data['total'] = $total_rows;
        $data['pagination'] = $this->pagination->create_links();
        $this->breadcrumb->append_crumb($this->_title, $data['task']['task_list']);
        
        $this->template->_Set_View($this->_controller . '/list', $data);
        $this->template->_Render();
    }
    
    function add() {
        $data = array();
        $data['heading_title'] = $this->_title;
        $data['task'] = $this->task();
        $data['post'] = array();        
        $data['image_template'] = $this->single_image('image');
        if($this->input->post()) {
            
            $this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
            
            if($this->form_validation->run()) {
                
                $this->category->_Add();
                
                $this->sangmaster->_Add_Msg(INSERT_SUCCESS);
                
                redirect($data['task']['task_list']);
            }
        }
        $this->template->_Set_View($this->_controller . '/form', $data);
        $this->template->_Render();
    }
    
    function change($id) {
        $data = array();
        $data['heading_title'] = $this->_title;
        $data['task'] = $this->task();
        $data['post'] = $this->category->_Get_By_Id($id);
        $data['image_template'] = $this->single_image('image', $data['post']['image']);
        $this->breadcrumb->append_crumb($data['post']['title'], admin_url($this->uri->segment(2) . '/index/' . $data['post']['id']));
 
        if($this->input->post()) {
            
            $this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
            
            if($this->form_validation->run()) {
                $this->category->_Update($id);
                $this->sangmaster->_Add_Msg(INSERT_SUCCESS);
                redirect($data['task']['task_list']);
            }
        }
        $this->template->_Set_View($this->_controller . '/form', $data);
        $this->template->_Render();
    }
    
    function update_sort() {
        if($this->input->post('update_sort')) {
            $post_data = $this->input->post('sort_order');
            foreach($post_data as $id => $val) {
                $this->category->_Update_Sort($id, $val);
            }
        }
    }
    
    function delete_checked() {
        if($this->input->post('delete_checked')) {
            $post_data = $this->input->post('results');
           
            foreach($post_data as $val) {
                $this->category->_Delete($val);
            }
        }
    }
    
    function status($id, $status) {
        $data['task'] = $this->task();
        $this->category->_Update_Status($id, $status);
        $this->sangmaster->_Add_Msg(INSERT_SUCCESS);
        redirect($data['task']['task_list']);
    }
    
    function delete($id) {
        $result = $this->category->_Get_By_Id($id);
        $this->category->_Delete($id);
        $this->sangmaster->_Add_Msg(DELETE_SUCCESS);
        redirect(admin_url($this->uri->segment(2). '/index/' . $result['category_id']));
    }
	
	function single_image($name = 'image', $value = '') {
        $this->load->library('RandomStringGenerator');
        $random = $this->randomstringgenerator->generate(32);
        $data['cache_id'] = $random . time();
		$data['value'] = $value;
		$data['name'] = $name;
        $data['folder_upload'] = $this->_folder_upload;
        return $this->load->view(ADMIN_FOLDER .'/'.$this->_controller .'/single_image', $data, TRUE);
    }
    
}