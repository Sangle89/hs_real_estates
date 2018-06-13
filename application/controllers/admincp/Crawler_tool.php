<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'core/MY_Admin.php';
class Crawler_tool extends MY_Admin {
    
    public $title = 'Crawler Tool';
    private $_controller = 'crawler_tool';
    
    function __construct() {
        parent::__construct();
        $this->load->model(array(
            'content_category_model',
            'content_model',
            'real_estate_model'
        ));
        $this->load->library(array(
            'pagination', 
            'form_validation'
        ));
        $this->breadcrumb->append_crumb('Trang chủ', admin_url());
        $this->load->database();
        $this->load->helper(array('url','utf8', 'functions','email','htmlpurifier'));
        $this->load->model('routes_model');
        
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
    }
    
    function index() {
        $this->page('phongtro123');
    }
    
    function page($name) {
        $data['page'] = $name;
        $data['heading_title'] = $this->title;
        $this->template->_Set_View('crawler_tool/view', $data);
        $this->template->_Render();
    }
    
    function start_crawler() {
        $pathname = $this->input->post('pathname');
        $page = $this->input->post('page');
        if(!$page) $page = 1;
        if($pathname != '' && $page) {
            
            $this->load->library('crawler');
        
            $crawler = new Crawler();
            $crawler->setConnectionTimeout(6000);
            $crawler->set_domain('phongtro123');
            $crawler->set_pathname($pathname);
            $url = 'https://phongtro123.com/'.$pathname;
            
            $follow_link = array(
                '\.html$'
            );
            
            $ignore_link = array(
                'tim-kiem',
                'doi-song-xa-hoi',
                'kinh-nghiem',
                'phong-thuy',
                'nha-dep',
                'dang-tin',
                'cho-thue-phong-tro',
                'nha-cho-thue',
                'cho-thue-can-ho',
                'cho-thue-mat-bang',
                'tim-nguoi-o-ghep',
                '\.(jpg|jpeg|gif|png)$'
            );
            $crawler->set_ignore_list($ignore_link);
            for($i=0; $i<=($page - 1); $i++) {
                // URL to crawl
                if($i==0)
                    $link = $url;
                else
                    $link = $url."/page/".$i;
            
                $crawler->setURL($link);
                // Only receive content of files with content-type "text/html"
                $crawler->addContentTypeReceiveRule("#text/html#");
                
                foreach($follow_link as $item) {
                    $crawler->addFollowMatch("#".$item."# i");    
                }
                
                // Ignore links to pictures, dont even request pictures
                foreach($ignore_link as $item) {
                    $crawler->addURLFilterRule("#".$item."#");
                }
                
                // Store and send cookie-data like a browser does
                $crawler->enableCookieHandling(true);
                
                // Set the traffic-limit to 1 MB (in bytes,
                // for testing we dont want to "suck" the whole site)
                $crawler->setTrafficLimit(1000 * 1024);
                
                // Thats enough, now here we go
                $crawler->go();
                
                $info = $crawler->handleDocumentInfo($crawler);
                
            }
            $response = array();
            $contents = $this->db->select('url')->from('crawler_links')
                ->where('status', 0)
                ->where('pathname', $pathname)
                ->where('domain', 'phongtro123')
                ->order_by('create_time')
                ->get()
                ->result_array();
            if($contents) {
                $response['success'] = true;
                foreach($contents as $content) {
                    $response['content'] .= $content['url'];
                     $response['content'].="\n";   
                }
            }
            echo json_encode($response);
        }
        
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
        $category_alias = $this->input->post('category_alias');
        $filename = $this->input->post('filename')!='' ? $this->input->post('filename'): 'chothuematbang';
		$data = $this->dlPage(trim($url));
		$res = array();
        $res['url'] = trim($url);
        
        $mapDistrict = $this->District();
        $mapSpin = $this->SpinContent();
        
        $this->logIndex($index);
        
        $category_map = array(
            'cho-thue-phong-tro' => 1,
            'nha-cho-thue' => 2,
            'cho-thue-can-ho' => 3,
            'cho-thue-mat-bang' => 4,
            'tim-nguoi-o-ghep' => 5
        );
        
		if(!empty($data)) {
			//do something
            $insert = array(
                'category_id' => isset($category_map[$category_alias]) ? $category_map[$category_alias] : 1,
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
                'from_date' => date('Y-m-d H:i:s', time()),
                'to_date' => date('Y-m-d H:i:s', time() + 3600*24*365),//1 nam
                'create_time' => date('Y-m-d H:i:s', time()),
                'update_time' => date('Y-m-d H:i:s', time()),
                'status' => 'active',
                'create_by' => 0,
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
                        if(isset($prices[1]) && strtolower($prices[1]) == 'triệu/tháng')
                            $insert['price_unit'] = 1;
                        elseif(isset($prices[1]) && strtolower($prices[1]) == 'nghìn/tháng')
                            $insert['price_unit'] = 2;
                        elseif(isset($prices[1]) && strtolower($prices[1]) == 'nghìn/m2/tháng')
                            $insert['price_unit'] = 3;
                        else
                            $insert['price_unit'] = 1;
                    }
                }
            }
            
