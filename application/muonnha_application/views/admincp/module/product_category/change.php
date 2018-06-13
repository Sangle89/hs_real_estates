<?php
$position = array(
    1 => 'Vị trí 1',
    2 => 'Vị trí 2'
);
?>
<section id="widget-grid" class="form-add">
	<div class="row">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">
            <?php 
                if(validation_errors()) echo '<div class="alert alert-danger fade in">'.validation_errors().'</div>';
             
                echo widget_open($title); 
                echo form_open_multipart(admin_url('module/'.$this->uri->segment(3) . '/change/'. $this->uri->segment(5)), array('method'=>'post','id'=>'myForm', 'class'=>'smart-form')); 
                
                //Vietnamese
                $this->table->add_row(
                    array('data'=>'Title', 'width' => '20%'),
                    array('data' => _Input("content[title]", $post['title']).form_error("content[title]"))
                );
                $this->table->add_row(array(
                    'Danh mục sản phẩm',
                    _Multiselect('content[category][]', $product_category, $post['category'])
                ));
                $this->table->add_row(
                     array('Banner 1',
                        _Button_Image('banner1', $post['banner1']).form_error('banner1')
                ));
                $this->table->add_row(
                     array('Banner 2',
                        _Button_Image('banner2', $post['banner2']).form_error('banner2')
                ));
                $this->table->add_row(array(
                    array('data'=>'Màu sắc', 'width'=>'20%'),
                    _Input('content[color]', $post['color'])
                ));
                $this->table->add_row(array(
                    array('data'=>'Xem thêm', 'width'=>'20%'),
                    _Input('content[link]', $post['link'])
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
                    _Submit('save', 'Lưu lại','save')
                ));
                echo form_close(); 
                echo widget_close(); 
 CKEditorReplace('content');               
 ?>
		</article>
	</div>
</section>