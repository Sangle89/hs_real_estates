<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'core/MY_Admin.php';
class Bannharieng extends MY_Admin {
    
    public $_title = 'Auto Post';
    private $_controller = 'bannharieng';
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
    
    function index() {
        require_once APPPATH .'/third_party/simple_html_dom.php';
        require_once "cron/bannharieng.com.php";
       
        if($this->input->get('url')!='') {
            $link = DOMAIN.$this->input->get('url');
        } else {
            $link = DOMAIN.'ban-nha-rieng/14/' ;
        }
        
        if($this->input->get('page')) {
            $page = (int)$this->input->get('page');
        } else {
            $page = 1;
        }
        $link .= '/page-'.$page.'/';
        
        $results = _getTop($link);
        
        $data['heading_title'] = $this->_title;
		$data['controller'] = $this->_controller;
        $data['results'] = $results;
        $this->template->_Set_View('stream/'.$this->_controller . '/list', $data);
        $this->template->_Render();
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