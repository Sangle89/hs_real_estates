<?php
require_once APPPATH . '/core/MY_Controller.php';
class Utility extends MY_Controller {
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        
        $this->load->view('default/utility/view');
    }
    
    function loadMap() {
        $data['address'] = $this->input->post('address');
        echo $this->load->view('default/utility/view', $data, true);
    }
}