<section id="widget-grid" class="form-add">
	<div class="row">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">
            <?php 
            if(validation_errors()) echo '<div class="alert alert-danger fade in">'.validation_errors().'</div>';
               
                echo form_open_multipart(admin_url($this->uri->segment(2) . '/change/' . $this->uri->segment(4). '/' . $this->uri->segment(5)), array('method'=>'post','id'=>'myForm', 'class'=>'smart-form')); 
                
                 //Vietnamese
                $this->table->add_row(
                    array('data'=>'Tiêu đề', 'width' => '20%'),
                    array('data' => _Input('title', $post['title']).form_error('title'))
                );
                $this->table->add_row(array(
                    'Từ khóa',
                    _Input('keywords',$post['keywords'])
                ));
                $this->table->add_row(array(
                    'Mô tả từ khóa',
                    _Input('description', $post['description'])
                ));
                $this->table->add_row(
                    array(
                        'Nội dung tóm tắt',
                        _Textarea('short_content', $post['short_content'])
                    )  
                );
                $this->table->add_row(
                    array(
                        'Nội dung',
                        _Textarea('content', $post['content'])
                    )  
                );
                
                $this->table->add_row(
                    array(
                        'Hình ảnh đại diện',
                        _Button_Image('image', $post['image']).form_error('image')
                    )
                );
                
                $this->table->add_row(array(
                    'Thuộc nhóm danh mục',
                    _Dropdown('category_id', $category, $post['category_id'])
                ));
                
                $this->table->add_row(array(
                    'Thứ tự',
                    _Input('sort_order', $post['sort_order'])
                ));  
                $this->table->add_row(array(
                    'Trạng thái',
                    _Status('status', $post['status'])
                ));
               
                echo $this->table->generate();
                echo widget_submit(array(
                    _Submit('save', 'Lưu lại','save').
                    _Submit('save_new', 'Lưu lại & tạo mới','save')
                ));
                echo form_close(); 
               
 CKEditorReplace('content');
 ?>
		</article>
	</div>
</section>