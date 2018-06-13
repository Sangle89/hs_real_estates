<?php
$title = isset($post['title']) ? $post['title'] : '';
$url = isset($post['url']) ? $post['url'] : '';
$keyword = isset($post['keyword']) ? $post['keyword'] : '';
$description = isset($post['description']) ? $post['description'] : '';
$status = isset($post['status']) ? $post['status'] : 'active';
?>

	<div class="row">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">
            <?php 
               
                $action = $this->uri->segment(3) == 'add' ? admin_url($this->uri->segment(2) . '/add') : admin_url($this->uri->segment(2) . '/change/' . $this->uri->segment(4));
                echo form_open_multipart($action, array('method'=>'post','id'=>'myForm', 'class'=>'smart-form')); 
                //Vietnamese
                $this->table->add_row(
                    array('data'=>'Url', 'width' => '20%'),
                    array('data' => _Input('url', $url).form_error('url'))
                );
                $this->table->add_row(
                    array('data'=>'Tiêu đề', 'width' => '20%'),
                    array('data' => _Input('title', $title).form_error('title'))
                );
				$this->table->add_row(
                    array('data'=>'Keyword', 'width' => '20%'),
                    array('data' => _Textarea('keyword', $keyword))
                );
                $this->table->add_row(
                    array('data'=>'Description', 'width' => '20%'),
                    array('data' => _Textarea('description', $description))
                );
                
                echo $this->table->generate();
                echo widget_submit(array(
                    _Submit('save', 'Lưu lại','save')
                ));
                echo form_close(); 
                            
 ?>
		</article>
	</div>