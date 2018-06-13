<?php
defined('BASEPATH') OR exit('No direct script access allowed');
function _Is_Home() {
    $CI =& get_instance();
    $class = $CI->router->class;
    $method = $CI->router->method;
    
    return $method=='home';
}

function _Current_Date() {
    return date('Y-m-d H:i:s', time());
}

function _The_Thumb($file_name, $alt='', $width='200') {
    echo '<img src="'.THUMB_URL.$file_name.'" alt="'.$alt.'" width="'.$width.'">';
}

function _The_Image($file_name, $alt='') {
    echo '<img src="'.IMAGE_URL.$file_name.'" alt="'.$alt.'">';
}

function pagination($base_url, $total_row, $per_page, $current) {
    $CI=&get_instance();
    $config = array(
        'base_url' => $base_url,
        'total_rows' => $total_row,
        'per_page' => $per_page,
        'cur_page' => $current,
        'full_tag_open' => '<ul>',
        'full_tag_close' => '</ul>',
        'cur_tag_open' => '<li class="active"><a>',
        'cur_tag_close' => '</a></li>',
        'first_tag_open' => '<li>',
        'first_tag_close' => '</li>',
        'first_link' => 'Trang đầu',
        'last_tag_open' => '<li>',
        'last_tag_close' => '</li>',
        'last_link' => 'Trang cuối',
        'next_tag_open' => '<li>',
        'next_tag_close' => '</li>',
        'next_link' => 'Trang sau',
        'prev_tag_open' => '<li>',
        'prev_tag_close' => '</li>',
        'prev_link' => 'Trang trước',
        'num_tag_open' => '<li>',
        'num_tag_close' => '</li>',
        'first_url' => site_url($CI->uri->segment(1)),
        'use_page_numbers' => true,
        //'reuse_query_string' => true
    );
    $CI->pagination->initialize($config);
    return $CI->pagination->create_links();
}

function mpagination($base_url, $total_row, $per_page, $current) {
    $total_page = ceil($total_row / $per_page);
    
    $page = '<div class="pager pager_controls">';
    
    if($current > 1) {
        $prev_link = $base_url . '/' . ($current-1);
        $first_link = $base_url;
        $page .= "<a href='".$first_link."' title=''><div class='style-pager-button-next-first-last' align='center'>Đầu</div></a>";
        $page .= "<a href='".$prev_link."' title=''><div class='style-pager-button-next-first-last' align='center'><<</div></a>";
    }
    
    $page .= "<a href='' title=''><div class='style-pager-row-selected' align='center'>".$current."</div></a>";
    
    if($current < $total_page) {
        $next_link = $base_url . '/' . ($current+1);
        $last_link = $base_url . '/' . $total_page;
        $page .= "<a href='".$next_link."' title=''><div class='style-pager-button-next-first-last' align='center'>>></div></a>";
        $page .= "<a href='".$last_link."' title=''><div class='style-pager-button-next-first-last' align='center'>Cuối</div></a>";
    }
    
    $page.='</div>';
    return $page;
}

function _Price_Label($price_unit_id) {
    $unit = array(
        -1 => 'Thỏa thuận',
        1 => 'Triệu/tháng',
        2 => 'Nghìn/tháng',
        3 => 'Nghìn/m2/tháng',
        5 => 'USD',
        6 => 'USD/m2',
        7 => 'Trăm nghìn/m2',
        8 => 'Triệu/m2',
        9 => 'Chỉ vàng/m2',
        10 => 'Cây vàng/m2' 
    );
    return $unit[$price_unit_id];
}
function _Direction_Label($direction_id) {
    $direction = array(
        1 => 'Không xác định',
        2 => 'Đông',
        3 => 'Tây',
        4 => 'Nam',
        5 => 'Bắc',
        6 => 'Đông-Bắc',
        7 => 'Tây-Bắc',
        8 => 'Tây-Nam',
        9 => 'Đông-Nam' 
    );
    return $direction[$direction_id];
}

/**
* Ham dinh dang lai so
* 1,000,000 -> 1000000
*/
function _Price_To_Int($str) {
    return intval(str_replace(",","",$str));
}

