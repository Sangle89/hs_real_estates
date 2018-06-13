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
        
        $upload_data = _Upload_Image2('images', 'uploadfile', 900, 600);
        //print_r($upload_data);
        if(!$upload_data['error']) {
            $res = array(
                'success' => true,
                'file_name' => $upload_data['file_path'],
                'file_url' => base_url('uploads/images/'.$upload_data['file_path'])
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
        @unlink('./uploads/images/thumb/'.$file_name);
    }
    
    function uploadContent(){
        
        $upload_data = _Upload_Image2('contents', 'uploadfile', 400, 300, false, false);
        
        if(!$upload_data['error']) {
            
            $this->load->library('image_moo');
            $result = $this->image_moo->load($upload_data['full_path'])
            ->resize_crop(630, 400, TRUE)
            ->save($upload_data['full_path'], TRUE);
            $res = array(
                'success' => true,
                'file_name' => $upload_data['file_path'],
                'file_url' => base_url('uploads/contents/'.$upload_data['file_path'])
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