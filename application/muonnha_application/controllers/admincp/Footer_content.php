<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'core/MY_Admin.php';
class Footer_content extends MY_Admin {
    public $title = 'N?i dung chân trang';
    function __construct() {
        parent::__construct();
        $this->load->model(array(
            'footer_content_model',
            'category_model',
            'city_model',
            'district_model',
            'ward_model',
            'street_model',
            'project_model',
            'routes_model'
        ));
        $this->load->library(array('pagination', 'form_validation'));
		$this->breadcrumb->append_crumb('Trang ch?', admin_url());
    }
    
    function index($page=0) {
		
		if($this->input->post()) {
            foreach($this->input->post('sort_order') as $id => $value) {
                $this->footer_content_model->_Update_Sort($id, $value);
            }
            $this->session->set_flashdata('message', 'Cap nhat thành công!');
            redirect(current_url());
        }
		
        $data = array();
        
		$base_url = admin_url($this->uri->segment(2) . '/index');
        $total_rows = $this->footer_content_model->_Count_All();
        
        $data['results'] = $this->footer_content_model->_Get_All(20, 0);
		$data['total'] = $total_rows;
        $data['total_page'] = ceil($total_rows/PER_PAGE);
		$data['pagination'] = admin_pagination($base_url, $total_rows, PER_PAGE, $page);
        $data['title'] = $this->title;
		$this->breadcrumb->append_crumb($this->title, admin_url($this->uri->segment(2)));
        
        $this->template->_Set_View('footer_content/view_all', $data);
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
        if($this->input->post()) {
            $data['post'] = $this->input->post();
            
            $this->form_validation->set_rules('content', 'N?i dung', 'required');
            
            if($this->form_validation->run()) {
                $this->footer_content_model->_Add($data['post']);
                $this->session->set_flashdata('message', 'Success!');
                redirect(admin_url($this->uri->segment(2)));
            }
        }
        $this->template->_Set_View('footer_content/form', $data);
        $this->template->_Render();
    }
    
    function change($id) {
        $data = array();
        $data['title'] = $this->title;
        $data['id'] = $id;
        $data['post'] = $this->footer_content_model->_Get_By_Id($id);
        $data['dropdown_category'] = $this->category_model->_Dropdown_Category();
        $data['dropdown_city'] = $this->city_model->_Get_Dropdown();
        $data['dropdown_district'] = $this->district_model->_Get_Dropdown();
        $data['dropdown_ward'] = $this->ward_model->_Get_Dropdown();
        $data['dropdown_street'] = $this->street_model->_Get_Dropdown();
        $data['dropdown_project'] = $this->project_model->_Get_Dropdown();
        
        $data['category_selected'] = $this->footer_content_model->_Get_Selected($id, 'category_id');
        $data['city_selected'] = $this->footer_content_model->_Get_Selected($id, 'city_id');
        $data['district_selected'] = $this->footer_content_model->_Get_Selected($id, 'district_id');
        $data['ward_selected'] = $this->footer_content_model->_Get_Selected($id, 'ward_id');
        $data['street_selected'] = $this->footer_content_model->_Get_Selected($id, 'street_id');
        
        if($this->input->post()) {
            $data['post'] = $this->input->post();
            $this->form_validation->set_rules('content', 'N?i dung', 'required');
            if($this->form_validation->run()) {
                $this->footer_content_model->_Update($data['post'], $id);
                $this->session->set_flashdata('message', 'Success!');
                redirect(admin_url($this->uri->segment(2)));
            }
        }
        
        $this->template->_Set_View('footer_content/form', $data);
        $this->template->_Render();
    }
    
    function delete($id) {
        $this->footer_content_model->_Delete($id);
        redirect(admin_url($this->uri->segment(2)));
    }
}