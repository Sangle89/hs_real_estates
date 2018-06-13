
<section id="widget-grid" class="">
	<div class="row">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">
            <?php 
                
                echo form_open_multipart(admin_url('user/edit_group/'.$group->id), array('method'=>'post','id'=>'myForm', 'class'=>'smart-form')); 
                
                $this->table->add_row(
                    array('data'=>'Name', 'width' => '20%'),
                    array('data' => form_input($group_name).form_error('group_name'))
                );
                $this->table->add_row(
                    array('data'=>'Description', 'width' => '20%'),
                    array('data' => form_input($group_description).form_error('group_description'))
                );
                
                $group_module = $group->modules;
                $modules = explode("|", $group_module);
                
                
                $this->load->config('admin_menu');
                $string_module = '<label class="label" name="checkall">'._Checkbox('checkall', 'all', false,'').'Toàn bộ</label>';
                foreach($this->config->item('admin_menu') as $menu) {
                    $checked = '';
                    if(in_array($menu['controller'], $modules))
                        $checked = 'checked';
                    else
                        $checked = '';
                    $string_module .= '<label class="label">'._Checkbox('modules[]', $menu['controller'], $checked).$menu['controller'].'</label>';
                    foreach($menu['childs'] as $child) {
                        $checked = '';
                        if(in_array($child['controller'], $modules))
                            $checked = 'checked';
                        else
                            $checked = '';
                        $string_module .= '<label class="label" style="padding-left:30px;">'._Checkbox('modules[]', $child['controller'], $checked).$child['controller'].'</label>';
                    }
                }
                
                $this->table->add_row(
                    'Module',
                    $string_module  
                );
                
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