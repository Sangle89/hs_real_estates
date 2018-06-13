<!-- row -->
	<div class="row">
        <div class="col-md-12">
            <?php
        $this->sangmaster->_Show_Msg();
        ?>
            <div class="box box-primary">
                <?php
                echo form_open_multipart(current_url(),array('method'=>'post','id'=>'formList'));
                ?>
                <div class="box-header">
                    <h3 class="box-title"><?=$heading_title?></h3>
                    <div class="box-tools">
                        <?php
                        $button_add = _Button_Add($task['task_add']);
                        $button_update = _Submit('update_sort',TEXT_UPDATE, 'refresh', 'warning');
                        $button_delete_checked = _Submit('delete_checked',TEXT_DELETE_CHECKED, 'trash', 'danger');
                        echo $button_add;
                        ?>
                    </div>
                </div>
                
                <?php 
            $this->table->set_heading(
                array(
                    'data' => '<input type="checkbox" id="checkAll" onclick="check_all(this);">
                    <input type="hidden" name="delete_checked" value="">',
                    'width' => '5%'
                ),
                array(
                    'data' => 'Tiêu đề',
                    'width' => ''
                ),
                array(
                    'data' => 'Loại banner',
                    'width' => ''
                ),
                array(
                    'data' => 'Vị trí',
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
            $type_option = array(
                    'image' => 'Hình ảnh',
                    'adsense' => 'Google Adsense',
                    'html5' => 'HTML5'
                );
            foreach($results as $val) {
                
                if($val['position']==1) $vitri = 'Header';
                elseif($val['position']==2) $vitri = 'Trang chủ 1';
                elseif($val['position']==16) $vitri = 'Trang chủ 2';
                elseif($val['position']==3) $vitri = 'Bên trái';
                elseif($val['position']==4) $vitri = 'Bên phải';
                elseif($val['position']==5) $vitri = 'Sidebar 1';
                elseif($val['position']==6) $vitri = 'Chi tiết tin rao, dưới slide hình';
                elseif($val['position']==7) $vitri = 'Chi tiết tin rao, dưới lưu ý';
                elseif($val['position']==8) $vitri = 'Trên footer';
                elseif($val['position']==9) $vitri = 'Danh sách tin rao';
                elseif($val['position']==10) $vitri = 'Sidebar 2';
                elseif($val['position']==11) $vitri = 'News Sidebar 1';
                elseif($val['position']==12) $vitri = 'News Sidebar 2';
                elseif($val['position']==13) $vitri = 'News Sidebar 3';
                elseif($val['position']==14) $vitri = 'News Detail Bottom';
                elseif($val['position']==15) $vitri = '3 banner detail kinh nghiệm';
                
                $this->table->add_row(
                        array(
                            array('data'=> '<input type="checkbox" name="results[]" value="'.$val['id'].'">'),
                            array('data'=> _Space(0, $val['title']),'class'=>'left'),
                            array('data'=> $type_option[$val['type']],'class'=>'left'),
                            array('data'=> $vitri, 'class'=>'left'),
                            array('data'=> _Format_Date($val['create_time']), 'class'=>'center'),
                            array('data'=> _Show_Status('banners',$val['id'],'status', $val['status']), 'class'=>'center'),
                            array('data'=> _Input('sort_order['.$val['id'].']', $val['sort_order']), 'class'=>'center'),
                            array('data'=> _Button_Change($task['task_change'].'/'.$val['id']).'&nbsp;'.
                                           _Button_Delete($task['task_delete'].'/'.$val['id']),'class'=>'center')
                        )
                );
                
                
            }
            
        echo $this->table->generate();
        echo form_close();
        
        echo $pagination;
        ?>
                
            </div>
            
        
        </div>
		
        
	</div>