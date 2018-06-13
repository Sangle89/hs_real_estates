<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . '/core/MY_Controller.php';
class Ajax extends MY_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model(array(
            'cache/main_model'
        ));
        $this->load->library(array('table', 'form_validation'));
    }
    
    function validate_captcha(){
		$this->load->library('session');
		$str = $this->input->post('captcha');
		if($str!='' && $this->session->userdata('captcha_word') == $str) {
			$res['success'] = true;
        } else {
            $res['success'] = false;
			$res['msg'] = 'Mã captcha không đúng';
        }	
		header("Content-type: application/json");
		echo json_encode($res);
	}
	
    function subscribe_email() {
        $return = array();
        if($this->input->post('email')){
            $this->load->model('newsletter_model');
            $post = $this->input->post();
            $this->newsletter_model->_Add($post);
            $return['success'] = 'Cảm ơn bạn đã đăng ký';
        } else {
            $return['success'] = 'Vui lòng nhập Email';
        }
        header('Content-Type: application/json');
            echo json_encode($return);
    }
    
    function load_category() {
        $parent_id = $this->input->post('parent_id');
        $results = $this->main_model->_Get_Real_Estate_Category($parent_id);
        $html = '';
        foreach($results as $row) {
            $html .= '<option value="'.$row['id'].'">'.$row['title'].'</option>';
        }
        echo $html;
    }
    
    function load_city() {
        $results = $this->main_model->_Get_City();
        $html = '<option value="-1">--Tỉnh/TP--</option>';
        foreach($results as $row) {
            $html .= '<option value="'.$row['id'].'">'.$row['title'].'</option>';
        }
        echo $html;
    }
    
    /**
    * @name Load quận huyện theo tỉnh thành
    * @param city_id
    * @return string
    * @author SangIT - 0906 493 124 - slevan89@gmail.com
    */
    function load_district_by_city() {
        $city_id = (int)$this->input->post('city_id');
        $district = $this->main_model->_Get_District($city_id);
        $res = '<option value="-1" selected="true">--Quận/Huyện--</option>';
        foreach($district as $row) {
            $res .= '<option value="'.$row['id'].'">'.$row['title'].'</option>';
        }
        echo $res;
    }
    
    /**
    * @name Load quận huyện theo tỉnh thành
    * @param city_id
    * @return string
    * @author SangIT - 0906 493 124 - slevan89@gmail.com
    */
    function load_ward_by_district() {
        $city_id = (int)$this->input->post('district_id');
        $district = $this->main_model->_Get_Ward($city_id);
        $res = '<option value="-1" selected="true">--Phường/Xã--</option>';
        foreach($district as $row) {
            $res .= '<option value="'.$row['id'].'">'.trim($row['title']).'</option>';
        }
        echo $res;
    }
    
    /**
    * @name Load quận huyện theo tỉnh thành
    * @param city_id
    * @return string
    * @author SangIT - 0906 493 124 - slevan89@gmail.com
    */
    function load_street_by_ward() {
        $city_id = (int)$this->input->post('district_id');
        $district = $this->main_model->_Get_Street($city_id);
        $res = '<option value="-1" selected="true">--Đường/Phố--</option>';
        foreach($district as $row) {
            $res .= '<option value="'.$row['id'].'">'.$row['title'].'</option>';
        }
        echo $res;
    }
    
    function load_street_by_city() {
        $city_id = (int)$this->input->post('city_id');
        $district = $this->main_model->_Get_Street_By_City($city_id);
        $res = '<option value="-1" selected="true">--Đường/Phố--</option>';
        foreach($district as $row) {
            $res .= '<option value="'.$row['id'].'">'.$row['title'].'</option>';
        }
        echo $res;
    }
    
    function load_street_by_district() {
        $district_id = (int)$this->input->post('district_id');
        $district = $this->main_model->_Get_Street_By_District($district_id);
        $res = '<option value="-1" selected="true">--Đường/Phố--</option>';
        foreach($district as $row) {
            $res .= '<option value="'.$row['id'].'">'.sub_string($row['title'], 100).'</option>';
        }
        echo $res;
    }
    
    function load_project_by_district() {
        $district_id = (int)$this->input->post('district_id');
        $district = $this->main_model->_Get_Project($district_id);
        $res = '<option value="-1" selected="true">--Dự án--</option>';
        foreach($district as $row) {
            $res .= '<option value="'.$row['id'].'">'.sub_string($row['title'], 100).'</option>';
        }
        echo $res;
    }
    
    function load_price() {
        $array = array(
            1 => '< 500 triệu',
            2 => '500 - 800 triệu',
            3 => '800 - 1 tỷ',
            4 => '1 - 2 tỷ',
            5 => '2 - 3 tỷ',
            6 => '3 - 5 tỷ',
            7 => '5 - 7 tỷ',
            8 => '7 - 10 tỷ',
            9 => '10 - 20 tỷ',
            10 => '20 - 30 tỷ',
            11 => '> 30 tỷ',
        );
        $html = '';
        foreach($array as $key => $val) {
            $html .= '<option value="'.$key.'">'.$val.'</option>';
        }
        echo $html;
    }
    
    function load_area() {
        $array = array(
            1 => '<=30m2',
            2 => '30 - 50m2',
            3 => '50 - 80m2',
            4 => '80 - 100m2',
            5 => '100 - 150m2',
            6 => '150 - 200m2',
            7 => '200 - 250m2',
            8 => '250 - 300m2',
            9 => '300 - 500m2',
            10 => '> 500m2',
        );
        $html = '';
        foreach($array as $key => $val) {
            $html .= '<option value="'.$key.'">'.$val.'</option>';
        }
        echo $html;
    }
    
    function load_direction() {
        $array = array(
            1 => 'Không xác định',
            2 => 'Đông',
            3 => 'Tây',
            4 => 'Nam',
            5 => 'Bắc',
            6 => 'Đông bắc',
            7 => 'Tây bắc',
            8 => 'Tây nam',
            9 => 'Đông nam' 
        );
        $html = '';
        foreach($array as $key => $val) {
            $html .= '<option value="'.$key.'">'.$val.'</option>';
        }
        echo $html;
    }
    
    function load_bedroom() {
        $array = array(
            1 => '1 phòng',
            2 => '2 phòng',
            3 => '3 phòng',
            4 => '4 phòng',
            5 => '5 phòng'
        );
        $html = '';
        foreach($array as $key => $val) {
            $html .= '<option value="'.$key.'">'.$val.'</option>';
        }
        echo $html;
    }
    
    function load_project() {
        $results  = $this->main_model->_Get_Project();
        $html = '';
        foreach($results as $row) {
            $html .= '<option value="'.$row['id'].'">'.$row['title'].'</option>';
        }
        echo $html;
    }
    
    //Upload image real estate
    function upload_avatar() {
        $output_dir = "./uploads/";
        if(isset($_FILES["avatar"]))
        {
        	$ret = array();
        	$fileName = '';
        	$error =$_FILES["avatar"]["error"];
            
        	//You need to handle  both cases
        	//If Any browser does not support serializing of multiple files using FormData() 
        	if(!is_array($_FILES["avatar"]["name"])) //single file
        	{
 	              
                $file_upload = _Upload_Avatar('avatar');
                $fileName = $file_upload['file_name'];
            	$ret[]= $fileName;
                
        	}
        	
            echo $fileName;
         }
    }
    
    //Delete image
    function delete_avatar() {
        if($this->input->post('op') == 'delete') {
            $name = $this->input->post('name');
            $name = str_replace('"', '', $name);
            $name = str_replace('[', '', $name);
            $name = str_replace(']', '', $name);
            var_dump(@unlink(FCPATH . '/uploads/avatar/'.$name));
        }
    }
    
    //Upload image real estate
    function upload_photo() {
        $output_dir = "./uploads/";
        if(isset($_FILES["myfile"]))
        {
        	$ret = array();
        	
        	$error =$_FILES["myfile"]["error"];
            
            $width = 900;
            $height = 600;
            $folder = 'images';
        	//You need to handle  both cases
        	//If Any browser does not support serializing of multiple files using FormData() 
        	if(!is_array($_FILES["myfile"]["name"])) //single file
        	{
 	              
                $file_upload = _Upload_Image2($folder, 'myfile', $width, $height);
                $fileName = $file_upload['file_path'];
            	$ret[]= $fileName;
        	}
        	else  //Multiple files, file[]
        	{
        	  $fileCount = count($_FILES["myfile"]["name"]);
        	  for($i=0; $i < $fileCount; $i++)
        	  {
        	  	$file_upload = _Upload_Image2($folder, 'myfile['.$i.']', $width, $height);
                $fileName = $file_upload['file_path'];
            	$ret[]= $fileName;
        	  }
        	
        	}
            echo json_encode($ret);
         }
    }
    
    //Delete image
    function delete_photo() {
        if($this->input->post('op') == 'delete') {
            $name = $this->input->post('name');
            $name = str_replace('"', '', $name);
            $name = str_replace('[', '', $name);
            $name = str_replace(']', '', $name);
            var_dump(@unlink(FCPATH . '/uploads/images/'.$name));
        }
    }
    
    function uploadRealEstate(){
        
        $upload_data = _Upload_Image2('images', 'uploadfile', 900, 600);
        
        if(!$upload_data['error']) {
            $res = array(
                'success' => true,
                'file_name' => $upload_data['file_path'],
                'file_url' => base_url('uploads/images/'.$upload_data['file_path'])
            );
        } else {
            $res = array(
                'success' => false
            );
        }
        echo json_encode($res);
    }
    
    function deleteImage($file_name) {
        @unlink('./uploads/images/'.$file_name);
        @unlink('./uploads/images/thumb/'.$file_name);
    }
    
    function add_image() {
        $this->load->library('RandomStringGenerator');
        $random = $this->randomstringgenerator->generate(32);
        $data['cache_id'] = $random . time();
        echo $this->load->view( 'default/ajax/add_image', $data, TRUE);
    }
    
    function load_image($id) {
        $id = $this->input->get('id');
        $this->load->library('RandomStringGenerator');
        $data['images'] = $this->main_model->_Get_Real_Estate_Images($id);
      
        echo $this->load->view( 'default/ajax/load_image', $data, true);
    }
    
    function loadUtility() {
        $radius = $this->input->post('radius');
        $types = $this->input->post('type');
        $lat = $this->input->post('lat');
        $lng = $this->input->post('lng');
        $data = array();
		require_once APPPATH . '/third_party/GooglePlaces.php';
		require_once APPPATH . '/third_party/GooglePlacesClient.php';
        $google_places = new joshtronic\GooglePlaces('AIzaSyBza93cCe_8NBqVaUyTPGP8gSTuRJXK7Jk');
		foreach($types as $type) {
            $google_places->location = array($lat, $lng);
			$google_places->radius   = $radius;
			$google_places->types    = $type; // Requires keyword, name or types
			$results                 = $google_places->nearbySearch();
            
			foreach($results as $result) {
				print_r($result);
				$google_places->reference = $result['reference'];
				$detail = $google_places->details();
				$data['results'][$type] = $detail['result'];	
			}
        }
        print_r($data);
        $html = $this->load->view('default/ajax/utility',$data, true);
        echo $html;
    }
    
    function contact_agency() {
        if($this->input->post()) {
            $post = $this->input->post();
            
            if($post['captcha'] != $this->session->userdata('captcha_word')){
                $res = array(
                    'success' => false,
                    'msg' => 'Mã captcha không đúng'
                );
            } elseif($post['email']!='') {
                $this->load->library('send_email');
                $this->main_model->_Add_Msg($post);
				if($post['to_email'] && filter_var($post['to_email'], FILTER_VALIDATE_EMAIL)) {
					$body = '<p>Họ tên: '.$post['fullname'].'</p>';
					$body .= '<p>Email: '.$post['email'].'</p>';
					$body .= '<p>Số điện thoại: '.$post['phone'].'</p>';
					$body .= '<p>Nội dung: '.$post['msg'].'</p>';
					$this->send_email->_Send("Liên hệ khách hàng", $body, $post['email'], $post['to_email']);
				}
                $res = array(
                    'success' => true,
                    'msg' => 'Gửi tin nhắn thành công!'  
                );
            } 
            
            echo json_encode($res);
        }
    }
    
    function searchAuto() {
        
        $res= array();
        $query = $this->input->get('term');
        $query = trim($query);
        $this->load->database();
        $search_result = $this->db->select('*')->from('search')->like('search_title', $query)->get()->result_array();
        foreach($search_result as $row) {
            $res[] = array(
                'value' => $row['search_title'],
                'data' => $row['search_alias']
            );
        }
        echo json_encode($res);
        
    }
}