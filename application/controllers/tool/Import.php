<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'core/MY_Admin.php';
class Import extends MY_Admin {

	public function __construct(){
		parent::__construct();
		$this->load->database();
        $this->load->helper(array('url','functions','email'));
        $this->load->model('routes_model');
        
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
	} 
	
    function deleteid() {
        $file = fopen("./ids.txt", "r");
        $arrLinks = array();
        while(($line = fgets($file))!== false) {
            $arrLinks[] = $line;  
        }
        if(!empty($arrLinks)) {
            $this->db->where_in('id', $arrLinks)->delete('real_estates');
            echo 'Deleted real estate:'. $this->db->affected_rows();
            $this->db->where('controller', 'real_estate')->where_in('value', $arrLinks)->delete('app_routes');
            echo ' Deleted router: '.$this->db->affected_rows();
        }
    }
    
	public function index()
	{
        $filename = 'chothuematbang';
		$file = fopen("./data/".$filename.".txt", "r");
        $arrLinks = array();
        $arrTemp = array();
        while(($line = fgets($file))!== false) {
            if(strpos($line, 'tinh-thanh/ho-chi-minh') !== false){
                $arrLinks[] = $line;    
            }
        }
        
        foreach($arrLinks as $item) {
            if(!in_array($item, $arrTemp)) {
                $arrTemp[] = $item;
            }
        }
        
        $data['arrLinks'] = $arrTemp;
        $data['filename'] = $filename;
		$this->load->view('tool/import', $data);
	}
    
    function District() {
        $result = $this->cache->get('district__');
        if(empty($result)) {
            $result = $this->db->select('id, alias, city_id')->from('district')->get()->result_array();
            $this->cache->save('district__', $result, 30000000);    
        }
        $res = array();
        foreach($result as $item) {
            $res[$item['alias']] = array(
                'city_id' => $item['city_id'],
                'district_id' => $item['id']
            );
        }
        return $res;
    }
    
    function SpinContent() {
        $array = array();
        $hanld = fopen("./spin.txt", "r");
        while($line = fgets($hanld) !== false) {
            $str = explode("|", $line);
            if(isset($str[0]) && isset($str[1])) {
                $array[trim($str[0])] = trim($str[1]);
            }
        }
        return $array;
    }
	
