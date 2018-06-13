<?php
require_once APPPATH . '/core/MY_Controller.php';
class Map extends MY_Controller {
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        
        $this->load->view('default/map/view');
    }
}