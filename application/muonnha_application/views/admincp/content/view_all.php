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
            $button_add = _Button_Add(admin_url($this->uri->segment(2) . '/add/'));
            $button_update = _Submit('submit_sort','Cập nhật');
            $this->table->set_heading(array(
                array('data' => form_label('Tổng cộng: ['.$total .'] / [' . $total_page.'] Trang', 'thongke')),
                array('data' => $button_add.' '.$button_update, 'colspan'=>2,'class' => 'center'),
            ));
            
            $this->table->add_row(array(
                array('data' => _Input('search_input', '', 'form-control', 'id="searchInput" data-type="search_content" placeholder="Nhập từ khóa cần tìm.."'), 'colspan'=>5)
            ));
            
            echo $this->table->generate();
            
            $this->table->set_template(array(
                'table_open'		=>	'<table class="table table-bordered table-hover table-striped table-list" id="tableList">'
            ));
            
            $this->table->set_heading(
                array(
                    array(
                    'data' => '#ID',
                    'width' => '5%',
                    'class' => 'center'
                ),
                array(
                    'data' => 'Tiêu đề',
                    'width' => '30%'
                ),
                array(
                    'data' => 'Hình ảnh',
                    'width' => '10%',
                    'class' => 'center'
                ),
                array(
                    'data' => 'Ngày tạo',
                    'width' => '10%',
                    'class' => 'center'
                ),
                array(
                    'data' => 'Trạng thái',
                    'width' => '10%',
                    'class' => 'center'
                ),
                array(
                    'data' => 'Tin nổi bật',
                    'width' => '10%',
                    'class' => 'center'
                ),
                array(
                    'data' => 'Lượt xem',
                    'width' => '10%',
                    'class' => 'center'
                ),
                
                array(
                    'data' => 'Chức năng',
                    'width' => '20%',
                    'class' => 'center'
                )
                )
            );
            if($products) {
                foreach($products as $val) {
                    $button = _Button_Change(admin_url($this->uri->segment(2) . '/change/' . $val['id'])).'&nbsp;';
                    if($this->ion_auth->is_admin()) {
                        $button .= _Button_Delete(admin_url($this->uri->segment(2) . '/delete/' . $val['id']));
                    }
                    $this->table->add_row(
                        array(
                            array('data'=>$val['id'],'class'=>'center'),
                            array('data'=>$val['title'], 'class'=>'left'),
                            array('data'=> '<img src="'.base_url('uploads/contents/'.$val['image']).'" width="50"/>', 'class'=>'center'),
                            array('data'=> _Format_Date($val['create_time']), 'class'=>'center'),
                            array('data'=> _Show_Status('contents',$val['id'],'status', $val['status']), 'class'=>'center'),
                            array('data' => $val['feature']==1?'Có':'Không', 'class' => 'center'),
                            array('data' => $val['views'], 'class' => 'center'),
                            array('data'=> $button, 'class'=>'center')
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
        
        echo $pagination
        ?>
		</article>
		<!-- WIDGET END -->

	</div>

	<!-- end row -->

	<!-- row -->


</section>