<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'core/MY_Admin.php';
class Web_link_content extends MY_Admin {
    public $title = 'Liên kết web';
    function __construct() {
        parent::__construct();
        $this->load->model(array(
            'web_link_content_model',
            'web_link_model',
            'category_model',
            'content_category_model',
            'city_model',
            'district_model',
            'ward_model',
            'street_model',
            'project_model',
            'routes_model'
        ));
        $this->load->library(array('pagination', 'form_validation'));
		$this->breadcrumb->append_crumb('Trang chủ', admin_url());
    }
    
    function index($page=0) {
		
		if($this->input->post()) {
            foreach($this->input->post('sort_order') as $id => $value) {
                $this->web_link_content_model->_Update_Sort($id, $value);
            }
            $this->session->set_flashdata('message', 'Cap nhat thành công!');
            redirect(current_url());
        }
		
        $data = array();
        
		$base_url = admin_url($this->uri->segment(2) . '/index');
        $total_rows = $this->web_link_content_model->_Count_All();
        
        $data['results'] = $this->web_link_content_model->_Get_All(20, 0);
		$data['total'] = $total_rows;
        $data['total_page'] = ceil($total_rows/PER_PAGE);
		$data['pagination'] = admin_pagination($base_url, $total_rows, PER_PAGE, $page);
        $data['title'] = $this->title;
		$this->breadcrumb->append_crumb($this->title, admin_url($this->uri->segment(2)));
        
        $this->template->_Set_View('web_link_content/view_all', $data);
        $this->template->_Render();
    }
    
    function add() {
        $data = array();
        $data['title'] = $this->title;
        $data['dropdown_content_category'] = $this->content_category_model->_Dropdown_Category();
        $data['dropdown_category'] = $this->category_model->_Dropdown_Category();
        $data['dropdown_city'] = $this->city_model->_Get_Dropdown();
        $data['dropdown_district'] = $this->district_model->_Get_Dropdown();
        $data['dropdown_ward'] = $this->ward_model->_Get_Dropdown();
        $data['dropdown_street'] = $this->street_model->_Get_Dropdown();
        
        $footer_link = $this->web_link_model->_Get_All();
        foreach($footer_link as $row) {
            $data['link_option'][$row['id']] = $row['title'];
        }
        $data['link_selected'] = array();
        if($this->input->post()) {
            $data['post'] = $this->input->post();
            
            $this->form_validation->set_rules('links[]', 'Liên kết', 'required|numeric');
            
            if($this->form_validation->run()) {
                $this->web_link_content_model->_Add($data['post']);
                $this->session->set_flashdata('message', 'Success!');
                redirect(admin_url($this->uri->segment(2)));
            }
        }
        $this->template->_Set_View('web_link_content/form', $data);
        $this->template->_Render();
    }
    
    function change($id) {
        $data = array();
        $data['title'] = $this->title;
        $data['id'] = $id;
        $data['post'] = $this->web_link_content_model->_Get_By_Id($id);
        $data['dropdown_content_category'] = $this->content_category_model->_Dropdown_Category();
        $data['dropdown_category'] = $this->category_model->_Dropdown_Category();
        $data['dropdown_city'] = $this->city_model->_Get_Dropdown();
        $data['dropdown_district'] = $this->district_model->_Get_Dropdown();
        $data['dropdown_ward'] = $this->ward_model->_Get_Dropdown();
        $data['dropdown_street'] = $this->street_model->_Get_Dropdown();
        $data['dropdown_project'] = $this->project_model->_Get_Dropdown();
        
        $data['content_category_selected'] = $this->web_link_content_model->_Get_Selected($id, 'content_cat_id');
        $data['category_selected'] = $this->web_link_content_model->_Get_Selected($id, 'category_id');
        $data['city_selected'] = $this->web_link_content_model->_Get_Selected($id, 'city_id');
        $data['district_selected'] = $this->web_link_content_model->_Get_Selected($id, 'district_id');
        $data['ward_selected'] = $this->web_link_content_model->_Get_Selected($id, 'ward_id');
        $data['street_selected'] = $this->web_link_content_model->_Get_Selected($id, 'street_id');
        $data['followed'] = $this->web_link_content_model->_Get_Follow($id);
        $footer_link = $this->web_link_model->_Get_All();
        foreach($footer_link as $row) {
            $data['link_option'][$row['id']] = $row['title'];
        }
        $data['link_selected'] = $data['post']['content']!='' ? explode(",",$data['post']['content']):array();
        
        if($this->input->post()) {
            $data['post'] = $this->input->post();
            $this->form_validation->set_rules('links[]', 'Liên kết', 'required|numeric');
            if($this->form_validation->run()) {
                $this->web_link_content_model->_Update($data['post'], $id);
                $this->session->set_flashdata('message', 'Success!');
                redirect(admin_url($this->uri->segment(2)));
            }
        }
        
        $this->template->_Set_View('web_link_content/form', $data);
        $this->template->_Render();
    }
    
    function delete($id) {
        $this->web_link_content_model->_Delete($id);
        redirect(admin_url($this->uri->segment(2)));
    }
}