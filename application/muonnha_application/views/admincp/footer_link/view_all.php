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
            $button_add = _Button_Add(admin_url($this->uri->segment(2) . '/add'));
            $button_update = _Submit('submit_sort','Cập nhật');
            $this->table->set_heading(array(
                array('data' => form_label('Tổng cộng: ['.$total .'] / [' . $total_page.'] Trang', 'thongke'), 'colspan'=>4),
                array('data' => $button_add.' '.$button_update, 'colspan'=>2,'class' => 'center'),
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
                    'data' => 'Alias',
                    'width' => '20%',
                    'class' => 'center'
                ),
                array(
                    'data' => 'Thứ tự',
                    'width' => '5%',
                    'class' => 'center'
                ),
                array(
                    'data' => 'Hiện footer',
                    'width' => '5%',
                    'class' => 'center'
                ),
                array(
                    'data' => 'Tùy chọn',
                    'width' => '20%',
                    'class' => 'center'
                )
            );
            $level1 = $this->footer_link_model->_Get_By_Parent();
            foreach($level1 as $val) {
                
                $this->table->add_row(
                    array(
                        array('data'=>$val['id'],'class'=>'center'),
                        array('data'=>$val['title'],'class'=>'left'),
                        array('data'=>$val['link'],'class'=>'left'),
                        array('data'=> _Input('sort_order['.$val['id'].']', $val['sort_order']), 'class'=>'center'),
                        array('data'=>$val['show_footer']==1 ? 'Có':'Không','class'=>'center'),
                        array('data'=>_Button_Change(admin_url($this->uri->segment(2) . '/change/' . $val['id'])).'&nbsp;'.
                        _Button_Delete(admin_url($this->uri->segment(2) . '/delete/' . $val['id'])),'class'=>'center')
                    )
                );
                $level2 = $this->footer_link_model->_Get_By_Parent($val['id']);
                foreach($level2 as $val1) {
                    
                    $this->table->add_row(
                        array(
                            array('data'=>$val1['id'],'class'=>'center'),
                            array('data'=>'___'.$val1['title'],'class'=>'left'),
                            array('data'=>$val1['link'],'class'=>'left'),
                            array('data'=> _Input('sort_order['.$val1['id'].']', $val1['sort_order']), 'class'=>'center'),
                            array('data'=>$val1['show_footer']==1 ? 'Có':'Không', 'class'=>'center'),
                            array('data'=>_Button_Change(admin_url($this->uri->segment(2) . '/change/' . $val1['id'])).'&nbsp;'.
                            _Button_Delete(admin_url($this->uri->segment(2) . '/delete/' . $val1['id'])),'class'=>'center')
                        )
                    );
                    
                    
                }
                
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