
<section id="widget-grid" class="">
	<div class="row">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">
            <?php 
              
                echo form_open_multipart(admin_url('user/edit_user/'.$user->id), array('method'=>'post','id'=>'myForm', 'class'=>'smart-form')); 
                
                $this->table->add_row(
                    array('data'=>'Firstname', 'width' => '20%'),
                    array('data' => form_input($first_name).form_error('first_name'))
                );
                $this->table->add_row(
                    array('data'=>'Lastname', 'width' => '20%'),
                    array('data' => form_input($last_name).form_error('last_name'))
                );
               
                $this->table->add_row(
                    array('data'=>'Company', 'width' => '20%'),
                    array('data' => form_input($company).form_error('company'))
                );
                $this->table->add_row(
                    array('data'=>'Telephone', 'width' => '20%'),
                    array('data' => form_input($telephone).form_error('telephone'))
                );
                $this->table->add_row(
                    array('data'=>'Mobiphone', 'width' => '20%'),
                    array('data' => form_input($mobiphone).form_error('mobiphone'))
                );
                $this->table->add_row(
                    array('data'=>'Address', 'width' => '20%'),
                    array('data' => form_input($address).form_error('address'))
                );
                $img_avatar = ($cur_avatar!='') ? '<img src="'.base_url('uploads/avatar/' . $cur_avatar).'" width="100">':'';
                $this->table->add_row(
                    array('data'=>'Avatar', 'width' => '20%'),
                    array('data' => $img_avatar.form_upload($avatar).form_hidden('cur_avatar', $cur_avatar).form_error('avatar'))
                );
                $this->table->add_row(
                    array('data'=>'Password', 'width' => '20%'),
                    array('data' => form_input($password).form_error('password'))
                );
                $this->table->add_row(
                    array('data'=>'Password comfirm', 'width' => '20%'),
                    array('data' => form_input($password_confirm).form_error('password_confirm'))
                );
                $this->table->add_row(
                    array('data'=>'Facebook', 'width' => '20%'),
                    array('data' => form_input($facebook).form_error('facebook'))
                );
                $this->table->add_row(
                    array('data'=>'Skype', 'width' => '20%'),
                    array('data' => form_input($skype).form_error('skype'))
                );
                
                if ($this->ion_auth->is_admin()) {
                    $user_group = '';
                    foreach ($groups as $group){
                        $user_group .= '<label class="checkbox">';
                        
                        $gID=$group['id'];
                          $checked = null;
                          $item = null;
                          $i_fa = '';
                          foreach($currentGroups as $grp) {
                              if ($gID == $grp->id) {
                                  $checked= ' checked="checked"';
                                  
                              break;
                              }
                          }
                        $user_group .= form_checkbox('groups[]', $group['id'], $checked) . '<i></i>';
                        $user_group .= htmlspecialchars($group['name'],ENT_QUOTES,'UTF-8');
                        $user_group .= '</label>';
                    }
                    
                    $this->table->add_row(
                        array('data'=>'Group', 'width' => '20%'),
                        array('data' => $user_group)
                    );
                }
                
                echo form_hidden('id', $user->id);
                echo form_hidden($csrf);
                echo $this->table->generate();
                echo widget_submit(array(
                    _Submit('save', 'Lưu lại')
                ));
                echo form_close(); 
                ?>
		</article>
	</div>
</section>