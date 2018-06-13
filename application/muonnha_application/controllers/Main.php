<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . '/core/MY_Controller.php';
class Main extends MY_Controller {
    
    function __construct() {
        parent::__construct();
        
        $this->load->model(array(
            'cache/main_model',
            'cache/image_model',
            'content_category_model',
            'routes_model'
        ));
        
        $this->load->helper(array('widget'));
        
        $this->load->library(array('pagination','breadcrumb','ion_auth'));
        $this->breadcrumb->__construct(array(
            'tag_open' => '<ul class="breadcrumb">',
            'tag_close' => '</ul>'
        ));
        $this->breadcrumb->append_crumb('<i class="fa fa-home"></i>', site_url());
        
        $this->data = array();
        
        $web_setting = $this->main_model->_Get_Setting();
        $this->template->_Set_Config($web_setting);
        
    }
    
    function index() {
        $key = $this->uri->segment(1);
        $current_url = current_url();
        if(strpos($current_url, ".html") != false){
            redirect(base_url('error404'));
        }
        $general_router = array(
            'search' => 'post_search'
        );
        
        if($this->uri->segment(2) == 'p' && $this->uri->segment(3))
            $page = intval($this->uri->segment(3));
        else 
            $page = 1;

        if($key == '') {
            $this->home();
        } else {
            
            if(array_key_exists($key, $general_router)) {
                $param = '';
                if($key=='dat-lai-mat-khau') $param = $this->uri->segment(2);
                $this->{$general_router[$key]}($param);
            } else  {
                if(strpos($_SERVER["REQUEST_URI"], ".htm") === false) {
                    //$this->error404();
                  //  break;   
                }    
                $route = $this->routes_model->_Get_Key($key);
                
                if($route) {
                    
                    $controller = $route['controller'];
                    $id = $route['value'];
                    
                    switch($controller) {
                        case 'category':
                            $this->category($id, $page);
                            break;
                        case 'category_project':
                            $this->category_project($route['category_id'], $route['project_id'], $page);
                            break;
                        case 'real_estate':
                            $this->real_estate($id);
                            break;
                        case 'tags':
                            $this->tags($id);
                            break;
                        case 'content_category':
                            $this->content_category($id, $page);
                            break;
                        case 'content':
                            $this->content($id);
                            break;
                        case 'page':
                            $this->page($id);
                            break;
                        case 'search':
                            $this->search();
                            break;
                        default: 
                            $this->home();
                            break;
                    }
                    
                } else {
                    $this->error404();
                }
            }
        }
    }
    
    function home() {
        
        $this->load->database();
        $results = $this->main_model->_Get_Contents(6);
        $data['results'] = $results;
        $data['cur_page'] = 'home';
        $this->template->_Set_Data('cur_page', 'home');
        $this->template->_Set_View('home/home', $data);
        $this->template->_Render();
    }
    
    /**
    * Post search
    */
    function post_search() {
		$keyword = $this->input->post('s', true);
        $category_id = $this->input->post('CatID');
        $city_id = $this->input->post('CityID');
        $district_id = $this->input->post('DistrictID');
        $ward_id = $this->input->post('WardID');
        $street_id = $this->input->post('StreetID');
        $area = $this->input->post('Area');
        $price = $this->input->post('Price');
        $bedroom = $this->input->post('Bedroom');
        $project_id = $this->input->post('ProjectID');
        
        $redirect_url = '';
		if($keyword!='') {
			$redirect_url = site_url('tim-kiem?s='.$keyword);
		} else {
			if(!$category_id) {
				$first_category = $this->main_model->_Get_First_Real_Estate_Category();
				$category_id = $first_category['id'];
			}
			if($category_id) {
				
				$category_info = $this->main_model->_Get_Real_Estate_Category_By_Id($category_id, array('alias'));
				$redirect_url = $category_info['alias'];
				
                //Nếu post street
				if($street_id != -1) {
					$this->session->set_flashdata('search_street', $street_id);
					$redirect_url = $this->routes_model->_Get_Search_URL('street', $category_id, $street_id,$district_id);
					$redirect_url = $redirect_url;
				}
                //Nếu post ward
				elseif($ward_id != -1) {
					$this->session->set_flashdata('search_ward', $ward_id);
					$redirect_url = $this->routes_model->_Get_Search_URL('ward', $category_id, $ward_id, $district_id);
					$redirect_url = $redirect_url;
				}
                //Nếu post district
				elseif($district_id != -1) {
					$this->session->set_flashdata('search_district', $district_id);
					$redirect_url = $this->routes_model->_Get_Search_URL('district', $category_id, $district_id);
				}
                //Nếu post city
				elseif($city_id != -1) {
					$this->session->set_flashdata('search_city', $city_id);
					$redirect_url = $this->routes_model->_Get_Search_URL('city', $category_id, $city_id);
				}
				
				if($area!=-1 || $price!=-1) $flag = true;
				else $flag = false;
				
				//Nếu post area
				if($flag=== true)
                $redirect_url .= '/p'.$price.'/a'.$area;
				
			}
		}
        
        redirect($redirect_url);
    }
    
