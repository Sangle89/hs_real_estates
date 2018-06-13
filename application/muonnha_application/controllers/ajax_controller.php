<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ajax_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('function');
        $this->load->model('model_bdscategory', 'bdscategory');
        $this->load->model('model_district', 'district');
        $this->load->model('model_ward', 'ward');
        
    }
    
    function getCategory() {
        $category_id = $this->input->get('category_id');
        $category = $this->bdscategory->get_bdscategories(array('parent_id'=>$category_id));
        foreach($category as $row) {
            echo '<option value="'.$row['id'].'">'.$row['title'].'</option>';
        }
    }
    
    function getDistrict() {
        $category_id = $this->input->get('city_id');
        $category = $this->district->get_districts(array('town_id'=>$category_id));
        foreach($category as $row) {
            echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
    }
    
    function getWard() {
        $category_id = $this->input->get('district_id');
        $category = $this->ward->get_wards(array('district_id'=>$category_id));
        foreach($category as $row) {
            echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
    }
    
    public function getwardoption()
    {
        $this->load->model('model_ward');
        $results = $this->model_ward->get_wards(array('district_id'=>$this->input->get('district_id')));
        if($this->input->get('ward_id')){
            $selected = (int)$this->input->get('ward_id');
        }else{
            $selected = array();
        }
        $string_option = '<option value="0">--Chọn phường--</option>';
        foreach($results as $result){
            if($this->input->get('ward_id') && $result['id']==$this->input->get('ward_id'))
                $string_option .= '<option value="'.$result['id'].'" selected="true">'.$result['name'].'</option>';
            else
                $string_option .= '<option value="'.$result['id'].'">'.$result['name'].'</option>';
        }
        echo $string_option;
    }
    
    function getSubCategory()
    {
        //$this->load->model('model_bdscategory');
        $results = $this->bdscategory->get_bdscategories(array('parent_id'=>$this->input->get('cat_id')));
        $html = '';
        foreach($results as $result){
            $html .= '<div class="item"><label><input class="inputSubCategory" type="radio" name="cat_id" value="'.$result['id'].'">'.$result['title'].'</label></div>';
        }
        echo $html;
    }
    
    function getDistrictByTown()
    {
        $this->load->model('model_district');
        $results = $this->model_district->get_districts(array('town_id'=>$this->input->get('town_id')));
        $html = '';
        foreach($results as $result){
            $html .= '<div class="item"><label><input class="inputDistrict" type="checkbox" name="district_id" value="'.$result['id'].'">'.$result['name'].'</label></div>';
        }
        echo $html;
    }
    
    function getWardByDistrict()
    {
        $this->load->model('model_ward');
        $results = $this->model_ward->get_wards(array('district_id'=>$this->input->get('district_id')));
        $html = '';
        foreach($results as $result){
            $html .= '<div class="item"><label><input class="inputWard" type="checkbox" name="ward_id" value="'.$result['id'].'">'.$result['name'].'</label></div>';
        }
        echo $html;
    }
    
    function uploadImage() {
        $upload_data = _Upload_Image('uploadfile');
        
        $res = array(
            'success' => true,
            'file_name' => $upload_data['file_name'],
            'file_url' => base_url('upload/'.$upload_data['file_name'])
        );
        
        echo json_encode($res);
    }
    
    function uploadImages() {
        $upload_data = _Upload_Image('uploadfile');
        
        $res = array(
            'success' => true,
            'file_name' => $upload_data['file_name'],
            'file_url' => base_url('upload/'.$upload_data['file_name'])
        );
        
        echo json_encode($res);
    }
    
    function getPartket() {
        $partket = $this->input->get('partket');
        $date = $this->input->get('date_expirate');
        $this->load->model('model_partket');
        $partket_detail = $this->model_partket->get_by_id($partket);
        if($partket_detail['price']==0) 
            echo 'Miễn phí';
        else
            echo number_format($partket_detail['price'] * $date).'đ';
    }
    
    function up_tin() {
        $id = $this->input->post('id');
        $this->load->database();
        $this->db->where('id', (int)$id)->update('bds', array('date_added', date('Y-m-d H:i:s', time())));
        echo 'Cập nhật thành công '.$this->db->affected_rows().' tin';
    }
}
?>