function _Format_Date($datetime) {
    $date = date_create($datetime);
    return date_format($date, 'd/m/Y');
}

function _Format_Price($number) {
    return number_format($number,0,",",".");
}

function get_day($datetime) {
    $date_obj = new DateTime($datetime);
    return date_format($date_obj, 'd');
}

function get_month($datetime) {
    $date_obj = new DateTime($datetime);
    return date_format($date_obj, 'm');
}

function get_year($datetime) {
    $date_obj = new DateTime($datetime);
    return date_format($date_obj, 'Y');
}

//Convert date d/m/yyyy -> Y-m-d H:i:s
function _convert_date($string_date) {
    $array = explode("/", $string_date);
    $new_date = $array[2].'-'.$array[1].'-'.$array[0].' '.date("H:i:s", time());
    return $new_date;
}
//Convert date d/m/yyyy -> Y-m-d
function _convert_date1($string_date) {
    $array = explode("/", $string_date);
    $new_date = $array[2].'-'.$array[1].'-'.$array[0];
    return $new_date;
}
function _convert_date2($string_date) {
    $array = explode(" ", $string_date);
    
    $temp = explode("-", $array[0]);
    
    $new_date = $temp[2].'/'.$temp[1].'/'.$temp[0];
    return $new_date;
}

function _short_date($string_date) {
    $array = explode(" ", $string_date);
    
    $temp = explode("-", $array[0]);
    
    $new_date = $temp[2].'/'.$temp[1];
    return $new_date;
}

//Kiem tra Email
function valid_email($str) {
    return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
}
//Kiem tra so
function valid_number($str) {
    return is_numeric($str);
}

//Tạo chuổi ngẩu nhiên
function random_str($length)
{
    return substr(sha1(rand()), 0, $length);
}

//chuan hoa tieu de
function format_title($string) {
    return ucfirst(mb_strtolower($string, "UTF-8"));
}

// Chuyen doi tieu de thanh chuoi URL
function to_slug($str) {
    $str = trim(mb_strtolower($str));
    $str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
    $str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
    $str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
    $str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
    $str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
    $str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
    $str = preg_replace('/(đ)/', 'd', $str);
    $str = preg_replace('/[^a-z0-9-\s]/', '', $str);
    $str = preg_replace('/([\s]+)/', '-', $str);
    $str = preg_replace("/[\/_|+ -]+/", '-', $str);
    return $str;
}

//Cat chuoi theo từ
function get_excerpt($text, $words_to_return = 20)
{
    $text = strip_tags(html_entity_decode($text, ENT_QUOTES, 'UTF-8'));
    $words_in_text = str_word_count($text,1);
    $array_word = explode(" ", trim($text));
    $array_word = array_splice($array_word, 0, $words_to_return);
    return implode(" ",$array_word) . '...';
}

//Cat chuoi
function sub_string($str, $length = 50) {
    $count = strlen(to_slug($str));
    $string = utf8_substr(strip_tags(html_entity_decode($str, ENT_QUOTES, 'UTF-8')), 0, $length); 
    if($length < $count)
        $string .= '...';
    return $string;
}

function send_mail($body, $email, $name, $subject, $cc='') {
    $CI=&get_instance();
    
        $smtp_user = $CI->setting_model->_Get_Setting('smtp_email');
        $smtp_pass = $CI->setting_model->_Get_Setting('smtp_password');
        $email_nhantin = explode(';',$CI->setting_model->_Get_Setting('emails'));
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => $smtp_user,
            'smtp_pass' => $smtp_pass,
            'mailtype' => 'html'
        );
        $email_nhantin[] = $email;
        $CI->load->library('email', $config);
        $CI->email->set_newline("\r\n");
        $CI->email->from($smtp_user, $name);
        //$CI->email->to($email);
        if(!empty($email_nhantin))
            $CI->email->to($email_nhantin);
        
        $CI->email->subject($subject);
        $CI->email->message($body);
        return $CI->email->send();
}

