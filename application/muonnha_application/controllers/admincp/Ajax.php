<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'core/MY_Admin.php';
class Ajax extends MY_Admin {
    
    function __construct() {
        parent::__construct();
        $this->load->library(array('pagination', 'form_validation'));
        $this->load->model(array(
            'content_model',
            'city_model',
            'district_model',
            'ward_model',
            'street_model',
            'category_model',
            'routes_model'
        ));
        $this->load->helper('utf8');
    }
    
    function save_post() {
        require_once APPPATH .'/third_party/simple_html_dom.php';
        require_once "cron/bannharieng.com.php";
        
        $href = $this->input->post('href');
        $image = $this->input->post('img');
        $detail = _detail($href, $image);
        
        $image = $this->saveImage($image);
        
        //kiem tra
        $check = $this->db->select('id')->from('temps')->where('alias', trim(to_slug($detail['title'])))->get()->num_rows();
        
        if($check==0){
            
            if($detail['district']!='') {
                $district = $this->db->where('alias', to_slug($detail['district']))->get('district')->row();
                if(!empty($district)) {
                    $district_id = $district->id;
                } else {
                    $district_id = '';
                }
            } else {
                $district_id = '';
            }
            
            $this->db->insert('temps', array(
               'title' => trim($detail['title']),
               'alias' => to_slug($detail['title']),
               'image' => $image,
               'content' => htmlpurifier(utf8_substr(strip_tags(html_entity_decode($detail['content'], ENT_QUOTES, 'UTF-8')), 0,3000)),
               'source' => 'bannharieng.com',
               'price_number' => $detail['price_number'],
               'create_time' => date("Y-m-d H:i:s", time()),
               'sophong' => (int)$detail['sophong'],
               'area' => (int)$detail['area'],
               'price_number' => (int)$detail['price_number'],
               'city_id' => $detail['city'] == 'Hà Nội' ? 2 : 1,
               'district_id' => $district_id,
               'guest_name' => $detail['guest_name'],
               'guest_phone' => (int)$detail['guest_phone'],
               
            ));
        
            $insert_id = $this->db->insert_id();
            
            $res = array(
                'success' => true
            );
        } else {
            $res = array(
                'success' => false
            );
        }
        echo json_encode($res);
    }
    
    function saveImage($link) {
        try {
            $filename = basename($link);
            //$this->sangmaster->_Save_Image($link, 'uploads/images/'.$filename);
            //$this->sangmaster->_Resize_Img($link, 'uploads/images/thumb/'.$filename, 300,200);
            
            //create path folder 2016/11/07
            $year = date("Y", time());
            $month = date("m", time());
            $date = date("d", time());
           
            if(!is_dir(FCPATH . 'uploads/images/' . $year)) {
                mkdir(FCPATH . 'uploads/images/' . $year, '0755', true);
            }
            if(!is_dir(FCPATH . 'uploads/images/' . $year . '/' . $month)) {
                mkdir(FCPATH . 'uploads/images/'.$year.'/'.$month, '0755', true);
            } 
            if(!is_dir(FCPATH . 'uploads/images/'.$year.'/'.$month.'/'.$date)) {
                mkdir(FCPATH . 'uploads/images/'.$year.'/'.$month.'/'.$date, '0755', true);
            }
            
            $upload_path = FCPATH . 'uploads/images/' . $year .'/' . $month . '/' . $date . '/';
            
            $ch = curl_init($link);
            $fp = fopen($upload_path . $filename, 'wb');
            curl_setopt($ch, CURLOPT_FILE, $fp);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_exec($ch);
            curl_close($ch);
            fclose($fp);
            
            return $year .'/' . $month . '/' . $date . '/' . $filename;
        } catch(Exception $ext) {
            return FALSE;
        }
    }
    
    function update_data() {
        $this->load->database();
        $streets = $this->db->select('id,title,alias')->from('streets')->get()->result_array();
        $count=0;
        foreach($streets as $street) {
            $check = $this->db->select('*')->from('app_routes')->where('controller', 'search')->where('search_level', 'street')->where('category_id', 25)->where('street_id', $street['id'])->get()->row_array();
            
            if(empty($check)) {
                /*$this->db->insert('app_routes', array(
                    'controller' => 'search',
                    'category_id' => 25,
                    'street_id' => $street,
                    'search_level' => 'street'
                ));*/
                echo $street['id'].'-';
                $count++;
            }
        }
        echo $count;
    }
    
