<?php
$city_id = isset($post['city_id']) ? $post['city_id'] : 0;
$district_id = isset($post['district_id']) ? $post['district_id'] : 0;
$ward_id = isset($post['ward_id']) ? $post['ward_id'] : 0;
$street_id = isset($post['street_id']) ? $post['street_id'] : 0;
$title = isset($post['title']) ? $post['title'] : '';
$meta_title = isset($post['meta_title']) ? $post['meta_title'] : '';
$keyword = isset($post['keywords']) ? $post['keywords'] : '';
$description = isset($post['description']) ? $post['description'] : '';
$content = isset($post['content']) ? $post['content'] : '';
$sort_order = isset($post['sort_order']) ? $post['sort_order'] : $this->project_model->_Get_Max_Sort_Order() + 1;
$status = isset($post['status']) ? $post['status'] : 'active';
$image = isset($post['image']) ? $post['image'] : '';
?>
<section id="widget-grid" class="form-add">
	<div class="row">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">
            <?php 
                if(validation_errors()) echo '<div class="alert alert-danger fade in">'.validation_errors().'</div>';
                $action = $id ? admin_url($this->uri->segment(2) . '/change/'.$id) : admin_url($this->uri->segment(2) . '/add');
                
                echo form_open_multipart($action, array('method'=>'post','id'=>'myForm', 'class'=>'smart-form')); 
                
                
                $this->table->add_row(
                    array('data'=>'Tiêu đề', 'width' => '20%'),
                    array('data' => _Input('title', $title).form_error('title'))
                );
                $this->table->add_row(
                    array('data'=>'Meta title', 'width' => '20%'),
                    array('data' => _Input('meta_title', $meta_title).form_error('meta_title'))
                );
                $this->table->add_row(array(
                    'Từ khóa',
                    _Input('keywords', $keyword)
                ));
                $this->table->add_row(array(
                    'Mô tả từ khóa',
                    _Input('description', $description)
                ));
                
                $this->table->add_row(array(
                    'Nội dung',
                    _TextEditor('content', $content)
                ));
                $this->table->add_row(
                    array('data'=>'Tỉnh/Thành phố', 'width' => '20%'),
                    array('data' => _Dropdown('city_id', $dropdown_city, $city_id))
                );
                $this->table->add_row(
                    array('data'=>'Quận/Huyện', 'width' => '20%'),
                    array('data' => _Dropdown('district_id', $dropdown_district, $district_id))
                );
                $this->table->add_row(
                    array('data'=>'Phường/Xã', 'width' => '20%'),
                    array('data' => _Dropdown('ward_id', $dropdown_ward, $ward_id))
                );
                $this->table->add_row(
                    array('data'=>'Đường/Phố', 'width' => '20%'),
                    array('data' => _Dropdown('street_id', $dropdown_street, $street_id))
                );
                
                $this->table->add_row(array(
                    array('data'=>'Thứ tự', 'width'=>'20%'),
                    _Input('sort_order', $sort_order)
                ));  
                $this->table->add_row(array(
                    'Trạng thái',
                    _Status('status', $status)
                ));
                    
                echo $this->table->generate();
                echo widget_submit(array(
                    _Submit('save', 'Lưu lại','save')
                ));
                echo form_close(); 
                
 CKEditorReplace('content');               
 ?>
		</article>
	</div>
</section>