            $title_alias = to_slug(str_replace("/","-",$insert['title']));
            if($this->check_exists($title_alias) == false) {
                $insert['alias'] = $this->routes_model->_Create_Key(str_replace("/","-",$insert['title']));
                
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
                    //$src = explode("&url=", $src);
                    if(!empty($src)) {
                        //$image = $src[1];
                        $image = $src;
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
                    $content = str_replace("\n", "<br/>", $content);
                    $content = nl2br($content);
                    foreach($mapSpin as $spin_key => $spin_val) {
                        $content = str_replace($spin_key, $spin_val, $content);
                    }
                    $insert['content'] = $content;
    			}
                if($insert && $insert['title']!='' && $insert['alias']!='') {
                    $insert_id = $this->insertData($insert);
                    if($insert_id)
                       $this->db->where('url', $url)->update('crawler_links', array('status'=>1));
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
		curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)");
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
        $check = $this->db->select('id')->from('real_estates')->where('alias', $alias)->get()->num_rows();
        if($check > 0) return true;
        else return false;
    }
    
    function insertData($data) {
        if($this->check_exists($data['alias']) == false) {
            $this->db->insert('real_estates', array(
               'title' => $data['title'],
               'keywords' => $data['title'],
               'description' => sub_string($data['content'], 300),
               'alias' => $data['alias'],
               'content' => htmlpurifier(trim($data['content'])),
               'category_id' => $data['category_id'], //cho thue can ho
               'city_id' => 1,
               'district_id' => $data['district_id'] ? $data['district_id'] : 0,
               'address' => $data['address'] ? $data['address']:'',
               'area' => $data['area'] ? $data['area'] : 0,
               'price_number' => $data['price_number']?$data['price_number'] : 0,
               'price_unit' => $data['price_unit'] ? $data['price_unit'] : 0,
               'latitude' => $data['lat'] ? $data['lat']:'',
               'longtitude' => $data['lng'] ? $data['lng'] : '',
               'from_date' => $data['from_date'],
               'to_date' => $data['to_date'],
               'guest_fullname' => $data['guest_fullname']!=''?$data['guest_fullname']:'',
               'guest_email' => $data['guest_email']!=''?$data['guest_email']:'',
               'guest_mobiphone' => $data['guest_mobiphone']!=''?$data['guest_mobiphone']:'',
               'create_time' => date('Y-m-d H:i:s', time()),
               'update_time' => date('Y-m-d H:i:s', time()),
               'create_by' => '',
               'type_id' => $data['type_id'],
               'views1' => 100,
               'views2' => 300,
               'status' => 'active',
               'post_by' => 'bot'
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
                $this->db->where('id', $id)->update('real_estates', array('image' => $data['images'][0]));  
            }
            $param = array(
                'category_id' => intval($data['category_id']),
                'city_id' => intval($data['city_id']),
                'district_id' => intval($data['district_id']),
               // 'ward_id' => intval($data['ward_id']),
               // 'street_id' => intval($data['street_id'])
            );
            $this->routes_model->_Add_Route($data['alias'], 'real_estate', $id, $param);
            $this->cache->clean();
            return $this->db->insert_id();
        } else {
            return false;
        }
        
    }
    function _Resize_Crop($file_path, $file_name, $folder = 'images', $width=155, $height=130) {
        
        $this->load->library('image_moo');
        $return = $this->image_moo->load($file_path)
                //->set_background_colour('#ffffff')
                ->resize_crop($width, $height, TRUE)
                ->save(FCPATH . 'uploads/thumb/'.$folder.'/'.$file_name, TRUE);
        return $return;
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
        $filename = $year .'/' . $month . '/' . $date . '/' . $name . ".jpg";
        $image_path = $year .'/' . $month . '/' . $date;
        $upload_thumb_path = FCPATH . 'uploads/thumb/'.$folder.'/'. $year .'/' . $month . '/' . $date . '/';
        
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
            
            _Resize_Crop($upload_path . $name.".jpg", $image_path . '/' . $name.'.jpg', 'images');
            
            $image_size = getimagesize($upload_path . $name.".jpg");
            $image_width = $image_size[0];
            $image_height = $image_size[1];
            
            $this->load->library('image_moo');   
            //Resize image
            if($image_width > $image_height) {
                $resize_width = 624;
                $resize_height = (624 * $image_height) / $image_width;
            } else {
                $resize_width = (476 * $image_width) / $image_height;
                $resize_height = 476;
            }
                
            $this->image_moo->load($upload_path . $name.".jpg")
            ->set_background_colour('#ffffff')
            ->resize($resize_width, $resize_height, TRUE)
            ->save($upload_path . $name.".jpg", TRUE);
            
            $this->image_moo->load($upload_path . $name.".jpg")
            ->load_watermark(FCPATH . 'theme/images/watermark.png')
            ->set_watermark_transparency(1)
            ->watermark(3)
            ->save($upload_path . $name.".jpg", TRUE);
            
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
    
    function mapCityDistrict($address) {
        $array_district = array(
            'Quận 1' => 1,
            'Quận 2' => 2,
            'Quận 3' => 3,
            'Quận 4' => 5,
            'Quận 5' => 6,
            'Quận 6' => 7,
            'Quận 7' => 8,
            'Quận 8' => 9,
            'Quận 9' => 10,
            'Quận 10' => 24,
            'Quận 11' => 11,
            'Quận 12' => 12,
            'Phú nhuận' => 13,
            'Tân Bình' => 14,
            'Bình thạnh' => 15,
            'Gò Vấp' => 16,
            'Tân Phú' => 17,
            'Thủ Đức' => 18,
            'Củ Chi' => 19,
            'Bình Chánh' => 20,
            'Hóc Môn' => 21,
            'Nhà Bè' => 22,
            'Cần Giờ' => 23,
            'Bình Tân' => 25
        );
        $district_id = 0;
        foreach($array_district as $title=>$id) {
            if(strpos(mb_strtolower($address), mb_strtolower($title)) != false) {
                $district_id = $id;
                break;   
            }
        }
        return $district_id;
    }
    
    function chuanhoaAddress($address) {
        $address = str_replace(array("Q.1", "Q1", "q1", "q.1"), "Quận 1", $address);
        $address = str_replace(array("Q.2", "Q2", "q2", "q.2"), "Quận 2", $address);
        $address = str_replace(array("Q.3", "Q3", "q3", "q.3"), "Quận 3", $address);
        $address = str_replace(array("Q.4", "Q4", "q4", "q.4"), "Quận 4", $address);
        $address = str_replace(array("Q.5", "Q5", "q5", "q.5"), "Quận 5", $address);
        $address = str_replace(array("Q.6", "Q6", "q6", "q.6"), "Quận 6", $address);
        $address = str_replace(array("Q.7", "Q7", "q7", "q.7"), "Quận 7", $address);
        $address = str_replace(array("Q.8", "Q8", "q8", "q.8"), "Quận 8", $address);
        $address = str_replace(array("Q.9", "Q9", "q9", "q.9"), "Quận 9", $address);
        $address = str_replace(array("Q.10", "Q10", "q10", "q.10"), "Quận 10", $address);
        $address = str_replace(array("Q.11", "Q11", "q11", "q.11"), "Quận 11", $address);
        $address = str_replace(array("Q.12", "Q12", "q12", "q.12"), "Quận 12", $address);
        return $address;
    }
    
    /**
    * Kenhnhatro.com
    */
    function kenhnhatro() {
        $data['page'] = $name;
        $data['heading_title'] = 'Kenhnhatro';
        $this->template->_Set_View('crawler_tool/kenhnhatro', $data);
        $this->template->_Render();
    }
    
    function start_crawler_kenhnhatro() {
        $pathname = $this->input->post('pathname');
        $page = $this->input->post('page');
        if(!$page) $page = 1;
        if($pathname != '' && $page) {
            $this->load->library('crawler');
            
            $crawler = new Crawler();
            $crawler->setConnectionTimeout(6000);
            $crawler->set_domain('kenhnhatro');
            $crawler->set_pathname($pathname);
            
            $url = 'http://kenhnhatro.com/'.$pathname;
            
            $follow_link = array(
                '\.html$'
            );
            
            $ignore_link = array(
                'cho-thue-can-ho-chung-cu.html',
                'cho-thue-phong-tro-nha-tro.html',
                'cho-thue-nha-nguyen-can.html',
                'cho-thue-can-ho-chung-cu.html',
                'cho-thue-van-phong.html',
                'tim-nguoi-o-ghep.html',
                'cho-thue-phong-khach-san-nha-nghi.html',
                'quen-mat-khau',
                'dang-ky',
                'huong-dan',
                '\.(jpg|jpeg|gif|png)$'
            );
            
            for($i=1; $i<=($page); $i++) {
                // URL to crawl
                if($i==1)
                    $link = $url;
                else
                    $link = str_replace(".html","",$url)."/page/".$i;
                
                $crawler->setURL($link);
                // Only receive content of files with content-type "text/html"
                $crawler->addContentTypeReceiveRule("#text/html#");
                
                foreach($follow_link as $item) {
                    $crawler->addFollowMatch("#".$item."# i");    
                }
                
                // Ignore links to pictures, dont even request pictures
                foreach($ignore_link as $item) {
                    $crawler->addURLFilterRule("#".$item."#");
                }
                
                // Store and send cookie-data like a browser does
                $crawler->enableCookieHandling(true);
                
                // Set the traffic-limit to 1 MB (in bytes,
                // for testing we dont want to "suck" the whole site)
                $crawler->setTrafficLimit(1000 * 1024);
                
                // Thats enough, now here we go
                $crawler->go();
                
                $info = $crawler->handleDocumentInfo($crawler);
                
            }
            $response = array();
            $contents = $this->db->select('url')->from('crawler_links')
                ->where('status', 0)
                ->where('pathname', $pathname)
                ->where('domain', 'kenhnhatro')
                ->order_by('create_time')
                ->get()
                ->result_array();
            if($contents) {
                $response['success'] = true;
                foreach($contents as $content) {
                    $response['content'] .= $content['url'];
                     $response['content'].="\n";   
                }
            }
            echo json_encode($response);
        }
    }
    
    public function crawler_kenhnhatro() {
		require APPPATH . "/third_party/phpcrawl/libs/simple_html_dom.php";
		
		$url = $this->input->post('url');
		$index = $this->input->post('index');
        $category_alias = $this->input->post('category_alias');
        $filename = $this->input->post('filename')!='' ? $this->input->post('filename'): 'chothuematbang';
		$data = $this->dlPage(trim($url));
		$res = array();
        $res['url'] = trim($url);
        
        $mapDistrict = $this->District();
        $mapSpin = $this->SpinContent();
        
        $this->logIndex($index);
        
        $category_map = array(
            'cho-thue-phong-tro-nha-tro' => 1,
            'cho-thue-nha-nguyen-can' => 2,
            'cho-thue-can-ho-chung-cu' => 3,
            'cho-thue-van-phong' => 4,
            'tim-nguoi-o-ghep' => 5,
            'cho-thue-phong-khach-san-nha-nghi' => 5
        );
        
        $category_path = explode("/", $category_alias);
        if(count($category_path)>1 && isset($category_map[$category_path[0]])) $category_id = $category_map[$category_path[0]];
        else $category_id = 1;
        
		if(!empty($data)) {
			//do something
            $insert = array(
                'category_id' => $category_id,
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
                'from_date' => date('Y-m-d H:i:s', time()),
                'to_date' => date('Y-m-d H:i:s', time() + 3600*24*365),//1 nam
                'create_time' => date('Y-m-d H:i:s', time()),
                'update_time' => date('Y-m-d H:i:s', time()),
                'status' => 'active',
                'create_by' => 0,
                'guest_address' => '',
                'guest_telephone' => '',
                'utilities' => array(),
                'images' => array()
            );
			
            //Find title
            $find_title = $data->find('#dnoidung_content h1.dtitle');
			if(!empty($find_title)) {
				foreach($find_title as $item) {
					$title = $item->plaintext;
                    //Title
                    $insert['title'] = trim($title);
				}    
			}
            
            //info
            $find_name = $data->find('.dtnguoidang .green');
            if(!empty($find_name)) {
                $insert['guest_fullname'] = $find_name[0]->plaintext;
            }
            $find_email = $data->find('.dtemail > a');
            if(!empty($find_email)) {
                $insert['guest_email'] = $find_email[0]->plaintext;
            }
            $find_phone = $data->find('.dphone > .blue');
            if(!empty($find_phone)) {
                $insert['guest_mobiphone'] = $find_phone[0]->plaintext;
            }
            $find_price = $data->find('.dgia > .red');
            if(!empty($find_price)) {
                $insert['price_number'] = str_replace(" vnđ","",$find_price[0]->plaintext);
                $insert['title'] = $insert['title'].' giá '.$insert['price_number'].'triệu/tháng';
            }
            $temp_price = $insert['price_number'];
            $temp_price = (int)str_replace(".","",$temp_price);
            if($temp_price / 1000000 >= 1) {
                $insert['price_unit'] = 1;    
            } else {
                $insert['price_unit'] = 2;
            }
             //1 trieu/thang 2 nghin/thang
            $find_area = $data->find('.ddientich > .greenbold');
            if(!empty($find_area)) {
                $insert['area'] = $find_area[0]->plaintext;
                $insert['title'] = $insert['title'].' diện tích '.$insert['area'];
            }
            
            $find_address = $data->find('.dtline', 2);
            if(!empty($find_address)) {
                $address = $find_address->find('.green', 0);
                if(!empty($address)) {
                    $address = $this->chuanhoaAddress($address->plaintext);
                    $insert['address'] = $address;
                    $insert['city_id'] = 1;
                    $insert['district_id'] = $this->mapCityDistrict($address);
                }
            }
            
            
            $find_content = $data->find('#dnoidung_content .dnoidung');
            if(!empty($find_content)) {
                $insert['content'] = $find_content[0]->innertext;
                $insert['content'] = trim($insert['content']);
                $insert['content'] = str_replace("\n", "<br/>", $insert['content']);
                $insert['content'] = nl2br($insert['content']);
                $insert['content'] = htmlpurifier($insert['content']);
                $insert['content'] = preg_replace('/<div[^class="notice">]*>.*?<\/div>/i', '', $insert['content']);
            }
            
            $title_alias = to_slug(str_replace("/","-",$insert['title']));
            if($this->check_exists($title_alias) == false) {
                $insert['alias'] = $this->routes_model->_Create_Key(str_replace("/","-",$insert['title']));
                //Image
    			$images = array();
                $find_image = $data->find('#dnoidung_content center > p');
                $image_id = 0;
                if(!empty($find_image)){
                    foreach($find_image as $item) {
                        $img = $item->find('img', 0);
                        $image = $img->src;
                        if($image != '') {
                            $image_base64 = file_get_contents($image);
                            $image_name = $insert['alias'].'-'.$image_id;
                            $image_uploaded = $this->save_base64_image($image_base64, $image_name);
                            if($image_uploaded) $images[] = $image_uploaded;
                            $image_id++;
                        }
                    }
                }
                $insert['images'] = $images;
                //print_r($insert);
    		    if($insert) {
                   $insert_id = $this->insertData($insert);
                    if($insert_id)
                        $this->db->where('url', $url)->update('crawler_links', array('status'=>1));
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
}