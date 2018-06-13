<div class="row">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">
            <?php 
            if(validation_errors()) echo '<div class="alert alert-danger fade in">'.validation_errors().'</div>';
             
                echo form_open_multipart(admin_url($this->uri->segment(2) . '/change/' . $this->uri->segment(4)), array('method'=>'post','id'=>'myForm', 'class'=>'smart-form')); 
                
                //Vietnamese
                $this->table->add_row(
                    array('data'=>'Title', 'width' => '20%'),
                    array('data' => _Input('title', $post['title']).form_error('title'))
                );
                $this->table->add_row(array(
                    'Keywords',
                    _Input('keywords', $post['keywords'])
                ));
                $this->table->add_row(array(
                    'Description',
                    _Input('description', $post['description'])
                ));
                
                $this->table->add_row(
                    array(
                        'Hình ảnh',
                        _Button_Image('image', $post['image']).form_error('image')
                    )
                );
                $this->table->add_row(array(
                    'Thuộc danh mục',
                    _Dropdown('parent_id', $dropdown_category, $post['parent_id'])
                ));
                $this->table->add_row(array(
                    array('data'=>'Thứ tự', 'width'=>'20%'),
                    _Input('sort_order', $post['sort_order'])
                ));  
                $this->table->add_row(array(
                    'Trạng thái',
                    _Status('status', $post['status'])
                ));
               
                echo $this->table->generate();
                echo widget_submit(array(
                    _Submit('save', 'Lưu lại', 'save')
                ));
                echo form_close(); 
               ?>
		</article>
	</div>