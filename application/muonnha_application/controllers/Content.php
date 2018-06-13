<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . '/core/MY_Controller.php';
class Content extends MY_Controller {
    
    function __construct() {
        parent::__construct();
        
        $this->load->model(array(
            'cache/main_model',
            'content_category_model',
            'routes_model'
        ));
        
        $this->load->helper(array('widget'));
        
        $this->load->library(array('pagination','breadcrumb','ion_auth'));
        $this->breadcrumb->__construct(array(
            'tag_open' => '<ul class="breadcrumb">',
            'tag_close' => '</ul>'
        ));
        $this->breadcrumb->append_crumb('Trang ch?', site_url());
        
        $this->data = array();
        
        $web_setting = $this->main_model->_Get_Setting();
        $this->template->_Set_Config($web_setting);
        
    }
    
    /**
    * Danh m?c tin t?c
    */
    function content_category($id, $page=1) {
        $category = $this->main_model->_Get_Content_Category_By_Id($id);
        
        //pagination
        $base_url = site_url($category['alias'].'/p');
        $per_page = 10;
        $total_row = $this->main_model->_Count_Content_By_Category($id);
        $this->data['pagination'] = pagination($base_url, $total_row, $per_page, $page);
        
        $this->data['heading_title'] = $category['title'];
        $this->data['total_result'] = $total_row;
        $this->data['results'] = $this->main_model->_Get_Content_By_Category($id, $per_page, ($page-1)*$per_page);
        $this->data['cur_page'] = $page;
        
        $this->template->_Set_Config($category);
        $this->template->_Set_View('content/list', $this->data);
        $this->template->_Render();
    }
    
    function content($id) {
        
        $this->data['content'] = $this->main_model->_Get_Content_By_Id($id);
        $this->template->_Set_Config($this->data['content']);
        $this->template->_Set_View('content/detail', $this->data);
        $this->template->_Render();
        
    }
    
    function page($id) {
        $this->data['content'] = $this->main_model->_Get_Page_By_Id($id);
        $this->data['cur_page'] = 'page';
        $this->template->_Set_Config($this->data['content']);
        $this->template->_Set_View('page/detail', $this->data);
        $this->template->_Render();
    }
}