<?php
$title = isset($post['title']) ? $post['title'] : '';
$alias = isset($post['alias']) ? $post['alias'] : '';
$category_id = isset($post['category_id']) ? $post['category_id'] : 0;
$city_id = isset($post['city_id']) ? $post['city_id'] : 0;
$district_id = isset($post['district_id']) ? $post['district_id'] : 0;
$ward_id = isset($post['ward_id']) ? $post['ward_id'] : 0;
$street_id = isset($post['street_id']) ? $post['street_id'] : 0;
$project_id = isset($post['project_id']) ? $post['project_id'] : 0;
$status = isset($post['status']) ? $post['status'] : 'active';
$category_tags = isset($post['tags']) ? explode(",",$post['tags']) : array();
?>

	<div class="row">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">
            <?php 
               
                $action = $this->uri->segment(3) == 'add' ? admin_url($this->uri->segment(2) . '/add') : admin_url($this->uri->segment(2) . '/change/' . $this->uri->segment(4));
                echo form_open_multipart($action, array('method'=>'post','id'=>'myForm', 'class'=>'smart-form')); 
                echo validation_errors();
                //Vietnamese
                $this->table->add_row(
                    array('data'=>'Chọn danh mục', 'width' => '20%'),
                    array('data' => _Dropdown('category_id', $dropdown_category, $category_id))
                );
                $this->table->add_row(
                    array('data'=>'Tỉnh thành', 'width' => '20%'),
                    array('data' => _Dropdown('city_id', $dropdown_city, $city_id))
                );
                $this->table->add_row(
                    array('data'=>'Quận huyện', 'width' => '20%'),
                    array('data' => _Dropdown('district_id', $dropdown_district, $district_id))
                );
                $this->table->add_row(
                    array('data'=>'Phường xã', 'width' => '20%'),
                    array('data' => _Dropdown('ward_id', $dropdown_ward, $ward_id))
                );
                $this->table->add_row(
                    array('data'=>'Đường', 'width' => '20%'),
                    array('data' => _Dropdown('street_id', $dropdown_street, $street_id))
                );
				$this->table->add_row(
                    array('data'=>'Tags', 'width' => '20%'),
                    array('data' => _Multiselect('tags[]', $dropdown_tags, $category_tags))
                );
                
                echo $this->table->generate();
                echo widget_submit(array(
                    _Submit('save', 'Lưu lại','save')
                ));
                echo form_close(); 
                            
 ?>
		</article>
	</div>