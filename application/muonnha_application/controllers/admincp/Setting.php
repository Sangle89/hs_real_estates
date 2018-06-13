<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'core/MY_Admin.php';
class Setting extends MY_Admin {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('setting_model');
    }
    
    public function website() {
        
        $data['setting'] = $this->setting_model->_Get_Setting();
        
        if($this->input->post()) {
            $this->setting_model->_Update_Setting($this->input->post());
            $this->session->set_flashdata('message', 'Cập nhật thành công!');
            redirect($this->uri->uri_string());
        }
        
        $this->template->_Set_View('setting/website', $data);
        $this->template->_Render();
    }
    
    public function email() {
        $data['setting'] = $this->setting_model->_Get_Setting();
        if($this->input->post()) {
            $this->setting_model->_Update_Email($this->input->post());
			$this->session->set_flashdata('message', 'Cập nhật thành công!');
            redirect($this->uri->uri_string());
        }
        $this->template->_Set_View('setting/email', $data);
        $this->template->_Render();
    }
    
    public function deleteid() {
        $data = array();
        if($this->input->post()) {
            $ids = $this->input->post('ids');
            $array_id = explode(",", trim($ids));
            if(is_array($array_id) && !empty($array_id)) {
                $this->load->database();
                $this->db->where_in('id', $array_id)->delete('real_estates');
                $deleted_id = $this->db->affected_rows();
                $data['deleted']['real_estate'] = $deleted_id;
                $this->db->where_in('real_estate_id', $array_id)->delete('real_estate_images');
                $deleted_id = $this->db->affected_rows();
                $data['deleted']['images'] = $deleted_id;
                $this->db->where('controller', 'real_estate')->where_in('value', $array_id)->delete('app_routes');
                $deleted_id = $this->db->affected_rows();
                $data['deleted']['router'] = $deleted_id;
                $this->session->set_flashdata('info', $data['deleted']);
                redirect(admin_url('setting/deleteid'));
            }
        }
        $this->template->_Set_View('setting/deleteid', $data);
        $this->template->_Render();
    }
    
    public function cleancache() {
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
        $this->cache->clean();
        redirect($_SERVER["HTTP_REFERER"]);
    }
}