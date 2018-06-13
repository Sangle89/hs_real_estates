<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'core/MY_Admin.php';
class District extends MY_Admin {
    public $title = 'Quận huyện';
    function __construct() {
        parent::__construct();
        $this->load->model(array('city_model','district_model'));
        $this->load->model('street_model', 'street');
        $this->load->library(array('pagination', 'form_validation'));
		$this->breadcrumb->append_crumb('Trang chủ', admin_url());
        $this->form_validation->set_rules('title', 'Title', 'required');
    }
    
    function index($city_id=NULL, $page=0) {
		
		if($this->input->post()) {
            foreach($this->input->post('sort_order') as $id => $value) {
                $this->district_model->_Update_Sort($id, $value);
            }
            $this->session->set_flashdata('message', 'Cập nhật thành công!');
            redirect(current_url());
        }
        
        $data = array();
        
        $city = $this->city_model->_Get_By_Id($city_id);
        
		$base_url = base_url(ADMIN_FOLDER . '/' . $this->uri->segment(2) . '/p');
        $total_rows = $this->district_model->_Count_All($city_id);
        $data['category'] = $this->district_model->_Get_All($city_id);
        
		$data['total'] = $total_rows;
        $data['total_page'] = ceil($total_rows/9999);
		$data['pagination'] = admin_pagination($base_url, $total_rows, 9999, $page);
        $data['title'] = $this->title;
	
        $this->breadcrumb->append_crumb($city['title'], admin_url('district/'.$city['id']));
       // $this->load->view(ADMIN_FOLDER . '/district/view_all', $data);
        
        $this->template->_Set_View('district/view_all', $data);
        $this->template->_Render();
    }
    
    function add($city_id=0) {
        $data = array();
        $data['title'] = $this->title;
        $data['city'] = $this->city_model->_Get_Dropdown();
        $data['post']['city_id'] = $city_id;
        
        $streets = $this->street->_Get_All();
        foreach($streets as $street) {
            $data['street_option'][$street['id']] = $street['title'];
        }
        
        if($this->input->post()) {
            $data['post'] = $this->input->post();
            
            $this->form_validation->set_rules('title', 'Title', 'required');
            
            if($this->form_validation->run()) {
                $this->district_model->_Add($data['post']);
                $this->session->set_flashdata('message', 'Success!');
                redirect(admin_url($this->uri->segment(2).'/index/'.$city_id));
            }
        }
        $city = $this->city_model->_Get_By_Id($city_id);
        $this->breadcrumb->append_crumb($city['title'], admin_url('district/'.$city['id']));
        
        //$this->load->view(ADMIN_FOLDER . '/district/add', $data);
        $this->template->_Set_View('district/form', $data);
        $this->template->_Render();
    }
    
    function change($id) {
        $data = array();
        $data['title'] = $this->title;
        $data['post'] = $this->district_model->_Get_By_Id($id);
        $data['city'] = $this->city_model->_Get_Dropdown();
        $data['id'] = $id;
        $streets = $this->street->_Get_All();
        foreach($streets as $street) {
            $data['street_option'][$street['id']] = $street['title'];
        }
        $data['district_street'] = $this->district_model->_Get_Street($id);
        if($this->input->post()) {
            $data['post'] = $this->input->post();
            if($this->form_validation->run()) {
                $this->district_model->_Update($data['post'], $id);
                $this->session->set_flashdata('message', 'Success!');
                redirect(admin_url($this->uri->segment(2).'/index/'.$data['post']['city_id']));
            }
        }
        $city = $this->city_model->_Get_By_Id($data['post']['city_id']);
        $this->breadcrumb->append_crumb($city['title'], admin_url('district/'.$city['id']));
        //$this->load->view(ADMIN_FOLDER . '/district/change', $data);
        $this->template->_Set_View('district/form', $data);
        $this->template->_Render();
    }
    
    function delete($id) {
        $result = $this->district_model->_Get_By_Id($id);
        $this->district_model->_Delete($id);
        $this->session->set_flashdata('message', 'Xóa thành công!');
        redirect(admin_url($this->uri->segment(2).'/index/'.$result['city_id']));
    }
}