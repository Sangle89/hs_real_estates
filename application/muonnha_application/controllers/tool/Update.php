<?php 
class Update extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function update_real() {
        $results = $this->db->select('title,alias')->from('real_estates')->where('id >= 2591')->result_array();
        foreach($results as $item) {
            $title = $item['title'];
            $alias = $item['alias'];
        }
    }
}