<?php
$title = isset($post['title']) ? $post['title'] : '';
$keywords = isset($post['keywords']) ? $post['keywords'] : '';
$description = isset($post['description']) ? $post['description'] : '';
$content = isset($post['content']) ? $post['content'] : '';
$sort_order = isset($post['sort_order']) ? $post['sort_order'] : $this->page_model->_Get_Max_Sort_Order() + 1;
$status = isset($post['status']) ? $post['status'] : 'active';
?>

	<div class="row">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">
            <?php 
                if(validation_errors()) echo '<div class="alert alert-danger fade in">'.validation_errors().'</div>';
                
                
                $action = $this->uri->segment(3) == 'add' ? admin_url($this->uri->segment(2) . '/add') : admin_url($this->uri->segment(2) . '/change/' . $this->uri->segment(4));
                echo form_open_multipart($action, array('method'=>'post','id'=>'myForm', 'class'=>'smart-form')); 
                
                //Vietnamese
                $this->table->add_row(
                    array('data'=>'Tiêu đề', 'width' => '20%'),
                    array('data' => _Input('title', $title).form_error('title'))
                );
                $this->table->add_row(array(
                    'Từ khóa',
                    _Input('keywords', $keywords)
                ));
                $this->table->add_row(array(
                    'Mô tả từ khóa',
                    _Input('description', $description)
                ));
                
                $this->table->add_row(array(
                    'Nội dung',
                    _TextEditor('content', $content)
                ));
                
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
                            
 ?>
		</article>
	</div>
<script src="/public/ckeditor/ckeditor.js"></script>
<script>
CKEDITOR.replace("content");
</script>