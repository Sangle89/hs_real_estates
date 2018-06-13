<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . '/core/MY_Controller.php';
class Rss extends MY_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->library('zip');
        $this->load->helper('file');
        $this->load->model('cache/main_model');
    }
    
    function index() {
        
        $data['cur_page'] = 'rss';
        $this->template->_Set_Data('title', 'RSS');
        $this->template->_Set_Data('cur_page', 'rss');
        $this->template->_Set_View('rss/index');
        $this->template->_Render();
    }
    
    function detail() {
        $type = $this->input->get('type');
        $catid = $this->input->get('catid');
        $data = array();
        if($type == 1) {
            $category = $this->main_model->_Get_Real_Estate_Category_By_Id($catid);
            $data['title'] = $category['title'];
            $data['description'] = $category['description'];
            $data['link'] = site_url($category['alias']);
            $data['results'] = $this->main_model->_Get_Real_Estate_By_Category($catid, 50, 0);
        } elseif ($type == 2) {
            
        } elseif($type == 3) {
            $project = $this->main_model->_Get_Project_By_Id($catid);
            $data['title'] = $project['title'];
            $data['description'] = $project['description'];
            $data['link'] = site_url($project['alias']);
        }
        
        $content = $this->load->view('default/rss/detail', $data);
        header("Content-Type: text/xml; charset=utf-8");
        echo $content;
    }
}