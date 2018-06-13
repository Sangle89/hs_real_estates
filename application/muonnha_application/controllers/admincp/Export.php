<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'core/MY_Admin.php';
class Export extends MY_Admin {
    
    public $title = 'Export';
    private $_controller = 'export';
    
    function __construct() {
        parent::__construct();
        $this->load->model(array(
            'content_category_model',
            'content_model',
            'real_estate_model',
            'city_model',
            'district_model'
        ));
        $this->load->library(array(
            'pagination', 
            'form_validation'
        ));
        
        $this->breadcrumb->append_crumb('Trang ch?', admin_url());
        
    }
    
    function index($page=0) {
        $data = array();
        $data['dropdown_city'] = $this->city_model->_Get_Dropdown();
        $data['dropdown_district'] = $this->district_model->_Get_Dropdown();
        if($this->input->post()) {
            $post = $this->input->post();
            $this->export_real_estate($post);
            redirect(admin_url('export'));
        } else {
            $this->template->_Set_View('setting/export', $data);
            $this->template->_Render();
        }
    }
    
    function export_real_estate($params = array()) {
        $fileName = 'DS_Real_Estate_'.date('d_m_Y_H_i_s',time()).'.xls';
        $title = 'Danh sách Tin đăng';
        $desc = 'Danh sách Email khách hàng đã đăng ký website';
        require APPPATH . "third_party/phpexcel/PHPExcel.php";
        require APPPATH . "third_party/phpexcel/PHPExcel/IOFactory.php";
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("SangIT")
				->setLastModifiedBy("SangIT")
				->setTitle($title)
				->setSubject($title)
				->setDescription($desc)
				->setKeywords("DS tin rao")
				->setCategory($title);
        $objPHPExcel->getActiveSheet()->setTitle($title);
        
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', 'ID')
        ->setCellValue('B1', 'Title')
        ->setCellValue('C1', 'Alias')
        ->setCellValue('D1', 'City')
        ->setCellValue('E1', 'District');
        
        $this->db->select('id,title,alias,city_id,district_id,ward_id,street_id')->from('real_estates');
        
        if(isset($params['city_id']) && $params['city_id'] > 0) $this->db->where('city_id', $params['city_id']);
        if(isset($params['district_id']) && $params['district_id'] > 0) $this->db->where('district_id', $params['district_id']);
        if($params['empty_city']==1) $this->db->where('city_id', 0);
        if($params['empty_district']==1) $this->db->where('district_id', 0);
        if($params['empty_ward']==1) $this->db->where('ward_id', 0);
        if($params['empty_street']==1) $this->db->where('street_id', 0);
        if($params['empty_content']==1) $this->db->where('content', '');
        
        $results = $this->db->order_by('create_time', 'DESC')->get()->result_array();
        
        $i=2;
        foreach($results as $val) {
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $val['id']);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $val['title']);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $val['alias']);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $val['city_id']);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $val['district_id']);
            $i++;
        }
        
        $filename = "RealEstate". date("Y-m-d-H-i-s").".csv";
        header("Content-Transfer-Encoding: binary"); 
        header('Content-Type: application/vnd.ms-excel; charset=UTF-8'); 
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0'); 
        header('Pragma: no-cache'); 
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');  
        echo "\xEF\xBB\xBF"; //UTF-8 BOM
        $objWriter->save('php://output');
    }
}