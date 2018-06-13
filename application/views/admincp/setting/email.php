<section id="widget-grid" class="form-add">
	<div class="row">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">
		<?php
        echo _Show_Message('success', $this->session->flashdata('message'));
        ?>
            <?php 
               
                echo form_open_multipart(admin_url($this->uri->segment(2) . '/email'), array('method'=>'post','id'=>'myForm', 'class'=>'smart-form')); 
                
                $this->table->add_row(
                    array('data'=>'Email', 'width' => '20%'),
                    array('data' => _Input('smtp_email', $setting['smtp_email']))
                );
                
                $this->table->add_row(array(
                    'Mật khẩu',
                    _Input('smtp_password', $setting['smtp_password'])
                ));
                
               
                echo $this->table->generate();
                echo widget_submit(array(
					_Submit('save', 'Lưu lại', 'save')
				));
                echo form_close(); 
 ?>
		</article>
	</div>
</section>