    /**
    * Do Search
    * URL : domain.com/[any]/1/2/3/4
    * 1: Area
    * 2: Price
    * 3: Bedroom
    * 4: Project
    */
    function search() {
        
        $area_maxmin = array(
            0 => array(
                'min' => 0,
                'max' => 0
            ),
            1 => array(
                'min' => 0,
                'max' => 20
            ),
            2 => array(
                'min' => 20,
                'max' => 30
            ),
            3 => array(
                'min' => 30,
                'max' => 50
            ),
            4 => array(
                'min' => 50,
                'max' => 60
            ),
            5 => array(
                'min' => 60,
                'max' => 70
            ),
            6 => array(
                'min' => 70,
                'max' => 80
            ),
            7 => array(
                'min' => 80,
                'max' => 90
            ),
            8 => array(
                'min' => 90,
                'max' => 100
            ),
            9 => array(
                'min' => 100,
                'max' => 50000
            )
        );
        
        $price_maxmin = array(
            0 => array(
                'min' => 0,
                'max' => 0,
                'unit' => 0
            ),
            1 => array(
                'min' => 0,
                'max' => 1,
                'unit' => 2
            ),
            2 => array(
                'min' => 1,
                'max' => 2,
                'unit' => 2
            ),
            3 => array(
                'min' => 2,
                'max' => 3,
                'unit' => 2
            ),
            4 => array(
                'min' => 3,
                'max' => 5,
                'unit' => 2
            ),
            5 => array(
                'min' => 5,
                'max' => 7,
                'unit' => 2
            ),
            6 => array(
                'min' => 7,
                'max' => 10,
                'unit' => 2
            ),
            7 => array(
                'min' => 10,
                'max' => 15,
                'unit' => 2
            ),
            8 => array(
                'min' => 15,
                'max' => 100,
                'unit' => 2
            )
        );
        
        $key = $this->uri->segment(1);
        
        $route = $this->routes_model->_Get_Key($key);
        $router_temp = $route;
        if($this->uri->segment(2) == 'p') {
            $url_path = $this->uri->segment(1);
        } else {
            $url_path = $_SERVER['REQUEST_URI'];
            $url_path = substr($url_path, 1, strlen($url_path)-1);
            $url_path = str_replace(".htm", "", $url_path);
        }
        $seo_meta = $this->main_model->_Get_Seo_Url($url_path);
        //echo $url_path;
        if(empty($route)) {
            $temp = explode("-", $key);
            $district_id = array_pop($temp);
            unset($temp[count($temp)]);
            $key = implode("-", $temp);
            $route = $this->routes_model->_Get_Key($key);
            if($route['search_level']=='ward') $ward_id = $district_id;
            if($route['search_level'] == 'district') $district_id = $district_id;
        } 
        //print_r($route);
        if(empty($route)) {
            $this->error404();
            //exit;   
        }
        
        $category_id = $route['category_id'];
		$district_id = $route['district_id'];
		
        if($category_id) {
            $category = $this->main_model->_Get_Real_Estate_Category_By_Id($category_id);
            //$this->breadcrumb->append_crumb($category['title'], site_url($category['alias']));
        }
        $street = $this->main_model->_Get_Street_By_Id($route['street_id']);
        //print_r($route);
        
        $this->data['show_tag_link'] = false;
        
        if($route['search_level'] == 'project') {
            //print_r($route);
            $project_id = $route['project_id'];
            $project = $this->main_model->_Get_Project_By_Id($project_id);
            
            unset($route['ward_id']);
            
            $city = $this->main_model->_Get_City_By_Id($project['city_id']);
            $district = $this->main_model->_Get_District_By_Id($project['district_id']);
            $heading_title = $category['title'].' '.$project['title'];
            $link_title = $category['title'].' '.$project['title'];
            
            $wards = $this->main_model->_Get_District($city['id']);
            foreach($wards as $item) {
                $router_temp['district_id'] = $item['id'];
                $count_real = $this->main_model->_Count_Real_Estate($router_temp);
                $this->data['list_category'][] = array(
                    'title' => $category['title'] . ' ' . $item['title'],
                    'alias' => $category['alias'] . '-' . $item['alias'],
                    'total' => $count_real
                );
            }
            
            $this->data['show_tag_link'] = true;
        }
        
        //Search level street
        if($route['search_level'] == 'street') {
            
            $district = $this->main_model->_Get_District_By_Id($district_id);
            $city = $this->main_model->_Get_City_By_Id($district['city_id']);
            $route['city_id'] = $city['id'];
            //Only index Go Vap
            if($district['id'] != 16) $this->template->_Set_Data('noindex', true);
            //end Only index Go vap
            $route['district_id'] = $district['id'];
            if($city) {
                $this->breadcrumb->append_crumb($category['title'].' '.$city['title'], site_url($category['alias'].'-'.$city['alias']));
            }
            if($district) {
                $this->breadcrumb->append_crumb($category['title'].' '.$district['title'], site_url($category['alias'].'-'.$district['alias']));
            }
            if($street){
                $this->breadcrumb->append_crumb($category['title'].' đường '.$street['title'], site_url($category['alias'].'-'.$street['alias']));    
            }
            
            $heading_title = $category['title'].' đường '.$street['title'].', '.$district['title'];
            $link_title = $category['title'].' đường '.$street['title'];
            
            if($category_id == 1) {
                $description = 'Cho thuê mướn nhà trọ, phòng trọ tại đường '.trim($street['title']).', '.$district['title'].': với các loại diện tích, giá cho thuê, địa điểm khác nhau dành cho sinh viên, nhân viên văn phòng, công nhân viên.';
            } elseif($category_id == 2) {
                $description = 'Cho thuê mướn nhà tại đường '.trim($street['title']).', '.$district['title'].': với các loại diện tích, giá cho thuê, địa điểm khác nhau cho sinh viên, nhân viên văn phòng  an ninh, giá rẻ uy tín nhất.';
            } elseif($category_id == 3) {
                $description = 'Cho thuê mướn căn hộ chung cư tại đường '.trim($street['title']).', '.trim($district['title']).' với các loại diện tích, giá cho thuê, địa điểm khác nhau cho sinh viên, nhân viên văn phòng  an ninh, giá rẻ uy tín nhất.';
            } elseif($category_id == 4) {
                $description = 'Cho thuê mướn văn phòng mặt bằng tại đường '.trim($street['title']).', '.trim($district['title']).': với các loại diện tích, giá cho thuê, địa điểm khác nhau cho sinh viên, nhân viên văn phòng  an ninh, giá rẻ uy tín nhất.';
            } elseif($category_id == 5) {
                $description = 'Tìm người ở ghép, tìm nam ở ghép, tìm nữ ở ghép tại đường '.trim($street['title']).', '.trim($district['title']).': share phòng trọ, tìm chỗ ở ghép cùng, tìm bạn ở ghép, xin ở ghép. Đăng tin ở ghép hiệu quả, nhanh chóng nhất đường '.$street['title'];    
            }
            
            $wards = $this->main_model->_Get_District($city['id']);
            foreach($wards as $item) {
                unset($router_temp['ward_id']);
                unset($router_temp['street_id']);
                $router_temp['district_id'] = $item['id'];
                $count_real = $this->main_model->_Count_Real_Estate($router_temp);
                $this->data['list_category'][] = array(
                    'title' => $category['title'] . ' ' . $item['title'],
                    'alias' => $category['alias'] . '-' . $item['alias'],
                    'total' => $count_real
                );
            }
            //$this->data['list_link_location'] = $this->main_model->_Get_Link_By_Location(array('category_id' => $category['id'], 'street_id'=>$street['id'], 'ward_id'=>$ward['id'], 'district_id' => $district['id'], 'city_id' => $city['id']));
            $this->data['title_list_category'] = $category['title'] .' theo quận tại ' . $city['title'];
            $this->data['show_tag_link'] = true;
        }
        if($route['search_level'] == 'ward') {
            $ward_id = $route['ward_id'];
            $ward = $this->main_model->_Get_Ward_By_Id($ward_id);
            $district = $this->main_model->_Get_District_By_Id($ward['district_id']);
            $city = $this->main_model->_Get_City_By_Id($district['city_id']);
            $route['city_id'] = $city['id'];
            $route['district_id'] = $district['id'];
            $route['ward_id'] = $ward['id'];
            //Only index Go Vap
            if($district['id'] != 16) $this->template->_Set_Data('noindex', true);
            //end Only index Go vap
            if($city) {
                $this->breadcrumb->append_crumb($category['title'].' '.$city['title'], site_url($category['alias'].'-'.$city['alias']));
            }
            if($district) {
                $this->breadcrumb->append_crumb($category['title'].' '.$district['title'], site_url($category['alias'].'-'.$district['alias']));
            }
            if($ward) {
                $this->breadcrumb->append_crumb($category['title'].' phường '.$ward['title'], '#');
            }
            $heading_title = $category['title'].' phường '.$ward['title'].', '.$district['title'];
            $link_title = $category['title'].' phường '.$ward['title'];
            
            if($category_id == 1) {
                $description = 'Cho thuê mướn nhà trọ, phòng trọ tại phường '.trim($ward['title']).', '.$district['title'].': với các loại diện tích, giá cho thuê, địa điểm khác nhau dành cho sinh viên, nhân viên văn phòng, công nhân viên.';
            } elseif($category_id == 2) {
                $description = 'Cho thuê mướn nhà tại phường '.trim($ward['title']).', '.$district['title'].' Hồ Chí Minh: với các loại diện tích, giá cho thuê, địa điểm khác nhau cho sinh viên, nhân viên văn phòng  an ninh, giá rẻ uy tín nhất.';
            } elseif($category_id == 3) {
                $description = 'Cho thuê mướn căn hộ chung cư tại phường '.trim($ward['title']).', '.$district['title'].', Hồ Chí Minh: với các loại diện tích, giá cho thuê, địa điểm khác nhau cho sinh viên, nhân viên văn phòng  an ninh, giá rẻ uy tín nhất.';
            } elseif($category_id == 4) {
                $description = 'Cho thuê mướn văn phòng mặt bằng tại phường '.trim($ward['title']).', '.$district['title'].': với các loại diện tích, giá cho thuê, địa điểm khác nhau cho sinh viên, nhân viên văn phòng  an ninh, giá rẻ uy tín nhất.';
            } elseif($category_id == 5) {
                $description = 'Tìm người ở ghép, tìm nam ở ghép, tìm nữ ở ghép tại Phường '.trim($ward['title']).', '.$district['title'].': share phòng trọ, tìm chỗ ở ghép cùng, tìm bạn ở ghép, xin ở ghép. Đăng tin ở ghép hiệu quả, nhanh chóng nhất phường '.$ward['title'];
            } 
            
            $districts = $this->main_model->_Get_District($district['city_id']);
            foreach($districts as $ward_item) {
                unset($router_temp['ward_id']);
                $router_temp['district_id'] = $ward_item['id'];
                $count_real = $this->main_model->_Count_Real_Estate($router_temp);
                $this->data['list_category'][] = array(
                    'title' => isset($category) ? $category['title'].' '.$ward_item['title'] : $ward_item['title'],
                    'alias' => $category['alias'] . '-' . $ward_item['alias'],
                    'total' => $count_real
                );
            }
            //$this->data['list_link_location'] = $this->main_model->_Get_Link_By_Location(array('category_id' => $category['id'], 'ward_id'=>$ward['id'], 'district_id' => $district['id'], 'city_id' => $city['id']));
            $this->data['title_list_category'] = $category['title'] .' theo quận tại ' . $city['title'];
            $this->data['show_tag_link'] = true;
        }
        if($route['search_level'] == 'district') {
            $district_id = $route['district_id'];
            $district = $this->main_model->_Get_District_By_Id($district_id);
            $city = $this->main_model->_Get_City_By_Id($district['city_id']);
            //Only index Go Vap
            if($district['id'] != 16) $this->template->_Set_Data('noindex', true);
            //end Only index Go vap
            if($city) {
                $this->breadcrumb->append_crumb($category['title'].' '.$city['title'], site_url($category['alias'].'-'.$city['alias']));
            }
            if($district) {
                $this->breadcrumb->append_crumb($category['title'].' '.$district['title'], '#');
            }
            $heading_title = $category['title'].' '.$district['title'].' '.$city['title'];
            $link_title = $category['title'].' '.$district['title'];
            $this->data['show_tag_link'] = true;
            
            if($category_id == 1) {
                $description = 'Cho thuê mướn phòng trọ sinh viên, thuê nhà trọ sinh viên, nhân viên văn phòng, giá rẻ, phòng rộng, đẹp, thoáng mát, điện nước đầy đủ, an ninh đảm bảo tại '.$district['title'].' TP.HCM';
            } elseif($category_id == 2) {
                $description = 'Cho thuê mướn nhà tại '.$district['title'].': với các loại diện tích, giá cho thuê, địa điểm khác nhau cho sinh viên, nhân viên văn phòng  an ninh, giá rẻ uy tín nhất.';
            } elseif($category_id == 3) {
                $description = 'Cho thuê mướn căn hộ chung cư tại '.$district['title'].' với các loại diện tích, giá cho thuê, địa điểm khác nhau cho sinh viên, nhân viên văn phòng  an ninh, giá rẻ uy tín nhất.';
            } elseif($category_id == 4) {
                $description = 'Cho thuê mướn văn phòng mặt bằng tại '.$district['title'].': với các loại diện tích, giá cho thuê, địa điểm khác nhau cho công ty, cá nhân, nhân viên văn phòng  an ninh, giá rẻ uy tín nhất.';
            } elseif($category_id == 5) {
                $description = 'Tìm người ở ghép, tìm nam ở ghép, tìm nữ ở ghép tại '.$district['title'].': share phòng trọ, tìm chỗ ở ghép cùng, tìm bạn ở ghép, xin ở ghép giá rẻ, an ninh, an toàn nhất.';
            } 
            $districts = $this->main_model->_Get_District($route['city_id']);
            foreach($districts as $row) {
                $router_temp['district_id'] = $row['id'];
                $count_real = $this->main_model->_Count_Real_Estate($router_temp);
                $this->data['list_category'][] = array(
                    'title' => isset($category) ? $category['title'].' '.$row['title'] : $row['title'],
                    'alias' => $category['alias'] . '-' . $row['alias'],
                    'total' => $count_real
                );
            }
            //$this->data['list_link_location'] = $this->main_model->_Get_Link_By_Location(array('category_id' => $category['id'], 'district_id'=>$district['id'], 'city_id' => $city['id']));
			//print_r($this->data['list_link_location']);
            $this->data['title_list_category'] = $category['title'] .' theo quận tại ' . $city['title'];
        }
        if($route['search_level'] == 'city') {
            $city = $this->main_model->_Get_City_By_Id($route['city_id']);
            if($city) {
                $this->breadcrumb->append_crumb($category['title'].' '.$city['title'], site_url($category['alias'].'-'.$city['alias']));
            }
            
            //Only index Go Vap
            if($city['id'] != 16) $this->template->_Set_Data('noindex', true);
            //end Only index Go vap
            $heading_title = $category['title'].' '.$city['title'];
            $link_title = $category['title'].' '.$city['title'];
            
            if($category_id == 1) {
                $description = 'Cho thuê mướn phòng trọ sinh viên, thuê nhà trọ sinh viên, nhân viên văn phòng, giá rẻ, phòng rộng, đẹp, thoáng mát, điện nước đầy đủ, an ninh đảm bảo tại Tp.HCM.';
            } elseif($category_id == 2) {
                $description = 'Cho thuê mướn nhà nguyên căn, nhà riêng tại Tp.HCM với các loại diện tích, giá cho thuê, địa điểm khác nhau trên kênh thông tin số 1 về cho thuê mướn nhà đất Việt Nam.';
            } elseif($category_id == 3) {
                $description = 'Cho thuê mướn căn hộ chung cư tại Hồ Chí Minh: với các loại diện tích, giá cho thuê, địa điểm khác nhau cho sinh viên, nhân viên văn phòng  an ninh, giá rẻ uy tín nhất.';
            } elseif($category_id == 4) {
                $description = 'Cho thuê mướn văn phòng mặt bằng tại Hồ Chí Minh: với các loại diện tích, giá cho thuê, địa điểm khác nhau cho công ty, cá nhân, nhân viên văn phòng  an ninh, giá rẻ uy tín nhất.';
            } elseif($category_id == 5) {
                $description = 'Tìm người ở ghép, tìm nam ở ghép, tìm nữ ở ghép tại Hồ Chí Minh, share phòng trọ, tìm chỗ ở ghép cùng, tìm bạn ở ghép, xin ở ghép giá rẻ, an ninh, an toàn nhất.';
            } 
            $districts = $this->main_model->_Get_District($route['city_id']);
            foreach($districts as $district) {
                $router_temp['district_id'] = $district['id'];
                $count_real = $this->main_model->_Count_Real_Estate($router_temp);
                $this->data['list_category'][] = array(
                    'title' => isset($category) ? $category['title'].' '.$district['title']:$district['title'],
                    'alias' => $category['alias'] . '-' . $district['alias'],
                    'total' => $count_real
                );
            }
            //$this->data['list_link_location'] = $this->main_model->_Get_Link_By_Location(array('category_id' => $category['id'], 'city_id'=>$city['id']));
            $this->data['title_list_category'] = $category['title'] .' theo quận tại ' . $city['title'];
        }
        
        $this->data['search_param'] = $route;
        $title_ext = '';
        
        //Filter price
        if($this->uri->segment(2) && $this->uri->segment(2)!='-1' && $this->uri->segment(2) != 'p') {
            $price = (int)str_replace('p','',$this->uri->segment(2));
            $route['filter_price'] = $price_maxmin[$price];
			$this->data['search_param']['filter_price'] = $price;
			
           if(!$seo_meta) {
                if($this->data['search_param']['filter_price'] == 0) $title_ext .=  ', Giá Thỏa thuận';
               elseif($this->data['search_param']['filter_price'] == 1) $title_ext .= ', Giá dưới 1 triệu';
               elseif($this->data['search_param']['filter_price'] == 2) $title_ext .=  ', Giá 1 - 2 triệu';
               elseif($this->data['search_param']['filter_price'] == 3) $title_ext .=  ', Giá 2 - 3 triệu';
               elseif($this->data['search_param']['filter_price'] == 4) $title_ext .=  ', Giá 3 - 5 triệu';
               elseif($this->data['search_param']['filter_price'] == 5) $title_ext .=  ', Giá 5 - 7 triệu';
               elseif($this->data['search_param']['filter_price'] == 6) $title_ext .=  ', Giá 7 - 10 triệu';
               elseif($this->data['search_param']['filter_price'] == 7) $title_ext .=  ', Giá 10 - 15 triệu';
               elseif($this->data['search_param']['filter_price'] == 8) $title_ext .=  ', Giá trên 15 triệu';
           }
            
		   if($this->uri->segment(4) == 'p') $page = (int)$this->uri->segment(5);
           else $page = 1;		
        } else {
            $this->data['search_param']['filter_price'] = -1;
        }
        
        //Filter area
        if($this->uri->segment(3) && $this->uri->segment(3)!='-1' && $this->uri->segment(2) != 'p') {
            $area = (int)str_replace('a','',$this->uri->segment(3));
            $route['filter_area'] = $area_maxmin[$area];
			$this->data['search_param']['filter_area'] = $area;
			
            if(!$seo_meta) {
                if($this->data['search_param']['filter_area'] == 0) $title_ext = ' Diện tích Không xác định';
               elseif($this->data['search_param']['filter_area'] == 1) $title_ext = ', Diện tích dưới 20m2';
               elseif($this->data['search_param']['filter_area'] == 2) $title_ext =  ', Diện tích 20 - 30m2';
               elseif($this->data['search_param']['filter_area'] == 3) $title_ext =  ', Diện tích 30 - 50m2';
               elseif($this->data['search_param']['filter_area'] == 4) $title_ext =  ', Diện tích 50 - 60m2';
               elseif($this->data['search_param']['filter_area'] == 5) $title_ext =  ', Diện tích 60 - 70m2';
               elseif($this->data['search_param']['filter_area'] == 6) $title_ext =  ', Diện tích 70 - 80m2';
               elseif($this->data['search_param']['filter_area'] == 7) $title_ext =  ', Diện tích 80 - 90m2';
               elseif($this->data['search_param']['filter_area'] == 8) $title_ext =  ', Diện tích 90 - 100m2';
               elseif($this->data['search_param']['filter_area'] == 9) $title_ext =  ', Diện tích trên 100m2';
            }
           
           if($this->uri->segment(4) == 'p') $page = (int)$this->uri->segment(5);
           else $page = 1;
           
        } else {
            $this->data['search_param']['filter_area'] = -1;
        }
        
        //Filter bedroom
        if($this->uri->segment(4) && $this->uri->segment(4)!='-1') {
            $route['sophongngu'] = (int)$this->uri->segment(4);
			$this->data['search_param']['filter_bedroom'] = $this->uri->segment(4);
			if($this->data['search_param']['filter_bedroom'] == 1) $title_ext .= ', 1 phòng ngủ';
            elseif($this->data['search_param']['filter_bedroom'] ==2) $title_ext .= ', 2 phòng ngủ';
            elseif($this->data['search_param']['filter_bedroom'] == 3) $title_ext .= ', 3 phòng ngủ';
            elseif($this->data['search_param']['filter_bedroom'] == 4) $title_ext .= ', 4 phòng ngủ';
            elseif($this->data['search_param']['filter_bedroom'] == 5) $title_ext .= ', 5 phòng ngủ';
        } else {
            $this->data['search_param']['filter_bedroom'] = -1;
        }
        
        if($this->uri->segment(5) && $this->uri->segment(5)!='-1') {
            $route['project_id'] = (int)$this->uri->segment(5);
			$this->data['search_param']['filter_project'] = $this->uri->segment(5);
        } else {
            $this->data['search_param']['filter_project'] = -1;
        }
        
        if($this->input->cookie('order_by')) {
            
        }
        
        if($this->uri->segment(2) == 'p' && $this->uri->segment(3)) {
            $page = (int)$this->uri->segment(3);
        } else {
            $page = 1;
        }
        
        //$heading_title = $this->main_model->_Create_Search_Title($route);
        
        $street = $this->main_model->_Get_Street_By_Id($route['street_id']);
        $ward = $this->main_model->_Get_Ward_By_Id($route['ward_id']);
        $district = $this->main_model->_Get_District_By_Id($route['district_id']);
        
        //print_r($district);
        if($route['street_id'] > 0) {
            unset($route['ward_id']);
            if(!empty($ward)) $title_ward = ', Phường '.$ward['title'];
            else $title_ward = '';
            if(!empty($street)) {
                $address = $ward['title'] .' ' . $district['title'].' '.$city['title'];
                $sub_address = 'Quận/huyện: <span>'.$district['title'] . '</span> - Tỉnh/TP: <span>' . $city['title'].'.</span>';
                $google_map = 'Đường '.$street['title'].$title_ward. ', '.$district['title'] . ', ' . $city['title'];
            } else {
                $address = $ward['title'] .' ' . $district['title'].' '.$city['title'];
                $sub_address = 'Phường: '.$ward['title'].' Quận/huyện: '.$district['title'] . ' Tỉnh/TP: ' . $city['title'];
                $google_map = 'Đường '.$street['title'].$title_ward. ', '.$district['title'] . ', ' . $city['title'];
            }
        }
        
        if($route['ward_id'] > 0 && $route['street_id'] == 0) {
            if(!empty($ward)) {
                $address = $district['title'].' '.$city['title'];
                $sub_address = 'Quận/huyện: <span>'.$district['title'] . '</span> - Tỉnh/TP: <span>' . $city['title'].'</span>';
                $google_map = 'Phường '.trim($ward['title']).', '.$district['title'] . ', ' . $city['title'];
            } else {
                $address = $district['title'].' '.$city['title'];
                $sub_address = 'Phường: <span>'.$ward['title'].'.</span> Quận/huyện: <span>'.$district['title'] . '.</span> Tỉnh/TP: <span>' . $city['title'].'</span>';
                $google_map = 'Phường '.trim($ward['title']).', '.$district['title'] . ', ' . $city['title'];
            }
            
        }
        if($route['district_id'] > 0 && $route['ward_id'] == 0 && $route['street_id'] == 0) {
            if(!empty($district) && $route['search_level'] == 'district') {
                $address = $district['title'].' '.$city['title'];
                $sub_address = 'Tỉnh/TP: <span>' . $city['title'].'.</span>';
                $google_map = $district['title'].', '.$city['title'];
            } else {
                $address = $district['title'].' '.$city['title'];
                $sub_address = $city['title'];
                $google_map = $district['title'].' '.$city['title'];
            }
			
        }
        if($route['city_id'] > 0 && $route['district_id'] == 0 && $route['ward_id'] == 0 && $route['street_id'] == 0) {
            $sub_address = 'Việt Nam';
            if(!empty($city)) {
                $google_map = $city['title'].', Việt Nam.';
            } else{
                $address = 'Việt Nam';
                $google_map = 'Việt Nam';
            }
        }
		
		if($this->input->post()) {
            
            $order_by = $this->input->post('order_by');
        
            if($order_by == 'time_desc') {
                $order_by = 'create_time';
                $sort = 'DESC';
                
            } elseif($order_by == 'price_desc') {
                $order_by = 'price';
                $sort = 'DESC';
            } elseif($order_by == 'price_asc') {
                $order_by = 'price';
                $sort = 'ASC';
            } else {
                $order_by = '';
                $sort = '';
                $this->data['order_by'] = '1';
            }
            
            $this->session->set_userdata('order_by', $order_by);
            $this->session->set_userdata('sort', $sort);
        } 
        $order_by = $this->session->userdata('order_by');
        $sort = $this->session->userdata('sort');
		
        if($order_by == 'create_time')
            $this->data['order_by'] = 'time_desc';
        else
            $this->data['order_by'] = $order_by.'_'.$sort;
		
        $this->data['category_tags'] = $this->main_model->_Get_Category_Tags($route);
        $this->data['address'] = isset($address) ? $address : '';
        $this->data['sub_address'] = $sub_address;
        $this->data['google_map'] = $google_map;
        $this->data['link_title'] = $link_title;
        //pagination
        $base_url = base_url($key.'/p');
        $per_page = 20;
        $total_row = $this->main_model->_Count_Search_Real_Estate($route);
        $this->data['pagination'] = pagination($base_url, $total_row, $per_page, $page);
        
        $this->data['heading_title'] = $heading_title;
        $this->data['total_result'] = $total_row;
        $this->data['results'] = $this->main_model->_Search_Real_Estate($route, $per_page, ($page-1)*$per_page);
        
        $search_param = $route;
        $filter_params = $route;
        
        //List danh sách tin theo khu vuc
        $districts = $this->main_model->_Get_District($route['city_id']);
        /*foreach($districts as $district) {
            $this->data['list_category'][] = array(
                'title' => $category['title'] . ' ' . $district['title'],
                'alias' => $category['alias'] . '-' . $district['alias']
            );
        }*/
        
        //Goi y them 10 tin
        $search_level = $route['search_level'];
        if(count($this->data['results']) < 10 && $search_level != 'city') {
            $ignore_list = array();
            foreach($this->data['results'] as $item) $ignore_list[] = $item['id'];
            if(!empty($ignore_list))
                $route['ignore'] = $ignore_list;
            if($search_level == 'street') {
                unset($route['street_id']);
            $this->data['results2'] = $this->main_model->_Search_Real_Estate($route, 10, 0);
            } elseif($search_level == 'ward') {
                unset($route['ward_id']);
            $this->data['results2'] = $this->main_model->_Search_Real_Estate($route, 10, 0);
            } elseif($search_level == 'district') {
                unset($route['district_id']);
                $this->data['results2'] = $this->main_model->_Search_Real_Estate($route, 10, 0);
            }
        }
        
        if($seo_meta && $seo_meta['title'] != '') {
            if($page > 1)
				$title = $seo_meta['title'] . $title_ext . ' - Trang ' . $page . ' | Muonnha.com.vn';
            else
				$title = $seo_meta['title'] . $title_ext . ' | Muonnha.com.vn';
        } else {
            if($page > 1)
				$title = $heading_title . $title_ext . ' - Trang '.$page . ' | Muonnha.com.vn';
            else 
				$title = $heading_title . $title_ext . ' | Muonnha.com.vn';
        }
        if($seo_meta && $seo_meta['keyword'] != '') {
            $keywords = $seo_meta['keyword'];
        } else {
            $keywords = $heading_title. $title_ext;
        }
        if($seo_meta && $seo_meta['description'] != '') {
            if($page > 1)
                $description = $seo_meta['description'].' - Trang ' . $page;
            else
                $description = $seo_meta['description'];
        } 
            $config=array(
                'title' => $title,
    			'keywords' => $keywords,
    			'description' => $description
            );
			$this->data['zoom'] = 12;
        $this->data['hidden_content'] = $description;
		$this->data['cur_page'] = 'category';
        unset($search_param['ward_id']);
        unset($search_param['street_id']);
        $this->data['category_content'] = $this->main_model->_Get_Footer_Content($search_param);
        
        //Lien ket noi bat theo khu vuc
        if($route['street_id'] == 0 && $route['ward_id'] > 0) $filter_params['ward_id'] = $route['ward_id'];
        else if($route['street_id'] > 0 ) $filter_params['street_id'] = $route['street_id'];
        $real_estate_links = $this->main_model->_Get_Real_Estate_Links($filter_params, 0);
        
        if($real_estate_links!='') {
            $idlinks = explode(",",$real_estate_links);
            $this->data['list_link_location'] = $this->main_model->_Get_Footer_Link_Where_In($idlinks);
        }
        
        $most_search_links = $this->main_model->_Get_Most_Search_Links($filter_params);
        if($most_search_links!='') {
            $idlinks = explode(",",$most_search_links);
            $this->data['list_most_search_link'] = $this->main_model->_Get_Footer_Link_Where_In($idlinks);
        }
        
        //$this->template->_Set_Default_Layout('layout_category');
        $this->template->_Set_Config($config);
        $this->template->_Set_View('estate/category/list', $this->data);
        $this->template->_Render();
        
    }
    
