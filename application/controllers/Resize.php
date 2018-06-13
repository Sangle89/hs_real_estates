<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . '/core/MY_Controller.php';
class Resize extends MY_Controller {
    
    function __construct() {
        parent::__construct();
        
        $this->load->library(array('image_moo'));
    }
    
	function real_estate() {
		$filename = $this->input->get('image');
        $width = $this->input->get('w') ? $this->input->get('w') : 150;
        $height = $this->input->get('h') ? $this->input->get('h') : 100;
		$this->image_moo->load('./uploads/images/'.$filename)
		->resize_crop($width,$height)
		->save_dynamic();
		
	}
}