    function update_data2() {
        $categories = $this->category_model->_Get_All();
        foreach($categories as $cat) {
            //$city = $this->city_model->_Get_All();
            //$district = $this->district_model->_Get_All();
            $street = $this->street_model->_Get_All();
            foreach($street as $ci) {
                $key = $this->routes_model->_Create_Key($cat['alias'].'-'.$ci['alias']);
            
                $this->routes_model->_Add_Route($key, 'search', 0, array(
                    //'city_id' => $ci['city_id'],
                    'ward_id' => $ci['ward_id'],
                    'street_id' => $ci['id'],
                    'category_id' => $cat['id']
                ));
            }
            
        }
    }
    
    function update_data3() {
        $categories = $this->category_model->_Get_All();
        foreach($categories as $cat) {
            //$city = $this->city_model->_Get_All();
            $district = $this->district_model->_Get_All();
            
            foreach($district as $ci) {
                $key = $this->routes_model->_Create_Key($cat['alias'].'-'.$ci['alias']);
            
                $this->routes_model->_Add_Route($key, 'search', 0, array(
                    'city_id' => $ci['city_id'],
                    'district_id' => $ci['id'],
                    'category_id' => $cat['id']
                ));
            }
            
        }
    }
    
    function update_data4() {
        $categories = $this->category_model->_Get_All();
        foreach($categories as $cat) {
            $city = $this->city_model->_Get_All();
            
            foreach($district as $ci) {
                $key = $this->routes_model->_Create_Key($cat['alias'].'-'.$ci['alias']);
            
                $this->routes_model->_Add_Route($key, 'search', 0, array(
                    'city_id' => $ci['id'],
                    'category_id' => $cat['id']
                ));
            }
            
        }
    }
    
    function create_link_district() {
        $this->load->model('link_model');
        $category = $this->category_model->_Get_All();
        $city = $this->ward_model->_Get_All();
        foreach($category as $cat) {
            foreach($city as $ci) {
                if($ci > 231) {
                    if($this->link_model->_Check_Link_Ward($cat['id'], $ci['id']) == 0) {
               //     $this->link_model->_Add_Link_Ward($cat['id'], $ci['id']);
                }
                }
                
            }
        }
    }
    
    function create_link_street($cat = 0) {
        $this->load->model('link_model');
        $category = $this->category_model->_Get_All();
        $street = $this->street_model->_Get_All();
        foreach($street as $ci) {
                
                if($this->link_model->_Check_Link_Street($cat, $ci['id']) == 0) {
                    $this->link_model->_Add_Link_Street($cat, $ci['id']);
                
                }
               
            }
    }
    
    function update_ward() {
        $wards = $this->db->get('wards')->result();
        foreach($wards as $ward) {
            
            $title = $ward->title;
            $title = str_replace("Phường", "", $title);
            $id = $ward->id;
            
            $this->db->where('id', $id)->update('wards', array(
                'title' => $title
            ));
            
        }
    }
    
    function add_street() {
        $district_id = 22;
        $street_id = 2981;
        $this->load->database();
        $handle = fopen("street.txt", "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                if((int)$line == 1) {
                    $insert = array(
                    'street_id' => $street_id,
                    'district_id' => $district_id
                );
                $this->db->insert('district_streets', $insert);
                    
                }
                $street_id++;
            }
        
