<section id="widget-grid" class="form-add">
	<div class="row">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">
            <?php 
                if(validation_errors()) echo '<div class="alert alert-danger fade in">'.validation_errors().'</div>';
             
                echo widget_open($title); 
                echo form_open_multipart(admin_url($this->uri->segment(2) . '/add'), array('method'=>'post','id'=>'myForm', 'class'=>'smart-form')); 
                
                //Vietnamese
                $this->table->add_row(
                    array('data'=>'Title', 'width' => '20%'),
                    array('data' => _Input('title').form_error('title'))
                );
                $this->table->add_row(array(
                    'Số điện thoại',
                    _Input('phone')
                ));
                $this->table->add_row(array(
                    'Email',
                    _Input('email')
                ));
                $this->table->add_row(array(
                    'Địa chỉ',
                    _Input('address')
                ));
                $this->table->add_row(array(
                    'Skype',
                    _Input('skype')
                ));
                $this->table->add_row(array(
                    array('data'=>'Thứ tự', 'width'=>'20%'),
                    _Input('sort_order')
                ));  
                $this->table->add_row(array(
                    'Trạng thái',
                    _Status('status')
                ));
                    
                echo $this->table->generate();
                echo widget_submit(array(
                    _Submit('save', 'Lưu lại','save')
                ));
                echo form_close(); 
                echo widget_close(); 
 CKEditorReplace('content');               
 ?>
		</article>
	</div>
</section>