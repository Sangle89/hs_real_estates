<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'core/MY_Admin.php';
class Product extends MY_Admin {
    
    public $title = 'Sản phẩm';
    
    function __construct() {
        parent::__construct();
        $this->load->model(array(
            'product_category_model',
            'product_model',
            'property_group_model',
            'property_model',
            'tags_model'
        ));
        $this->load->library(array(
            'pagination', 
            'form_validation'
        ));
        $this->breadcrumb->append_crumb('Trang chủ', admin_url());
        
    }
    
    function index($page=0) {
        $data = array();
        
        if($this->input->post()) {
            foreach($this->input->post('sort_order') as $id => $value) {
                $this->product_model->_Update_Sort($id, $value);
            }
            $this->session->set_flashdata('message', 'Cập nhật thành công!');
            redirect(current_url());
        }
        
        $data['title'] = $this->title;
        $base_url = admin_url($this->uri->segment(2) . '/index/');
        $total_rows = $this->product_model->_Count_All();
        
        $data['products'] = $this->product_model->_Get_All(PER_PAGE, $page);
        
        $data['pagination'] = admin_pagination($base_url, $total_rows, PER_PAGE, $page);
        $data['total'] = $total_rows;
        $data['total_page'] = ceil($total_rows/PER_PAGE);
        $this->breadcrumb->append_crumb($this->title, admin_url($this->uri->segment(2)));
        
        $this->template->_Set_View('product/view_all', $data);
        $this->template->_Render();
    }
    
    function add($category_id = NULL, $page=0) {
        $data = array();
        $data['title'] = $this->title;
        $data['images'] = array();
        $data['post'] = array();        
        
        $data['dropdown_category'] = $this->product_category_model->_Dropdown_Category();
        $property_group = $this->property_group_model->_Get_All();
        foreach($property_group as $key => $group) {
            $data['property'][$group['title']] = $this->property_model->_Get_Dropdown($group['id']);
        }
        
        $tags = $this->tags_model->_Get_All();
        foreach($tags as $val) {
            $data['tags'][$val['id']] = $val['title'];
        }
        
        if($category_id){
            $data['category'] = $this->product_category_model->_Get_By_Id($category_id);
        }else{
            $data['category'] = array();
        }
            
        if($this->input->post()) {
            $data['post'] = $this->input->post();
           
            if($category_id) $data['post']['category_id'] = intval($category_id);
            
            $this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
            
            $data['post']['image'] = _Upload_Image('image', UPLOAD_IMAGE, 400, 400);
            
            if($this->form_validation->run()) {
                
                $this->product_model->_Add($data['post']);
                $this->session->set_flashdata('message', 'Thêm thành công!');
                
                if(isset($data['post']['save']))                
                    redirect(admin_url($this->uri->segment(2) . '/p/' . $page));
                elseif(isset($data['post']['save_new']))
                    redirect(admin_url($this->uri->segment(2) . '/add/' . $page));
            }
        }
        $this->breadcrumb->append_crumb($this->title, admin_url($this->uri->segment(2)));
        $this->template->_Set_Script('UploadImage("images");');
        $this->template->_Set_View('product/add', $data);
        $this->template->_Render();
    }
    
    function change($id, $category_id = NULL, $page=0) {
        $data = array();
        $data['title'] = $this->title;
       
        $data['post'] = $this->product_model->_Get_By_Id($id);
        
        $data['dropdown_category'] = $this->product_category_model->_Dropdown_Category();
        $property_group = $this->property_group_model->_Get_All();
        foreach($property_group as $key => $group) {
            $data['property'][$group['title']] = $this->property_model->_Get_Dropdown($group['id']);
        }
        $property = $this->product_model->_Get_Property($id);
        foreach($property as $val) {
            $data['product_property'][] = $val['property_id'];
        }
        
        $tags = $this->tags_model->_Get_All();
        foreach($tags as $val) {
            $data['tags'][$val['id']] = $val['title'];
        }
        
        $data['images'] = $this->product_model->_Get_Product_Image($id);
        $product_tags = $this->product_model->_Get_Product_tag($id);
        foreach($product_tags as $val) {
            $data['product_tags'][] = $val['tag_id'];
        }
        if($this->input->post()) {
            
            $data['post'] = $this->input->post();
            
            $this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
            
            $data['post']['image'] = _Upload_Image('image', UPLOAD_IMAGE, 400, 400);
            
            if($this->form_validation->run()) {
                $this->product_model->_Update($data['post'], $id);
                $this->session->set_flashdata('message', 'Cập nhật thành công!');
                redirect(admin_url($this->uri->segment(2) . '/p/' . $page));
            }
        }
        $this->breadcrumb->append_crumb($this->title, admin_url($this->uri->segment(2)));
        $this->template->_Set_Script('UploadImage("images");');
        $this->template->_Set_View('product/change', $data);
        $this->template->_Render();
    }
    
    function update_sort() {
        
    }
    
    function delete($id, $category_id, $page=0) {
        $this->product_model->_Delete($id);
        $this->session->set_flashdata('message', 'Xóa thành công!');
        redirect(admin_url($this->uri->segment(2). '/index/' . $category_id . '/' . $page));
    }
    
}