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
                array('data' => form_label('Tổng cộng: ['.$total .'] / [' . $total_page.'] Trang', 'thongke'), 'colspan'=>2),
                array('data' => $button_add.' '.$button_update, 'colspan'=>2,'class' => 'center'),
            ));
            $this->table->add_row(
                array(
                    'data' => '#ID',
                    'width' => '5%',
                    'class' => 'center'
                ),
                array(
                    'data' => 'Nội dung',
                    'width' => '50%'
                ),
                array(
                    'data' => 'Chi tiết tin',
                    'width' => '5%',
                    'class' => 'center'
                ),
                array(
                    'data' => 'Tùy chọn',
                    'width' => '20%',
                    'class' => 'center'
                )
            );
            
            foreach($results as $result) {
                $query = $this->db->where_in('id', explode(",",$result['content']))->get('footer_link')->result_array();
                $links = array();
                foreach($query as $item) {
                    $links[] = anchor($item['link'], $item['title']);
                }
                $this->table->add_row(
                    array('data' => $result['id'],'class'=>'center'),
                    array('data'=>implode(", ", $links)),
                    array('data'=>$result['show_detail']==1?'Có':'Không','class'=>'center'),
                    array('data'=>_Button_Change(admin_url($this->uri->segment(2) . '/change/' . $result['id'])).'&nbsp;'.
                        _Button_Delete(admin_url($this->uri->segment(2) . '/delete/' . $result['id'])),'class'=>'center')
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