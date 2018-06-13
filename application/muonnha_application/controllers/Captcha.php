<?php
class Captcha extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->helper(array('url', 'antispam'));
        $this->load->library('session');
    }
    
    function captcha_refresh() {
		$array_font = array(
			'captcha0.ttf',
			'captcha1.ttf',
			'captcha2.ttf',
			'captcha3.ttf',
			'captcha4.ttf'
		);
		$rand_font = array_rand($array_font, 1);
        $vals = array(
            'img_path'      => './captcha/',
            'img_url'       => base_url() . '/captcha/',
            'font_path'     => './captcha/font/captcha5.ttf',
            'img_width'     => '100',
            'img_height'    => '30',
            'expiration'    => 3600,
            'word_length'   => 4,
            'font_size'     => 17,
            'img_id'        => 'Imageid',
            'pool'          => '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ',
    
            // White background and border, black text and red grid
            'colors'        => array(
                    'background' => array(235, 235, 235),
                    'border' => array(203, 192, 186),
                    'text' => array(0, 0, 0),
                    'grid' => array(203, 192, 186)
            )
        );
    
        $cap = make_captcha($vals);
        $this->session->set_userdata('captcha_word', $cap['word']);
        echo $cap['image'];
    }
}