	function search_text($string) {
		if($this->uri->segment(2) == 'p' && $this->uri->segment(3)) {
            $page = (int)$this->uri->segment(3);
        } else {
            $page = 1;
        }
		$per_page = 20;
		$string = $this->input->get('s');
		$sql = "SELECT *,MATCH( title ) AGAINST ('".$string."') as relevance FROM `bds_real_estates` 
		WHERE MATCH( title ) AGAINST ('".$string."' IN NATURAL LANGUAGE MODE ) 
		HAVING relevance > 0.1 
		ORDER BY relevance DESC LIMIT ".($page-1)*20 .",".$per_page;
		$sql_count = "SELECT id, MATCH( title ) AGAINST ('".$string."') as relevance FROM `bds_real_estates` 
		WHERE MATCH( title ) AGAINST ('".$string."' IN NATURAL LANGUAGE MODE ) 
		HAVING relevance > 0.1";
		
		$this->load->database();
		$results = $this->db->query($sql)->result_array();
		$result_total = $this->db->query($sql_count)->num_rows();
		$this->data['cur_page'] = 'category';
		$this->data['results'] = $results;
		$this->data['total_result'] = $result_total;
		$base_url = base_url('tim-kiem/p');
        
		
        $this->data['pagination'] = pagination($base_url, $result_total, $per_page, $page);
        //$this->template->_Set_Default_Layout('layout_category');
		$this->template->_Set_Data('noindex', true);
		$this->template->_Set_View('estate/category/list', $this->data);
        $this->template->_Render();
	}
	
