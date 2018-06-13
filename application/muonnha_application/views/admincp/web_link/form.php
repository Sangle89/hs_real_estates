<?php
$id = isset($post['id']) ? $post['id']:null;
$title = isset($post['title']) ? $post['title'] : '';
$parent_id = isset($post['parent_id']) ? $post['parent_id'] : 0;
$link = isset($post['link']) ? $post['link'] : '';
$category_id = isset($post['category_id']) ? $post['category_id'] : 0;
$city_id = isset($post['city_id']) ? $post['city_id'] : 0;
$district_id = isset($post['district_id']) ? $post['district_id'] : 0;
$ward_id = isset($post['ward_id']) ? $post['ward_id'] : 0;
$street_id = isset($post['street_id']) ? $post['street_id'] : 0;
$project_id = isset($post['project_id']) ? $post['project_id'] : 0;
$sort_order = isset($post['sort_order']) ? $post['sort_order'] : '';
$status = isset($post['status']) ? $post['status'] : 'active';
$show_footer = isset($post['show_footer']) && $post['show_footer']==1 ? true : false;
$show_detail = isset($post['show_detail']) && $post['show_detail']==1 ? true : false;
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
                    array('data'=>'Link', 'width' => '20%'),
                    array('data' => _Input('link', $link))
                );
                 $this->table->add_row(
                    array('data'=>'Danh mục cha', 'width' => '20%'),
                    array('data' => _Dropdown('parent_id', $dropdown, $parent_id))
                );
                $this->table->add_row(
                    array('data'=>'Danh mục tin đăng', 'width' => '20%'),
                    array('data' => _Dropdown('category_id', $dropdown_category, $category_id))
                );
                
                $this->table->add_row(
                    array('data'=>'Tỉnh thành phố', 'width' => '20%'),
                    array('data' => _Dropdown('city_id', $dropdown_city, $city_id))
                );
                
                $this->table->add_row(
                    array('data'=>'Quận huyện', 'width' => '20%'),
                    array('data' => _Dropdown('district_id', $dropdown_district, $district_id))
                );
                
                $this->table->add_row(
                    array('data'=>'Phường/Xã', 'width' => '20%'),
                    array('data' => _Dropdown('ward_id', $dropdown_ward, $ward_id))
                );
                
                $this->table->add_row(
                    array('data'=>'Đường phố', 'width' => '20%'),
                    array('data' => _Dropdown('street_id', $dropdown_street, $street_id))
                );
                
                $this->table->add_row(array(
                    array('data'=>'Thứ tự', 'width'=>'20%'),
                    _Input('sort_order', $sort_order)
                ));  
                $this->table->add_row(array(
                    array('data'=>'Hiện ở footer', 'width'=>'20%'),
                    form_checkbox('show_footer', 1, $show_footer)
                ));
				$this->table->add_row(array(
                    array('data'=>'Hiện ở chi tiết', 'width'=>'20%'),
                    form_checkbox('show_detail', 1, $show_detail)
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