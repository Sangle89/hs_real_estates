<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'core/MY_Admin.php';
class Common extends MY_Admin {
    
    function __construct() {
        parent::__construct();
        $this->load->library(array('pagination', 'form_validation', 'sangmaster'));
        
    }
    
    function uploadUserAvatar(){
        $upload_data = $this->sangmaster->_Upload_Image('uploadfile', 'avatar');
        
        $this->sangmaster->_Resize_Crop($upload_data['full_path'], $upload_data['file_path'].'thumb/'.$upload_data['file_name'], 300,300);
        
        $res = array(
            'success' => true,
            'file_name' => $upload_data['file_name'],
            'type' => $upload_data['file_ext'],
            'file_url' => base_url('uploads/avatar/thumb/'.$upload_data['file_name'])
        );
        
        echo json_encode($res);
	}
    
    function deleteUserAvatar($file_name) {
        @unlink('./uploads/avatar/'.$file_name);
        @unlink('./uploads/avatar/thumb/'.$file_name);
    }
	
	function uploadRealEstate(){
        
        $folder = 'images';
        
        //Upload image
        $this->load->library('upload');
        
        $filename = random_str(8);
        
        //create path folder 2016/11/07
        $year = date("Y", time());
        $month = date("m", time());
        $date = date("d", time());
       
        if(!is_dir(FCPATH . 'uploads/'.$folder.'/' . $year)) {
            mkdir(FCPATH . 'uploads/'.$folder.'/' . $year, '0755', true);
        }
        if(!is_dir(FCPATH . 'uploads/thumb/'.$folder.'/' . $year)) {
            mkdir(FCPATH . 'uploads/thumb/'.$folder.'/' . $year, '0755', true);
        }
        if(!is_dir(FCPATH . 'uploads/'.$folder.'/' . $year . '/' . $month)) {
            mkdir(FCPATH . 'uploads/'.$folder.'/'.$year.'/'.$month, '0755', true);
        } 
        if(!is_dir(FCPATH . 'uploads/thumb/'.$folder.'/' . $year . '/' . $month)) {
            mkdir(FCPATH . 'uploads/thumb/'.$folder.'/'.$year.'/'.$month, '0755', true);
        } 
        if(!is_dir(FCPATH . 'uploads/'.$folder.'/'.$year.'/'.$month.'/'.$date)) {
            mkdir(FCPATH . 'uploads/'.$folder.'/'.$year.'/'.$month.'/'.$date, '0755', true);
        }
        if(!is_dir(FCPATH . 'uploads/thumb/'.$folder.'/'.$year.'/'.$month.'/'.$date)) {
            mkdir(FCPATH . 'uploads/thumb/'.$folder.'/'.$year.'/'.$month.'/'.$date, '0755', true);
        }
        
        $upload_path = FCPATH . 'uploads/'.$folder.'/' . $year .'/' . $month . '/' . $date . '/';
        
        $image_path = $year .'/' . $month . '/' . $date;
        
        $filename = $filename.'_'.time();
        
		$config = array(
			'upload_path' 		=> 	$upload_path,
			'allowed_types'	 	=> 'jpg|jpeg|png|gif|JPG|JPEG|PNG|GIF',
			'file_name'         => $filename,
			'is_image'			=>	true,
			'max_size'			=> 	80*1024,
			'max_width'  		=> 	1024*100,
			'max_height'  		=> 	1024*100,
			'max_filename'		=>	250,
			'encrypt_name'		=>	false,
			'overwrite'			=> false,
		);
        
        $upload_data = array();
        
		$this->upload->initialize($config);
		
        if(!$this->upload->do_upload('uploadfile')){
		      
        	$upload_data = array(
                'error' => $this->upload->display_errors()
            );
		
        } else {
		
            $file_upload = $this->upload->data();
            
            $this->load->library('image_moo');
            
            //Tạo ảnh thumb 150x150
            $create_thumb = $this->image_moo->load($file_upload['full_path'])
                ->set_background_colour('#ffffff')
                ->resize_crop(150, 150, TRUE)
                ->save(FCPATH . 'uploads/thumb/'.$folder.'/'.$image_path.'/'.$file_upload['file_name'], TRUE);
            
            //Resize ảnh gốc 
            $this->image_moo->load($file_upload['full_path'])
                ->set_background_colour('#ffffff')
                ->resize_crop(786, 484, TRUE)
                ->save($file_upload['full_path'], TRUE);
            
            //Wartermark ảnh gốc
            $this->image_moo->load($file_upload['full_path'])
            ->load_watermark(FCPATH . 'theme/images/watermark.png')
            ->set_watermark_transparency(1)
            ->watermark(3)
            ->save($file_upload['full_path'], TRUE);
            
            $upload_data =array(
                'file_name' => $file_upload['file_name'],
                'file_path' => $image_path . '/' . $file_upload['file_name'],
                'full_path' => $file_upload['full_path'],
                'file_type' => $file_upload['file_type'],
                'file_size' => $file_upload['file_size'],
                'file_ext'  => $file_upload['file_ext']
            );
		  
        }
        
        if(!$upload_data['error']) {
            $res = array(
                'success' => true,
                'file_name' => $upload_data['file_path'],
                'file_url' => base_url('uploads/'.$folder.'/'.$upload_data['file_path'])
            );
        } else {
            $res = array(
                'success' => false,
				'msg' => $upload_data['error']
            );
        }
        
        echo json_encode($res);
	}
    