function _Get_Youtube_Id($url) {
    parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
    return $my_array_of_vars['v'];    
}

function _Upload_Avatar($name) {
    get_instance()->load->library('upload');
		$config = array(
			'upload_path' 		=> 	'./uploads/avatar/',
			'allowed_types'	 	=> 	'jpg|png|JPG|PNG',
			'is_image'			=>	true,
			'max_size'			=> 	80*1024,
			'max_width'  		=> 	1024*100,
			'max_height'  		=> 	1024*100,
			'max_filename'		=>	250,
			'encrypt_name'		=>	true,
			'overwrite'			=> false,
		);
		get_instance()->upload->initialize($config);
		if(!get_instance()->upload->do_upload($name)){
			return get_instance()->upload->display_errors();
		}
		return get_instance()->upload->data();
}

function _Upload_Catalogue($name, $path) {
        get_instance()->load->library('upload');
		$config = array(
			'upload_path' 		=> 	$path,
			'allowed_types'	 	=> 	'doc|docx|pdf',
			'is_image'			=>	true,
			'max_size'			=> 	80*1024,
			'max_width'  		=> 	1024*100,
			'max_height'  		=> 	1024*100,
			'max_filename'		=>	250,
			'encrypt_name'		=>	true,
			'overwrite'			=> false,
		);
		get_instance()->upload->initialize($config);
		if(!get_instance()->upload->do_upload($name)){
			return get_instance()->upload->display_errors();
		}
		return get_instance()->upload->data();
}

