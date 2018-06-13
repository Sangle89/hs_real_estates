<section id="widget-grid" class="form-add">
	<div class="row">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">
            <?php 
            if(validation_errors()) echo '<div class="alert alert-danger fade in">'.validation_errors().'</div>';
                echo widget_open('Thêm nội dung'); 
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
                $this->table->add_row(array(
                    'Đánh giá',
                    _Dropdown('rate', array(
                        1 => '1',
                        2 => '2',
                        3 => '3',
                        4 => '4',
                        5 => '5'
                    ), $post['rate']) 
                ));
                $this->table->add_row(array(
                    'Giá bán',
                    _Input_Price('price', $post['price']) 
                ));
                $this->table->add_row(array(
                    'Giá khuyến mãi',
                    _Input_Price('special_price', $post['special_price']) 
                ));
                $this->table->add_row(array(
                    'Đơn vị',
                    _Input('unit', $post['unit']) 
                ));
                $this->table->add_row(
                    array(
                        'Hình ảnh đại diện',
                        _Button_Image('image', $post['image']).form_error('image')
                    )
                );
                $this->table->add_row(
                    array(
                        'Hình ảnh',
                        _Button_Images('images', 'multiple',$images)
                    )
                );
                $this->table->add_row(array(
                    'Thuộc nhóm danh mục',
                    _Dropdown('category_id', $dropdown_category, $post['category_id'])
                ));
                 $this->table->add_row(array(
                    'Thuộc tính',
                    _Multiselect('property[]', $property, $product_property)
                ));
                $this->table->add_row(array(
                    'Tags',
                    _Multiselect('tags[]', $tags, $product_tags)
                ));
                
                $this->table->add_row(array(
                    'Thứ tự',
                    _Input('sort_order', $post['sort_order'])
                ));  
                $this->table->add_row(array(
                    'Trạng thái',
                    _Status('status', $post['status'])
                ));
               $this->table->add_row(array(
                    'Sản phẩm mới',
                    _Dropdown('new', array('yes'=>'Có', 'no'=>'Không'), $post['new'])
                ));
                echo $this->table->generate();
          
                echo widget_submit(
                    array(_Submit('save','Lưu lại', 'save'))
                );
                echo form_close(); 
                echo widget_close(); 
 CKEditorReplace('content');
 ?>
		</article>
	</div>
</section>