<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'core/MY_Admin.php';
class Auto_post extends MY_Admin {
    
    public $_title = 'Auto Post';
    private $_controller = 'auto_post';
    private $_folder_upload = 'images';
    function __construct() {
        parent::__construct();
        $this->load->model('real_estate_model', 'post');
        $this->load->library(array(
            'pagination', 
            'form_validation'
        ));
        $this->breadcrumb->append_crumb('Trang chủ', admin_url());
        $this->breadcrumb->append_crumb($this->_title, admin_url($this->_controller));
        $this->message = array();
    }
    
    function task() {
		$data['task_add'] = base_url('admincp/' . $this->_controller . '/add/');
		$data['task_change'] = base_url('admincp/' . $this->_controller . '/change/' );
		$data['task_delete'] = base_url('admincp/' . $this->_controller . '/delete/' );
		$data['task_list'] = $this->session->userdata("CALLBACK_URL") ? $this->session->userdata("CALLBACK_URL") : base_url('admincp/' . $this->_controller . '/p/');
		$data['task_status'] = base_url('admincp/' . $this->_controller . '/status/' );
        return $data;
	}
    
    function index() {
        require_once APPPATH .'/third_party/simple_html_dom.php';
        require_once "cron/zita.php";
        $link = DOMAIN.'/nha-dat-ban' ;
        print_r(_getTop($link));
        if($this->input->post()) {
            
            $page = $this->input->post('page');
            $link = $this->input->post('link');
            if($page)
                $link .= '/'.$page; 
            $category_id = $this->input->post('category_id');
            
            $results = _getTop($link);
            $count = 0;
            foreach($results as $result) {
                $result['category_id'] = $category_id;
                $this->post->_Add_Auto($result);
                $this->saveImage($result['image']);
                $count++;
            }    
            $data['total'] = $count;
        }
        
        $data['heading_title'] = $this->_title;
		$data['controller'] = $this->_controller;
        $data['task'] = $this->task();
        
        //$this->template->_Set_View($this->_controller . '/list', $data);
        //$this->template->_Render();
    }
    
    function saveImage($link) {
        try {
            $filename = basename($link);
            $this->sangmaster->_Save_Image($link, 'uploads/images/'.$filename);
            $this->sangmaster->_Resize_Img($link, 'uploads/images/thumb/'.$filename, 300,200);
        } catch(Exception $ext) {
            return FALSE;
        }
    }
}