<?php
$title = isset($post['title']) ? $post['title'] : '';
$alias = isset($post['alias']) ? $post['alias'] : '';
$status = isset($post['status']) ? $post['status'] : 'active';
?>

	<div class="row">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">
            <?php 
               
                $action = $this->uri->segment(3) == 'add' ? admin_url($this->uri->segment(2) . '/add') : admin_url($this->uri->segment(2) . '/change/' . $this->uri->segment(4));
                echo form_open_multipart($action, array('method'=>'post','id'=>'myForm', 'class'=>'smart-form')); 
                
                //Vietnamese
                $this->table->add_row(
                    array('data'=>'Tiêu đề', 'width' => '20%'),
                    array('data' => _Input('title', $title).form_error('title'))
                );
				$this->table->add_row(
                    array('data'=>'Alias', 'width' => '20%'),
                    array('data' => _Input('alias', $alias))
                );
                
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