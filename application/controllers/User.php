<?php
require_once APPPATH . '/core/MY_Controller.php';
class User extends MY_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model(array(
            'cache/main_model',
            'content_category_model',
            'routes_model'
        ));
        
        $this->load->library(array('pagination','breadcrumb','ion_auth'));
        $this->breadcrumb->__construct(array(
            'tag_open' => '<ul class="breadcrumb">',
            'tag_close' => '</ul>'
        ));
        $this->breadcrumb->append_crumb('<i class="fa fa-home"></i>', site_url());
        $this->data = array();
        $web_setting = $this->main_model->_Get_Setting();
        $this->template->_Set_Config($web_setting);
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
    }
    
    function managerproduct($page=1) {
        $user_id = $this->ion_auth->get_user_id();
        $param = array();
        $param['user_id'] = $user_id;
        if($this->input->get('from_date')) {
            $param['from_date'] = _convert_date1($this->input->get('from_date'));
        }
        if($this->input->get('to_date')) {
            $param['to_date'] = _convert_date1($this->input->get('to_date'));
        }
        if($this->input->get('type')) {
            $param['type'] = $this->input->get('type');
        }
        if($this->input->get('status')) {
            $param['status'] = $this->input->get('status');
        }
        if($this->input->get('product_id')) {
            $param['product_id'] = $this->input->get('product_id');
        }
        //pagination
        $base_url = base_url('trang-ca-nhan/uspg-quan-ly-tin-rao/p');
        $per_page = 10;
        $total_row = $this->main_model->_Count_Real_Estate_By_User($param);
        
        $this->data['pagination'] = pagination($base_url, $total_row, $per_page, $page);
        
        
        $this->breadcrumb->append_crumb('Quản lý tin rao', site_url('trang-ca-nhan/uspg-quan-ly-tin-rao'));
        
        $this->data['results'] = $this->main_model->_Get_Real_Estate_By_User($param, $per_page, ($page-1)*10);
        $this->template->_Set_Data('cur_page', 'manager_product');
       // $this->template->_Set_Config($config);
        $this->template->_Set_View('user/manager_product', $this->data);
        $this->template->_Render();
    }
    
    /**
    * Dang tin mien phi
    */
    function newproduct($catid = 24) {
        
        if(get_cookie('customer_post_count') > 2 && !$this->ion_auth->logged_in()) {
            $this->data['message'] = 'Bạn chỉ được đăng tối đa 3 tin trong ngày';
            $this->template->_Set_View('notify/gioihan_tindang', $this->data);
            $this->template->_Render();
        } else {
            if($this->input->post()) {
            	$data['post'] = $this->input->post();
                $this->form_validation->set_rules('title', 'Tiêu đề', 'trim|required|max_length[99]|min_length[20]');
                $this->form_validation->set_rules('category_id', 'Loại nhà đất', 'required|callback__check_category');
                $this->form_validation->set_rules('district_id', 'Quận/Huyện', 'required|callback__check_district');
                $this->form_validation->set_rules('content', 'Nội dung mô tả', 'trim|required|max_length[5000]');
                $this->form_validation->set_rules('from_date', 'Từ ngày', 'required');
                $this->form_validation->set_rules('to_date', 'Đến ngày', 'required');
                $this->form_validation->set_rules('captcha', 'Mã an toàn', 'required|callback__captcha_validate');

                if($this->form_validation->run()) {
                    $data = $this->input->post();
                    $id = $this->main_model->_Add_Real_Estate($data);

                    $cookie_count_post = get_cookie('customer_post_count', $xss_clean);
                    if(!$cookie_count_post) {
                        set_cookie('customer_post_count', 1, 3600 * 24);
                    } else {
                        set_cookie('customer_post_count', $cookie_count_post+1, 3600 * 24);
                    }
                    $data = array(
                        'title' => $data['title'],
                        'id' => $id
                    );
                    $this->session->set_flashdata('success', 'Thêm thành công!');
                    $this->session->set_flashdata('post_title', $data['title']);
                    $this->session->set_flashdata('post_id', $id);
                    redirect('dang-tin-thanh-cong', $data);
                }
            }

            $config = array(
                'title' => 'Đăng tin cho thuê nhà đất miễn phí hiệu quả nhất',
                'keywords' => 'Đăng tin cho thuê nhà đất miễn phí hiệu quả nhất',
                'description' => 'Đăng tin cho thuê nhà đất miễn phí hiệu quả nhất'
            );
            $this->data['catid'] = $catid;
            if($this->ion_auth->logged_in())
                $this->data['user'] = $this->template->_Get_Data('user');
            
        $this->breadcrumb->append_crumb('Đăng tin', site_url('dang-tin-nha-ban'));
            $this->data['cur_page'] = 'updateproduct';
            $this->template->_Set_Config($config);
            $this->template->_Set_View('user/new_product', $this->data);
            $this->template->_Render();
        }
    }
    
    function _check_category() {
        if($this->input->post('category_id')==0) {
            $this->form_validation->set_message('_check_category', 'Bạn chưa chọn danh mục');
            return false;
        } else {
            return true;
        }
    }
    function _check_city() {
        if($this->input->post('city_id')==0) {
            $this->form_validation->set_message('_check_city', 'Bạn chưa chọn tỉnh thành');
            return false;
        } else {
            return true;
        }
    }
    function _check_district() {
        if($this->input->post('district_id')==0) {
            $this->form_validation->set_message('_check_district', 'Bạn chưa chọn quận huyện');
            return false;
        } else {
            return true;
        }
    }
    
    function dangtin_thanhcong() {
        $this->template->_Set_Config($config);
        $this->template->_Set_View('notify/dangtin_thanhcong', $this->data);
        $this->template->_Render();
    }
    
    function thongbao_tubanquantri() {
        $this->template->_Set_Config($config);
        $this->template->_Set_View('user/thongbao_tubanquantri', $this->data);
        $this->template->_Render();
    }
    
    function updateproduct($id) {
        $user_id = $this->ion_auth->get_user_id();
        $result = $this->main_model->_Get_Real_Estate_By_User_Id($id, $user_id);
        $real_utilities = $this->main_model->_Get_Real_Estate_Utilities($id);
        $user = $this->ion_auth->user($user_id);
        
        if(empty($result)) {
            redirect('thong-bao-loi');
        } else {
            
            if($this->input->post()) {
                $this->form_validation->set_rules('title', 'Tiêu đề', 'required');
                $this->form_validation->set_rules('captcha', 'Mã an toàn', 'required|callback__captcha_validate');

                if($this->form_validation->run()) {
                    $data = $this->input->post();
                    $this->main_model->_Update_Real_Estate($id, $data);

                    $cookie_count_post = get_cookie('customer_post_count', $xss_clean);
                    
                    if(!$cookie_count_post) {
                        set_cookie('customer_post_count', 1, 3600 * 24);
                    } else {
                        set_cookie('customer_post_count', $cookie_count_post+1, 3600 * 24);
                    }

                    $this->session->set_flashdata('success', 'Cập nhật thành công!');
                    redirect(current_url());
                }
            }
            
        $this->breadcrumb->append_crumb('Sửa tin đăng', site_url('trang-ca-nhan/uspg-updateproduct'));
            $this->data['result'] = $result;
            $this->data['real_utilities'] = $real_utilities;
            $this->data['images'] = $this->main_model->_Get_Real_Estate_Images($result['id']);
            $this->data['user'] = $user;
            $this->data['cur_page'] = 'updateproduct';
            $this->template->_Set_Data('cur_page', 'update_product');
            $this->template->_Set_Config($result);
            $this->template->_Set_View('user/update_product', $this->data);
            $this->template->_Render();
        }
    }
    
    function renewproduct($id) {
        $this->main_model->_Renew_Real_Estate($id);
        $this->session->set_flashdata('renew_success', 'Làm mới tin thành công');
        redirect(site_url('trang-ca-nhan/uspg-quan-ly-tin-rao'));
    }
    
    function delete_product($id) {
        $user_id = $this->ion_auth->get_user_id();
        $id = (int)$this->uri->segment(2);
        $this->main_model->_Delete_Real_Estate_By_User_Id($id, $user_id);
        $this->session->set_flashdata('message', 'Xóa thành công!');
        redirect(site_url('quan-ly-tin-dang'));
    }
    
    /**
    * Đăng ký thành viên
    */
    function register() {
        
        if($this->input->post()) {
            
            $this->form_validation->set_rules('first_name', 'Họ tên', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('captcha', 'Mã an toàn', 'trim|required|callback__captcha_validate');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
            $this->form_validation->set_rules('mobiphone', 'Di động', 'trim|required|min_length[8]|max_length[15]');
            $this->form_validation->set_rules('telephone', 'Số điện thoại', 'trim|max_length[15]');
            $this->form_validation->set_rules('password', 'Mật khẩu', 'required|max_length[20]');
            $this->form_validation->set_rules('repassword', 'Xác nhận Mật khẩu', 'required|max_length[20]|matches[password]');
            
            $this->form_validation->set_message('is_unique', 'Email này đã được đăng ký, vui lòng nhập Email khác.');
            
            if($this->form_validation->run()) {
                $email    = strtolower($this->input->post('email'));
                $identity = ($identity_column==='email') ? $email : $this->input->post('identity');
                $password = $this->input->post('password');
                $additional_data = array(
                    'first_name' => $this->input->post('first_name'),
                    'gender'  => $this->input->post('gender'),
                    'account_type'    => $this->input->post('account_type'),
                    'mobiphone'      => $this->input->post('mobiphone'),
                    'city_id'    => $this->input->post('city'),
                    'district_id' => $this->input->post('district')
                );
                if($_FILES['uploadavatar']['name'] && $_FILES['uploadavatar']['size']) {
                    $upload = _Upload_Avatar('uploadavatar');
                    _Resize_Img($upload['full_path'], $upload['file_path'], 300, 300);
                    $data['avatar'] = $upload['file_name'];
                } else {
                    $additional_data['avatar'] = '';
                }
                if ($this->form_validation->run() == true && $this->ion_auth->register($identity, $password, $email, $additional_data))
                {
                        // check to see if we are creating the user
                        // redirect them back to the admin page
                        /*$this->session->set_flashdata('message', '<p>Đăng ký tài khoản thành công.</p>
                        <p>Chúng tôi đã gửi một email yêu cầu kích hoạt tài khoản tới địa chỉ . Bạn vui lòng kiểm tra email này và thực hiện thao tác kích hoạt tài khoản theo hướng dẫn trong nội dung email.</p>
                        <p><i>(Lưu ý: Trong một số trường hợp, email này có thể bị hòm thư của bạn lọc vào thư mục spam. Vì vậy, nếu phải đợi lâu mà vẫn không thấy email này được gửi đến thì bạn vui lòng kiểm tra trong thư mục spam. Nếu bạn gặp trục trặc trong quá trình đăng ký hoặc đăng tin xin vui lòng liên lạc với chúng tôi qua email: <a href="mailto:muonnha.com.vn@gmail.com">muonnha.com.vn@gmail.com</a> để chúng tôi hỗ trợ)</i></p>');*/
                        $this->session->set_flashdata('email', $identity);
						redirect("dang-ky-thanh-cong", 'refresh');
                }
                
            } 
            
        }
        
        $config = array(
            'title' => 'Đăng ký thành viên'
        );
        
        $this->breadcrumb->append_crumb('Đăng ký', site_url('dang-ky'));
        $this->data['cur_page'] = 'register';
		$this->template->_Set_Config($config);
        $this->template->_Set_View('user/register', $this->data);
        $this->template->_Render();
        
    }
	
	function register_success(){
		$this->template->_Set_View('notify/register_success');
        $this->template->_Render();	
	}
    
    function login() {
        
        $this->form_validation->set_rules('identity', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
		$this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');
		if ($this->form_validation->run() == true)
		{
			// check to see if the user is logging in
			// check for "remember me"
			$remember = (bool) $this->input->post('remember');
			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
			{
				//if the login is successful
				//redirect them back to the home page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect(site_url('trang-ca-nhan/uspg-quan-ly-tin-rao'), 'refresh');
			}
			else
			{
				// if the login was un-successful
				// redirect them back to the login page
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect(site_url('dang-nhap'), 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
			}
		}
		else
		{
			// the user is not logging in so display the login page
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->data['identity'] = array('name' => 'identity',
				'id'    => 'username',
				'type'  => 'text',
				'class' => 'form-control',
                'placeholder' => 'Email đăng nhập',
                'aria-describedby' => 'icon-identity',
				'value' => $this->form_validation->set_value('identity'),
                'required' => 'true'
			);
			$this->data['password'] = array('name' => 'password',
				'id'   => 'password',
                'placeholder' => 'Mật khẩu',
				'class' => 'form-control',
                'aria-describedby' => 'icon-password',
				'type' => 'password',
                'required' => 'true'
			);
		  $config = array(
            'title' => 'Đăng nhập'
        );
        
        $this->breadcrumb->append_crumb('Đăng nhập', site_url('dang-nhap'));
        $this->data['cur_page'] = 'login';
		$this->template->_Set_Config($config);
        $this->template->_Set_View('user/login', $this->data);
        $this->template->_Render();
		}
    }
    
    function dang_xuat() {
        $this->ion_auth->logout();
        redirect(site_url());
    }
    
    function profile() {
        if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('dang-nhap', 'refresh');
		}
       
        $id = $this->ion_auth->get_user_id();
		$this->data['title'] = $this->lang->line('edit_user_heading');
		$user = $this->ion_auth->user($id)->row();
		$groups=$this->ion_auth->groups()->result_array();
		$currentGroups = $this->ion_auth->get_users_groups($id)->result();
		// validate form input
		$this->form_validation->set_rules('first_name', 'Họ tên', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('mobiphone', 'Số điện thoại di động', 'required');
		//$this->form_validation->set_rules('company', $this->lang->line('edit_user_validation_company_label'), 'required');
		if (isset($_POST) && !empty($_POST))
		{
			// do we have a valid request?
			if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
			{
				show_error($this->lang->line('error_csrf'));
                
			}
			// update the password if it was posted
			if ($this->input->post('password'))
			{
				$this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
			}
			if ($this->form_validation->run() === TRUE)
			{
			 
				$data = array(
					'first_name' => $this->input->post('first_name'),
					'gender'  => $this->input->post('gender'),
                    'account_type'    => $this->input->post('account_type'),
					'company'    => $this->input->post('company'),
					'mobiphone'      => $this->input->post('mobiphone'),
                    'telephone'      => $this->input->post('telephone'),
                    'city_id'    => $this->input->post('city_id'),
                    'district_id' => $this->input->post('district_id'),
				);
                
                if($_FILES['uploadavatar']['name'] && $_FILES['uploadavatar']['size']) {
                    $upload = _Upload_Avatar('uploadavatar');
                    _Resize_Img($upload['full_path'], $upload['file_path'], 300, 300);
                    $data['avatar'] = $upload['file_name'];
                } 
                
				// update the password if it was posted
				if ($this->input->post('password'))
				{
					$data['password'] = $this->input->post('password');
				}
				// Only allow updating groups if user is admin
				if ($this->ion_auth->is_admin())
				{
					//Update the groups user belongs to
					$groupData = $this->input->post('groups');
					if (isset($groupData) && !empty($groupData)) {
						$this->ion_auth->remove_from_group('', $id);
						foreach ($groupData as $grp) {
							$this->ion_auth->add_to_group($grp, $id);
						}
					}
				}
		
			   if($this->ion_auth->update($user->id, $data))
			    {
				    $this->session->set_flashdata('message', 'Cập nhật thành công!' );
				    redirect(site_url('trang-ca-nhan/uspg-thong-tin-ca-nhan'), 'refresh');
			    }
			    else
			    {
				    $this->session->set_flashdata('message', $this->ion_auth->errors() );
				    redirect('/', 'refresh');
			    }
			}
		}
        
        $this->data['user_id'] = $id;
		// display the edit user form
		$this->data['csrf'] = $this->_get_csrf_nonce();
		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		// pass the user to the view
		$this->data['user'] = $user;
		$this->data['groups'] = $groups;
		$this->data['currentGroups'] = $currentGroups;
		$this->data['first_name'] = array(
			'name'  => 'first_name',
			'id'    => 'first_name',
            'class' => 'form-control',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('first_name', $user->first_name),
		);
		$this->data['last_name'] = array(
			'name'  => 'last_name',
			'id'    => 'last_name',
            'class' => 'form-control',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('last_name', $user->last_name),
		);
		$this->data['company'] = array(
			'name'  => 'company',
			'id'    => 'company',
            'class' => 'form-control',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('company', $user->company),
		);
		$this->data['mobiphone'] = array(
			'name'  => 'mobiphone',
			'id'    => 'phone',
            'class' => 'form-control',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('mobiphone', $user->mobiphone),
		);
        $this->data['telephone'] = array(
			'name'  => 'telephone',
			'id'    => 'phone',
            'class' => 'form-control',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('telephone', $user->telephone),
		);
        $this->data['city_id'] = $user->city_id;
        $this->data['district_id'] = $user->district_id;
        $this->data['facebook'] = array(
			'name'  => 'facebook',
			'id'    => 'facebook',
            'class' => 'form-control',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('facebook', $user->facebook),
		);
        $this->data['twitter'] = array(
			'name'  => 'twitter',
			'id'    => 'twitter',
            'class' => 'form-control',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('twitter', $user->twitter),
		);
        $this->data['skype'] = array(
			'name'  => 'skype',
			'id'    => 'skype',
            'class' => 'form-control',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('skype', $user->skype),
		);
        $this->data['avatar'] = $user->avatar;
        $this->data['gender'] = $user->gender;
        $this->data['account_type'] = $user->account_type;
		$this->data['password'] = array(
			'name' => 'password',
			'id'   => 'password',
            'class' => 'form-control',
			'type' => 'password'
		);
		$this->data['password_confirm'] = array(
			'name' => 'password_confirm',
			'id'   => 'password_confirm',
            'class' => 'form-control',
			'type' => 'password'
		);
        
        $this->breadcrumb->append_crumb('Thông tin cá nhân', site_url('trang-ca-nhan/uspg-thong-tin-ca-nhan'));
        $this->data['cur_page'] = 'profile';
        $this->template->_Set_Config($config);
        $this->template->_Set_View('user/profile', $this->data);
        $this->template->_Render();
    }
    
    function change_password() {
        if (!$this->ion_auth->logged_in())
		{
			redirect('dang-nhap', 'refresh');
		}
       
        $id = $this->ion_auth->get_user_id();
		$this->data['title'] = $this->lang->line('edit_user_heading');
		$user = $this->ion_auth->user($id)->row();
		if (isset($_POST) && !empty($_POST))
		{
            $this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
		      $this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
			// do we have a valid request?
			if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
			{
				show_error($this->lang->line('error_csrf'));
                
			}
			// update the password if it was posted
			if ($this->input->post('password'))
			{
				
			}
			if ($this->form_validation->run() === TRUE)
			{
                $data['password'] = $this->input->post('password');
			   if($this->ion_auth->update($user->id, $data))
			    {
				    $this->session->set_flashdata('message', 'Cập nhật thành công!' );
				    redirect(site_url('tai-khoan'), 'refresh');
			    }
			    else
			    {
				    $this->session->set_flashdata('message', $this->ion_auth->errors() );
				    redirect('/', 'refresh');
			    }
			}
		}
        
        $this->data['user_id'] = $id;
		// display the edit user form
		$this->data['csrf'] = $this->_get_csrf_nonce();
		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		// pass the user to the view
		$this->data['user'] = $user;
		$this->data['curpassword'] = array(
			'name' => 'curpassword',
			'id'   => 'curpassword',
            'class' => 'form-control',
			'type' => 'password'
		);
		$this->data['password'] = array(
			'name' => 'password',
			'id'   => 'password',
            'class' => 'form-control',
			'type' => 'password'
		);
		$this->data['password_confirm'] = array(
			'name' => 'password_confirm',
			'id'   => 'password_confirm',
            'class' => 'form-control',
			'type' => 'password'
		);
        
        $this->breadcrumb->append_crumb('Thay đổi mật khẩu', site_url('trang-ca-nhan/uspg-doi-mat-khau'));
        $this->data['cur_page'] = 'changepassword';
        $this->template->_Set_Config($config);
        $this->template->_Set_View('user/change_password', $this->data);
        $this->template->_Render();
    }
    
    // forgot password
	function forgot_password()
	{
		// setting validation rules by checking whether identity is username or email
		if($this->config->item('identity', 'ion_auth') != 'email' )
		{
		   $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_identity_label'), 'required');
		}
		else
		{
		   $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
		}
        $this->form_validation->set_rules('captcha', 'Mã an toàn', 'trim|required|callback__captcha_validate');
		if ($this->form_validation->run() == false)
		{
			$this->data['type'] = $this->config->item('identity','ion_auth');
			// setup the input
			$this->data['identity'] = array(
                'name' => 'identity',
				'id' => 'identity',
                'aria-describedby' => 'icon-user'
			);
			if ( $this->config->item('identity', 'ion_auth') != 'email' ){
				$this->data['identity_label'] = $this->lang->line('forgot_password_identity_label');
			}
			else
			{
				$this->data['identity_label'] = 'Email của bạn';
			}
            $this->data['cur_page'] = 'forgot_password';
			// set any errors and display the form
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			//$this->template->_Set_Config($config);
            $this->template->_Set_View('user/forgot_password', $this->data);
            $this->template->_Render();
		}
		else
		{
			$identity_column = $this->config->item('identity','ion_auth');
			$identity = $this->ion_auth->where($identity_column, $this->input->post('identity'))->users()->row();
			if(empty($identity)) {
	            		if($this->config->item('identity', 'ion_auth') != 'email')
		            	{
		            		$this->ion_auth->set_error('forgot_password_identity_not_found');
		            	}
		            	else
		            	{
		            	   $this->ion_auth->set_error('forgot_password_email_not_found');
		            	}
		                $this->session->set_flashdata('message', $this->ion_auth->errors());
                		redirect("quen-mat-khau", 'refresh');
            		}
			// run the forgotten password method to email an activation code to the user
			$forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});
			if ($forgotten)
			{
				// if there were no errors
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("dang-nhap", 'refresh'); //we should display a confirmation page here instead of the login page
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect("quen-mat-khau", 'refresh');
			}
		}
	}
	// reset password - final step for forgotten password
	public function reset_password($code = NULL)
	{
		if (!$code)
		{
			show_404();
		}
		$user = $this->ion_auth->forgotten_password_check($code);
		if ($user)
		{
			// if the code is valid then display the password reset form
			$this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
			$this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');
			if ($this->form_validation->run() == false)
			{
				// display the form
				// set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
				$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
				$this->data['new_password'] = array(
					'name' => 'new',
					'id'   => 'new',
					'type' => 'password',
					'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
				);
				$this->data['new_password_confirm'] = array(
					'name'    => 'new_confirm',
					'id'      => 'new_confirm',
					'type'    => 'password',
					'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
				);
				$this->data['user_id'] = array(
					'name'  => 'user_id',
					'id'    => 'user_id',
					'type'  => 'hidden',
					'value' => $user->id,
				);
				$this->data['csrf'] = $this->_get_csrf_nonce();
				$this->data['code'] = $code;
				$this->data['cur_page'] = 'reset_password';
                // render
				$this->template->_Set_Config($config);
                $this->template->_Set_View('user/reset_password', $this->data);
                $this->template->_Render();
			}
			else
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id'))
				{
					// something fishy might be up
					$this->ion_auth->clear_forgotten_password_code($code);
					show_error($this->lang->line('error_csrf'));
				}
				else
				{
					// finally change the password
					$identity = $user->{$this->config->item('identity', 'ion_auth')};
					$change = $this->ion_auth->reset_password($identity, $this->input->post('new'));
					if ($change)
					{
						// if the password was successfully changed
						$this->session->set_flashdata('message', $this->ion_auth->messages());
						redirect("dang-nhap", 'refresh');
					}
					else
					{
						$this->session->set_flashdata('message', $this->ion_auth->errors());
						redirect('quen-mat-khau' . $code, 'refresh');
					}
				}
			}
		}
		else
		{
			// if the code is invalid then send them back to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("quen-mat-khau", 'refresh');
		}
	}
    
    // activate the user
	function activate($id, $code=false)
	{
		if ($code !== false)
		{
			$activation = $this->ion_auth->activate($id, $code);
		}
		else if ($this->ion_auth->is_admin())
		{
			$activation = $this->ion_auth->activate($id);
		}
		if ($activation)
		{
		      $userinfo = $this->ion_auth->user($id)->row();
			// redirect them to the auth page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
            $this->session->set_flashdata('email', $userinfo->email);
			redirect("kich-hoat-thanh-cong", 'refresh');
		}
		else
		{
			// redirect them to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("quen-mat-khau", 'refresh');
		}
	}
    
    function activate_success(){
		$this->template->_Set_View('notify/activate_success');
        $this->template->_Render();	
	}
    
	// deactivate the user
	function deactivate($id = NULL)
	{
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
		$id = (int) $id;
		$this->load->library('form_validation');
		$this->form_validation->set_rules('confirm', $this->lang->line('deactivate_validation_confirm_label'), 'required');
		$this->form_validation->set_rules('id', $this->lang->line('deactivate_validation_user_id_label'), 'required|alpha_numeric');
		if ($this->form_validation->run() == FALSE)
		{
			// insert csrf check
			$this->data['csrf'] = $this->_get_csrf_nonce();
			$this->data['user'] = $this->ion_auth->user($id)->row();
			$this->_render_page('auth/deactivate_user', $this->data);
		}
		else
		{
			// do we really want to deactivate?
			if ($this->input->post('confirm') == 'yes')
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
				{
					show_error($this->lang->line('error_csrf'));
				}
				// do we have the right userlevel?
				if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
				{
					$this->ion_auth->deactivate($id);
				}
			}
			// redirect them back to the auth page
			redirect('auth', 'refresh');
		}
	}
    
    function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key   = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);
		return array($key => $value);
	}
	function _valid_csrf_nonce()
	{
        return TRUE;
	}
    
    function _captcha_validate($str) {
        if($this->session->userdata('captcha_word') != $str) {
            $this->form_validation->set_message('_captcha_validate', 'Mã captcha không đúng');
            return false;
        } else {
            return true;
        }
    }
    
    function admin_message($page=1) {
        $user_id = $this->ion_auth->get_user_id();
        $param = array();
        $param['user_id'] = $user_id;
        
        $this->breadcrumb->append_crumb('Thông báo từ ban quản trị', site_url('tien-ich/uspg-thong-bao-tu-ban-quan-tri'));
        
        //pagination
        $base_url = base_url('tien-ich/uspg-thong-bao-tu-ban-quan-tri/p');
        $per_page = 10;
        $total_row = $this->main_model->_Count_Real_Estate_By_User($param);
        
        $this->data['pagination'] = pagination($base_url, $total_row, $per_page, $page);
        
        $this->data['results'] = $this->main_model->_Get_User_Msgs($user_id, $per_page, ($page-1)*10);
        $this->template->_Set_Data('cur_page', 'manager_product');
       // $this->template->_Set_Config($config);
        $this->template->_Set_View('user/admin_message', $this->data);
        $this->template->_Render();
    }
    
    function message($page=1) {
        $user_id = $this->ion_auth->get_user_id();
        $param = array();
        $param['user_id'] = $user_id;
        
        $this->breadcrumb->append_crumb('Quản lý tin nhắn', site_url('trang-ca-nhan/uspg-message'));
        
        //pagination
        $base_url = base_url('trang-ca-nhan/uspg-message/p');
        $per_page = 10;
        $total_row = $this->main_model->_Count_Real_Estate_By_User($param);
        
        $this->data['pagination'] = pagination($base_url, $total_row, $per_page, $page);
        
        $this->data['results'] = $this->main_model->_Get_User_Msgs($user_id, $per_page, ($page-1)*10);
        $this->template->_Set_Data('cur_page', 'manager_product');
       // $this->template->_Set_Config($config);
        $this->template->_Set_View('user/message', $this->data);
        $this->template->_Render();
    }
    
    function view_message($id) {
        $user_id = $this->ion_auth->get_user_id();
        $param = array();
        $param['user_id'] = $user_id;
        
        $this->data['result'] = $this->main_model->_Get_User_Msg($user_id,$id);
        
        if(!$this->data['result']) redirect(site_url('trang-ca-nhan/uspg-message'));
        $this->main_model->_Update_Msg_Status($user_id, $id);
        $this->template->_Set_Data('cur_page', 'manager_product');
       // $this->template->_Set_Config($config);
        $this->template->_Set_View('user/view_message', $this->data);
        $this->template->_Render();
    }
    
    function delete_message($id) {
        $user_id = $this->ion_auth->get_user_id();
        $this->main_model->_Delete_Msg($user_id, $id);
        $this->session->set_flashdata('msg_success', 'Xóa thành công');
        redirect(site_url('trang-ca-nhan/uspg-message'));
    }
}