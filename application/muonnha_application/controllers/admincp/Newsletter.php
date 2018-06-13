<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'core/MY_Admin.php';
class Newsletter extends MY_Admin {
    public $title = 'Newsletter';
    function __construct() {
        parent::__construct();
        $this->load->model('newsletter_model');
        $this->load->library(array('pagination', 'form_validation'));
		$this->breadcrumb->append_crumb('Trang chủ', admin_url());
        $this->form_validation->set_rules('title', 'Title', 'required');
    }
    
    function index($page=0) {
		
		if($this->input->post()) {
            foreach($this->input->post('sort_order') as $id => $value) {
                $this->newsletter_model->_Update_Sort($id, $value);
            }
            $this->session->set_flashdata('message', 'Cập nhật thành công!');
            redirect(current_url());
        }
		
        $data = array();
        
		$base_url = admin_url($this->uri->segment(2) . '/index');
        $total_rows = $this->newsletter_model->_Count_All();
        $data['results'] = $this->newsletter_model->_Get_All(12, $page);
        
		$data['total'] = $total_rows;
        $data['total_page'] = ceil($total_rows/PER_PAGE);
		$data['pagination'] = admin_pagination($base_url, $total_rows, PER_PAGE, $page);
        $data['title'] = $this->title;
		$this->breadcrumb->append_crumb($this->title, admin_url($this->uri->segment(2)));
        
        $this->template->_Set_View('newsletter/view_all', $data);
        $this->template->_Render();
    }
    
    function export() {
        $fileName = 'DS_Email_'.date('d_m_Y',time());
        $title = 'Danh sách Email khách hàng';
        $desc = 'Danh sách Email khách hàng đã đăng ký tại website';
        require APPPATH . "third_party/phpexcel/PHPExcel.php";
        $obj = new PHPExcel();
        $obj->getProperties()->setCreator("SangIT")
				->setLastModifiedBy("SangIT")
				->setTitle($title)
				->setSubject($title)
				->setDescription($desc)
				->setKeywords("Newsletter Email")
				->setCategory($title);
        $obj->getActiveSheet()->setTitle($title);
        
        $obj->setActiveSheetIndex(0)
        ->setCellValue('A1', 'Email');
        
        $emails = $this->newsletter_model->_Get_All();
        $i=2;
        foreach($emails as $val) {
            $obj->getActiveSheet()->setCellValueByColumnAndRow('A', $i, $val['email']);
            $i++;
        }
        
       // require_once APPPATH."third_party/IOFactory.php";
        // set header information to force download
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        // Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file        
        // Write the Excel file to filename some_excel_file.xlsx in the current directory                
        $objWriter = new PHPExcel_Writer_Excel2007($obj); 
        // Write the Excel file to filename some_excel_file.xlsx in the current directory
        $objWriter->save('php://output');
    }
    
    function view($id) {
        $data = array();
        $data['title'] = $this->title;
        $data['post'] = $this->newsletter_model->_Get_By_Id($id);
        $this->newsletter_model->_Update_Viewed($id);
        $this->template->_Set_View('newsletter/view', $data);
        $this->template->_Render();
    }
    
    function add() {
        $data = array();
        $data['title'] = $this->title;
        if($this->input->post()) {
            $data['post'] = $this->input->post();
            
            
            $data['post']['image'] = _Upload_Image('image', UPLOAD_IMAGE);
           
            if($this->form_validation->run()) {
                $this->newsletter_model->_Add($data['post']);
                $this->session->set_flashdata('message', 'Success!');
                redirect(admin_url($this->uri->segment(2)));
            }
        }
        $this->template->_Set_View('newsletter/add', $data);
        $this->template->_Render();
    }
    
    function change($id) {
        $data = array();
        $data['title'] = $this->title;
        $data['post'] = $this->newsletter_model->_Get_By_Id($id);
        
        if($this->input->post()) {
            $data['post'] = $this->input->post();
            
            $data['post']['image'] = _Upload_Image('image', UPLOAD_IMAGE);
            
            if($this->form_validation->run()) {
                $this->newsletter_model->_Update($data['post'], $id);
                $this->session->set_flashdata('message', 'Success!');
                redirect(admin_url($this->uri->segment(2)));
            }
        }
        
        $this->template->_Set_View('newsletter/change', $data);
        $this->template->_Render();
    }
    
    function delete($id) {
        $this->newsletter_model->_Delete($id);
        redirect(admin_url($this->uri->segment(2)));
    }
}