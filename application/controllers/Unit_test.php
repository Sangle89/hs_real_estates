<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . '/core/MY_Controller.php';
class Unit_test extends MY_Controller {
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
    
    function test_resize() {
        $image = '2018/03/15/mien-trung-gian-cho-nu-di-lam-sinh-vien-nu-hoac-vo-chong-thue-phong-khep-kin-dien-tich-25m2-gia-22-trieu-thang-0.jpg';
        $this->image_model->resize($image,150, 150);
        $this->image_model->resize($image,350, 350);
        $this->image_model->resize($image,550, 550);
        $file = '2018/01/03/3a45ea5b_1514970136.jpg';
        $this->image_model->resize($file, 350, 250, 'contents');
    }
    
    function search() {
        $this->load->database();
        $categories = $this->db->select('*')->from('categories')->get()->result_array();
        $districts = $this->db->select('*')->from('district')->where('city_id', 1)->get()->result_array();
        
        foreach($categories as $cat) {
            $this->db->insert('search', array(
                'search_title' => $cat['title'],
                'search_alias' => $cat['alias'],
                'search_text' => str_replace("-", " ", $cat['alias'])
            ));
            
            $this->db->insert('search', array(
                'search_title' => $cat['title'].' Hồ Chí Minh',
                'search_alias' => $cat['alias'].'-ho-chi-minh',
                'search_text' => str_replace("-", " ", $cat['alias']).' ho chi minh'
            ));
            
            foreach($districts as $district) {
                $this->db->insert('search', array(
                    'search_title' => $cat['title'].' '.$district['title'],
                    'search_alias' => $cat['alias'].'-'.$district['alias'],
                    'search_text' => str_replace("-", " ", $cat['alias']).' '.str_replace("-"," ",$district['alias'])
                ));
            }
        }
    }
}