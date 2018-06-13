<section id="widget-grid" class="form-list">

	<!-- row -->
	<div class="row">

		<!-- NEW WIDGET START -->
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">
        <?php
        echo _Show_Message('success', $this->session->flashdata('message'));
        ?>
        <?php echo widget_open($title);
        echo form_open_multipart(current_url(),array('method'=>'post'));
            $button_add = _Button_Add(admin_url($this->uri->segment(2) . '/add/' . $this->uri->segment(4).'/'. $this->uri->segment(5)));
            $button_update = _Submit('submit_sort','Cập nhật');
            $this->table->set_heading(array(
                array('data' => form_label('Tổng cộng: ['.$total .'] / [' . $total_page.'] Trang', 'thongke'), 'colspan'=>5),
                array('data' => $button_add.' '.$button_update, 'colspan'=>2,'class' => 'center'),
            ));
            
            $this->table->add_row(
                array(
                    'data' => 'Hình ảnh',
                    'width' => '10%',
                    'class' => 'center'
                ),
                array(
                    'data' => 'Tiêu đề',
                    'width' => '25%'
                ),
                
                array(
                    'data' => 'Giá bán',
                    'width' => '10%',
                    'class' => 'center'
                ),
                array(
                    'data' => 'Ngày tạo',
                    'width' => '15%',
                    'class' => 'center'
                ),
                array(
                    'data' => 'Trạng thái',
                    'width' => '10%',
                    'class' => 'center'
                ),
                array(
                    'data' => 'Thứ tự',
                    'width' => '10%',
                    'class' => 'center'
                ),
                
                array(
                    'data' => 'Chức năng',
                    'width' => '20%',
                    'class' => 'center'
                )
            );
            if($products) {
                foreach($products as $val) {
                    
                    if($val['special_price'] > 0) {
                        $price = '<span style="text-decoration: line-through;">'.number_format($val['price']).'</span><br>';
                        $price .= '<span style="color:red;">'.number_format($val['special_price']).'</span>';
                    } else {
                        $price = '<span>'.number_format($val['price']).'</span>';
                    }
                    
                    $this->table->add_row(
                        array(
                            array('data'=>_Show_Thumb($val['image']), 'class'=>'center'),
                            array('data'=>$val['title'], 'class'=>'left'),
                            array('data'=> $price,'class'=>'center'),
                            array('data'=> _Format_Date($val['create_time']), 'class'=>'center'),
                            array('data'=> _Show_Status('products',$val['id'],'status', $val['status']), 'class'=>'center'),
                            array('data'=> _Input('sort_order['.$val['id'].']', $val['sort_order']), 'class'=>'center'),
                            array('data'=> _Button_Change(admin_url($this->uri->segment(2) . '/change/' . $val['id'] . '/' . $this->uri->segment(4))).'&nbsp;'.
                            _Button_Delete(admin_url($this->uri->segment(2) . '/delete/' . $val['id']. '/' . $this->uri->segment(4))), 'class'=>'center')
                        )
                    );
                    
                }
            } else {
                $this->table->add_row(
                    array(
                        'data' => 'Nội dung đang cập nhật.',
                        'colspan' => 7
                    )
                );
            }
            
        echo $this->table->generate();
        echo form_close();
        echo widget_close();
        echo $pagination
        ?>
		</article>
		<!-- WIDGET END -->

	</div>

	<!-- end row -->

	<!-- row -->


</section>