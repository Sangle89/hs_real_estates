<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'core/MY_Admin.php';
class Ward extends MY_Admin {
    public $title = 'Phường xã';
    function __construct() {
        parent::__construct();
        $this->load->model(array('city_model','district_model','ward_model'));
        $this->load->library(array('pagination', 'form_validation'));
		$this->breadcrumb->append_crumb('Trang chủ', admin_url());
        $this->form_validation->set_rules('title', 'Title', 'required');
    }
    
    function index($district_id=NULL, $page=0) {
		
		if($this->input->post()) {
            foreach($this->input->post('sort_order') as $id => $value) {
                $this->ward_model->_Update_Sort($id, $value);
            }
            $this->session->set_flashdata('message', 'Cập nhật thành công!');
            redirect(current_url());
        }
		
        $data = array();
        
        $district = $this->district_model->_Get_By_Id($district_id);
        $city = $this->city_model->_Get_By_Id($district['city_id']);
        
		$base_url = admin_url($this->uri->segment(2) . '/index/'.$district_id);
        $total_rows = $this->ward_model->_Count_All($district_id);
        $data['category'] = $this->ward_model->_Get_All($district_id);
        
		$data['total'] = $total_rows;
        $data['total_page'] = ceil($total_rows/PER_PAGE);
		$data['pagination'] = admin_pagination($base_url, $total_rows, PER_PAGE, $page);
        $data['title'] = $this->title;
		
        
        $this->breadcrumb->append_crumb($city['title'], admin_url('district/index/'.$city['id']));
        $this->breadcrumb->append_crumb($district['title'], admin_url('ward/index/'.$district['id']));
        
        $this->template->_Set_View('ward/view_all', $data);
        $this->template->_Render();
    }
    
    function add($city_id=NULL) {
        $data = array();
        $data['title'] = $this->title;
        $data['city'] = $this->city_model->_Get_Dropdown();
        $data['district'] = $this->district_model->_Get_Dropdown();
        $data['post']['district_id'] = $city_id;
        if($this->input->post()) {
            $data['post'] = $this->input->post();
            
            $this->form_validation->set_rules('title', 'Title', 'required');
            
            if($this->form_validation->run()) {
                $this->ward_model->_Add($data['post']);
                $this->session->set_flashdata('message', 'Success!');
                redirect(admin_url($this->uri->segment(2).'/index/'.$this->uri->segment(4)));
            }
        }
        $this->template->_Set_View('ward/form', $data);
        $this->template->_Render();
    }
    
    function change($id) {
        $data = array();
        $data['title'] = $this->title;
        $data['post'] = $this->ward_model->_Get_By_Id($id);
        $data['city'] = $this->city_model->_Get_Dropdown();
        $data['district'] = $this->district_model->_Get_Dropdown();
        $data['id'] = $id;
        if($this->input->post()) {
            $data['post'] = $this->input->post();
            if($this->form_validation->run()) {
                $this->ward_model->_Update($data['post'], $id);
                $this->session->set_flashdata('message', 'Success!');
                redirect(admin_url($this->uri->segment(2).'/index/'.$data['post']['district_id']));
            }
        }
        
        $this->template->_Set_View('ward/form', $data);
        $this->template->_Render();
    }
    
    function delete($id) {
        $result = $this->ward_model->_Get_By_Id($id);
        $this->ward_model->_Delete($id);
        $this->session->set_flashdata('message', 'Xóa thành công!');
        redirect(admin_url($this->uri->segment(2).'/index/'.$result['district_id']));
    }
}