    /**
    * Danh mục tin đăng
    */
    function category($id, $page=1) {
        $category = $this->main_model->_Get_Real_Estate_Category_By_Id($id);
        //$order_by = '';
        //$sort = '';
        $route = $this->routes_model->_Get_Key($this->uri->segment(1));
        $route['category_id'] = $route['value'];
        $this->data['search_param'] = $route;
        
        if($category['parent_id']>0){
            $list_category = $this->main_model->_Get_Real_Estate_Category($category['parent_id']);
        } else {
            $list_category = $this->main_model->_Get_Real_Estate_Category(0);
        }
        
        $this->data['list_category'] = $list_category;
        
        $this->data['list_link_location'] = $this->main_model->_Get_Link_By_Location(array('category_id' => $id));
        
        if($this->input->post()) {
            
            $order_by = $this->input->post('order_by');
        
            if($order_by == 'time_desc') {
                $order_by = 'create_time';
                $sort = 'DESC';
                
            } elseif($order_by == 'price_desc') {
                $order_by = 'price';
                $sort = 'DESC';
            } elseif($order_by == 'price_asc') {
                $order_by = 'price';
                $sort = 'ASC';
            } else {
                $order_by = '';
                $sort = '';
                $this->data['order_by'] = '1';
            }
            
            $this->session->set_userdata('order_by', $order_by);
            $this->session->set_userdata('sort', $sort);
        } 
        $order_by = $this->session->userdata('order_by');
        $sort = $this->session->userdata('sort');
		
        if($order_by == 'create_time')
            $this->data['order_by'] = 'time_desc';
        else
            $this->data['order_by'] = $order_by.'_'.$sort;
        
        
        //pagination
        $base_url = base_url($category['alias'].'/p');
        $per_page = 20;
        $total_row = $this->main_model->_Count_Real_Estate_By_Category($id);
        if(USERTYPE == 'Mobile'){
            $this->data['pagination'] = mpagination($base_url, $total_row, $per_page, $page);
        } else {
            $this->data['pagination'] = pagination($base_url, $total_row, $per_page, $page);
        }
        
        $this->data['heading_title'] = $category['title'] . ' tại Việt Nam';
        $this->data['link_title'] = $category['title'];
        $this->data['total_result'] = $total_row;
        $this->data['results'] = $this->main_model->_Get_Real_Estate_By_Category($id, $per_page, ($page-1)*$per_page, $order_by, $sort);
        $this->data['sub_address'] = 'tại Việt Nam.';
        $this->data['google_map'] = 'Việt Nam';
        $this->data['zoom'] = 5;
        //$results = $this->main_model->_Search_Real_Estate($route);
        $this->data['search_param'] = $route;
        $title_ext = '';
        if($this->uri->segment(2) && $this->uri->segment(2)!='-1' && $this->uri->segment(2)!='p') {
            $route['filter_area'] = $area_maxmin[(int)$this->uri->segment(2)];
			$this->data['search_param']['filter_area'] = $this->uri->segment(2);
			if($this->data['search_param']['filter_area'] == 0) $title_ext = ' Diện tích Không xác định';
                                  elseif($this->data['search_param']['filter_area'] == 1) $title_ext = ', Diện tích <=30m2';
                                    elseif($this->data['search_param']['filter_area'] == 2) $title_ext =  ', Diện tích 30 - 50m2';
                                    elseif($this->data['search_param']['filter_area'] == 3) $title_ext =  ', Diện tích 50 - 80m2';
                                    elseif($this->data['search_param']['filter_area'] == 4) $title_ext =  ', Diện tích 80 - 100m2';
                                    elseif($this->data['search_param']['filter_area'] == 5) $title_ext =  ', Diện tích 100 - 150m2';
                                    elseif($this->data['search_param']['filter_area'] == 6) $title_ext =  ', Diện tích 150 - 200m2';
                                    elseif($this->data['search_param']['filter_area'] == 7) $title_ext =  ', Diện tích 200 - 250m2';
                                    elseif($this->data['search_param']['filter_area'] == 8) $title_ext =  ', Diện tích 250 - 300m2';
                                    elseif($this->data['search_param']['filter_area'] == 9) $title_ext =  ', Diện tích 300 - 500m2';
                                    elseif($this->data['search_param']['filter_area'] == 10) $title_ext =  ', Diện tích >= 500m2';
        } else {
            $this->data['search_param']['filter_area'] = -1;
        }
        if($this->uri->segment(3) && $this->uri->segment(3)!='-1' && $this->uri->segment(2)!='p') {
            $route['filter_price'] = $price_maxmin[(int)$this->uri->segment(3)];
			$this->data['search_param']['filter_price'] = $this->uri->segment(3);
			if($this->data['search_param']['filter_price'] == 0) $title_ext .=  ', Giá Thỏa thuận';
                                    elseif($this->data['search_param']['filter_price'] == 1) $title_ext .= ', Giá <=500 triệu';
                                    elseif($this->data['search_param']['filter_price'] == 2) $title_ext .=  ', Giá 500 - 800 triệu';
                                    elseif($this->data['search_param']['filter_price'] == 3) $title_ext .=  ', Giá 800 - 1 tỷ';
                                    elseif($this->data['search_param']['filter_price'] == 4) $title_ext .=  ', Giá 1 - 2 tỷ';
                                    elseif($this->data['search_param']['filter_price'] == 5) $title_ext .=  ', Giá 2 - 3 tỷ';
                                    elseif($this->data['search_param']['filter_price'] == 6) $title_ext .=  ', Giá 3 - 5 tỷ';
                                    elseif($this->data['search_param']['filter_price'] == 7) $title_ext .=  ', Giá 5 - 7 tỷ';
                                    elseif($this->data['search_param']['filter_price'] == 8) $title_ext .=  ', Giá 7 - 10 tỷ';
                                    elseif($this->data['search_param']['filter_price'] == 9) $title_ext .=  ', Giá 10 - 20 tỷ';
                                    elseif($this->data['search_param']['filter_price'] == 10) $title_ext .=  ', Giá 20 - 30 tỷ';
                                    elseif($this->data['search_param']['filter_price'] == 11) $title_ext .=  ', Giá >= 30 tỷ';
        } else {
            $this->data['search_param']['filter_price'] = -1;
        }
        if($this->uri->segment(4) && $this->uri->segment(4)!='-1') {
            $route['sophongngu'] = (int)$this->uri->segment(4);
			$this->data['search_param']['filter_bedroom'] = $this->uri->segment(4);
			if($this->data['search_param']['filter_bedroom'] == 1) $title_ext .= ', 1 phòng ngủ';
                                    elseif($this->data['search_param']['filter_bedroom'] ==2) $title_ext .= ', 2 phòng ngủ';
                                    elseif($this->data['search_param']['filter_bedroom'] == 3) $title_ext .= ', 3 phòng ngủ';
                                    elseif($this->data['search_param']['filter_bedroom'] == 4) $title_ext .= ', 4 phòng ngủ';
                                    elseif($this->data['search_param']['filter_bedroom'] == 5) $title_ext .= ', 5 phòng ngủ';
        } else {
            $this->data['search_param']['filter_bedroom'] = -1;
        }
        if($this->uri->segment(5) && $this->uri->segment(5)!='-1') {
            $route['project_id'] = (int)$this->uri->segment(5);
			$this->data['search_param']['filter_project'] = $this->uri->segment(5);
        } else {
            $this->data['search_param']['filter_project'] = -1;
        }
        
        $this->data['category_tags'] = $this->main_model->_Get_Category_Tags($route);
        
        $this->breadcrumb->append_crumb($category['title'], site_url($category['alias']));
        
        
        $seo_meta = $this->main_model->_Get_Seo_Url($this->uri->segment(1));
        if($seo_meta && $seo_meta['title'] != '') {
            $title = $seo_meta['title'] . ' | Muonnha.com.vn';
        } else {
            $title = $category['title'] . $title_ext .' tại Việt Nam | Muonnha.com.vn';
        }
        if($seo_meta && $seo_meta['keyword'] != '') {
            $keywords = $seo_meta['keyword'];
        } else {
            $keywords = $category['keywords']. $title_ext;
        }
        if($seo_meta && $seo_meta['description'] != '') {
            $description = $seo_meta['description'];
        } else {
            if($id == 1) //nha ban
                $description = 'Cho thuê mướn phòng trọ sinh viên, thuê nhà trọ sinh viên, nhân viên văn phòng, giá rẻ, phòng rộng, đẹp, thoáng mát, điện nước đầy đủ, an ninh đảm bảo tại Tp.HCM.';
           elseif($id == 2) // Ban nha rieng
                $description = 'Cho thuê mướn nhà nguyên căn, nhà riêng tại Tp.HCM với các loại diện tích, giá cho thuê, địa điểm khác nhau trên kênh thông tin số 1 về cho thuê mướn nhà đất Việt Nam.';
           elseif($id == 3) // ban biet thu lien ke
                $description = 'Cho thuê mướn căn hộ chung cư tại Hồ Chí Minh: với các loại diện tích, giá cho thuê, địa điểm khác nhau cho sinh viên, nhân viên văn phòng  an ninh, giá rẻ uy tín nhất.';
           elseif($id == 4) // ban nha mat pho
                $description = 'Cho thuê mướn văn phòng mặt bằng tại Hồ Chí Minh: với các loại diện tích, giá cho thuê, địa điểm khác nhau cho công ty, cá nhân, nhân viên văn phòng  an ninh, giá rẻ uy tín nhất.';
           elseif($id == 5) // dat ban
                $description = 'Tìm người ở ghép, tìm nam ở ghép, tìm nữ ở ghép tại Hồ Chí Minh, share phòng trọ, tìm chỗ ở ghép cùng, tìm bạn ở ghép, xin ở ghép giá rẻ, an ninh, an toàn nhất.';
            else $description = $category['description'];
        }
            $config=array(
                'title' => $title,
    			'keywords' => $keywords,
    			'description' => $description
            );
        
        /*
		$config = array(
			'title' => $category['title'].$title_ext.' tại Việt Nam | Muonnha.com.vn',
			'keywords' => $category['keywords'].$title_ext,
			'description' => $category['description'].$title_ext
		);*/
        if(empty($this->data['results'])) $this->template->_Set_Data('noindex', true);
		$this->data['hidden_content'] = $description;
        $this->data['show_tag_link'] = false;
        $this->data['cur_page'] = 'category';
        //$this->template->_Set_Default_Layout('layout_category');
        $this->template->_Set_Data('pageindex', false);
        $this->template->_Set_Config($config);
        $this->template->_Set_View('estate/category/list', $this->data);
        $this->template->_Render();
    }
    
