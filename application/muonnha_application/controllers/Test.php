<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . '/core/MY_Controller.php';
class Test extends MY_Controller {
    
    function __construct() {
        parent::__construct();
        
        $this->load->model(array(
            'cache/main_model',
            'cache/image_model',
            'content_category_model',
            'routes_model'
        ));
        
        $this->load->helper(array('widget'));
        
        $this->load->library(array('pagination','breadcrumb','ion_auth'));
        $this->breadcrumb->__construct(array(
            'tag_open' => '<ul class="breadcrumb">',
            'tag_close' => '</ul>'
        ));
        $this->breadcrumb->append_crumb('<i class="fa fa-home"></i>', site_url());
        
        $this->data = array();
        
        $web_setting = $this->main_model->_Get_Setting();
        $this->template->_Set_Config($web_setting);
        
    }
    
    function test_mail() {
        $this->load->library('send_email');
        $this->send_email->_Send('Test', 'Content', 'slevan89@gmail.com', 'ngoinhasach.com@gmail.com');
    }
}