<section id="widget-grid" class="form-add">
	<div class="row">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">
            <?php 
                if(validation_errors()) echo '<div class="alert alert-danger fade in">'.validation_errors().'</div>';
             
                echo widget_open($title); 
                //echo form_open_multipart(admin_url($this->uri->segment(2) . '/add'), array('method'=>'post','id'=>'myForm', 'class'=>'smart-form')); 
                
                $this->table->add_row(
                    array('data'=>'Họ tên', 'width' => '20%'),
                    array('data' => $post['fullname'])
                );
                $this->table->add_row(array(
                    'Email',
                    $post['email']
                ));
                $this->table->add_row(array(
                    'Số điện thoại',
                    $post['phone']
                ));
                $this->table->add_row(array(
                    'Địa chỉ',
                    $post['address']
                ));
                $this->table->add_row(array(
                    'Nội dung',
                    $post['message']
                ));
                
                  $this->table->add_row(array(
                    'Ngày gửi',
                    format_date($post['create_time'])
                ));  
                echo $this->table->generate();
                echo widget_submit(array(
                    _Button_Back(admin_url($this->uri->segment(2)))
                ));
              //  echo form_close(); 
                echo widget_close(); 
 ?>
		</article>
	</div>
</section>