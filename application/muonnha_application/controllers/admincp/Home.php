<?php 
require APPPATH . 'core/MY_Admin.php';
class Home extends MY_Admin {
    
    function __construct() {
        parent::__construct();
    }
    
    function index() {
        $data['content'] = 'Home Admin';
        $this->template->_Set_View('home', $data);
        $this->template->_Render();
    }
    
}