    function deleteImage($file_name) {
        @unlink('./uploads/images/'.$file_name);
        @unlink('./uploads/thumb/images/'.$file_name);
    }
    
    function uploadContent(){
        
        $folder = 'contents';
        
        //Upload image
        $this->load->library('upload');
        
        $filename = random_str(8);
        
        //create path folder 2016/11/07
        $year = date("Y", time());
        $month = date("m", time());
        $date = date("d", time());
       
        if(!is_dir(FCPATH . 'uploads/'.$folder.'/' . $year)) {
            mkdir(FCPATH . 'uploads/'.$folder.'/' . $year, '0755', true);
        }
        if(!is_dir(FCPATH . 'uploads/thumb/'.$folder.'/' . $year)) {
            mkdir(FCPATH . 'uploads/thumb/'.$folder.'/' . $year, '0755', true);
        }
        if(!is_dir(FCPATH . 'uploads/'.$folder.'/' . $year . '/' . $month)) {
            mkdir(FCPATH . 'uploads/'.$folder.'/'.$year.'/'.$month, '0755', true);
        } 
        if(!is_dir(FCPATH . 'uploads/thumb/'.$folder.'/' . $year . '/' . $month)) {
            mkdir(FCPATH . 'uploads/thumb/'.$folder.'/'.$year.'/'.$month, '0755', true);
        } 
        if(!is_dir(FCPATH . 'uploads/'.$folder.'/'.$year.'/'.$month.'/'.$date)) {
            mkdir(FCPATH . 'uploads/'.$folder.'/'.$year.'/'.$month.'/'.$date, '0755', true);
        }
        if(!is_dir(FCPATH . 'uploads/thumb/'.$folder.'/'.$year.'/'.$month.'/'.$date)) {
            mkdir(FCPATH . 'uploads/thumb/'.$folder.'/'.$year.'/'.$month.'/'.$date, '0755', true);
        }
        
        $upload_path = FCPATH . 'uploads/'.$folder.'/' . $year .'/' . $month . '/' . $date . '/';
        
        $image_path = $year .'/' . $month . '/' . $date;
        
        $filename = $filename.'_'.time();
        
		$config = array(
			'upload_path' 		=> 	$upload_path,
			'allowed_types'	 	=> 'jpg|jpeg|png|gif|JPG|JPEG|PNG|GIF',
			'file_name'         => $filename,
			'is_image'			=>	true,
			'max_size'			=> 	80*1024,
			'max_width'  		=> 	1024*100,
			'max_height'  		=> 	1024*100,
			'max_filename'		=>	250,
			'encrypt_name'		=>	false,
			'overwrite'			=> false,
		);
        
        $upload_data = array();
        
		$this->upload->initialize($config);
		
        if(!$this->upload->do_upload('uploadfile')){
		      
        	$upload_data = array(
                'error' => $this->upload->display_errors()
            );
		
        } else {
		
            $file_upload = $this->upload->data();
            
            $this->load->library('image_moo');
            
            //Tạo ảnh thumb 150x150
            $create_thumb = $this->image_moo->load($file_upload['full_path'])
                ->set_background_colour('#ffffff')
                ->resize_crop(400, 300, TRUE)
                ->save(FCPATH . 'uploads/thumb/'.$folder.'/'.$image_path.'/'.$file_upload['file_name'], TRUE);
            
            //Resize ảnh gốc 
            $this->image_moo->load($file_upload['full_path'])
                ->set_background_colour('#ffffff')
                ->resize_crop(900, 600, TRUE)
                ->save($file_upload['full_path'], TRUE);
            
            //Wartermark ảnh gốc
            $this->image_moo->load($file_upload['full_path'])
            ->load_watermark(FCPATH . 'theme/images/watermark.png')
            ->set_watermark_transparency(1)
            ->watermark(3)
            ->save($file_upload['full_path'], TRUE);
            
            $upload_data =array(
                'file_name' => $file_upload['file_name'],
                'file_path' => $image_path . '/' . $file_upload['file_name'],
                'full_path' => $file_upload['full_path'],
                'file_type' => $file_upload['file_type'],
                'file_size' => $file_upload['file_size'],
                'file_ext'  => $file_upload['file_ext']
            );
        }
        
        if(!$upload_data['error']) {
            $res = array(
                'success' => true,
                'file_name' => $upload_data['file_path'],
                'file_url' => base_url('uploads/thumb/'.$folder.'/'.$upload_data['file_path'])
            );
        } else {
            $res = array(
                'success' => false,
				'msg' => $upload_data['error']
            );
        }
        echo json_encode($res);
	}
    
    function deleteContent($file_name) {
        @unlink('./uploads/contents/'.$file_name);
        @unlink('./uploads/thumb/contents/'.$file_name);
    }
	
	function uploadBannerAdv(){
        
        $upload_data = _Upload_Image2('banners', 'uploadfile', '', '', false);
        //print_r($upload_data);
        if($upload_data) {
            $res = array(
                'success' => true,
                'file_name' => $upload_data['file_path'],
                'file_url' => base_url('uploads/banners/'.$upload_data['file_path'])
            );
        } else {
            $res = array(
                'success' => false
            );
        }
        echo json_encode($res);
	}
    
    function deleteBannerAdv($file_name) {
        @unlink('./uploads/images/'.$file_name);
        @unlink('./uploads/images/thumb/'.$file_name);
    }
}