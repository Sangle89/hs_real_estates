<section id="widget-grid" class="form-add">
	<div class="row">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">
		<?php
        echo _Show_Message('success', $this->session->flashdata('message'));
        ?>
            <?php 
            
             
                echo form_open_multipart(admin_url($this->uri->segment(2) . '/website'), array('method'=>'post','id'=>'myForm', 'class'=>'smart-form')); 
                
                $this->table->add_row(
                    array('data'=>'Tiêu đề', 'width' => '20%'),
                    array('data' => _Input('title', $setting['title']))
                );
                
                $this->table->add_row(array(
                    'Keywords',
                    _Input('keywords', $setting['keywords'])
                ));
                $this->table->add_row(array(
                    'Description',
                    _Input('description', $setting['description'])
                ));
                
                $this->table->add_row(array(
                    array('data'=>'Telephone','width'=>'20%'),
                    _Input('telephone', $setting['telephone'])
                )); 
				$this->table->add_row(array(
                    array('data'=>'Mobiphone','width'=>'20%'),
                    _Input('mobiphone', $setting['mobiphone'])
                ));
                
                $this->table->add_row(array(
                    'Fax',
                    _Input('fax', $setting['fax'])
                )); 
                $this->table->add_row(array(
                    'Email',
                    _Input('email', $setting['email'])
                ));  
                $this->table->add_row(array(
                    'Email nhận tin',
                    _Input('emails', $setting['emails'])
                ));  
                $this->table->add_row(array(
                    'Address',
                    _Input('address', $setting['address'])
                )); 
                $this->table->add_row(array(
                    'Facebook',
                    _Input('facebook', $setting['facebook'])
                ));
                $this->table->add_row(array(
                    'Google plus',
                    _Input('google_plus', $setting['google_plus'])
                ));
                $this->table->add_row(array(
                    'Twitter',
                    _Input('twitter', $setting['twitter'])
                ));
                $this->table->add_row(array(
                    'Youtube',
                    _Input('youtube', $setting['youtube'])
                ));
                $this->table->add_row(array(
                    'Trạng thái',
                    _Status('status', $setting['status'])
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