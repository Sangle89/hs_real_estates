<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . '/core/MY_Controller.php';
class Home extends MY_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model(array(
            'slider_model',
            'content_model',
            'content_category_model'
        ));
    }
    
    function index() {
        $data = array();
        
        $this->template->_Set_Title($title);
        $this->template->_Set_Keywords($keyword);
        $this->template->_Set_Description($description);
        $this->template->_Set_View('home/home', $data);
        $this->template->_Render();
    }
    
    function read_file() {
        $this->load->model('street_model');
        $this->load->model('category_model');
        $this->load->model('routes_model');
        $this->load->database();
        $file = 'street.txt';
        $handle = fopen($file, 'r');
        $id = 1;
        $district_id = 22; //quan 1
        
        while($line = fgets($handle)) {
           /* if($line == 1) {
                $this->db->insert('district_streets', array(
                    'district_id' => $district_id,
                    'street_id' => $id,
                ));    
            }
            $id++;*/
        }
        
    }
    
    function update_route() {
        
        $this->load->model('street_model');
        $this->load->model('category_model');
        $this->load->model('routes_model');
        $this->load->database();
        
        $street = $this->street_model->_Get_All();
        $category = $this->category_model->_Get_All();
        $count=1;
        foreach($category as $cat) {
            
            foreach($street as $str) {
                
                $alias = $cat['alias'].'-'.$str['alias'].'-'.$str['city_id'];
                echo $count.' '.$alias.'<br>';
                $count++;
            }
            
        }
        
    }
}