use Imagecraft\ImageBuilder;
function _Resize_Img($source, $target, $nwidth, $nheight){
	get_instance()->load->library('my_img');
		return get_instance()->my_img->Do_Resize_White($nwidth, $nheight, $target, $source);
		list($width,$height)=getimagesize($source);
		$newwidth=$nwidth;
		if($nheight==0 && $nwidth!=0){
		  	$ratio = $nwidth / $width;
      		$newheight = $height * $ratio;
			$newwidth=$nwidth;
		}elseif($nwidth==0 && $nheight!=0){
			$ratio = $nheight / $height;
		  	$newwidth = $width * $ratio;
			$newheight=$nheight;
		}elseif($nheight==0 && $nwidth==0){
			$newheight=$height;
			$newwidth=$width;
		}else{
			$newheight=$nheight;
			$newwidth=$nwidth;
		}
		require_once(APPPATH.'third_party/imagecraft/autoload.php');
		$options =array('engine' => 'php_gd', 'locale' => 'en');
		$builder = new ImageBuilder($options);
		$image = $builder
			->addBackgroundLayer()
				->filename($source)
				->resize($newwidth, $newheight, 'fill_crop')
				->done()
				->save();
		if ($image->isValid()) {
			file_put_contents($target, $image->getContents());
			return true;
		} else {
			return $image->getMessage();
		}
		/*require_once(BASEPATH.'plugin/Zebra_Image.php');
		$image = new Zebra_Image();
		$image->source_path = $source;
		$image->target_path = $target;
		if (!$image->resize($width, $height, ZEBRA_IMAGE_BOXED, -1)){
			return _show_img_error($image->error, $image->source_path, $image->target_path);
		}
		return true;*/
}
function _Resize_Crop($file_path, $file_name, $folder = 'images', $width=155, $height=130) {
    $CI =& get_instance();
    $CI->load->library('image_moo');
    $return = $CI->image_moo->load($file_path)
            //->set_background_colour('#ffffff')
            ->resize_crop($width, $height, TRUE)
            ->save(FCPATH . 'uploads/thumb/'.$folder.'/'.$file_name, TRUE);
    return $return;
}
function _Upload_Image2($folder, $name, $width=900, $height=600, $resize = true) {
    
    $CI =& get_instance();
    
    //Upload image
    $CI->load->library('upload');
    
    $filename = random_str(8);
    
    //create path folder 2016/11/07
    $year = date("Y", time());
    $month = date("m", time());
    $date = date("d", time());
   
    if(!is_dir(FCPATH . 'uploads/'.$folder.'/' . $year)) {
        mkdir(FCPATH . 'uploads/'.$folder.'/' . $year, '0755', true);
    }
    if(!is_dir(FCPATH . 'uploads/'.$folder.'/' . $year . '/' . $month)) {
        mkdir(FCPATH . 'uploads/'.$folder.'/'.$year.'/'.$month, '0755', true);
    } 
    if(!is_dir(FCPATH . 'uploads/'.$folder.'/'.$year.'/'.$month.'/'.$date)) {
        mkdir(FCPATH . 'uploads/'.$folder.'/'.$year.'/'.$month.'/'.$date, '0755', true);
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
        
		$CI->upload->initialize($config);
		
        if(!$CI->upload->do_upload($name)){
		      
        	return array(
                'error' => $CI->upload->display_errors()
            );
		
        } else {
		
            $file_upload = $CI->upload->data();
            
            if($resize){
                $image_size = getimagesize($file_upload['full_path']);
                $image_width = $image_size[0];
                $image_height = $image_size[1];
                
                if($image_width > $image_height) {
                    $resize_width = 624;
                    $resize_height = (624 * $image_height) / $image_width;
                } else {
                    $resize_width = (476 * $image_width) / $image_height;
                    $resize_height = 476;
                }
                
                
            }
                
                
                //_Resize_Img($file_upload['full_path'], $file_upload['full_path'], 900, 600);
            
            
            $CI->load->library('image_moo');
            $return = $CI->image_moo->load($file_upload['full_path'])
            ->set_background_colour('#ffffff')
            ->resize($resize_width, $resize_height, TRUE)
            ->save($file_upload['full_path'], TRUE);
            
            //Wartermark
            $CI->image_moo->load($file_upload['full_path'])
            ->load_watermark(FCPATH . 'theme/images/watermark.png')
            ->set_watermark_transparency(1)
            ->watermark(3)
            ->save($file_upload['full_path'], TRUE);
            
            $source =array(
                'file_name' => $file_upload['file_name'],
                'file_path' => $image_path . '/' . $file_upload['file_name'],
                'full_path' => $file_upload['full_path'],
                'file_type' => $file_upload['file_type'],
                'file_size' => $file_upload['file_size'],
                'file_ext'  => $file_upload['file_ext']
            );
		  
            return $source;
        }
}
	
function _show_img_error($error_code, $source_path, $target_path){
    switch ($error_code) {
            case 1:
                return 'Source file "' . $source_path . '" could not be found!';
                break;
            case 2:
                return 'Source file "' . $source_path . '" is not readable!';
                break;
            case 3:
                return 'Could not write target file "' . $source_path . '"!';
                break;
            case 4:
                return $source_path . '" is an unsupported source file format!';
                break;
            case 5:
                return $target_path . '" is an unsupported target file format!';
                break;
            case 6:
                return 'GD library version does not support target file format!';
                break;
            case 7:
                return 'GD library is not installed!';
                break;
            case 8:
                return '"chmod" command is disabled via configuration!';
                break;
    }
}

/*Admin*/
function CKEditorReplace($object_name){
	require_once('public/ckeditor/ckeditor.php');
	require_once('public/ckfinder/ckfinder.php');
	$CKE=new CKEditor(base_url('public/ckeditor/').'/');
	$CKF=new CKFinder(base_url('public/ckfinder/').'/');
	$CKF->SetupCKEditorObject($CKE);
    $config=array(
        'height' => 500
    );
	$CKE->Replace($object_name, $config);
}

function CKEBasic($object_name){
	require_once('public/ckeditor/ckeditor.php');
	require_once('public/ckfinder/ckfinder.php');
	$CKE=new CKEditor(base_url('public/ckeditor/').'/');
	$CKF=new CKFinder(base_url('public/ckfinder/').'/');
	$CKF->SetupCKEditorObject($CKE);
    $config=array(
        'height' => 400,
        'toolbar' => false
    );
	$CKE->Replace($object_name, $config);
}

function admin_url($url="") {
    return base_url(ADMIN_FOLDER . '/' . $url);
}

function _Space($num, $string) {
    $space = '';
    for($i=1; $i<=intval($num); $i++) {
        $space .= '---';
    }
    if($num==0) $string = '<strong>'.$string.'</strong>';
    return $space.$string;
}

function _Button_Add($url) {
    return '<a class="btn btn-primary" href="'.$url.'">Thêm <i class="fa fa-plus"></i></a>';
}

function _Button_Delete($url) {
    return '<a class="" href="'.$url.'" onclick="return confirmDelete();"><i class="fa fa-trash"></i></a>';
	//return '<a class="btn btn-danger" rel="tooltip" data-placement="bottom" data-original-title="<i class=\'text-warning fa fa-warning\'></i> '.lang('text_delete_tooltip').'" data-html="true" data-reset-msg="'.lang('text_confirm_delete').'" href="javascript:;" onClick="confirmDelete(\'Are you sure ?\', \''.$url.'\')"><i class="fa fa-trash-o"></i></a>';
}
function _Button_Status($url, $id, $status) {
    $class = $status==1 ? 'active.png' : 'hide.png';
    $status = $status==1?0:1;
    return '<a href="'.$url . '/' . $id .'/'.$status .'"><img src="'.base_url('assets/images/'.$class).'"></a>';
}
function _Button_Change($url) {
    return '<a class="" href="'.$url.'"><i class="fa fa-pencil"></i></a>';
}
function _Button_View($url) {
    return '<a class="btn btn-primary" href="'.$url.'"><i class="fa fa-eye"></i></a>';
}
function _Button_Link($url, $title, $class = "primary", $icon = "") {
    $string = '<a class="btn btn-'.$class.'" href="'.$url.'"><i class="fa fa-'.$icon.'"></i>'.$title.'</a>';
    return $string;
}
function _Button_Window($url, $title, $icon='fa') {
    return "<a class=\"btn btn-primary\" href=\"javascript:;\" onclick=\"openWindowPopup('".$url."')\"><i class='fa fa-".$icon."'></i>&nbsp;".$title."</a>";
}
function _Button_Upload($name, $val = '') {
    return '<div class="imgupload"><button type="button" class="btn btn-default btn-file">
                                    <span>Browse</span>
                                    <input type="file" name="'.$name.'">
                                </button>
                                <button type="button" class="btn btn-default">Remove</button></div>';
}

function _Show_Thumb($folder, $image, $width = 60) {
    return '<img src="'.base_url().'uploads/'.$folder.'/'.$image.'" alt="" width="'.$width.'">';
}
function _Show_Status($table, $id, $field, $value) {
    $label = ($value=='active') ? '<i class="fa fa-check-square" aria-hidden="true"></i>' : '<i class="fa fa-ban" aria-hidden="true"></i>';
    return '<a class="changeStatus" id="'.$field.$id.'" data-status="'.$value.'" onClick="changeStatus(\''.$table.'\',\''.$id.'\',\''.$field.'\');">'.$label.'</a>';
}
function _Button_Back($url) {
    return '<a class="btn btn-primary" href="'.$url.'" onClick="window.history.back();"><i class="fa fa-back"></i>&nbsp;Quay lại</a>';
}

function _Show_Message($type = 'success', $message='') {
    if($message)
        return '<div class="alert alert-'.$type.'">'.$message.'</div>';
    return '';
}

function widget_open($title, $table_form=false, $padding=false) {
    if($table_form) 
        get_instance()->table->set_template(array(
            'table_open'		=>	'<table class="table table-bordered table-hover table-striped table-form">'
        ));
    else
        get_instance()->table->set_template(array(
            'table_open'		=>	'<table class="table table-bordered table-hover table-striped table-form">'
        ));
    return '<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-12" data-widget-editbutton="false">
				
				<header role="heading">
                <span class="widget-icon"> <i class="fa fa-shopping-cart txt-color-white"></i> </span>
                <h2>'.$title.'</h2>
                <div class="widget-toolbar"></div>
                </header>

				<!-- widget div-->
				<div role="content">

					<!-- widget content -->
					<div class="widget-body">
						
						<div class="table-responsive">';
}
function widget_submit($buttons = array()) {
	$return = '<footer>';
	foreach($buttons as $button) $return .= $button;
	$return .= '</footer>';
    
	return $return;
}
function widget_button($string) {
    return '<footer>' . $string . '</footer>';
}
function widget_close() {
    return '</div></div></div></div>';
}

function widget_tab($data = array()) {
    
    $string = '<ul id="myTab'.$data['tab_id'].'" class="nav nav-tabs bordered" style="margin-bottom:10px;">';
    foreach($data['tab_content'] as $num=>$tab) {
        $cl = ($num==0) ? 'active' : '';
        $string .= '<li class="'.$cl.'"><a href="#tab'.$num.'" data-toggle="tab">'.$tab['title'].'</a></li>';
    }
    $string .= '</ul>';
    $string .= '<div id="myTabContent'.$data['tab_id'].'" class="tab-content">';
    foreach($data['tab_content'] as $num=>$tab) {
        $cl = ($num==0) ? 'active' : '';
        $string .= '<div class="tab-pane fade '.$cl.' in" id="tab'.$num.'">'.$tab['content'] .'</div>';
    }
    $string .= '</div>';
    return $string;
}

function _Set_Value($name, $value="") {
    return set_value($name, $value, FALSE);
}

/*Bootstrap control input*/
function _Input($name, $value="", $class="form-control", $param='') {
    return form_input($name, set_value($name, $value, FALSE), 'class="'.$class.'" ' . $param);
}

function _Input_Price($name, $value="", $class="form-control price") {
    return form_input($name, set_value($name, $value, FALSE), 'class="'.$class.'"');
}

function _Input_Date($name, $value="", $class="form-control datepicker") {
    return form_input($name, set_value($name, $value, FALSE), 'class="'.$class.'" style="display:inline-block;width:150px;"');
}

function _Password($name, $value="", $class="form-control") {
    return form_password($name, set_value($name, $value, FALSE), 'class="'.$class.'"');
}

function _Textarea($name, $value="", $class="form-control") {
    return form_textarea($name, set_value($name, $value, FALSE), 'class="'.$class.'"');
}

function _TextEditor($name, $value="", $class="form-control") {
    return form_textarea($name, set_value($name, $value, FALSE), 'class="'.$class.'"');
}

function _Dropdown($name, $options=array(), $selected = array(), $class="form-control select2") {
    return form_dropdown($name, $options, $selected, 'class="'.$class.'"');
}

function _Checkbox($name, $value="", $checked=FALSE, $class="select2") {
    return form_checkbox($name, $value, $checked, 'class="'.$class.'"');
}
/**
* value = array(
*   array(
*       'title' => 'Có',
*       'value' => 1
*   ),
*   array(
*       'title' => 'Không',
*       'value' => 0
*   ),
* );
* checked = array(1)
*/
function _Radio($name, $value=array(), $checked=array(), $class="") {
    $html = '';
    if($value) {
       foreach($value as $val) {
            $html .= '<label>';
                $html.=$val['title'];
                if(in_array($val['value'], $checked)) $selected = "checked='true'";
                else $selected = "";
                $html.='&nbsp;<input name="'.$name.'" type="radio" value="' .$val['value'].'" '.$selected.'>';
            
            $html .= '</label>&nbsp;';
       } 
    }
    return $html;
}

function _Multiselect($name, $options, $selected = array(), $class="form-control select2") {
    return form_multiselect($name, $options, $selected, 'class="'.$class.'" multiple');
}

function _Input_Hidden($name, $value="", $class="form-control") {
    return form_hidden($name, set_value($name, $value, FALSE), 'class="'.$class.'"');
}

function _Status($name, $status='active', $class="form-control") {
    if($status == 'active') {
        return '<label class="">Hiện '.form_radio($name, 'active', TRUE).'<i></i></label>&nbsp;&nbsp;' . 
        ' <label class="">Ẩn '.form_radio($name, 'hide').'<i></i></label>';
    } else {
        return '<label class="">Hiện '.form_radio($name, 'active').'<i></i></label>&nbsp;&nbsp;' . 
        ' <label class="">Ẩn '.form_radio($name, 'hide', TRUE).'<i></i></label>';
    }
}

function _Label($text, $id, $attr = array('class="label"')) {
    return form_label($text, $id, $attr);
}

function _Submit($name, $value, $icon='refresh', $class="btn btn-primary") {
    return '<button type="submit" class="'.$class.'" name="'.$name.'">'.$value.'&nbsp;<i class="fa fa-'.$icon.'"></i></button>';
}

function _Button($name, $value, $class="btn btn-default") {
    return form_button($name, $value, 'class="'.$class.'"');
}

function _Reset($name, $value, $class="btn btn-default") {
    return form_reset($name, $value, 'class="'.$class.'"');
}

function _Button_Image($name, $val = '') {
    $image = '';
    
    if($val && file_exists('./uploads/images/'.$val)) {
        $image.='<div class="thumb"><img src="'.base_url().'uploads/images/'.$val.'" width="150"><span class="remove-thumb" onClick="removeThumb();"><i class="fa fa-trash-o"></i></span>'.
        form_hidden($name, $val) . '</div>';
	}
    
    $image .= '<input type="file" class="btn btn-default" name="'.$name.'">';
    return $image;
}

function _Button_Images($name, $multi = '',$images=array()) {
    $string = '<span class="btn btn-success fileinput-button"><i class="fa fa-plus"></i>&nbsp;<span>Chọn hình</span><input id="'.$name.'upload" type="file" name="'.$name.'" '.$multi.'></span> <br><div id="progress" class="progress" style="display:none;"><div class="progress-bar progress-bar-success"></div></div><div id="'.$name.'list" class="files">';
    
    if($images) {
        foreach($images as $image) {
            $string .= '<div class="thumb">
            <a target="_blank" href="'.base_url('uploads/images/' . $image['image']).'">
                <p><img width="100" height="100" src="'.base_url() . 'uploads/images/' . $image['image'] .'"></p>
                <input type="hidden" name="images[]" value="'.$image['image'].'">
                <button class="btn btn-danger btn-trash" data-type="DELETE" data-url="'.site_url('admin/upload/deleteImage/' . $image['image']).'"><i class="fa fa-trash-o"></i></button>
            </a></div>';
        }
    }
    $string .= '</div>';
    return $string;
}

function _Button_Catalogue($name, $filename='') {
    $image = '';
    if($filename && file_exists('./public/uploads/files/'.$filename)) {
        $image.='<div class="thumb"><a href="'.base_url().'public/uploads/images/thumbs/'.$filename.'">'.$filename.'</a><span class="remove-thumb" onClick="removeThumb();"><i class="fa fa-trash-o"></i></span>'.
        form_hidden($name, $filename) . '</div>';
	}
    
    $image .= '<input type="file" class="btn btn-default" name="'.$name.'">';
    return $image;
}

function admin_pagination($base_url, $total_row, $per_page, $current) {
    $CI=&get_instance();
    $config = array(
        'base_url' => $base_url,
        'total_rows' => $total_row,
        'per_page' => $per_page,
        'cur_page' => $current,
        'full_tag_open' => '<ul class="pagination">',
        'full_tag_close' => '</ul>',
        'cur_tag_open' => '<li class="active"><span>',
        'cur_tag_close' => '</span></li>',
        'first_tag_open' => '<li>',
        'first_tag_close' => '</li>',
        'last_tag_open' => '<li>',
        'last_tag_close' => '</li>',
        'next_tag_open' => '<li>',
        'next_tag_close' => '</li>',
        'prev_tag_open' => '<li>',
        'prev_tag_close' => '</li>',
        'num_tag_open' => '<li>',
        'num_tag_close' => '</li>',
        'first_url' => admin_url($CI->uri->segment(2)),
        'use_page_numbers' => true,
        'reuse_query_string' => true
    );
    $CI->pagination->initialize($config);
    return $CI->pagination->create_links();
}
?>