            fclose($handle);
        } else {
            // error opening the file.
        } 
    }
    
    
    function update_status() {
        
        $icon = array(
            'active' => '<i class="fa fa-check-square" aria-hidden="true"></i>',
            'hide' => '<i class="fa fa-ban" aria-hidden="true"></i>'
        );
        
        $id = $this->input->post('id');
        $table = $this->input->post('table');
        $field = $this->input->post('field');
        $value = $this->input->post('value');
        if($value=='active')
            $update_status = 'hide';
        else
            $update_status = 'active';
        
        $this->db->where('id', $id)->update($table, array(
            $field => $update_status
        ));
        $res = array(
            'id' => $id,
            'label' => $icon[$update_status],
            'status' => $update_status
        );
        header('Content-Type: application/json');
        echo json_encode($res);
    }
    
    function check_login() {
        if (!$this->ion_auth->logged_in())
		{
			echo '<script>window.location.href="'.admin_url('login').'";</script>';
		}
    }
    
    /**
    * LOAD DITRICT BY CITY_ID
    * 
    */
    function loadDistrict() {
        $city = intval($this->input->post('city_id'));
        $district = $this->district_model->_Get_All($city);
        $html = '<option value="0">-- Quận/Huyện --</option>';
        foreach($district as $val) {
            $html .= '<option value="'.$val['id'].'">'.$val['title'].'</option>';
        }
        echo $html;
    }
    
    /**
    * LOAD WARD BY CITY_ID
    * 
    */
    function loadWard() {
        $district = intval($this->input->post('district_id'));
        $results = $this->ward_model->_Get_All($district);
        $html = '<option value="0">-- Phường/Xã --</option>';
        foreach($results as $val) {
            $html .= '<option value="'.$val['id'].'">'.$val['title'].'</option>';
        }
        echo $html;
    }
    
    /**
    * LOAD WARD BY CITY_ID
    * 
    */
    function loadStreet() {
        $city_id = intval($this->input->post('district_id'));
        $results = $this->street_model->_Get_Dropdown($city_id);
        
        foreach($results as $id=>$val) {
            $html .= '<option value="'.$id.'">'.$val.'</option>';
        }
        echo $html;
    }
    
    //Upload image real estate
    function do_upload($folder) {
        $output_dir = "./uploads/";
        if(isset($_FILES["myfile"]))
        {
        	$ret = array();
        	
        	$error =$_FILES["myfile"]["error"];
            
            if($folder == 'images') {
                $width = 900;
                $height = 600;
            } 
            if($folder == 'news') {
                $width = 600;
                $height = 400;
            }
            
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
    function delete_image($folder = 'images') {
        if($this->input->post('op') == 'delete') {
            $name = $this->input->post('name');
            $name = str_replace('"', '', $name);
            $name = str_replace('[', '', $name);
            $name = str_replace(']', '', $name);
            var_dump(@unlink(FCPATH . '/uploads/'.$folder.'/'.$name));
        }
    }
    
    //Search thành phố
    function search_city() {
        $q = $this->input->post('q');
        $results = $this->city_model->_Get_Search($q);
        
        foreach($results as $val) {
            $this->table->add_row(
                    array(
                        array('data'=>$val['title'].'<br>Alias: ['.$val['alias'].']','class'=>'left'),
                        array('data'=> _Format_Date($val['create_time']), 'class'=>'center'),
                        array('data'=> _Show_Status('city',$val['id'],'status', $val['status']), 'class'=>'center'),
                        array('data'=> _Input('sort_order['.$val['id'].']', $val['sort_order']), 'class'=>'center'),
                        array('data'=>
                        _Button_Link(admin_url('district/index/'.$val['id']), 'Quận/Huyện') . '&nbsp;'.
                        _Button_Change(admin_url('city/change/' . $val['id'])).'&nbsp;'.
                        _Button_Delete(admin_url('city/delete/' . $val['id'])),'class'=>'center')
                    )
                );
        }
        if(empty($results)) {
            $this->table->add_row(array(
                'data' => 'Không tìm thấy kết quả.', 'colspan'=>5
            ));
        }
        echo $this->table->generate();
    }
    
    //Search district
    function search_district() {
        $q = $this->input->post('q');
        $results = $this->district_model->_Get_Search($q);
        
        foreach($results as $val) {
            $this->table->add_row(
                    array(
                        array('data'=>$val['title'].'<br>Alias: ['.$val['alias'].']','class'=>'left'),
                        array('data'=> _Format_Date($val['create_time']), 'class'=>'center'),
                        array('data'=> _Show_Status('city',$val['id'],'status', $val['status']), 'class'=>'center'),
                        array('data'=> _Input('sort_order['.$val['id'].']', $val['sort_order']), 'class'=>'center'),
                        array('data'=>
                        _Button_Link(admin_url('ward/index/'.$val['id']), 'Quận/Huyện') . '&nbsp;'.
                        _Button_Change(admin_url('district/change/' . $val['id'])).'&nbsp;'.
                        _Button_Delete(admin_url('district/delete/' . $val['id'])),'class'=>'center')
                    )
                );
        }
        if(empty($results)) {
            $this->table->add_row(array(
                'data' => 'Không tìm thấy kết quả.', 'colspan'=>5
            ));
        }
        echo $this->table->generate();
    }
    
    //Search ward
    function search_ward() {
        $q = $this->input->post('q');
        $results = $this->ward_model->_Get_Search($q);
        
        foreach($results as $val) {
            $this->table->add_row(
                    array(
                        array('data'=>$val['title'].'<br>Alias: ['.$val['alias'].']','class'=>'left'),
                        array('data'=> _Format_Date($val['create_time']), 'class'=>'center'),
                        array('data'=> _Show_Status('city',$val['id'],'status', $val['status']), 'class'=>'center'),
                        array('data'=> _Input('sort_order['.$val['id'].']', $val['sort_order']), 'class'=>'center'),
                        array('data'=>
                        _Button_Link(admin_url('street/index/'.$val['id']), 'Quận/Huyện') . '&nbsp;'.
                        _Button_Change(admin_url('ward/change/' . $val['id'])).'&nbsp;'.
                        _Button_Delete(admin_url('ward/delete/' . $val['id'])),'class'=>'center')
                    )
                );
        }
        if(empty($results)) {
            $this->table->add_row(array(
                'data' => 'Không tìm thấy kết quả.', 'colspan'=>5
            ));
        }
        echo $this->table->generate();
    }
    
    //Search street
    function search_street() {
        $q = $this->input->post('q');
        $cat_id = $this->input->post('cat_id');
        $results = $this->street_model->_Get_Search($q, $cat_id);
        
        foreach($results as $val) {
            $this->table->add_row(
                    array(
                        array('data'=>$val['title'].'<br>Alias: ['.$val['alias'].']','class'=>'left'),
                        array('data'=> _Format_Date($val['create_time']), 'class'=>'center'),
                        array('data'=> _Show_Status('city',$val['id'],'status', $val['status']), 'class'=>'center'),
                        array('data'=> _Input('sort_order['.$val['id'].']', $val['sort_order']), 'class'=>'center'),
                        array('data'=>
                        _Button_Change(admin_url('street/change/' . $val['id'])).'&nbsp;'.
                        _Button_Delete(admin_url('street/delete/' . $val['id'])),'class'=>'center')
                    )
                );
        }
        if(empty($results)) {
            $this->table->add_row(array(
                'data' => 'Không tìm thấy kết quả.', 'colspan'=>5
            ));
        }
        echo $this->table->generate();
    }
    
    //Search real estate
    function search_real_estate() {
        $q = $this->input->post('q');
        $results = $this->real_estate_model->_Get_Search($q);
        
        foreach($results as $val) {
            if($val['type_id'] == 1)
                                    $class = '<span class="label label-danger">Vip đặc biệt</span>';
                                elseif($val['type_id'] == 2) 
                                     $class = '<span class="label label-warning">vip 1</span>';
                                elseif($val['type_id'] == 3)
                                    $class = '<span class="label label-primary">vip 2</span>';
                                else
                                    $class = '<span class="label label-info">Tin thường</span>';
            if($val['feature']==1) $feature = 'Có';
            else $feature = 'Không';
            $this->table->add_row(
                    array(
                        array('data'=>$val['id'],'class'=>'center'),
                        array('data'=>'<strong>'.$val['title'].'</strong><br>[Alias:'.$val['alias'].']','class'=>'left'),
                        array('data'=> $class, 'class'=>'center'),
                        array('data'=> _Format_Date($val['create_time']), 'class'=>'center'),
                        array('data'=> _Show_Status('pages',$val['id'],'status', $val['status']), 'class'=>'center'),
                        array('data'=> $feature, 'class'=>'center'),
                        array('data'=> ($val['views1']), 'class'=>'center'),
                        array('data'=> ($val['views2']), 'class'=>'center'),
                        array('data'=>_Button_Change(admin_url('real_estate/change/' . $val['id'])).'&nbsp;'.
                        _Button_Delete(admin_url('real_estate/delete/' . $val['id'])),'class'=>'center')
                    )
                );
        }
        if(empty($results)) {
            $this->table->add_row(array(
                'data' => 'Không tìm thấy kết quả.', 'colspan'=>6
            ));
        }
        echo $this->table->generate();
    }
    
    //Search content
    function search_content() {
        $q = $this->input->post('q');
        $results = $this->content_model->_Get_Search($q);
        
        foreach($results as $val) {
            $this->table->add_row(
                    array(
                        array('data'=>$val['id'],'class'=>'center'),
                            array('data'=>$val['title'], 'class'=>'left'),
                            array('data'=>_Show_Thumb('news', $val['image']), 'class'=>'center'),
                            array('data'=> _Format_Date($val['create_time']), 'class'=>'center'),
                            array('data'=> _Show_Status('contents',$val['id'],'status', $val['status']), 'class'=>'center'),
                            array('data'=> _Input('sort_order['.$val['id'].']', $val['sort_order']), 'class'=>'center'),
                            array('data'=> _Button_Change(admin_url('content/change/' . $val['id'] . '/' . $this->uri->segment(4))).'&nbsp;'.
                            _Button_Delete(admin_url('content/delete/' . $val['id']. '/' . $this->uri->segment(4))), 'class'=>'center')
                    )
                );
        }
        if(empty($results)) {
            $this->table->add_row(array(
                'data' => 'Không tìm thấy kết quả.', 'colspan'=>7
            ));
        }
        echo $this->table->generate();
    }
    
    //Search user
    function search_user() {
        $q = $this->input->post('q');
        $results = $this->ion_auth->like('username', $q)->users()->result();
        
        foreach($results as $user) {
                $user_group = '';
                foreach($user->groups as $group) {
                    $user_group .= $group->name . ', ';
                }
                $this->table->add_row(
                    array(
                       $user->username,
                       $user->email,
                       $user_group,
                        _Button_Change(admin_url('user/edit_user/' . $user->id)).'&nbsp;'.
                        _Button_Delete(admin_url('user/delete_user/' . $user->id))
                    )
                );
                
            }
        if(empty($results)) {
            $this->table->add_row(array(
                'data' => 'Không tìm thấy kết quả.', 'colspan'=>4
            ));
        }
        echo $this->table->generate();
    }
    
    function get_user() {
        $user_id = $this->input->get('user_id');
        $user = $this->ion_auth_model->user($user_id)->row_array();
        echo json_encode($user);
    }
    
    function update_alias() {
        $data = $this->input->post();
        $tables = array('contents', 'real_estates');
        $this->load->model('routes_model');
        if(isset($data['table']) && isset($data['id']) && isset($data['alias']) && in_array($data['table'], $tables)) {
            $check = $this->db->select('alias')->from($data['table'])->where('id', (int)$data['id'])->get()->row_array();
            //Neu co su thay doi alias
            if($check && $check['alias'] != $data['alias']) {
                $new_alias = $this->routes_model->_Create_Key($data['alias']);
                $this->db->where('id', $data['id'])->update($data['table'], array('alias' => $new_alias));
                $this->db->where('controller', substr($data['table'], 0, -1))->where('value', $data['id'])->update('app_routes', array('key'=>$new_alias));
                $response = array(
                    'updated' => true,
                    'alias' => $new_alias
                );
            } else {
                $response = array(
                    'updated' => false
                );
            }
        } else {
            $response = array(
                'updated' => false
            );
        }
        echo json_encode($response);
    }
    
    function export_route() {
        require APPPATH . '/third_party/phpexcel/PHPExcel.php';
        $results = $this->db->where('controller','search')->where('search_level', 'street')->get('app_routes')->result();
        
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();
        
        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Alessandro Minoccheri")
                                     ->setLastModifiedBy("Alessandro Minoccheri")
                                     ->setTitle("Office 2007 XLSX Test Document")
                                     ->setSubject("Office 2007 XLSX Test Document")
                                     ->setDescription("Generazione report inverter")
                                     ->setKeywords("office 2007 openxml php")
                                     ->setCategory("");
        
        
        
        $i = 1;
        foreach($results as $row) {
            // Add some data
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.$i, $row->id)
                    ->setCellValue('B'.$i, $row->key);    
        $i++;
        }
        
        
        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="app_routes.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }
}