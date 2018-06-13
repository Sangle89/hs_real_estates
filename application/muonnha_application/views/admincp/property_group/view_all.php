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
            
            $button_add = _Button_Link(admin_url('property/add'), 'Thêm thuộc tính','primary','plus');
            $button_add_group = _Button_Link(admin_url($this->uri->segment(2) . '/add'), 'Thêm nhóm', 'warning', 'plus');
            $button_update = _Submit('submit_sort','Cập nhật');
            $this->table->set_heading(array(
                array('data' => form_label('Tổng cộng: ['.$total .'] / [' . $total_page.'] Trang', 'thongke'), 'colspan'=>3),
                array('data' => $button_add.' ' . $button_add_group .' '.$button_update,'class' => 'center'),
            ));
            $this->table->add_row(
                array(
                    'data' => '#ID',
                    'width' => '5%',
                    'class' => 'center'
                ),
                array(
                    'data' => 'Tiêu đề',
                    'width' => '20%'
                ),
                array(
                    'data' => 'Thứ tự',
                    'width' => '15%',
                    'class' => 'center'
                ),
                array(
                    'data' => 'Tùy chọn',
                    'width' => '20%',
                    'class' => 'center'
                )
            );
            
            foreach($category as $val) {
                
                $this->table->add_row(
                    array(
                        array('data'=>$val['id'],'class'=>'center'),
                        array('data'=>'<strong>'.$val['title'].'</strong>','class'=>'left'),
                        array('data'=> _Input('sort_order['.$val['id'].']', $val['sort_order']), 'class'=>'center'),
                        array('data'=>_Button_Change(admin_url($this->uri->segment(2) . '/change/' . $val['id'])).'&nbsp;'.
                        _Button_Delete(admin_url($this->uri->segment(2) . '/delete/' . $val['id'])),'class'=>'center')
                    )
                );
                
                foreach($val['property'] as $pro) {
                    
                    $this->table->add_row(
                        array(
                            array('data'=>$pro['id'],'class'=>'center'),
                            array('data'=>'----'.$pro['title'],'class'=>'left'),
                            array('data'=> _Input('sort_order1['.$pro['id'].']', $pro['sort_order']), 'class'=>'center'),
                            array('data'=>_Button_Change(admin_url($this->uri->segment(2) . '/change/' . $pro['id'])).'&nbsp;'.
                            _Button_Delete(admin_url($this->uri->segment(2) . '/delete/' . $pro['id'])),'class'=>'center')
                        )
                    );
                    
                }
                
            }
        echo $this->table->generate();
        echo form_close();
        echo widget_close();
        echo $pagination;
        ?>
		</article>
		<!-- WIDGET END -->

	</div>

	<!-- end row -->

	<!-- row -->


</section>