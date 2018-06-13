<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'core/MY_Admin.php';
class Content extends MY_Admin {
    
    public $title = 'Nội dung';
    private $_controller = 'content';
    private $_folder_upload = 'contents';
    
    function __construct() {
        parent::__construct();
        $this->load->model(array(
            'content_category_model',
            'content_model'
        ));
        $this->load->library(array(
            'pagination', 
            'form_validation'
        ));
        $this->breadcrumb->append_crumb('Trang chủ', admin_url());
        
    }
    
    function index($page=1) {
        $data = array();
        if($this->input->post()) {
            foreach($this->input->post('sort_order') as $id => $value) {
                $this->content_model->_Update_Sort($id, $value);
            }
            $this->session->set_flashdata('message', 'Cập nhật thành công!');
            redirect(current_url());
        }
        
        $data['title'] = $this->title;
        $base_url = admin_url($this->uri->segment(2).'/p');
        $total_rows = $this->content_model->_Count_All();
        
        $data['products'] = $this->content_model->_Get_All(PER_PAGE, ($page-1)*PER_PAGE);
        
        $data['pagination'] = admin_pagination($base_url, $total_rows, PER_PAGE, $page);
        $data['total'] = $total_rows;
        $data['total_page'] = ceil($total_rows/PER_PAGE);
        $this->template->_Set_View('content/view_all', $data);
        $this->template->_Render();
    }
    
    function add($category_id = NULL, $page=0) {
        $data = array();
        $data['title'] = $this->title;
        $data['images'] = array();
        $data['post'] = array();        
        $category = $this->content_category_model->_Get_All_Category();
        $data['image_template'] = $this->single_image('image');
        foreach($category as $val) {
            $data['category'][$val['id']] = $val['title']; 
        }
        
        $category_info = $this->content_category_model->_Get_Category_By_Id($category_id);
        $data['category_info'] = $category_info;
        $this->breadcrumb->append_crumb($category_info['title'], admin_url($this->uri->segment(2) . '/index/' . $category_id));
        if($this->input->post()) {
            $data['post'] = $this->input->post();
            
            if($category_id) $data['post']['category_id'] = intval($category_id);
            
            $this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
            
            if($this->form_validation->run()) {
                
                
                $data['post']['image'] = $this->_format_image($data['post']['image']);
                
                $this->content_model->_Add($data['post']);
                $this->session->set_flashdata('message', 'Thêm thành công!');
                
                if(isset($data['post']['save']))                
                    redirect(admin_url($this->uri->segment(2)));
                elseif(isset($data['post']['save_new']))
                    redirect(admin_url($this->uri->segment(2) . '/add/'));
            }
        }
        $this->template->_Set_View('content/form', $data);
        $this->template->_Render();
    }
    
    function change($id, $category_id = NULL, $page=0) {
        $data = array();
        $data['title'] = $this->title;
        $category_info = $this->content_category_model->_Get_Category_By_Id($category_id);
       
        $data['post'] = $this->content_model->_Get_By_Id($id);
        $data['image_template'] = $this->single_image('image', $data['post']['image']);
        $category = $this->content_category_model->_Get_All_Category();
        foreach($category as $val) {
            $data['category'][$val['id']] = $val['title']; 
        }
        $this->breadcrumb->append_crumb($category_info['title'], admin_url($this->uri->segment(2) . '/index/' . $data['post']['category_id']));
        if($this->input->post()) {
            
            $data['post'] = $this->input->post();
            $data['post']['image'] = $this->_format_image($data['post']['image']);
            $this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
            
            if($this->form_validation->run()) {
                $this->content_model->_Update($data['post'], $id);
                $this->session->set_flashdata('message', 'Cập nhật thành công!');
                redirect(admin_url($this->uri->segment(2)));
            }
        }
        $this->template->_Set_View('content/form', $data);
        $this->template->_Render();
    }
    
    function _format_image($image) {
       
                $image = str_replace('"', '', $image);
                $image = str_replace('[', '', $image);
                $image = str_replace(']', '', $image);
                $image = str_replace('\\', '', $image);
                return $image;
    }
    
    function delete($id) {
        $result = $this->content_model->_Get_By_Id($id);
        $this->content_model->_Delete($id);
        $this->session->set_flashdata('message', 'Xóa thành công!');
        redirect(admin_url($this->uri->segment(2)));
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