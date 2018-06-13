
	<!-- row -->
	<div class="row">
        
		<!-- NEW WIDGET START -->
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">
        <?php
        echo _Show_Message('success', $this->session->flashdata('message'));
        ?>
        <?php 
            echo form_open_multipart(current_url(),array('method'=>'post'));
            $button_add = _Button_Add(admin_url($this->uri->segment(2) . '/add/'.$this->uri->segment(4)));
            $button_update = _Submit('submit_sort','Cập nhật');
            $this->table->set_heading(array(
                array('data' => form_label('Tổng cộng: ['.$total .'] / [' . $total_page.'] Trang', 'thongke'), 'colspan'=>4),
                array('data' => $button_add.' '.$button_update, 'colspan'=>2,'class' => 'center'),
            ));
            
            $this->table->add_row(array(
                array('data' => _Input('search_input', '', 'form-control', 'id="searchInput" data-type="search_district" placeholder="Nhập từ khóa cần tìm.."'), 'colspan'=>5)
            ));
            
            echo $this->table->generate();
            
            $this->table->set_template(array(
                'table_open'		=>	'<table class="table table-bordered table-hover table-striped table-list" id="tableList">'
            ));
            
            $this->table->set_heading(
                
                array(
                    'data' => 'Tiêu đề',
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
                      
                        array('data'=>'<strong>'.$val['title'].'</strong><br><i>[Alias: '.$val['alias'].'</i>]','class'=>'left'),
                        array('data'=> _Format_Date($val['create_time']), 'class'=>'center'),
                        array('data'=> _Show_Status('districts',$val['id'],'status', $val['status']), 'class'=>'center'),
                        array('data'=> _Input('sort_order['.$val['id'].']', $val['sort_order']), 'class'=>'center'),
                        array('data'=>
                        _Button_Link(admin_url('ward/index/'.$val['id']), 'Phường/Xã') . '&nbsp;'.
                        _Button_Change(admin_url($this->uri->segment(2) . '/change/' . $val['id'])).'&nbsp;'.
                        _Button_Delete(admin_url($this->uri->segment(2) . '/delete/' . $val['id'])),'class'=>'center')
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
