<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'core/MY_Admin.php';
class Web_link extends MY_Admin {
    public $title = 'Liên kết nổi bật';
    function __construct() {
        parent::__construct();
        $this->load->model(array(
            'web_link_model',
            'category_model',
            'city_model',
            'district_model',
            'ward_model',
            'street_model',
            'project_model',
            'routes_model'
        ));
        $this->load->library(array('pagination', 'form_validation'));
		$this->breadcrumb->append_crumb('Trang chủ', admin_url());
        $this->form_validation->set_rules('title', 'Title', 'required');
    }
    
    function index($page=0) {
		
		if($this->input->post()) {
            foreach($this->input->post('sort_order') as $id => $value) {
                $this->Web_link_model->_Update_Sort($id, $value);
            }
            $this->session->set_flashdata('message', 'Cập nhật thành công!');
            redirect(current_url());
        }
		
        $data = array();
        
		$base_url = admin_url($this->uri->segment(2) . '/index');
        $total_rows = $this->web_link_model->_Count_All();
        $data['category'] = $this->web_link_model->_Get_By_Parent();
        
		$data['total'] = $total_rows;
        $data['total_page'] = ceil($total_rows/PER_PAGE);
		$data['pagination'] = admin_pagination($base_url, $total_rows, PER_PAGE, $page);
        $data['title'] = $this->title;
		$this->breadcrumb->append_crumb($this->title, admin_url($this->uri->segment(2)));
        
        $this->template->_Set_View('web_link/view_all', $data);
        $this->template->_Render();
    }
    
    function add() {
        $data = array();
        $data['title'] = $this->title;
        
        $data['dropdown_category'] = $this->category_model->_Dropdown_Category();
        $data['dropdown_city'] = $this->city_model->_Get_Dropdown();
        $data['dropdown_district'] = $this->district_model->_Get_Dropdown();
        $data['dropdown_ward'] = $this->ward_model->_Get_Dropdown();
        $data['dropdown_street'] = $this->street_model->_Get_Dropdown();
        $data['dropdown_project'] = $this->project_model->_Get_Dropdown();
        $data['dropdown'] = $this->web_link_model->_Get_Dropdown();
        if($this->input->post()) {
            $data['post'] = $this->input->post();
            
            $this->form_validation->set_rules('title', 'Title', 'required');
            
            if($this->form_validation->run()) {
                $key = $this->routes_model->_Get_Key_By_Param($data['post']);
                $data['post']['alias'] = $key['key'];
                $this->web_link_model->_Add($data['post']);
                $this->session->set_flashdata('message', 'Success!');
                redirect(admin_url($this->uri->segment(2)));
            }
        }
        $this->template->_Set_View('web_link/form', $data);
        $this->template->_Render();
    }
    
    function change($id) {
        $data = array();
        $data['title'] = $this->title;
        $data['id'] = $id;
        $data['post'] = $this->web_link_model->_Get_By_Id($id);
        //$route = $this->routes_model->_Get_Key($data['post']['alias']);
        
        $data['dropdown_category'] = $this->category_model->_Dropdown_Category();
        $data['dropdown_city'] = $this->city_model->_Get_Dropdown();
        $data['dropdown_district'] = $this->district_model->_Get_Dropdown();
        $data['dropdown_ward'] = $this->ward_model->_Get_Dropdown();
        $data['dropdown_street'] = $this->street_model->_Get_Dropdown();
        $data['dropdown_project'] = $this->project_model->_Get_Dropdown();
        $data['dropdown'] = $this->web_link_model->_Get_Dropdown();
        if($this->input->post()) {
            $data['post'] = $this->input->post();
            
            if($this->form_validation->run()) {
                $key = $this->routes_model->_Get_Key_By_Param($data['post']);
                $data['post']['alias'] = $key['key'];
                $this->web_link_model->_Update($data['post'], $id);
                $this->session->set_flashdata('message', 'Success!');
                redirect(admin_url($this->uri->segment(2)));
            }
        }
        
        $this->template->_Set_View('web_link/form', $data);
        $this->template->_Render();
    }
    
    function delete($id) {
        $this->web_link_model->_Delete($id);
        redirect(admin_url($this->uri->segment(2)));
    }
}