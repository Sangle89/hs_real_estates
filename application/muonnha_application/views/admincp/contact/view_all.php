<section id="widget-grid" class="form-list">

	<!-- row -->
	<div class="row">

		<!-- NEW WIDGET START -->
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">
        <?php
        echo _Show_Message('success', $this->session->flashdata('message'));
        ?>
        <?php echo widget_open('Danh mục nội dung');
            echo form_open_multipart(current_url(),array('method'=>'post'));
            
            $this->table->set_heading(array(
                array('data' => form_label('Tổng cộng: ['.$total .'] / [' . $total_page.'] Trang', 'thongke'), 'colspan'=>6),
                //array('data' => $button_update, 'colspan'=>2,'class' => 'center'),
            ));
            $this->table->add_row(
                array(
                    'data' => '#ID',
                    'width' => '5%',
                    'class' => 'center'
                ),
                array(
                    'data' => 'Tên người gửi',
                    'width' => '20%'
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
                    'data' => 'Tùy chọn',
                    'width' => '20%',
                    'class' => 'center'
                )
            );
            
            foreach($category as $val) {
                
                $this->table->add_row(
                    array(
                        array('data'=>$val['id'],'class'=>'center'),
                        array('data'=>$val['fullname'],'class'=>'left'),
                        array('data'=> _Format_Date($val['create_time']), 'class'=>'center'),
                        array('data'=> ($val['viewed']==1)?'<label class="label label-success">Đã xem</label>':'<label class="label label-danger">Chưa xem</label>', 'class'=>'center'),
                        array('data'=>_Button_Link(admin_url($this->uri->segment(2) . '/view/' . $val['id']),'','primary','eye').'&nbsp;'.
                        _Button_Delete(admin_url($this->uri->segment(2) . '/delete/' . $val['id'])),'class'=>'center')
                    )
                );
                
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