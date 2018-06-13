<?php
require_once APPPATH . '/core/MY_Controller.php';
class Utility extends MY_Controller {
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        
        $this->load->view('default/utility/index');
    }
    
    function loadMap() {
        echo $this->load->view('default/utility/view', array(), true);
    }
}