<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Spider extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
	} 
	
    public function rever_blog() {
        $this->load->library('crawler');
        
        $crawler = new Crawler();
        $url = 'https://blog.rever.vn/topic/thị-trường';
        for($i=0; $i<33; $i++) {
            // URL to crawl
            if($i==0)
                $link = $url;
            else
                $link = $url."/page/".$i;
        
            $crawler->setURL($link);
            // Only receive content of files with content-type "text/html"
            $crawler->addContentTypeReceiveRule("#text/html#");
            
            // Ignore links to pictures, dont even request pictures
            $crawler->addURLFilterRule("#\.(jpg|jpeg|gif|png)$# i");
            $crawler->addURLFilterRule("/rever.vn\/author/ i");
            
            // Store and send cookie-data like a browser does
            $crawler->enableCookieHandling(true);
            
            // Set the traffic-limit to 1 MB (in bytes,
            // for testing we dont want to "suck" the whole site)
            $crawler->setTrafficLimit(1000 * 1024);
            
            // Thats enough, now here we go
            $crawler->go();
            
            // At the end, after the process is finished, we print a short
            // report (see method getProcessReport() for more information)
            $report = $crawler->getProcessReport();
            
            if (PHP_SAPI == "cli") $lb = "\n";
            else $lb = "<br />";
                
            echo "Summary:".$lb;
            echo "Links followed: ".$report->links_followed.$lb;
            echo "Documents received: ".$report->files_received.$lb;
            echo "Bytes received: ".$report->bytes_received." bytes".$lb;
            echo "Process runtime: ".$report->process_runtime." sec".$lb; 
        }
    }
    
    function phongtro123() {
        $this->load->library('crawler');
        
        $crawler = new Crawler();
        $crawler->setConnectionTimeout(60);
        $url = 'https://phongtro123.com/cho-thue-phong-tro';
        
        $follow_link = array(
            '\.html$'
        );
        
        $ignore_link = array(
            'cho-thue-phong-tro',
            'nha-cho-thue',
            'cho-thue-can-ho',
            'cho-thue-mat-bang',
            'tim-nguoi-o-ghep',
            'tim-kiem',
            'doi-song-xa-hoi',
            'kinh-nghiem',
            'phong-thuy',
            'nha-dep',
            'dang-tin',
            '\.(jpg|jpeg|gif|png)$'
        );
        
        for($i=0; $i < 827; $i++) {
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
            
            // At the end, after the process is finished, we print a short
            // report (see method getProcessReport() for more information)
            $report = $crawler->getProcessReport();
            
            if (PHP_SAPI == "cli") $lb = "\n";
            else $lb = "<br />";
                
            echo "Summary:".$lb;
            echo "Links followed: ".$report->links_followed.$lb;
            echo "Documents received: ".$report->files_received.$lb;
            echo "Bytes received: ".$report->bytes_received." bytes".$lb;
            echo "Process runtime: ".$report->process_runtime." sec".$lb; 
        }
    }
}