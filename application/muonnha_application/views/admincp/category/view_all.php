<!-- row -->
	<div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header">Quản lý tin đăng</div>
                <?php
        echo _Show_Message('success', $this->session->flashdata('message'));
        ?>
                <div class="box-body">
                     <?php 
            echo form_open_multipart(current_url(),array('method'=>'post'));
            $button_add = _Button_Add(admin_url($this->uri->segment(2) . '/add'));
            $button_update = _Submit('submit_sort','Cập nhật');
            $this->table->set_heading(array(
                array('data' => form_label('Tổng cộng: ['.$total .'] / [' . $total_page.'] Trang', 'thongke'), 'colspan'=>3),
                array('data' => $button_add.' '.$button_update, 'colspan'=>2,'class' => 'center'),
            ));
            $this->table->add_row(
                array(
                    'data' => 'ID',
                    'width' => ''
                ),
                array(
                    'data' => 'Tiêu đề',
                    'width' => ''
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
                    'data' => 'Tùy chọn',
                    'width' => '10%',
                    'class' => 'center'
                )
            );
            
            function dequy_category($category,$lv=0) {
                foreach($category as $val) {
                    get_instance()->table->add_row(
                        array(
                           array('data'=>$val['id'],'class'=>'left'),
                            array('data'=>_Space($lv,$val['title']).'<br>Alias: ['.$val['alias'].']','class'=>'left'),
                            array('data'=> _Format_Date($val['create_time']), 'class'=>'center'),
                            array('data'=> _Show_Status('content_categories',$val['id'],'status', $val['status']), 'class'=>'center'),
                            array('data'=> _Input('sort_order['.$val['id'].']', $val['sort_order']), 'class'=>'center'),
                            array('data'=>_Button_Change(admin_url(get_instance()->uri->segment(2) . '/change/' . $val['id'])).'&nbsp;'.
                            _Button_Delete(admin_url(get_instance()->uri->segment(2) . '/delete/' . $val['id'])),'class'=>'center')
                        )
                    );
                    if($val['sub']) {
                        dequy_category($val['sub'], $lv+1);
                    }
                }
            }
            dequy_category($category);
        echo $this->table->generate();
        echo form_close();
        
        echo $pagination;
        ?>
                </div>
            </div>
            
       
        </div>
		
        
	</div>