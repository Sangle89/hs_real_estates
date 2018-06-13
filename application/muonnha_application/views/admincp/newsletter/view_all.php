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
            $button_export = _Button_Link(admin_url($this->uri->segment(2) . '/export/'), 'Xuất ra Excel');
            $this->table->set_heading(array(
                array('data' => form_label('Tổng cộng: ['.$total .'] / [' . $total_page.'] Trang', 'thongke'), 'colspan'=>2),
                array('data' => $button_export, 'class' => 'center'),
            ));
            $this->table->add_row(
                array(
                    'data' => 'Email',
                    'width' => '20%'
                ),
                array(
                    'data' => 'Ngày tạo',
                    'width' => '15%',
                    'class' => 'center'
                ),
                array(
                    'data' => 'Tùy chọn',
                    'width' => '20%',
                    'class' => 'center'
                )
            );
            
            foreach($results as $val) {
                
                $this->table->add_row(
                    array(
                        array('data'=>$val['email'],'class'=>'left'),
                        array('data'=> _Format_Date($val['create_time']), 'class'=>'center'),
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