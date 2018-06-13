<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'core/MY_Admin.php';
class Street extends MY_Admin {
    public $title = 'Đường phố';
    function __construct() {
        parent::__construct();
        $this->load->model(array('city_model','district_model','ward_model','street_model'));
        $this->load->library(array('pagination', 'form_validation'));
		$this->breadcrumb->append_crumb('Trang chủ', admin_url());
        $this->form_validation->set_rules('title', 'Title', 'required');
    }
    
    function index($page=0) {
		
	if($this->input->post()) {
            foreach($this->input->post('sort_order') as $id => $value) {
                $this->street_model->_Update_Sort($id, $value);
            }
            $this->session->set_flashdata('message', 'Cập nhật thành công!');
            redirect(current_url());
        }
		
        $data = array();
        
        $ward = $this->ward_model->_Get_By_Id($district_id);
        $district = $this->district_model->_Get_By_Id($ward['district_id']);
        $city = $this->city_model->_Get_By_Id($district['city_id']);
        
        
	$base_url = base_url(ADMIN_FOLDER .'/' . $this->uri->segment(2) . '/index');
        $total_rows = $this->street_model->_Count_All();
        $data['category'] = $this->street_model->_Get_All(PER_PAGE, $page);
        
	$data['total'] = $total_rows;
        $data['total_page'] = ceil($total_rows/PER_PAGE);
	$data['pagination'] = admin_pagination($base_url, $total_rows, PER_PAGE, $page);
        $data['title'] = $this->title;
		
        
        $this->breadcrumb->append_crumb($city['title'], admin_url('district/index/'.$city['id']));
        $this->breadcrumb->append_crumb($district['title'], admin_url('ward/index/'.$district['id']));
        $this->breadcrumb->append_crumb($ward['title'], admin_url('ward/index/'.$ward['id']));
        
        $this->template->_Set_View('street/view_all', $data);
        $this->template->_Render();
    }
    
    function add($district_id=NULL) {
        $data = array();
        $data['title'] = $this->title;
        
        $ward = $this->ward_model->_Get_By_Id($district_id);
        $district = $this->district_model->_Get_By_Id($district_id);
        $city = $this->city_model->_Get_By_Id($district['city_id']);
        
        $data['city_selected'] = $district['city_id'];
        $data['district_selected'] = $district_id;
        $data['city'] = $this->city_model->_Get_Dropdown();
        $data['district'] = $this->district_model->_Get_Dropdown();
        $data['ward'] = $this->ward_model->_Get_Dropdown($district_id);
        
        if($this->input->post()) {
            $data['post'] = $this->input->post();
            print_r($data['post']);
            $this->form_validation->set_rules('title', 'Title', 'required');
            
            if($this->form_validation->run()) {
                $this->street_model->_Add($data['post']);
                $this->session->set_flashdata('message', 'Success!');
                redirect(admin_url($this->uri->segment(2).'/index/'.$data['post']['district_id']));
            }
        }
        
        $this->breadcrumb->append_crumb($city['title'], admin_url('district/index/'.$city['id']));
        $this->breadcrumb->append_crumb($district['title'], admin_url('ward/index/'.$district['id']));
        $this->breadcrumb->append_crumb($ward['title'], admin_url('ward/index/'.$ward['id']));
        
        $this->template->_Set_View('street/form', $data);
        $this->template->_Render();
    }
    
    function change($id) {
        $data = array();
        $data['title'] = $this->title;
        $data['post'] = $this->street_model->_Get_By_Id($id);
        $data['city'] = $this->city_model->_Get_Dropdown();
        $data['district'] = $this->district_model->_Get_Dropdown();
        $data['ward'] = $this->ward_model->_Get_Dropdown();
        $ward = $this->ward_model->_Get_By_Id($data['post']['ward_id']);
        $district = $this->district_model->_Get_By_Id($ward['district_id']);
        $city = $this->city_model->_Get_By_Id($district['city_id']);
        $data['id'] = $id;
        if($this->input->post()) {
            $data['post'] = $this->input->post();
            if($this->form_validation->run()) {
                $this->street_model->_Update($data['post'], $id);
                $this->session->set_flashdata('message', 'Success!');
                redirect(admin_url($this->uri->segment(2).'/index/'.$data['post']['district_id']));
            }
        }
        
        $this->breadcrumb->append_crumb($city['title'], admin_url('district/index/'.$city['id']));
        $this->breadcrumb->append_crumb($district['title'], admin_url('ward/index/'.$district['id']));
        $this->breadcrumb->append_crumb($ward['title'], admin_url('ward/index/'.$ward['id']));
        
        $this->template->_Set_View('street/form', $data);
        $this->template->_Render();
    }
    
    function delete($id) {
        $result = $this->street_model->_Get_By_Id($id);
        $this->street_model->_Delete($id);
        $this->session->set_flashdata('message', 'Xóa thành công!');
        redirect(admin_url($this->uri->segment(2).'/index/'.$result['ward_id']));
    }
}