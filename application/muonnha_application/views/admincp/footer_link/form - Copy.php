<?php

$title = isset($post['title']) ? $post['title'] : '';
$parent_id = isset($post['parent_id']) ? $post['parent_id'] : 0;
$category_id = isset($post['category_id']) ? $post['category_id'] : 0;
$city_id = isset($post['city_id']) ? $post['city_id'] : 0;
$district_id = isset($post['district_id']) ? $post['district_id'] : 0;
$ward_id = isset($post['ward_id']) ? $post['ward_id'] : 0;
$street_id = isset($post['street_id']) ? $post['street_id'] : 0;
$project_id = isset($post['project_id']) ? $post['project_id'] : 0;
$sort_order = isset($post['sort_order']) ? $post['sort_order'] : '';
$status = isset($post['status']) ? $post['status'] : 'active';
?>
<section id="widget-grid" class="form-add">
	<div class="row">
<?php
$title = isset($post['title']) ? $post['title'] : '';
$sort_order = isset($post['sort_order']) ? $post['sort_order'] : 0;
?>
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">
            <?php 
                if(validation_errors()) echo '<div class="alert alert-danger fade in">'.validation_errors().'</div>';
             $action = $id ? admin_url($this->uri->segment(2) . '/change/'.$id) : admin_url($this->uri->segment(2) . '/add');
                echo form_open_multipart($action, array('method'=>'post','id'=>'myForm', 'class'=>'smart-form')); 
                
                //Vietnamese
                $this->table->add_row(
                    array('data'=>'Title', 'width' => '20%'),
                    array('data' => _Input('title', $title).form_error('title'))
                );
                 $this->table->add_row(
                    array('data'=>'Danh mục cha', 'width' => '20%'),
                    array('data' => _Dropdown('parent_id', $dropdown, $parent_id))
                );
                
                 $this->table->add_row(
                    array('data'=>'Nhóm danh mục', 'width' => '20%'),
                    array('data' => _Dropdown('category_id', $dropdown_category, $category_id))
                );
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
                $this->table->add_row(
                    array('data'=>'Dự án', 'width' => '20%'),
                    array('data' => _Dropdown('project_id', $dropdown_project, $project_id))
                );
                
                $this->table->add_row(array(
                    array('data'=>'Thứ tự', 'width'=>'20%'),
                    _Input('sort_order', $sort_order)
                ));  
                echo $this->table->generate();
                echo widget_submit(array(
                    _Submit('save', 'Lưu lại','save')
                ));
                echo form_close(); 
                             
 ?>
		</article>
	</div>
</section>