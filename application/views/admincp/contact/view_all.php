<section id="widget-grid" class="form-list">

	<!-- row -->
	<div class="row">

		<!-- NEW WIDGET START -->
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">
        <?php
        echo _Show_Message('success', $this->session->flashdata('message'));
        ?>
        <?php 
            echo form_open_multipart(current_url(),array('method'=>'post'));
            
            $this->table->set_heading(array(
                array('data' => form_label('Tổng cộng: ['.$total .'] / [' . $total_page.'] Trang', 'thongke'), 'colspan'=>5),
               // array('data' => $button_add.' '.$button_update, 'colspan'=>2,'class' => 'center'),
            ));
            $this->table->add_row(
                array(
                    'data' => '#ID',
                    'width' => '5%',
                    'class' => 'center'
                ),
                array(
                    'data' => 'Thông tin',
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
            
            foreach($category as $val) {
                
                $content = '<strong>'.$val['fullname'].'</strong><br/>'
                            .'<a href="mailto:'.$val['email'].'">'.$val['email'].'</a><br/>'
                            .$val['phone'].'<br/>'
                            .'<div class="">'.$val['message'].'</div>';
                
                $this->table->add_row(
                    array(
                        array('data'=>$val['id'],'class'=>'center'),
                        array('data'=> $content,'class'=>'left'),
                        array('data'=> _Format_Date($val['create_time']), 'class'=>'center'),
                        array('data'=> _Button_Delete(admin_url($this->uri->segment(2) . '/delete/' . $val['id'])),'class'=>'center')
                    )
                );
                
            }
        echo $this->table->generate();
        echo form_close();
        echo $pagination;
        ?>
		</article>
		<!-- WIDGET END -->

	</div>

	<!-- end row -->

	<!-- row -->


</section>