
<section id="widget-grid" class="">
	<div class="row">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">
            <?php 
                
                echo form_open_multipart(admin_url($this->uri->segment(2) . '/change_password'), array('method'=>'post','id'=>'myForm', 'class'=>'smart-form')); 
                if($message) echo $message;
                $this->table->add_row(
                    array('data'=>'Old password', 'width' => '20%'),
                    array('data' => form_input($old_password).form_error('old'))
                );
                $this->table->add_row(
                    array('data'=>'New password', 'width' => '20%'),
                    array('data' => form_input($new_password).form_error('new'))
                );
                $this->table->add_row(
                    array('data'=>'New password comfirm', 'width' => '20%'),
                    array('data' => form_input($new_password_confirm).form_error('new_confirm'))
                );
                echo form_input($user_id);
                echo $this->table->generate();
                echo widget_submit(array(
                    _Submit('save', 'Lưu lại')
                ));
                echo form_close(); 
                ?>
		</article>
	</div>
</section>