    function category_project($category_id, $project_id, $page) {
        
        $area_maxmin = array(
            0 => array(
                'min' => 0,
                'max' => 0
            ),
            1 => array(
                'min' => 0,
                'max' => 20
            ),
            2 => array(
                'min' => 20,
                'max' => 30
            ),
            3 => array(
                'min' => 30,
                'max' => 50
            ),
            4 => array(
                'min' => 50,
                'max' => 60
            ),
            5 => array(
                'min' => 60,
                'max' => 70
            ),
            6 => array(
                'min' => 70,
                'max' => 80
            ),
            7 => array(
                'min' => 80,
                'max' => 90
            ),
            8 => array(
                'min' => 90,
                'max' => 100
            ),
            9 => array(
                'min' => 100,
                'max' => 50000
            )
        );
        
        $price_maxmin = array(
            0 => array(
                'min' => 0,
                'max' => 0,
                'unit' => 0
            ),
            1 => array(
                'min' => 0,
                'max' => 1,
                'unit' => 2
            ),
            2 => array(
                'min' => 1,
                'max' => 2,
                'unit' => 2
            ),
            3 => array(
                'min' => 2,
                'max' => 3,
                'unit' => 2
            ),
            4 => array(
                'min' => 3,
                'max' => 5,
                'unit' => 2
            ),
            5 => array(
                'min' => 5,
                'max' => 7,
                'unit' => 2
            ),
            6 => array(
                'min' => 7,
                'max' => 10,
                'unit' => 2
            ),
            7 => array(
                'min' => 10,
                'max' => 15,
                'unit' => 2
            ),
            8 => array(
                'min' => 15,
                'max' => 100,
                'unit' => 2
            )
        );
        
        
        
        $category = $this->main_model->_Get_Real_Estate_Category_By_Id($category_id);
        $project = $this->main_model->_Get_Project_By_Id($project_id);
        //$order_by = '';
        //$sort = '';
        $route = $this->routes_model->_Get_Key($this->uri->segment(1));
        $route_temp = $route;
        $route['category_id'] = $category_id;
        $route['project_id'] = $route['project_id'];
        $this->data['search_param'] = $route;
        $this->data['project'] = $project;
        if($category['parent_id']>0){
            $list_category = $this->main_model->_Get_Real_Estate_Category($category['parent_id']);
        } else {
            $list_category = $this->main_model->_Get_Real_Estate_Category(0);
        }
        
        $this->breadcrumb->append_crumb($category['title'].' Hồ Chí Minh', site_url($category['alias'].'-ho-chi-minh'));
        
        if($project['district_id']) {
            $district = $this->main_model->_Get_District_By_Id($project['district_id']);
            if($district) {
                $this->breadcrumb->append_crumb($category['title'].' '.$district['title'], site_url($category['alias'].'-'.$district['alias']));
            }
        }
        $this->breadcrumb->append_crumb($category['title'].' tại dự án '.$project['title'], '#');
        
        $this->data['list_link_location'] = $this->main_model->_Get_Link_By_Location(array('category_id' => $id));
        
        //Filter price
        if($this->uri->segment(2) && $this->uri->segment(2)!='-1' && $this->uri->segment(2) != 'p') {
            $price = (int)str_replace('p','',$this->uri->segment(2));
            $route['filter_price'] = $price_maxmin[$price];
			$this->data['search_param']['filter_price'] = $price;
			
           if(!$seo_meta) {
                if($this->data['search_param']['filter_price'] == 0) $title_ext .=  ', Giá Thỏa thuận';
               elseif($this->data['search_param']['filter_price'] == 1) $title_ext .= ', Giá dưới 1 triệu';
               elseif($this->data['search_param']['filter_price'] == 2) $title_ext .=  ', Giá 1 - 2 triệu';
               elseif($this->data['search_param']['filter_price'] == 3) $title_ext .=  ', Giá 2 - 3 triệu';
               elseif($this->data['search_param']['filter_price'] == 4) $title_ext .=  ', Giá 3 - 5 triệu';
               elseif($this->data['search_param']['filter_price'] == 5) $title_ext .=  ', Giá 5 - 7 triệu';
               elseif($this->data['search_param']['filter_price'] == 6) $title_ext .=  ', Giá 7 - 10 triệu';
               elseif($this->data['search_param']['filter_price'] == 7) $title_ext .=  ', Giá 10 - 15 triệu';
               elseif($this->data['search_param']['filter_price'] == 8) $title_ext .=  ', Giá trên 15 triệu';
           }
            
		   if($this->uri->segment(4) == 'p') $page = (int)$this->uri->segment(5);
           else $page = 1;		
        } else {
            $this->data['search_param']['filter_price'] = -1;
        }
        
        //Filter area
        if($this->uri->segment(3) && $this->uri->segment(3)!='-1' && $this->uri->segment(2) != 'p') {
            $area = (int)str_replace('a','',$this->uri->segment(3));
            $route['filter_area'] = $area_maxmin[$area];
			$this->data['search_param']['filter_area'] = $area;
			
            if(!$seo_meta) {
                if($this->data['search_param']['filter_area'] == 0) $title_ext = ' Diện tích Không xác định';
               elseif($this->data['search_param']['filter_area'] == 1) $title_ext = ', Diện tích dưới 20m2';
               elseif($this->data['search_param']['filter_area'] == 2) $title_ext =  ', Diện tích 20 - 30m2';
               elseif($this->data['search_param']['filter_area'] == 3) $title_ext =  ', Diện tích 30 - 50m2';
               elseif($this->data['search_param']['filter_area'] == 4) $title_ext =  ', Diện tích 50 - 60m2';
               elseif($this->data['search_param']['filter_area'] == 5) $title_ext =  ', Diện tích 60 - 70m2';
               elseif($this->data['search_param']['filter_area'] == 6) $title_ext =  ', Diện tích 70 - 80m2';
               elseif($this->data['search_param']['filter_area'] == 7) $title_ext =  ', Diện tích 80 - 90m2';
               elseif($this->data['search_param']['filter_area'] == 8) $title_ext =  ', Diện tích 90 - 100m2';
               elseif($this->data['search_param']['filter_area'] == 9) $title_ext =  ', Diện tích trên 100m2';
            }
           
           if($this->uri->segment(4) == 'p') $page = (int)$this->uri->segment(5);
           else $page = 1;
           
        } else {
            $this->data['search_param']['filter_area'] = -1;
        }
        
        //Filter bedroom
        if($this->uri->segment(4) && $this->uri->segment(4)!='-1') {
            $route['sophongngu'] = (int)$this->uri->segment(4);
			$this->data['search_param']['filter_bedroom'] = $this->uri->segment(4);
			if($this->data['search_param']['filter_bedroom'] == 1) $title_ext .= ', 1 phòng ngủ';
            elseif($this->data['search_param']['filter_bedroom'] ==2) $title_ext .= ', 2 phòng ngủ';
            elseif($this->data['search_param']['filter_bedroom'] == 3) $title_ext .= ', 3 phòng ngủ';
            elseif($this->data['search_param']['filter_bedroom'] == 4) $title_ext .= ', 4 phòng ngủ';
            elseif($this->data['search_param']['filter_bedroom'] == 5) $title_ext .= ', 5 phòng ngủ';
        } else {
            $this->data['search_param']['filter_bedroom'] = -1;
        }
        
        if($this->uri->segment(5) && $this->uri->segment(5)!='-1') {
            $route['project_id'] = (int)$this->uri->segment(5);
			$this->data['search_param']['filter_project'] = $this->uri->segment(5);
        } else {
            $this->data['search_param']['filter_project'] = -1;
        }
        
        
        if($this->input->post()) {
            
            $order_by = $this->input->post('order_by');
        
            if($order_by == 'time_desc') {
                $order_by = 'create_time';
                $sort = 'DESC';
                
            } elseif($order_by == 'price_desc') {
                $order_by = 'price';
                $sort = 'DESC';
            } elseif($order_by == 'price_asc') {
                $order_by = 'price';
                $sort = 'ASC';
            } else {
                $order_by = '';
                $sort = '';
                $this->data['order_by'] = '1';
            }
            
            $this->session->set_userdata('order_by', $order_by);
            $this->session->set_userdata('sort', $sort);
        } 
        $order_by = $this->session->userdata('order_by');
        $sort = $this->session->userdata('sort');
		
        if($order_by == 'create_time')
            $this->data['order_by'] = 'time_desc';
        else
            $this->data['order_by'] = $order_by.'_'.$sort;
        
        $category_project_url = $this->routes_model->_Get_Category_Project_Url($category_id, $project_id);
        
        //pagination
        $base_url = base_url($category_project_url.'/p');
        $per_page = 20;
        $total_row = $this->main_model->_Count_Search_Real_Estate($route);
        if(USERTYPE == 'Mobile'){
            $this->data['pagination'] = mpagination($base_url, $total_row, $per_page, $page);
        } else {
            $this->data['pagination'] = pagination($base_url, $total_row, $per_page, $page);
        }
        
        $this->data['heading_title'] = $category['title'].' tại dự án '.$project['title'];
        $this->data['link_title'] = $category['title'].' tại dự án '.$project['title'];
        $this->data['total_result'] = $total_row;
        $this->data['results'] = $this->main_model->_Search_Real_Estate($route, $per_page, ($page-1)*$per_page, $order_by, $sort);
        $this->data['sub_address'] = 'tại Việt Nam.';
        $this->data['google_map'] = 'Việt Nam';
        $this->data['zoom'] = 5;
        //$results = $this->main_model->_Search_Real_Estate($route);
        $route['city_id'] = $project['city_id'];
        $route['district_id'] = $project['district_id'];
        
        //Goi y them 10 tin
        $search_level = $route['search_level'];
        if(count($this->data['results']) < 10 && $search_level != 'city') {
            $ignore_list = array();
            foreach($this->data['results'] as $item) $ignore_list[] = $item['id'];
            if(!empty($ignore_list))
                $route['ignore'] = $ignore_list;
            
            $this->data['results2'] = $this->main_model->_Search_Real_Estate(array(
                'category_id' => $category_id,
                'district_id' => $project['district_id'],
                'ignore'      => $ignore_list
            ), 10, 0);
        }
        
        $this->data['search_param'] = $route;
        $title_ext = '';
        if($this->uri->segment(2) && $this->uri->segment(2)!='-1' && $this->uri->segment(2)!='p') {
            $route['filter_area'] = $area_maxmin[(int)$this->uri->segment(2)];
			$this->data['search_param']['filter_area'] = $this->uri->segment(2);
			if($this->data['search_param']['filter_area'] == 0) $title_ext = ' Diện tích Không xác định';
                                  elseif($this->data['search_param']['filter_area'] == 1) $title_ext = ', Diện tích <=30m2';
                                    elseif($this->data['search_param']['filter_area'] == 2) $title_ext =  ', Diện tích 30 - 50m2';
                                    elseif($this->data['search_param']['filter_area'] == 3) $title_ext =  ', Diện tích 50 - 80m2';
                                    elseif($this->data['search_param']['filter_area'] == 4) $title_ext =  ', Diện tích 80 - 100m2';
                                    elseif($this->data['search_param']['filter_area'] == 5) $title_ext =  ', Diện tích 100 - 150m2';
                                    elseif($this->data['search_param']['filter_area'] == 6) $title_ext =  ', Diện tích 150 - 200m2';
                                    elseif($this->data['search_param']['filter_area'] == 7) $title_ext =  ', Diện tích 200 - 250m2';
                                    elseif($this->data['search_param']['filter_area'] == 8) $title_ext =  ', Diện tích 250 - 300m2';
                                    elseif($this->data['search_param']['filter_area'] == 9) $title_ext =  ', Diện tích 300 - 500m2';
                                    elseif($this->data['search_param']['filter_area'] == 10) $title_ext =  ', Diện tích >= 500m2';
        } else {
            $this->data['search_param']['filter_area'] = -1;
        }
        if($this->uri->segment(3) && $this->uri->segment(3)!='-1' && $this->uri->segment(2)!='p') {
            $route['filter_price'] = $price_maxmin[(int)$this->uri->segment(3)];
			$this->data['search_param']['filter_price'] = $this->uri->segment(3);
			if($this->data['search_param']['filter_price'] == 0) $title_ext .=  ', Giá Thỏa thuận';
                                    elseif($this->data['search_param']['filter_price'] == 1) $title_ext .= ', Giá <=500 triệu';
                                    elseif($this->data['search_param']['filter_price'] == 2) $title_ext .=  ', Giá 500 - 800 triệu';
                                    elseif($this->data['search_param']['filter_price'] == 3) $title_ext .=  ', Giá 800 - 1 tỷ';
                                    elseif($this->data['search_param']['filter_price'] == 4) $title_ext .=  ', Giá 1 - 2 tỷ';
                                    elseif($this->data['search_param']['filter_price'] == 5) $title_ext .=  ', Giá 2 - 3 tỷ';
                                    elseif($this->data['search_param']['filter_price'] == 6) $title_ext .=  ', Giá 3 - 5 tỷ';
                                    elseif($this->data['search_param']['filter_price'] == 7) $title_ext .=  ', Giá 5 - 7 tỷ';
                                    elseif($this->data['search_param']['filter_price'] == 8) $title_ext .=  ', Giá 7 - 10 tỷ';
                                    elseif($this->data['search_param']['filter_price'] == 9) $title_ext .=  ', Giá 10 - 20 tỷ';
                                    elseif($this->data['search_param']['filter_price'] == 10) $title_ext .=  ', Giá 20 - 30 tỷ';
                                    elseif($this->data['search_param']['filter_price'] == 11) $title_ext .=  ', Giá >= 30 tỷ';
        } else {
            $this->data['search_param']['filter_price'] = -1;
        }
        if($this->uri->segment(4) && $this->uri->segment(4)!='-1') {
            $route['sophongngu'] = (int)$this->uri->segment(4);
			$this->data['search_param']['filter_bedroom'] = $this->uri->segment(4);
			if($this->data['search_param']['filter_bedroom'] == 1) $title_ext .= ', 1 phòng ngủ';
                                    elseif($this->data['search_param']['filter_bedroom'] ==2) $title_ext .= ', 2 phòng ngủ';
                                    elseif($this->data['search_param']['filter_bedroom'] == 3) $title_ext .= ', 3 phòng ngủ';
                                    elseif($this->data['search_param']['filter_bedroom'] == 4) $title_ext .= ', 4 phòng ngủ';
                                    elseif($this->data['search_param']['filter_bedroom'] == 5) $title_ext .= ', 5 phòng ngủ';
        } else {
            $this->data['search_param']['filter_bedroom'] = -1;
        }
        if($this->uri->segment(5) && $this->uri->segment(5)!='-1') {
            $route['project_id'] = (int)$this->uri->segment(5);
			$this->data['search_param']['filter_project'] = $this->uri->segment(5);
        } else {
            $this->data['search_param']['filter_project'] = -1;
        }
        
        $this->data['category_tags'] = $this->main_model->_Get_Category_Tags($route);
        
        $this->data['search_url'] = $this->routes_model->_Get_Search_URL('district', $category_id, $project['district_id']);
        
        /*if($route['street_id'] > 0) {
            unset($route['ward_id']);
            if(!empty($ward)) $title_ward = ', Phường '.$ward['title'];
            else $title_ward = '';
            if(!empty($street)) {
                $address = $ward['title'] .' ' . $district['title'].' '.$city['title'];
                $sub_address = 'Quận/huyện: <span>'.$district['title'] . '</span> - Tỉnh/TP: <span>' . $city['title'].'.</span>';
                $google_map = 'Đường '.$street['title'].$title_ward. ', '.$district['title'] . ', ' . $city['title'];
            } else {
                $address = $ward['title'] .' ' . $district['title'].' '.$city['title'];
                $sub_address = 'Phường: '.$ward['title'].' Quận/huyện: '.$district['title'] . ' Tỉnh/TP: ' . $city['title'];
                $google_map = 'Đường '.$street['title'].$title_ward. ', '.$district['title'] . ', ' . $city['title'];
            }
        }
        
        if($route['ward_id'] > 0 && $route['street_id'] == 0) {
            if(!empty($ward)) {
                $address = $district['title'].' '.$city['title'];
                $sub_address = 'Quận/huyện: <span>'.$district['title'] . '</span> - Tỉnh/TP: <span>' . $city['title'].'</span>';
                $google_map = 'Phường '.trim($ward['title']).', '.$district['title'] . ', ' . $city['title'];
            } else {
                $address = $district['title'].' '.$city['title'];
                $sub_address = 'Phường: <span>'.$ward['title'].'.</span> Quận/huyện: <span>'.$district['title'] . '.</span> Tỉnh/TP: <span>' . $city['title'].'</span>';
                $google_map = 'Phường '.trim($ward['title']).', '.$district['title'] . ', ' . $city['title'];
            }
            
        }*/
        
        $footer_content = $this->main_model->_Get_Footer_Content_Project();
        $this->data['category_content'] = $footer_content['content'];
        
        $districts = $this->main_model->_Get_District($route['city_id']);
        
        foreach($districts as $row) {
            $route_temp['district_id'] = $row['id'];
			unset($route_temp['ward_id']);
            unset($route_temp['street_id']);
			unset($route_temp['project_id']);
			$count_real = $this->main_model->_Count_Real_Estate($route_temp);
                $this->data['list_category'][] = array(
                    'title' => $category['title'].' ' . $row['title'],
                    'alias' => $category['alias'] . '-' . $row['alias'].'-'.$route['district_id'],
                    'total' => $count_real
                );
            }
        $this->data['title_list_category'] = $category['title'] .' theo quận tại Hồ Chí Minh';
        
        if($route['district_id'] > 0 && $route['city_id']) {
            $city = $this->main_model->_Get_City_By_Id($route['city_id']);
            $sub_address = 'Quận/Huyện: <span>' . $district['title'].'</span>, Tỉnh/TP: <span>'.$city['title'].'.</span>';
        }
        
        $this->data['sub_address'] = $sub_address;
        
        $seo_meta = $this->main_model->_Get_Seo_Url($this->uri->segment(1));
        if($seo_meta && $seo_meta['title'] != '') {
            if($page == 1) {
                $title = $seo_meta['title'] . ' | Muonnha.com.vn';    
            } else {
                $title = $seo_meta['title']. ' - Trang ' . $page . ' | Muonnha.com.vn';
            }
        } else {
            $title = $project['meta_title'] . ' | Muonnha.com.vn';
        }
        if($seo_meta && $seo_meta['keyword'] != '') {
            if($page==1) {
                $keywords = $seo_meta['keyword'];    
            } else {
                $keywords = $seo_meta['keyword'].' Trang '.$page;
            }
            
        } else {
            $keywords = $project['keywords'] . $title_ext;
        }
        if($seo_meta && $seo_meta['description'] != '') {
            if($page==1) { 
                $description = $seo_meta['description'];   
            } else {
                $description = $seo_meta['description'].' Trang '.$page;
            }
        } else {
           $description = $project['description'];
        }
            $config=array(
                'title' => $title,
    			'keywords' => $keywords,
    			'description' => $description
            );
        
        /*
		$config = array(
			'title' => $category['title'].$title_ext.' tại Việt Nam | Muonnha.com.vn',
			'keywords' => $category['keywords'].$title_ext,
			'description' => $category['description'].$title_ext
		);*/
        if(empty($this->data['results'])) $this->template->_Set_Data('noindex', true);
		$this->data['hidden_content'] = $description;
        $this->data['show_tag_link'] = false;
        $this->data['cur_page'] = 'category';
        //$this->template->_Set_Default_Layout('layout_category');
        $this->template->_Set_Data('pageindex', false);
        $this->template->_Set_Config($config);
        
        
        $this->template->_Set_View('estate/list_project', $this->data);
        $this->template->_Render();
    }
    
    
    /**
    * Ch tiết tin đăng
    */
    function real_estate($id) {
        
        $this->data['real_estate'] = $this->main_model->_Get_Real_Estate_By_Id($id);
        $this->data['real_estate']['search_title'] = $this->main_model->_Create_Search_Title($this->data['real_estate']);
        $this->data['real_estate_images'] = $this->main_model->_Get_Real_Estate_Images($id);
        $this->data['category'] = $this->main_model->_Get_Real_Estate_Category_By_Id($this->data['real_estate']['category_id']);
        
        $category_id = $this->data['real_estate']['category_id'];
        $city_id = $this->data['real_estate']['city_id'];
        $district_id = $this->data['real_estate']['district_id'];
        $ward_id = $this->data['real_estate']['ward_id'];
        $street_id = $this->data['real_estate']['street_id'];
        $project_id = $this->data['real_estate']['project_id'];
        
        $link_params = $this->data['real_estate'];
		$link_params['show_detail'] = 1;
		$this->data['list_link_location'] = $this->main_model->_Get_Link_By_Location($link_params);
        
        if($district_id!=16) $this->template->_Set_Data('noindex', true);
        
        $category = $this->main_model->_Get_Real_Estate_Category_By_Id($category_id);
        
        $address = '';
		$search_text = $this->data['category']['title']; 
        
        if($project_id) {
            $project = $this->main_model->_Get_Project_By_Id($project_id);
            $this->data['search_param']['city_id'] = $city_id; 
            
        }
        
        $this->data['search_param']['category_id'] = $category_id; 
        $this->data['search_param']['filter_bedroom'] = $this->data['real_estate']['sophong']; 
        
        if($this->data['real_estate']['area']==0) $this->data['search_param']['filter_area'] = -1;
        elseif($this->data['real_estate']['area'] <= 30) $this->data['search_param']['filter_area'] = 1;
        elseif($this->data['real_estate']['area'] > 30 && $this->data['real_estate']['area'] <= 50) $this->data['search_param']['filter_area'] = 2;
        elseif($this->data['real_estate']['area'] > 50 && $this->data['real_estate']['area'] <= 80) $this->data['search_param']['filter_area'] = 3;
        elseif($this->data['real_estate']['area'] > 80 && $this->data['real_estate']['area'] <= 100) $this->data['search_param']['filter_area'] = 4;
        elseif($this->data['real_estate']['area'] > 100 && $this->data['real_estate']['area'] <= 150) $this->data['search_param']['filter_area'] = 5;
        elseif($this->data['real_estate']['area'] > 150 && $this->data['real_estate']['area'] <= 200) $this->data['search_param']['filter_area'] = 6;
        elseif($this->data['real_estate']['area'] > 200 && $this->data['real_estate']['area'] <= 250) $this->data['search_param']['filter_area'] = 7;
        elseif($this->data['real_estate']['area'] > 250 && $this->data['real_estate']['area'] <= 300) $this->data['search_param']['filter_area'] = 8;
        elseif($this->data['real_estate']['area'] > 300 && $this->data['real_estate']['area'] <= 500) $this->data['search_param']['filter_area'] = 9;
        elseif($this->data['real_estate']['area'] > 500) $this->data['search_param']['filter_area'] = 10;
        
        if($this->data['real_estate']['price_number']==0) $this->data['search_param']['filter_price'] = -1;
        elseif($this->data['real_estate']['price_unit']==1) $this->data['search_param']['filter_price'] = 0;
        elseif($this->data['real_estate']['price_unit']==2 && $this->data['real_estate']['price_number'] < 500) $this->data['search_param']['filter_price'] = 1;
        elseif($this->data['real_estate']['price_unit']==2 && $this->data['real_estate']['price_number'] > 500 && $this->data['real_estate']['price_number'] <= 800) $this->data['search_param']['filter_price'] = 2;
        elseif($this->data['real_estate']['price_unit']==2 && $this->data['real_estate']['price_number'] > 800 && $this->data['real_estate']['price_number'] <= 999) $this->data['search_param']['filter_price'] = 3;
        elseif($this->data['real_estate']['price_unit']==3 && $this->data['real_estate']['price_number'] > 1 && $this->data['real_estate']['price_number'] <= 2) $this->data['search_param']['filter_price'] = 4;
        elseif($this->data['real_estate']['price_unit']==3 && $this->data['real_estate']['price_number'] > 2 && $this->data['real_estate']['price_number'] <= 3) $this->data['search_param']['filter_price'] = 5;
        elseif($this->data['real_estate']['price_unit']==3 && $this->data['real_estate']['price_number'] > 3 && $this->data['real_estate']['price_number'] <= 5) $this->data['search_param']['filter_price'] = 6;
        elseif($this->data['real_estate']['price_unit']==3 && $this->data['real_estate']['price_number'] > 5 && $this->data['real_estate']['price_number'] <= 7) $this->data['search_param']['filter_price'] = 7;
        elseif($this->data['real_estate']['price_unit']==3 && $this->data['real_estate']['price_number'] > 7 && $this->data['real_estate']['price_number'] <= 10) $this->data['search_param']['filter_price'] = 8;
        elseif($this->data['real_estate']['price_unit']==3 && $this->data['real_estate']['price_number'] > 10 && $this->data['real_estate']['price_number'] <= 20) $this->data['search_param']['filter_price'] = 9;
        elseif($this->data['real_estate']['price_unit']==3 && $this->data['real_estate']['price_number'] > 20 && $this->data['real_estate']['price_number'] <= 30) $this->data['search_param']['filter_price'] = 10;
        elseif($this->data['real_estate']['price_unit']==3 && $this->data['real_estate']['price_number'] > 30) $this->data['search_param']['filter_price'] = 11;
        $city = $this->main_model->_Get_City_By_Id($city_id);
        if($street_id) {
            $street = $this->main_model->_Get_Street_By_Id($street_id);
            $address.='Đường '.$street['title'];
			$this->data['search_param']['street_id'] = $street_id; 
            
        }
        if($ward_id) {
            $ward = $this->main_model->_Get_Ward_By_Id($ward_id);
            $address.=', Phường '.$ward['title'];
            $this->data['search_param']['ward_id'] = $ward_id; 
            
        }
        
        if($district_id) {
            $district = $this->main_model->_Get_District_By_Id($district_id);
            $address .= ', '.$district['title'];
            $this->data['locations'] = 'Quận/huyện: <span>'.$district['title'].'</span> - ';
            $this->data['search_param']['district_id'] = $district_id; 
            
            $this->data['title_list_category'] = $category['title'] . ' theo quận tại '.$city['title'];
            //List danh sách tin theo khu vuc
            $districts = $this->main_model->_Get_District($city_id);
            $router_temp = $this->data['real_estate'];
            foreach($districts as $row) {
                $router_temp['district_id'] = $row['id'];
				unset($router_temp['ward_id']);
				unset($router_temp['street_id']);
                $count_real = $this->main_model->_Count_Real_Estate($router_temp);
                $this->data['list_category'][] = array(
                    'title' => $this->data['category']['title'] . ' '.$row['title'],
                    'alias' => $this->data['category']['alias'] . '-' . $row['alias'],
                    'total' => $count_real
                );
            }
        }
        if($city_id) {
            
            $address .= ', '.$city['title'];
            $this->data['locations'] .= ' Tỉnh/Tp: <span>'.$city['title'].'</span>.';
            $this->data['search_param']['city_id'] = $city_id; 
        }
        
        if($city_id) {
            $this->breadcrumb->append_crumb($category['title'].' '.$city['title'], site_url($category['alias'].'-'.$city['alias']));
        }
        if($district_id) {
             $this->breadcrumb->append_crumb($category['title'].' '.$district['title'], site_url($category['alias'].'-'.$district['alias']));
        }
        if($ward_id && !$street_id){
            $this->breadcrumb->append_crumb($category['title'].' phường '.$ward['title'], site_url($category['alias'].'-'.$ward['alias'].'-'.$district_id));
        }
        if($street_id) {
            $this->breadcrumb->append_crumb($category['title'].' đường '.$street['title'], site_url($category['alias'].'-'.$street['alias'].'-'.$district_id));
        }
        
        //$this->data['sub_address'] = $address;
        $this->data['google_map'] = $address;
		if($this->data['real_estate']['create_by']){
			$detail_user = $this->ion_auth->user($this->data['real_estate']['create_by'])->row_array(); 
			
			$this->data['detail_user'] = array(
				'name' => $detail_user['last_name'].' '.$detail_user['first_name'],
				'mobiphone' => $detail_user['mobiphone'],
                'telephone' => $detail_user['telephone'],
				'email' => $detail_user['email'],
				'address' => $detail_user['address']
			);
		} else {
			$this->data['detail_user'] = array(
				'name' => $this->data['real_estate']['guest_fullname'],
				'mobiphone' => $this->data['real_estate']['guest_mobiphone'],
                'telephone' => $this->data['real_estate']['guest_telephone'],
				'email' => $this->data['real_estate']['guest_email'],
				'address' => $this->data['real_estate']['guest_address'],
			);
		}
        
        if($project_id>0) {
            $this->data['search_title'] = $category['title'].' tại dự án '.$project['title'];
            $this->data['search_alias'] = $this->routes_model->_Get_Category_Project_Url($category_id, $project_id); 
             
        }
		elseif($street_id>0){
			$this->data['search_title'] = $category['title'].' đường '.$street['title'];
			$this->data['search_alias'] = $this->routes_model->_Get_Search_URL('street', $category_id, $street_id, $district_id);
			
		}
		elseif($ward_id>0) {
            $this->data['search_title'] = $category['title'].' phường '.$ward['title'];
			$this->data['search_alias'] = $this->routes_model->_Get_Search_URL('ward', $category_id, $ward_id, $district_id);
            //echo $this->data['search_alias'];
			//$this->data['search_alias'] .= '-'.$district_id;
        
		}
        elseif($district_id>0) {
            $this->data['search_title'] = $category['title'] .' '.$district['title'];
            $this->data['search_alias'] = $this->routes_model->_Get_Search_URL('district', $category_id, $district_id);   
          
        }
        elseif($city_id>0) {
            $this->data['search_title'] = $category['title'] .' '.$city['title'];
            
            $this->data['search_alias'] = $this->routes_model->_Get_Search_URL('city', $category_id, $city_id);   
         
        } else {
            $this->data['search_alias'] = '';
        }
        
        if($category_id && $district_id)
            $this->data['link_view_more'] = $this->routes_model->_Get_Search_URL('district', $category_id, $district_id);
        else 
            $this->data['link_view_more'] = '';
        
        //Cập nhật lượt view
        $this->main_model->_Update_Real_Estate_View($id);
		$this->main_model->_Update_Real_Estate_View_Ao($id);
        
        //Tin đăng cùng khu vực
        $this->data['result_by_location'] = $this->main_model->_Get_Real_Estate_By_Location($this->data['real_estate'], 10, 0);
        //Tin đăng cùng khoản giá
        $this->data['result_by_price'] = $this->main_model->_Get_Real_Estate_By_Price($this->data['real_estate'], 10, 0);
        
        //List danh sách tin theo khu vuc
        $districts = $this->main_model->_Get_District($this->data['real_estate']['city_id']);
       /* foreach($districts as $district) {
            $this->data['list_category'][] = array(
                'title' => $district['title'],
                'alias' => $this->data['category']['alias'] . '-' . $district['alias']
            );
        }*/
        
        
        $this->template->_Set_Data('title', $this->data['real_estate']['title']);
        if($this->data['real_estate']['keywords']!='') {
            $this->template->_Set_Data('keywords', $this->data['real_estate']['keywords']);
        } else {
            $this->template->_Set_Data('keywords', $this->data['real_estate']['title']);
        }
        if($this->data['real_estate']['description']!='' || (strcmp($this->data['real_estate']['description'], $this->data['real_estate']['title']) != 0) && $this->data['real_estate']['description']!='') {
            $this->template->_Set_Data('description', trim($this->data['real_estate']['description']));
        } else {
            $metadesc = sub_string($this->data['real_estate']['content'], 300);
            $metadesc = trim($metadesc);
            $metadesc = str_replace("\n"," ",$metadesc);
            $this->template->_Set_Data('description', $metadesc);
        }
        $this->template->_Set_Data('image', $this->data['real_estate_images'][0]['image']);
        $this->data['cur_page'] = 'real_estate';
        $this->template->_Set_Data('cur_page', 'real_estate');
        $this->template->_Set_View('estate/detail/detail', $this->data);
        $this->template->_Render();
        //$this->output->cache(60*24);
    }
	
