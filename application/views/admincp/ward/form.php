<?php
$title = isset($post['title']) ? $post['title'] : '';
$city_id = isset($post['city_id']) ? $post['city_id'] : 0;
$district_id = isset($post['district_id']) ? $post['district_id'] : 0;
$sort_order = isset($post['sort_order']) ? $post['sort_order'] :  $this->ward_model->_Get_Max_Sort_Order() + 1;
$status = isset($post['status']) ? $post['status'] : 'active';
?>
	<div class="row">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">
            <?php 
                if(validation_errors()) echo '<div class="alert alert-danger fade in">'.validation_errors().'</div>';
             
                $action = $id!=NULL ? admin_url($this->uri->segment(2) . '/change/'.$id):admin_url($this->uri->segment(2) . '/add/'.$this->uri->segment(4));
                echo form_open_multipart($action, array('method'=>'post','id'=>'myForm', 'class'=>'smart-form')); 
                
                //Vietnamese
                $this->table->add_row(
                    array('data'=>'Title', 'width' => '20%'),
                    array('data' => _Input('title', $title).form_error('title'))
                );
                $this->table->add_row(array(
                    'Tỉnh thành',
                    _Dropdown('city_id', $city, $city_id)
                ));
                $this->table->add_row(array(
                    'Quận huyện',
                    _Dropdown('district_id', $district, $district_id)
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