<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'core/MY_Admin.php';
class User extends MY_Admin {
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth','form_validation'));
		$this->load->helper(array('url','language'));
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
		$this->lang->load('auth');
	}
	// redirect if needed, otherwise display the user list
	function index()
	{
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect(ADMIN_FOLDER . '/login', 'refresh');
		}
		elseif (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
		else
		{
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			//list the users
			$this->data['users'] = $this->ion_auth->users()->result();
            $this->data['total'] = $this->ion_auth->users()->num_rows();
            //$this->data['per_page'] = ceil();
			foreach ($this->data['users'] as $k => $user)
			{
				$this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
			}
			$this->template->_Set_View('user/all_user', $this->data);
            $this->template->_Render();
		}
	}
	// change password
	function change_password()
	{
		$this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
		$this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
		$this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}
		$user = $this->ion_auth->user()->row();
		if ($this->form_validation->run() == false)
		{
			// display the form
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
			$this->data['old_password'] = array(
				'name' => 'old',
				'id'   => 'old',
				'type' => 'password',
                'class' => 'form-control'
			);
			$this->data['new_password'] = array(
				'name'    => 'new',
				'id'      => 'new',
				'type'    => 'password',
				'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
                'class' => 'form-control'
			);
			$this->data['new_password_confirm'] = array(
				'name'    => 'new_confirm',
				'id'      => 'new_confirm',
				'type'    => 'password',
				'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
                'class' => 'form-control'
			);
			$this->data['user_id'] = array(
				'name'  => 'user_id',
				'id'    => 'user_id',
				'type'  => 'hidden',
				'value' => $user->id,
			);
			// render
            $this->template->_Set_View('user/change_password', $data);
            $this->template->_Render();
		}
		else
		{
			$identity = $this->session->userdata('identity');
			$change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));
			if ($change)
			{
				//if the password was successfully changed
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				$this->logout();
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect(ADMIN_FOLDER . '/user/change_password', 'refresh');
			}
		}
	}
    
    // log the user out
	function logout()
	{
		$this->data['title'] = "Logout";
		// log the user out
		$logout = $this->ion_auth->logout();
		// redirect them to the login page
		$this->session->set_flashdata('message', $this->ion_auth->messages());
		redirect(ADMIN_FOLDER . '/login', 'refresh');
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
		if ($this->form_validation->run() == false)
		{
			$this->data['type'] = $this->config->item('identity','ion_auth');
			// setup the input
			$this->data['identity'] = array('name' => 'identity',
				'id' => 'identity',
			);
			if ( $this->config->item('identity', 'ion_auth') != 'email' ){
				$this->data['identity_label'] = $this->lang->line('forgot_password_identity_label');
			}
			else
			{
				$this->data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
			}
			// set any errors and display the form
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->_render_page('auth/forgot_password', $this->data);
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
                		redirect("auth/forgot_password", 'refresh');
            		}
			// run the forgotten password method to email an activation code to the user
			$forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});
			if ($forgotten)
			{
				// if there were no errors
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("auth/login", 'refresh'); //we should display a confirmation page here instead of the login page
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect("auth/forgot_password", 'refresh');
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
				// render
				$this->_render_page('auth/reset_password', $this->data);
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
						redirect("auth/login", 'refresh');
					}
					else
					{
						$this->session->set_flashdata('message', $this->ion_auth->errors());
						redirect('auth/reset_password/' . $code, 'refresh');
					}
				}
			}
		}
		else
		{
			// if the code is invalid then send them back to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("auth/forgot_password", 'refresh');
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
			// redirect them to the auth page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect("auth", 'refresh');
		}
		else
		{
			// redirect them to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("auth/forgot_password", 'refresh');
		}
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
	// create a new user
	function create_user()
    {
        $this->data['title'] = $this->lang->line('create_user_heading');
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
        {
            redirect('auth', 'refresh');
        }
        $tables = $this->config->item('tables','ion_auth');
        $identity_column = $this->config->item('identity','ion_auth');
        $this->data['identity_column'] = $identity_column;
        $groups=$this->ion_auth->groups()->result_array();
        $this->data['groups'] = $groups;
        // validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required');
        $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required');
        if($identity_column!=='email')
        {
            $this->form_validation->set_rules('identity',$this->lang->line('create_user_validation_identity_label'),'required|is_unique['.$tables['users'].'.'.$identity_column.']');
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email');
        }
        else
        {
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|is_unique[' . $tables['users'] . '.email]');
        }
        $this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'trim');
        $this->form_validation->set_rules('company', $this->lang->line('create_user_validation_company_label'), 'trim');
        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');
        if ($this->form_validation->run() == true)
        {
            $email    = strtolower($this->input->post('email'));
            $identity = ($identity_column==='email') ? $email : $this->input->post('identity');
            $password = $this->input->post('password');
            $additional_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name'  => $this->input->post('last_name'),
                'company'    => $this->input->post('company'),
                'phone'      => $this->input->post('phone'),
            );
        }
        if ($this->form_validation->run() == true && $this->ion_auth->register($identity, $password, $email, $additional_data))
        {
            // check to see if we are creating the user
            // redirect them back to the admin page
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            redirect("admincp/user", 'refresh');
        }
        else
        {
            // display the create user form
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
            $this->data['first_name'] = array(
                'name'  => 'first_name',
                'id'    => 'first_name',
                'class' => 'form-control',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('first_name'),
            );
            $this->data['last_name'] = array(
                'name'  => 'last_name',
                'id'    => 'last_name',
                'class' => 'form-control',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('last_name'),
            );
            $this->data['identity'] = array(
                'name'  => 'identity',
                'id'    => 'identity',
                'class' => 'form-control',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('identity'),
            );
            $this->data['email'] = array(
                'name'  => 'email',
                'id'    => 'email',
                'class' => 'form-control',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('email'),
            );
            $this->data['address'] = array(
                'name'  => 'address',
                'id'    => 'address',
                'class' => 'form-control',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('address'),
            );
            $this->data['company'] = array(
                'name'  => 'company',
                'id'    => 'company',
                'class' => 'form-control',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('company'),
            );
            $this->data['phone'] = array(
                'name'  => 'phone',
                'id'    => 'phone',
                'class' => 'form-control',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('phone'),
            );
            $this->data['password'] = array(
                'name'  => 'password',
                'id'    => 'password',
                'class' => 'form-control',
                'type'  => 'password',
                'value' => $this->form_validation->set_value('password'),
            );
            $this->data['password_confirm'] = array(
                'name'  => 'password_confirm',
                'id'    => 'password_confirm',
                'class' => 'form-control',
                'type'  => 'password',
                'value' => $this->form_validation->set_value('password_confirm'),
            );
            $this->template->_Set_View('user/create_user', $this->data);
        $this->template->_Render();
        }
    }
    
    function profile() {
        $id = $this->ion_auth->get_user_id();
        $this->data['title'] = $this->lang->line('edit_user_heading');
		if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id)))
		{
			redirect(ADMIN_FOLDER . '/login', 'refresh');
		}
		$user = $this->ion_auth->user($id)->row();
		$groups=$this->ion_auth->groups()->result_array();
		$currentGroups = $this->ion_auth->get_users_groups($id)->result();
		// validate form input
		$this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'required');
		$this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'required');
		$this->form_validation->set_rules('mobiphone', $this->lang->line('edit_user_validation_phone_label'), 'required');
		$this->form_validation->set_rules('company', $this->lang->line('edit_user_validation_company_label'), 'required');
        $this->form_validation->set_rules('address', $this->lang->line('edit_user_validation_address_label'), 'required');
		if (isset($_POST) && !empty($_POST))
		{
			// do we have a valid request?
			if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
			{
				show_error($this->lang->line('error_csrf'));
			}
            
            //Upload avatar
            if($_FILES['avatar']['name']!='') {
                $this->form_validation->set_rules('avatar', 'Avatar', 'callback__check_avatar');
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
					'last_name'  => $this->input->post('last_name'),
					'company'    => $this->input->post('company'),
					'phone'      => $this->input->post('phone'),
                    'address'    => $this->input->post('address')
				);
                
                if($this->avatar) {
                    $data['avatar'] = $this->avatar;
                }else{
                    $data['avatar'] = $this->input->post('cur_avatar');
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
			// check to see if we are updating the user
			   if($this->ion_auth->update($user->id, $data))
			    {
			    	// redirect them back to the admin page if admin, or to the base url if non admin
				    $this->session->set_flashdata('message', $this->ion_auth->messages() );
				    if ($this->ion_auth->is_admin())
					{
						redirect(ADMIN_FOLDER . '/user', 'refresh');
					}
					else
					{
						redirect('/admin', 'refresh');
					}
			    }
			    else
			    {
			    	// redirect them back to the admin page if admin, or to the base url if non admin
				    $this->session->set_flashdata('message', $this->ion_auth->errors() );
				    if ($this->ion_auth->is_admin())
					{
						redirect(ADMIN_FOLDER . '/user', 'refresh');
					}
					else
					{
						redirect('/admin', 'refresh');
					}
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
		$this->data['phone'] = array(
			'name'  => 'phone',
			'id'    => 'phone',
            'class' => 'form-control',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('phone', $user->phone),
		);
        $this->data['address'] = array(
			'name'  => 'address',
			'id'    => 'address',
            'class' => 'form-control',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('address', $user->address),
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
        $this->data['avatar'] = array(
			'name' => 'avatar',
			'id'   => 'avatar',
            'class' => 'form-control',
			'type' => 'file'
		);
        $this->data['cur_avatar'] = $user->avatar;
		$this->template->_Set_View('user/profile', $this->data);
        $this->template->_Render();
    }
    
	// edit a user
	function edit_user($id)
	{
		$this->data['title'] = $this->lang->line('edit_user_heading');
		if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id)))
		{
			redirect(ADMIN_FOLDER . '/login', 'refresh');
		}
		$user = $this->ion_auth->user($id)->row();
		$groups=$this->ion_auth->groups()->result_array();
		$currentGroups = $this->ion_auth->get_users_groups($id)->result();
		// validate form input
		$this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'required');
		$this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'required');
		$this->form_validation->set_rules('mobiphone', $this->lang->line('edit_user_validation_phone_label'), 'required');
		$this->form_validation->set_rules('company', $this->lang->line('edit_user_validation_company_label'), 'required');
		if (isset($_POST) && !empty($_POST))
		{
			// do we have a valid request?
			if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
			{
				show_error($this->lang->line('error_csrf'));
			}
            
            //Upload avatar
            if($_FILES['avatar']['name']!='') {
                $this->form_validation->set_rules('avatar', 'Avatar', 'callback__check_avatar');
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
					'last_name'  => $this->input->post('last_name'),
					'company'    => $this->input->post('company'),
					'phone'      => $this->input->post('phone'),
                    'address'    => $this->input->post('address')
				);
                
                if($this->avatar) {
                    $data['avatar'] = $this->avatar;
                }else{
                    $data['avatar'] = $this->input->post('cur_avatar');
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
			// check to see if we are updating the user
			   if($this->ion_auth->update($user->id, $data))
			    {
			    	// redirect them back to the admin page if admin, or to the base url if non admin
				    $this->session->set_flashdata('message', $this->ion_auth->messages() );
				    if ($this->ion_auth->is_admin())
					{
						redirect(ADMIN_FOLDER . '/user', 'refresh');
					}
					else
					{
						redirect('/admin', 'refresh');
					}
			    }
			    else
			    {
			    	// redirect them back to the admin page if admin, or to the base url if non admin
				    $this->session->set_flashdata('message', $this->ion_auth->errors() );
				    if ($this->ion_auth->is_admin())
					{
						redirect(ADMIN_FOLDER . '/user', 'refresh');
					}
					else
					{
						redirect('/admin', 'refresh');
					}
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
        $this->data['facebook'] = array(
			'name'  => 'facebook',
			'id'    => 'facebook',
            'class' => 'form-control',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('facebook', $user->facebook),
		);
        $this->data['skype'] = array(
			'name'  => 'skype',
			'id'    => 'skype',
            'class' => 'form-control',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('skype', $user->skype),
		);
		$this->data['phone'] = array(
			'name'  => 'phone',
			'id'    => 'phone',
            'class' => 'form-control',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('phone', $user->phone),
		);
        $this->data['telephone'] = array(
			'name'  => 'telephone',
			'id'    => 'telephone',
            'class' => 'form-control',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('telephone', $user->telephone),
		);
        $this->data['mobiphone'] = array(
			'name'  => 'mobiphone',
			'id'    => 'mobiphone',
            'class' => 'form-control',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('mobiphone', $user->mobiphone),
		);
        $this->data['address'] = array(
			'name'  => 'address',
			'id'    => 'address',
            'class' => 'form-control',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('address', $user->address),
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
        $this->data['avatar'] = array(
			'name' => 'avatar',
			'id'   => 'avatar',
            'class' => 'form-control',
			'type' => 'file'
		);
        $data['city_id'] = $user->city_id;
        $data['district_id'] = $user->district_id;
        $this->data['cur_avatar'] = $user->avatar;
		$this->template->_Set_View('user/edit_user', $this->data);
        $this->template->_Render();
	}
    
    //Manager group
    function group() {
        
        $this->data['groups'] = $this->ion_auth_model->groups()->result();
        
        
        
        $this->template->_Set_View('user/group', $this->data);
        $this->template->_Render();
    }
    
	// create a new group
	function create_group()
	{
		$this->data['title'] = $this->lang->line('create_group_title');
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('auth', 'refresh');
		}
		// validate form input
		$this->form_validation->set_rules('group_name', $this->lang->line('create_group_validation_name_label'), 'required|alpha_dash');
		if ($this->form_validation->run() == TRUE)
		{
			$new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('description'));
			if($new_group_id)
			{
				// check to see if we are creating the group
				// redirect them back to the admin page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("admincp/user", 'refresh');
			}
		}
		else
		{
			// display the create group form
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			$this->data['group_name'] = array(
				'name'  => 'group_name',
				'id'    => 'group_name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('group_name'),
			);
			$this->data['description'] = array(
				'name'  => 'description',
				'id'    => 'description',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('description'),
			);
			$this->template->_Set_View('user/create_group', $this->data);
        $this->template->_Render();
		}
	}
	// edit a group
	function edit_group($id)
	{
		// bail if no group id given
		if(!$id || empty($id))
		{
			redirect(ADMIN_FOLDER . '/user', 'refresh');
		}
		$this->data['title'] = $this->lang->line('edit_group_title');
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect(ADMIN_FOLDER . '/user', 'refresh');
		}
		$group = $this->ion_auth->group($id)->row();
		// validate form input
		$this->form_validation->set_rules('group_name', $this->lang->line('edit_group_validation_name_label'), 'required|alpha_dash');
		if (isset($_POST) && !empty($_POST))
		{
			if ($this->form_validation->run() === TRUE)
			{
                $modules = $_POST['modules'];
                
                $modules = implode("|", $modules);
                $additional['modules'] = $modules;
				$group_update = $this->ion_auth->update_group($id, $_POST['group_name'], array(
                    'description' => $_POST['description'],
                    'modules' => $modules
                ));
				if($group_update)
				{
					$this->session->set_flashdata('message', $this->lang->line('edit_group_saved'));
				}
				else
				{
					$this->session->set_flashdata('message', $this->ion_auth->errors());
				}
				redirect(admin_url('user/group'), 'refresh');
			}
		}
		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		// pass the user to the view
		$this->data['group'] = $group;
		$readonly = $this->config->item(ADMIN_FOLDER . '_group', 'ion_auth') === $group->name ? 'readonly' : '';
		$this->data['group_name'] = array(
			'name'    => 'group_name',
			'id'      => 'group_name',
			'type'    => 'text',
			'value'   => $this->form_validation->set_value('group_name', $group->name),
            'class'   => 'form-control',
			$readonly => $readonly,
		);
		$this->data['group_description'] = array(
			'name'  => 'description',
			'id'    => 'group_description',
			'type'  => 'text',
            'class'   => 'form-control',
			'value' => $this->form_validation->set_value('group_description', $group->description),
		);
		$this->template->_Set_View('user/edit_group', $this->data);
        $this->template->_Render();
	}
    function delete_user($id) {
        $user = $this->ion_auth->user()->row();
        if($user->id!=$id) {
            $this->ion_auth->delete_user($id);
            redirect(ADMIN_FOLDER . '/user');
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
	function _render_page($view, $data=null, $returnhtml=false)//I think this makes more sense
	{
		$this->viewdata = (empty($data)) ? $this->data: $data;
		$view_html = $this->load->view($view, $this->viewdata, $returnhtml);
		if ($returnhtml) return $view_html;//This will return html on 3rd argument being true
	}
    
    function _Check_Avatar() {
        if($_FILES['avatar']['name']=='' && $this->uri->segment(3)=='change'){
				return true;
			}
			
			$upload = _Upload_Avatar('avatar', './public/uploads/users/');
			if(trim($upload['file_name'])=='' || !is_array($upload)){
				$this->form_validation->set_message('_check_avatar', $upload);
				return false;
			}
			$this->avatar = $upload['file_name'];
			_Resize_Img($upload['full_path'], $upload['file_path'].'thumbs/'.$upload['file_name'], 50, 50);
			return true;
    }
    
    function resetpass($id) {
        if(!$id) redirect(admin_url('user'));
        else {
            $user = $this->ion_auth->user($id)->row();
            if(!empty($user)) {
                $change = $this->ion_auth->reset_password($user->email, "12345678");
                if($change) {
                    $this->session->set_flashdata('reset_success', 'C?p nh?t thành công ! Email '.$user->email. ' Pass: 12345678');
                    redirect(admin_url('user'));
                } else {
                    redirect(admin_url('user'));
                }
            } else {
                redirect(admin_url('user'));
            }
        }
    }
}