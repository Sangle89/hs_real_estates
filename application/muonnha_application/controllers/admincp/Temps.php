<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'core/MY_Admin.php';
class Temps extends MY_Admin {
    public $title = 'Tin đăng';
    private $_controller = 'temps';
    function __construct() {
        parent::__construct();
        $this->load->model(array(
            'temps_model',
            'real_estate_model',
            'category_model',
            'city_model',
            'district_model',
            'ward_model',
            'street_model',
            'project_model',
            'ion_auth_model'
        ));
        
        $this->load->library(array('pagination', 'form_validation'));
		$this->breadcrumb->append_crumb('Trang chủ', admin_url());
        $this->form_validation->set_rules('title', 'Title', 'required');
    }
    
    function index($page=0) {
		
		if($this->input->post()) {
            foreach($this->input->post('sort_order') as $id => $value) {
                $this->real_estate_model->_Update_Sort($id, $value);
            }
            $this->session->set_flashdata('message', 'Cập nhật thành công!');
            redirect(current_url());
        }
		
        $data = array();
        $data['heading_title'] = $this->title;
		$base_url = base_url('admincp/temps/p');
        $total_rows = $this->temps_model->_Count_All();
        $data['category'] = $this->temps_model->_Get_All(20, $page);
        
		$data['total'] = $total_rows;
        $data['total_page'] = ceil($total_rows/20);
		$data['pagination'] = admin_pagination($base_url, $total_rows, 20, $page);
        $data['title'] = $this->title;
		$this->breadcrumb->append_crumb($this->title, admin_url($this->uri->segment(2)));
        
        $this->template->_Set_View('temps/view_all', $data);
        $this->template->_Render();
    }
    
    function copy($id) {
        $this->load->database();
        
        $data = $this->temps_model->_Get_By_Id($id);
        $data['status'] = 'active';
        $data['featured'] = 0;
        $data['create_by'] = 1;
        $data['create_time'] = date("Y-m-d H:i:s", time() - 60*60*24*360);
        $data['images'][] = $data['image'];
        
        $this->real_estate_model->_Add($data);
        $this->temps_model->_Delete($id);
        $this->session->set_flashdata('message', 'Thêm thành công!');
        redirect(admin_url($this->uri->segment(2)));
    }
    
    function add() {
        $data = array();
        
        $data['title'] = $this->title;
        $data['heading_title'] = $this->title;
        $data['dropdown_category'] = $this->category_model->_Dropdown_Category();
        $data['dropdown_city'] = $this->city_model->_Get_Dropdown();
        $data['dropdown_district'] = $this->district_model->_Get_Dropdown();
        $data['dropdown_ward'] = $this->ward_model->_Get_Dropdown();
        $data['dropdown_street'] = $this->street_model->_Get_Dropdown2();
        $data['dropdown_project'] = $this->project_model->_Get_Dropdown();
        
        $users = $this->ion_auth_model->users()->result_array();
        $data['dropdown_user'][0] = '--Khách vãng lai--';
        foreach($users as $user) {
            $data['dropdown_user'][$user['id']] = $user['email'];
        }
         
        if($this->input->post()) {
            $data['post'] = $this->input->post();
            
            $this->form_validation->set_rules('title', 'Tiêu đề tin', 'trim|required|max_length[250]');
            $this->form_validation->set_rules('category_id', 'Danh mục', 'required|callback_check_category');
            $this->form_validation->set_rules('city_id', 'Tỉnh thành', 'required|callback_check_city');
            $this->form_validation->set_rules('district_id', 'Quận huyện', 'required|callback_check_district');
            
            if($this->form_validation->run()) {
                $this->real_estate_model->_Add($data['post']);
                $this->session->set_flashdata('message', 'Thêm thành công!');
                redirect(admin_url($this->uri->segment(2)));
            }
        }
        $this->template->_Set_Script('UploadImage("images");');
        $this->template->_Set_View('real_estate/form', $data);
        $this->template->_Render();
    }
    
    function change($id) {
        $data = array();
        $data['post'] = $this->real_estate_model->_Get_By_Id($id);
        
        $data['heading_title'] = $this->title;
        $data['id'] = $id;
        $data['dropdown_category'] = $this->category_model->_Dropdown_Category();
        $data['dropdown_city'] = $this->city_model->_Get_Dropdown();
        $data['dropdown_district'] = $this->district_model->_Get_Dropdown($data['post']['city_id']);
        $data['dropdown_ward'] = $this->ward_model->_Get_Dropdown($data['post']['district_id']);
        $data['dropdown_street'] = $this->street_model->_Get_Dropdown($data['post']['district_id']);
        $data['dropdown_project'] = $this->project_model->_Get_Dropdown();
        
        $data['images'] = $this->real_estate_model->_Get_Images($id);
        
        $users = $this->ion_auth_model->users()->result_array();
        $data['dropdown_user'][0] = '--Khách vãng lai--';
        foreach($users as $user) {
            $data['dropdown_user'][$user['id']] = $user['email'];
        }
        
        if($this->input->post()) {
            $data['post'] = $this->input->post();
            
            $this->form_validation->set_rules('title', 'Tiêu đề tin', 'required');
            
            if($this->form_validation->run()) {
                $this->real_estate_model->_Update($data['post'], $id);
                $this->session->set_flashdata('message', 'Cập nhật thành công!');
                redirect(admin_url($this->uri->segment(2)));
            }
        }
        
        $this->template->_Set_View('real_estate/form', $data);
        $this->template->_Render();
    }
    
    function check_category($str) {
        if(!$this->input->post('category_id')) {
            $this->form_validation->set_message('check_category', 'Bạn chưa chọn danh mục');
            return false;
        } else {
            return true;
        }
    }
    function check_city($str) {
        if($this->input->post('city_id')==0) {
            $this->form_validation->set_message('check_city', 'Bạn chưa chọn tỉnh thành');
            return false;
        } else {
            return true;
        }
    }
    function check_district($str) {
        if($this->input->post('district_id')==0) {
            $this->form_validation->set_message('check_district', 'Bạn chưa chọn quận huyện');
            return false;
        } else {
            return true;
        }
    }
    
    function delete($id) {
        $this->real_estate_model->_Delete($id);
        $this->session->set_flashdata('message', 'Xóa thành công!');
        redirect(admin_url($this->uri->segment(2)));
    }
    
    function _check_image($str) {
        $this->form_validation->set_message('_check_image',$this->error_image);
        return false;
    }
    
    function add_image() {
        $this->load->library('RandomStringGenerator');
        $random = $this->randomstringgenerator->generate(32);
        $data['cache_id'] = $random . time();
        echo $this->load->view(ADMIN_FOLDER .'/'.$this->_controller .'/add_image', $data, TRUE);
    }
    
    function load_image($id) {
        $this->load->library('RandomStringGenerator');
        $data['images'] = $this->real_estate_model->_Get_Images($id);
        echo $this->load->view(ADMIN_FOLDER . '/' . $this->_controller.'/load_image', $data, true);
    }
}