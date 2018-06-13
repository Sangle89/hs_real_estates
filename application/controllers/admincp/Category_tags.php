<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'core/MY_Admin.php';
class Category_tags extends MY_Admin {
    public $title = 'Từ khóa danh mục';
    function __construct() {
        parent::__construct();
        
		$this->load->model(array(
            'real_estate_model',
            'category_model',
            'city_model',
            'district_model',
            'ward_model',
            'street_model',
            'project_model',
            'ion_auth_model',
			'category_tags_model',
			'tags_model'
        ));
        $this->load->library(array('pagination', 'form_validation'));
		$this->breadcrumb->append_crumb('Trang chủ', admin_url());
    }
    
    function index($page=0) {
		
		if($this->input->post()) {
            foreach($this->input->post('sort_order') as $id => $value) {
                $this->category_tags_model->_Update_Sort($id, $value);
            }
            $this->session->set_flashdata('message', 'Cập nhật thành công!');
            redirect(current_url());
        }
		
        $data = array();
        
		$base_url = admin_url($this->uri->segment(2) . '/index');
        $total_rows = $this->category_tags_model->_Count_All();
        $data['category'] = $this->category_tags_model->_Get_All(12, $page);
        
		$data['total'] = $total_rows;
        $data['total_page'] = ceil($total_rows/20);
		$data['pagination'] = admin_pagination(base_url(ADMIN_FOLDER.'/category_tags/index'), $total_rows, 20, $page);
        $data['title'] = $this->title;
		$this->breadcrumb->append_crumb($this->title, admin_url($this->uri->segment(2)));
        
        $this->template->_Set_View('category_tags/view_all', $data);
        $this->template->_Render();
    }
    
    function add() {
        $data = array();
        $data['title'] = $this->title;
		$data['dropdown_category'] = $this->category_model->_Dropdown_Category();
        $data['dropdown_city'] = $this->city_model->_Get_Dropdown();
		$data['dropdown_district'] = $this->district_model->_Get_Dropdown();
        $data['dropdown_ward'] = $this->ward_model->_Get_Dropdown();
        $data['dropdown_street'] = $this->street_model->_Get_Dropdown2();
		$data['dropdown_tags'] = $this->tags_model->_Get_Dropdown();
        if($this->input->post()) {
            $data['post'] = $this->input->post();
            
            $this->form_validation->set_rules('category_id', 'Danh mục', 'required');
            
            if($this->form_validation->run()) {
                $this->category_tags_model->_Add($data['post']);
                $this->session->set_flashdata('message', 'Success!');
                redirect(admin_url($this->uri->segment(2)));
            }
        }
        $this->template->_Set_View('category_tags/form', $data);
        $this->template->_Render();
    }
    
    function change($id) {
        $data = array();
        $data['title'] = $this->title;
        $data['post'] = $this->category_tags_model->_Get_By_Id($id);
        $data['dropdown_category'] = $this->category_model->_Dropdown_Category();
        $data['dropdown_city'] = $this->city_model->_Get_Dropdown();
		$data['dropdown_district'] = $this->district_model->_Get_Dropdown($data['post']['city_id']);
        $data['dropdown_ward'] = $this->ward_model->_Get_Dropdown($data['post']['ward_id']);
        $data['dropdown_street'] = $this->street_model->_Get_Dropdown2($data['post']['street_id']);
		$data['dropdown_tags'] = $this->tags_model->_Get_Dropdown();
        if($this->input->post()) {
            $data['post'] = $this->input->post();
            
            $this->form_validation->set_rules('category_id', 'Danh mục', 'required');
            
            if($this->form_validation->run()) {
                $this->category_tags_model->_Update($data['post'], $id);
                $this->session->set_flashdata('message', 'Success!');
                redirect(admin_url($this->uri->segment(2)));
            }
        }
        
        $this->template->_Set_View('category_tags/form', $data);
        $this->template->_Render();
    }
    
    function delete($id) {
        $this->category_tags_model->_Delete($id);
        redirect(admin_url($this->uri->segment(2)));
    }
}