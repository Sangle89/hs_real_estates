<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ExcelReader extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
	} 
	
    public function index() {
        require APPPATH . "/third_party/phpexcel/PHPExcel/IOFactory.php";
        $inputFileName = './excel_data/nha-cho-thue.xlsx';
        //  Read your Excel workbook
        try {
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);
        } catch(Exception $e) {
            die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
        }
        
        //  Get worksheet dimensions
        $sheet = $objPHPExcel->getSheet(0); 
        $highestRow = $sheet->getHighestRow(); 
        $highestColumn = $sheet->getHighestColumn();
        
        //  Loop through each row of the worksheet in turn
        for ($row = 1; $row <= $highestRow; $row++){ 
            //  Read a row of data into an array
            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                            NULL,
                                            TRUE,
                                            FALSE);
            //  Insert row data array into your database of choice here
            if($row > 1) {
                $fopen = fopen("./data/link_nha_cho_thue.txt", "a");
                fwrite($fopen, $rowData[0][3]."\n");
                fclose($fopen); 
            }
             
        }
    }
}