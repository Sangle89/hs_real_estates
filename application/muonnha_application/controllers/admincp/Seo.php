<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'core/MY_Admin.php';
class Seo extends MY_Admin {
    public $title = 'Seo';
    function __construct() {
        parent::__construct();
        $this->load->model('seo_model');
        $this->load->library(array('pagination', 'form_validation'));
		$this->breadcrumb->append_crumb('Trang chủ', admin_url());
    }
    
    function index($page=1) {
		
		if($this->input->post()) {
            foreach($this->input->post('sort_order') as $id => $value) {
                $this->seo_model->_Update_Sort($id, $value);
            }
            $this->session->set_flashdata('message', 'Cập nhật thành công!');
            redirect(current_url());
        }
		
        $data = array();
        
		$base_url = admin_url($this->uri->segment(2) . '/index');
        $total_rows = $this->seo_model->_Count_All();
        $data['category'] = $this->seo_model->_Get_All(12, ($page-1)*PER_PAGE);
        
		$data['total'] = $total_rows;
        $data['total_page'] = ceil($total_rows/PER_PAGE);
		$data['pagination'] = admin_pagination(base_url(ADMIN_FOLDER.'/seo/index'), $total_rows, PER_PAGE, $page);
        $data['title'] = $this->title;
		$this->breadcrumb->append_crumb($this->title, admin_url($this->uri->segment(2)));
        
        $this->template->_Set_View('seo/view_all', $data);
        $this->template->_Render();
    }
    
    function add() {
        $data = array();
        $data['title'] = $this->title;
        if($this->input->post()) {
            $data['post'] = $this->input->post();
            
            $this->form_validation->set_rules('url', 'URL', 'required|is_unique[seo.url]');
            $this->form_validation->set_rules('title', 'Title', 'required|is_unique[seo.title]');
            
            if($this->form_validation->run()) {
                $this->seo_model->_Add($data['post']);
                $this->session->set_flashdata('message', 'Success!');
                redirect(admin_url($this->uri->segment(2)));
            }
        }
        $this->template->_Set_View('seo/form', $data);
        $this->template->_Render();
    }
    
    function change($id) {
        $data = array();
        $data['title'] = $this->title;
        $data['post'] = $this->seo_model->_Get_By_Id($id);
        
        if($this->input->post()) {
            $data['post'] = $this->input->post();
            $this->form_validation->set_rules('url', 'URL', 'required');
            if($this->form_validation->run()) {
                $this->seo_model->_Update($data['post'], $id);
                $this->session->set_flashdata('message', 'Success!');
                redirect(admin_url($this->uri->segment(2)));
            }
        }
        
        $this->template->_Set_View('seo/form', $data);
        $this->template->_Render();
    }
    
    function delete($id) {
        $this->seo_model->_Delete($id);
        redirect(admin_url($this->uri->segment(2)));
    }
}