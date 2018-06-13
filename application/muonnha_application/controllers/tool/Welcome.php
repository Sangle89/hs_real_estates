<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct(){
		parent::__construct();
		$this->load->database();
        $this->load->helper(array('url','functions'));
	} 
	
	public function index()
	{
		$file = fopen("./data/link_phantich.txt", "r");
        $arrLinks = array();
        while(($line = fgets($file))!== false) {
            $arrLinks[] = $line;
        }
        $data['arrLinks'] = $arrLinks;
		$this->load->view('welcome_message', $data);
	}
	
	public function crawler() {
		require APPPATH . "/third_party/phpcrawl/libs/simple_html_dom.php";
		
		$url = $this->input->post('url');
		
		$data = $this->dlPage(trim($url));
		$res = array();
        $res['url'] = trim($url);
		if(!empty($data)) {
			//do something
			$title = '';
			$img = '';
			$content = '';
			$element = $data->find('div.body-container-wrapper div.rv-blog-banner-wrapper div.RV-tittle-wrapper h1 span');
			if(!empty($element)) {
				foreach($element as $item) {
					$title = $item->innertext;
				}    
			}
            
            if($title !='') $alias = to_slug($title);
            else $alias = '';
            
			foreach($data->find('div[class="main-body"]') as $item) {
				$img = $item->find('div[class="hs-featured-image-wrapper"] > img', 0);
                $img = $img->src;
			}
			
			foreach($data->find('div[class="main-body"] div[class="post-body"]') as $item) {
				$content = $item->innertext;
			}
            
            if($title!='' && $content!='' && $this->check_exists($alias)===false) {
                $this->insertData($title, $alias, $content, $img);
            }
			
			$res['success'] = true;    
			$res['title'] = $title;
		} else {
			$res['success'] = false;
		}
		echo json_encode($res);
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
    
    function insertData($title = '', $alias='', $content = '', $image = '') {
        $this->db->insert('contents', array(
           'title' => $title,
           'alias' => $alias,
           'content' => $content,
           'image' => $image 
        ));
        return $this->db->insert_id();
    }
}