	public function crawler() {
		require APPPATH . "/third_party/phpcrawl/libs/simple_html_dom.php";
		
		$url = $this->input->post('url');
		$index = $this->input->post('index');
        $filename = $this->input->post('filename')!='' ? $this->input->post('filename'): 'chothuematbang';
		$data = $this->dlPage(trim($url));
		$res = array();
        $res['url'] = trim($url);
        
        $mapDistrict = $this->District();
        $mapSpin = $this->SpinContent();
        //Log index
        $this->logIndex($index);
        
        $category_map = array(
            'cho_thue_phong_tro' => 1,
            'cho_thue_nha' => 2,
            'cho_thue_can_ho' => 3,
            'cho_thue_mat_bang' => 4,
            'tim_nguoi_o_ghep' => 5
        );
        
		if(!empty($data)) {
			//do something
            $insert = array(
                'category_id' => 2,
                'ward_id' => 0,
                'street_id' => 0,
    			'project_id' => 0,
                'mattien' => 0,
                'duongtruocnha' => 0,
                'sotang' => 0,
                'sophong' => 0,
                'sotoilet' => 0,
                'huongnha' => 0,
                'noithat' => '',
                'type_id' => 4,
                'from_date' => date('d/m/Y', time()),
                'to_date' => date('d/m/Y', time() + 3600*24*365),//1 nam
                'create_time' => date('Y-m-d H:i:s', time()),
                'status' => 'active',
                'create_by' => ($this->ion_auth->get_user_id()) ? $this->ion_auth->get_user_id() : '0',
                'guest_address' => '',
                'guest_telephone' => '',
                'utilities' => array(),
                'images' => array()
            );
			
            //Find title
            $find_title = $data->find('.post-title-lg > a');
			if(!empty($find_title)) {
				foreach($find_title as $item) {
					$title = $item->plaintext;
                    //Title
                    $insert['title'] = trim($title);
				}    
			}
            
            //Info
            $find_info = $data->find('div[class="post_summary"] div[class="summary_row"]');
            if(!empty($find_info)) {
                foreach($find_info as $item) {
                    $info_row = $item->find('.summary_item_info');
                    foreach($info_row as $item_row) {
                        $info[] = $item_row->plaintext;
                        //echo $item_row->innertext;
                    }
                }
                $address = isset($info[0]) ? trim($info[0]) : '';
                //Address
                $insert['address'] = $address;
                                
                if($address != '') {
                    $locations = explode(",", $address);
                    $city = isset($locations[count($locations)-1]) ? $locations[count($locations)-1] : '';
                    $district = isset($locations[count($locations)-2]) ? $locations[count($locations)-2] : '';
                    $ward = isset($locations[count($locations)-3]) ? $locations[count($locations)-3] : '';
                    $street = isset($locations[count($locations)-4]) ? $locations[count($locations)-4] : '';
                    //if($street) $insert['street'] = $street;
                    //if($ward) $insert['ward'] = $ward;
                 
                    if($district){
                        $insert['district_id'] = $mapDistrict[to_slug($district)]['district_id'];
                    } else {
                        $insert['district_id'] = 0;
                    }
                    //$insert['district'] = $district;
                    if($city){
                        $insert['city_id'] = $mapDistrict[to_slug($district)]['city_id'];        
                    } else {
                        $insert['city_id'] = 1;
                    }
                    //$insert['city'] = $city;
                }
                
                $insert['guest_name'] = isset($info[3]) ? trim($info[3]) : '';
                if(isset($info[4])) {
                    if(valid_email($info[4])) {
                        $insert['guest_email'] = trim($info[4]);
                        $insert['guest_mobiphone'] = '';
                    }
                    else {
                        $insert['guest_mobiphone'] = trim($info[4]);
                        $insert['guest_email'] = ''; 
                    }
                }
                if(isset($info[6])) {
                    $insert['area'] = trim($info[6]);
                    $insert['title'] = $insert['title'].' Diện tích '.str_replace("m²","m2",$insert['area']);    
                } else {
                    $insert['area'] = '';
                }
                if(isset($info[8])) {
                    $prices = trim($info[8]);
                    $insert['title'] = $insert['title'].' Giá '.$prices;  
                    if($prices != '') {
                        $prices = explode(" ", $prices);
                        if(isset($prices[0])) $insert['price_number'] = $prices[0];
                        $insert['price_unit'] = 1;
                    }
                }
            }
            
            $insert['alias'] = $this->routes_model->_Create_Key(str_replace("/","-",$insert['title']));
            
            $check = $this->db->select('*')->from('app_routes')->where('key', $insert['alias'])->get()->num_rows();
            
            if($check == 0) {
                //Map lat lng
                $find_map = $data->find('div[id="maps_content"]', 0);
                if(!empty($find_map)) {
                    $insert['lat'] = $find_map->attr['data-lat'];
                    $insert['lng'] = $find_map->attr['data-long'];
                }
                
                //Image
    			$images = array();
                $image_id = 0;
                foreach($data->find('div[id="flexslider_slider"] > ul[class="slides"] > li') as $item) {
    				$img = $item->find('img', 0);
                    $src = $img->src;
                    $src = explode("&url=", $src);
                    if(!empty($src)) {
                        $image = $src[1];
                        
                        $image_base64 = file_get_contents($image);
                        $image_name = $insert['alias'].'-'.$image_id;
                        $image_uploaded = $this->save_base64_image($image_base64, $image_name);
                        if($image_uploaded) $images[] = $image_uploaded;
                        
                        $image_id++;
                    }
                        
    			}
                $insert['image_default'] = 0;
                $insert['images'] = $images;
    			
                //Content
    			foreach($data->find('div[id="motachitiet"]') as $item) {
    				$content = $item->innertext;
                    $content = str_replace("<span class=\"block_headline\">Thông tin mô tả</span>", "", $content);
                    foreach($mapSpin as $spin_key => $spin_val) {
                        $content = str_replace($spin_key, $spin_val, $content);
                    }
                    $insert['content'] = $content;
    			}
                if($insert) {
                    $this->insertJson($filename, $insert);
                }
    			
    			$res['success'] = true;    
    			$res['title'] = $title;
            } else {
                $res['success'] = false;
            }
		} else {
			$res['success'] = false;
		}
		echo json_encode($res);
	}
    
    function insertJson($filename, $data) {
        $handle = fopen('./json/'.$filename.".json", "a");
        if($handle) {
            fwrite($handle, json_encode($data)."\n");
            fclose($handle);
        }
    }
	
