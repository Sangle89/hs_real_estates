<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'core/MY_Admin.php';
class Project extends MY_Admin {
    public $title = 'Dự án';
    function __construct() {
        parent::__construct();
        $this->load->model(array(
            'project_model',
            'city_model',
            'district_model',
            'ward_model',
            'street_model'
        ));
        $this->load->library(array('pagination', 'form_validation'));
		$this->breadcrumb->append_crumb('Trang chủ', admin_url());
        $this->form_validation->set_rules('title', 'Title', 'required');
    }
    
    function index($page=0) {
		
		if($this->input->post()) {
            foreach($this->input->post('sort_order') as $id => $value) {
                $this->project_model->_Update_Sort($id, $value);
            }
            $this->session->set_flashdata('message', 'Cập nhật thành công!');
            redirect(current_url());
        }
		
        $data = array();
        $data['heading_title'] = $this->title;
		$base_url = admin_url($this->uri->segment(2) . '/index');
        $total_rows = $this->project_model->_Count_All();
        $data['category'] = $this->project_model->_Get_All(PER_PAGE, $page);
        
		$data['total'] = $total_rows;
        $data['total_page'] = ceil($total_rows/PER_PAGE);
		$data['pagination'] = admin_pagination($base_url, $total_rows, PER_PAGE, $page);
        $data['title'] = $this->title;
		$this->breadcrumb->append_crumb($this->title, admin_url($this->uri->segment(2)));
        
        $this->template->_Set_View('project/view_all', $data);
        $this->template->_Render();
    }
    
    function add() {
        $data = array();
        $data['heading_title'] = $this->title;
        $data['dropdown_city'] = $this->city_model->_Get_Dropdown();
        $data['dropdown_district'] = $this->district_model->_Get_Dropdown();
        $data['dropdown_ward'] = $this->ward_model->_Get_Dropdown();
        $data['dropdown_street'] = $this->street_model->_Get_Dropdown();
        if($this->input->post()) {
            $data['post'] = $this->input->post();
            
            $this->form_validation->set_rules('title', 'Title', 'required');
            
            /*$file_upload = _Upload_Image2('image', UPLOAD_IMAGE);
            
            if($file_upload['error']) {
                $this->form_validation->set_rules('image', 'image', 'required');
            } else {
                $data['post']['image'] = $file_upload['file_path'];
            }*/
           
            if($this->form_validation->run()) {
                $this->project_model->_Add($data['post']);
                $this->session->set_flashdata('message', 'Success!');
                redirect(admin_url($this->uri->segment(2)));
            }
        }
        $this->template->_Set_View('project/form', $data);
        $this->template->_Render();
    }
    
    function change($id) {
        $data = array();
        $data['heading_title'] = $this->title;
        $data['id'] = $id;
        $data['post'] = $this->project_model->_Get_By_Id($id);
        $data['dropdown_city'] = $this->city_model->_Get_Dropdown();
        $data['dropdown_district'] = $this->district_model->_Get_Dropdown();
        $data['dropdown_ward'] = $this->ward_model->_Get_Dropdown();
        $data['dropdown_street'] = $this->street_model->_Get_Dropdown();
        if($this->input->post()) {
            $data['post'] = $this->input->post();
            /*
            $file_upload = _Upload_Image2('image', UPLOAD_IMAGE);
            
            if($file_upload['error']) {
                $this->error_image = $file_upload['error'];
                $this->form_validation->set_rules('image', 'image', 'callback__check_image');
            } else {
                $data['post']['image'] = $file_upload['file_path'];
            }*/
            
            if($this->form_validation->run()) {
                $this->project_model->_Update($data['post'], $id);
                $this->session->set_flashdata('message', 'Success!');
                redirect(admin_url($this->uri->segment(2)));
            }
        }
        
        $this->template->_Set_View('project/form', $data);
        $this->template->_Render();
    }
    
    function delete($id) {
        $this->project_model->_Delete($id);
        $this->session->set_flashdata('message', 'Xóa thành công');
        redirect(admin_url($this->uri->segment(2)));
    }
    
    function _check_image($str) {
        $this->form_validation->set_message('_check_image',$this->error_image);
        return false;
    }
}