<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . '/core/MY_Controller.php';
class Sitemap extends MY_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->library('zip');
        $this->load->helper('file');
    }
    
    function category() {
        //Danh muc tin
        $name = 'Category.xml';
        $category = $this->db->select('alias')->from('categories')->where('status',1)->get()->result_array();
        $data['result'] = $category;
        $xml = $this->load->view('default/sitemap', $data, true);
        write_file(FCPATH . 'sitemap/'.$name, $xml);
    }
    
    function category_city() {
        //Danh muc tin dang theo tinh thanh
        $name = 'CategoryCity.xml';
        $city = $this->db->select('alias')->from('city')->where('status',1)->get()->result();
        $category = $this->db->select('alias')->from('categories')->where('status',1)->get()->result();
        foreach($city as $cty) {
            foreach($category as $cat) {
                $data['result'][] = array(
                    'alias' => $cat->alias .'-'.$cty->alias,
                    'priority' => '0.8'
                );
            }
        }
        $xml = $this->load->view('default/sitemap', $data, true);
        write_file(FCPATH . 'sitemap/'.$name, $xml);
    }
    
    function general_full_sitemap() {
        //Danh muc tin dang theo quan
        $name = 'CategoryDistrict.xml';
        $district = $this->db->select('id,alias')->from('district')->where('status',1)->get()->result();
        $category = $this->db->select('alias')->from('categories')->where('status',1)->get()->result();
        foreach($district as $row) {
            $folder = 'district'.$row->id;
            mkdir(FCPATH.'/sitemap/'.$folder, 0755);
            foreach($category as $cat) {
                $data['result'][] = array(
                    'alias' => $cat->alias .'-'.$row->alias.'.htm',
                    'priority' => '0.8'
                );
            }
            //District sitemap
            $xml = $this->load->view('default/sitemap', $data, true);
            write_file(FCPATH . 'sitemap/'.$folder.'/district.xml', $xml);
            
            //Ward sitemap
            $wards = $this->db->select('alias,district_id')->from('wards')->where('status',1)->where('district_id', $row->id)->get()->result();
            $data['result'] = array();
            foreach($category as $cat) {
                foreach($wards as $ward) {
                    $data['result'][] = array(
                        'alias' => $cat->alias .'-'.$ward->alias.'-'.$row->id.'.htm',
                        'priority' => '0.8'
                    );
                }
            }
            $xml = $this->load->view('default/sitemap', $data, true);
            write_file(FCPATH . 'sitemap/'.$folder.'/ward.xml', $xml);
            
            //Street sitemap
            $streets = $this->db->select('t1.alias')
            ->from('streets t1')
            ->join('district_streets t2', 't2.street_id=t1.id')
            ->where('t2.district_id', $row->id)
            ->where('t1.status',1)
            ->get()->result();
            $data['result'] = array();
            foreach($category as $cat) {
                foreach($streets as $street) {
                    $data['result'][] = array(
                        'alias' => $cat->alias .'-'.$street->alias.'-'.$row->id.'.htm',
                        'priority' => '0.8'
                    );
                }
            }
            $xml = $this->load->view('default/sitemap', $data, true);
            write_file(FCPATH . 'sitemap/'.$folder.'/street.xml', $xml);
            
            //Real estate sitemap
            $real_estates = $this->db->select('alias,title')->from('real_estates')->where('status',1)->where('district_id', $row->id)->get()->result();
            $data['result'] = array();
            foreach($real_estates as $street) {
                    $data['result'][] = array(
                        'alias' => $street->alias.'.htm',
                        'priority' => '0.8'
                    );
            }
            $xml = $this->load->view('default/sitemap', $data, true);
            write_file(FCPATH . 'sitemap/'.$folder.'/real_estate.xml', $xml);
            $this->zip->add_data(FCPATH . 'sitemap/'.$folder.'/real_estate.xml');
            $this->zip->archive(FCPATH.'sitemap/'.$folder.'/real_estate.gz');
        }   
    }
    
    function project_category($category_id, $project_id) {
        $data = array();
        
        //Danh sach tin dang
        $results = $this->db->select('alias')->from('real_estates')
        ->where('status',1)
        ->where('category_id', $category_id)
        ->where('project_id', $project_id)
        ->get()->result_array();
        foreach($results as $row) {
            $data['result'][] = array(
                'alias' => $row['alias'].'.htm',
                'priority' => '0.8'
            );
        }
        
        $xml = $this->load->view('default/sitemap', $data, true);
        header("Content-Type: text/xml;charset=iso-8859-1");
        echo $xml;
    }
    
    function category_ward() {
        $name = 'CategoryWard.xml';
        $wards = $this->db->select('alias,district_id')->from('wards')->where('status',1)->get()->result();
        $category = $this->db->select('alias')->from('categories')->where('status',1)->get()->result();
        foreach($wards as $row) {
            foreach($category as $cat) {
                $data['result'][] = array(
                    'alias' => $cat->alias .'-'.$row->alias.'-'.$row->district_id.'.htm',
                    'priority' => '0.8'
                );
            }
        }
        $xml = $this->load->view('default/sitemap', $data, true);
        write_file(FCPATH . 'sitemap/'.$name, $xml);
        echo 'Success!';
    }
    
    function category_street($district_id) {
        if($district_id) {
            
        $name = 'CategoryDistrict'.$district_id.'.xml';
        $street = $this->db->select('t1.alias')
        ->from('streets t1')
        ->join('district_streets t2', 't2.street_id=t1.id')
        ->where('t2.district_id', $district_id)
        ->where('t1.status',1)
        ->get()->result();
        $category = $this->db->select('alias')->from('categories')->where('status',1)->get()->result();
        foreach($street as $row) {
            foreach($category as $cat) {
                $data['result'][] = array(
                    'alias' => $cat->alias .'-'.$row->alias.'-'.$district_id.'.htm',
                    'priority' => '0.8'
                );
            }
        }
        $xml = $this->load->view('default/sitemap', $data, true);
        write_file(FCPATH . 'sitemap/'.$name, $xml);   
        } else {
            echo 'Enter district id';
        }
    }
    
    function create_sitemap_street() {
        for($i=5; $i<54; $i++) {
            $this->category_street($i);
        }
    }
    
    function tags() {
        $results = $this->db->get('real_tags')->result_array();
        foreach($results as $row) {
            $data['result'][] = array(
                'alias' => 'tags/'.$row['alias'].'.htm',
                'priority' => '0.6'
            );
        }
        $xml = $this->load->view('default/sitemap', $data, true);
        header("Content-Type: text/xml;charset=iso-8859-1");
        echo $xml;
    }
    
    function real_estate($district_id) {
        $data = array();
        
        //Danh sach tin dang
        $results = $this->db->select('alias')->from('real_estates')
        ->where('status',1)
        ->where('district_id', $district_id)
        ->get()->result_array();
        foreach($results as $row) {
            $data['result'][] = array(
                'alias' => $row['alias'].'.htm',
                'priority' => '0.6'
            );
        }
        
        $xml = $this->load->view('default/sitemap', $data, true);
        header("Content-Type: text/xml;charset=iso-8859-1");
        echo $xml;
    }
    
    function contents($cat_id) {
        $results = $this->db->select('t1.alias,t2.alias AS cat_alias')->from('contents t1')
        ->join('content_categories t2', 't1.category_id=t2.id')
        ->where('t1.status','active')
        ->where('t1.category_id', $cat_id)
        ->get()->result_array();
        foreach($results as $row) {
            $data['result'][] = array(
                'alias' => $row['cat_alias'].'/'.$row['alias'].'.htm',
                'priority' => '0.8'
            );
        }
        $xml = $this->load->view('default/sitemap', $data, true);
        header("Content-Type: text/xml;charset=iso-8859-1");
        echo $xml;
    }
}