	function dlPage($href) {
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		//curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($curl, CURLOPT_URL, $href);
		curl_setopt($curl, CURLOPT_REFERER, $href);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
			// Blindly accept the certificate
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
		// decode response
		curl_setopt($curl, CURLOPT_ENCODING, 1);
		curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/533.4 (KHTML, like Gecko) Chrome/5.0.375.125 Safari/533.4");
		$str = curl_exec($curl);
		
		if(curl_exec($curl) === false)
		{
			echo 'Curl error: ' . curl_error($curl);
		}
		
		curl_close($curl);
		// Create a DOM object
		$dom = new simple_html_dom();
		// Load HTML from a string
		$dom->load($str);

		return $dom;
	}
    
    function check_exists($alias) {
        $check = $this->db->select('id')->from('contents')->where('alias', $alias)->get()->num_rows();
        if($check > 0) return true;
        else return false;
    }
    
    function insertData($data) {
        
        $this->db->insert('real_estates', array(
           'title' => $data['title'],
           'keywords' => $data['title'],
           'description' => $data['title'],
           'alias' => $data['alias'],
           //'short_content' => $data['short_content'],
           'content' => $data['content'],
           'category_id' => 5, //cho thue can ho
           'city_id' => 1,
           'district_id' => $data['district_id'],
           //'ward_id' => $data['ward_id'],
           //'street_id' => $data['street_id'], 
           'address' => $data['address'],
           'area' => $data['area'],
           'price_number' => $data['price_number'],
           'price_unit' => $data['price_unit'],
           'latitude' => $data['lat'],
           'longtitude' => $data['lng'],
           'from_date' => '',
           'to_date' => '',
           'guest_fullname' => $data['guest_fullname'],
           'guest_email' => $data['guest_email'],
           'guest_mobiphone' => $data['guest_mobiphone'],
           'create_time' => date('Y-m-d H:i:s', time()),
           'create_by' => '',
           'views1' => 100,
           'views2' => 300,
           'status' => 'hide'
        ));
        
        $id = $this->db->insert_id();
        if($data['images']) {
            foreach($data['images'] as $key => $image) {
                $this->db->insert('real_estate_images', array(
                    'real_estate_id' => $id,
                    'image' => $image,
                    'is_default' => $key==0 ? 1 : 0
                ));
            }
        }
        $param = array(
            'category_id' => intval($data['category_id']),
            'city_id' => intval($data['city_id']),
            'district_id' => intval($data['district_id']),
           // 'ward_id' => intval($data['ward_id']),
           // 'street_id' => intval($data['street_id'])
        );
        $this->routes_model->_Add_Route($data['alias'], 'real_estate', $id, $param);
        
        return $this->db->insert_id();
    }
    
    function save_base64_image($file, $name) {
        //create path folder 2016/11/07
        $year = date("Y", time());
        $month = date("m", time());
        $date = date("d", time());
        
        $folder = 'images';
       
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
        $filename = $year .'/' . $month . '/' . $date . '/' . $name . ".jpg";
        
        if($file!=''){
            if (!is_dir($upload_path) or !is_writable($upload_path)) {
                // Error if directory doesn't exist or isn't writable.
                echo 'Error folder not found';
                return false;
            } elseif (is_file($upload_path) and !is_writable($upload_path)) {
                echo 'Permission deny';
                return false;
                // Error if the file exists and isn't writable.
            }
            file_put_contents($upload_path . $name.".jpg", $file);
            return $filename;    
        } else {
            return false;
        }
    }
    
    function logIndex($val) {
        $handle = fopen('log.dat', 'w');
        fwrite($handle, $val);
        fclose($handle);
    }
    
    function updateImage() {
        $results = $this->db->get('real_estate_images')->result_array();
        foreach($results as $item) {
            $this->db->where('image', $item['image'])->update('real_estate_images', array(
                'image' => '2017/12/11/' . $item['image']
            ));
        }
    }
    
    function insertDB($filename) {
        $this->load->model('cache/main_model');
        $handle = fopen("./json/".$filename.".json", "r");
        $insert_id = array();
        if($handle) {
            while(($line = fgets($handle)) !== false) {
                $insert = (array)json_decode($line);
                if(isset($insert['alias']) && isset($insert['title']) && $insert['alias']!='' && $insert['title']!='') {
                    $id = $this->main_model->_Add_Real_Estate($insert);
                    if($id) $insert_id[] = $id;
                }
            }
        }
        print_r($insert_id);
    }
}