	function tags($tags, $page = 1) {
		$real_tags = $this->main_model->_Get_Real_Tag($tags);
        //pagination
        $base_url = base_url('tags/'.$tags.'/p');
        $per_page = 20;
        $total_row = $this->main_model->_Count_Real_Estate_By_Tags($tags);
        $this->data['pagination'] = pagination($base_url, $total_row, $per_page, $page);
        
		$this->data['heading_title'] = $real_tags['title'];
        $this->data['link_title'] = $real_tags['title'];
        $this->data['total_result'] = $total_row;
		$this->data['results'] = $this->main_model->_Get_Real_Estate_By_Tags($tags, $per_page, ($page-1)*$per_page);
        $this->data['show_tag_link'] = false;
        $this->breadcrumb->append_crumb('tags', '#');
		$this->breadcrumb->append_crumb($real_tags['title'], site_url('tags/'.$real_tags['alias']));
		
        $seo_meta = $this->main_model->_Get_Seo_Url('tags/'.$this->uri->segment(2));
        if($page > 1) $tag_page = ' Trang ' . $page.' ';
        else $tag_page = '';
        
        if($seo_meta['title']!='') $meta_title = $seo_meta['title'].$tag_page;
        else $meta_title = $real_tags['title'].' - Tags' . $tag_page . ' | Muonnha.com.vn';
        
        if($seo_meta['keyword'] != '') $meta_keywords = $seo_meta['keyword'].$tag_page;
        else $meta_keywords = $real_tags['title'].$tag_page;
        
        if($seo_meta['description']) $meta_description = $seo_meta['description'].$tag_page;
        else $meta_description = $real_tags['title'] . ' với đầy đủ các loại diện tích và giá cho thuê.'.$tag_page;
        
		$config=array(
            'title' => $meta_title,
    		'keywords' => $meta_keywords,
    		'description' => $meta_description
        );
		
		$this->template->_Set_Config($config);
		
       // $this->template->_Set_Title($real_tags['title'].' - Tags | Muonnha.com.vn');
        $this->template->_Set_View('estate/list', $this->data);
        $this->template->_Render();
	}
    
    
    function content_category($id, $page=0) {
        if($this->uri->segment(2) && $this->uri->segment(2) != 'p') {
            $this->content($this->uri->segment(2));
        } else {
            $category = $this->main_model->_Get_Content_Category_By_Id($id);
            if($category) {
                
                //pagination
                $base_url = base_url($category['alias'].'/p');
                $per_page = 24;
                $total_row = $this->main_model->_Count_Content_By_Category($id);
                
                $this->data['pagination'] = pagination($base_url, $total_row, $per_page, $page);
                
                $this->template->_Set_Config($category);
                if($page > 0) {
                    $this->template->_Set_Title($category['meta_title'].' - Trang '.$page); 
                    $this->template->_Set_Data('description', $category['description'].' - Trang '.$page);  
                } else {
                    $this->template->_Set_Title($category['meta_title']);
                }
                $result = $this->main_model->_Get_Content_By_Category($id, $per_page, ($page-1)*$per_page);
                
                $this->data['category'] = $category;
                $this->data['cur_page'] = $page;
                $this->data['results'] = $result;
                $this->data['heading_title'] = $category['title'];
                $this->breadcrumb->append_crumb($category['title'], '#');
                $this->template->_Set_View('content/list', $this->data);
                $this->template->_Render();
            } else {
                redirect('error_404');
            }   
        }
    }
    
    function content($id) {
        $content = $this->main_model->_Get_Content_By_Id($id);
        if($content) {
            $this->data['heading_title'] = $content['title'];
            $this->data['content'] = $content;
            $this->data['category'] = $this->main_model->_Get_Content_Category_By_Id($content['category_id']);
            $this->data['contents'] = $this->main_model->_Get_Content_Related($content, 11);
            $this->main_model->_Update_Content_View($content['id']);
            $this->breadcrumb->append_crumb($this->data['category']['title'], site_url($this->data['category']['alias']));
            $this->breadcrumb->append_crumb($content['title'], '#');
            $this->template->_Set_Config($content);
            $this->template->_Set_Title($content['meta_title']);
            $this->template->_Set_View('content/detail', $this->data);
            $this->template->_Set_Data('image', base_url('uploads/contents/'.$content['image']));
            $this->template->_Render();
        } else {
            redirect('error_404');
        }
    }
 
    function error404() {
        $config = array(
            'title' => 'Error 404',
            'keywords' => 'Error 404',
            'description' => 'Error 404'
        );
        $this->template->_Set_Config($config);
        
        $this->template->_Set_View('error404', $this->data);
        $this->template->_Render();
    }
}