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
                array('data' => form_label('Tổng cộng: ['.$total .'] / [' . $total_page.'] Trang', 'thongke')),
                array('data' => $button_add.' '.$button_update, 'colspan'=>2,'class' => 'center'),
            ));
            
            $this->table->add_row(array(
                array('data' => _Input('search_input', '', 'form-control', 'id="searchInput" data-type="search_real_estate" placeholder="Nhập từ khóa cần tìm.."'), 'colspan'=>5)
            ));
            
            echo $this->table->generate();
            
            $this->table->set_template(array(
                'table_open'		=>	'<table class="table table-bordered table-hover table-striped table-list" id="tableList">'
            ));
            
            $this->table->set_heading(array(
                array(
                    'data' => 'Hình',
                    'width' => '5%'
                ),
                array(
                    'data' => 'Tiêu đề',
                    'width' => '15%'
                ),
                array(
                    'data' => 'Ngày tạo',
                    'width' => '5%',
                    'class' => 'center'
                ),
                
                array(
                    'data' => 'Thông tin',
                    'width' => '30%',
                    'class' => 'center'
                ),
                array(
                    'data' => 'Tùy chọn',
                    'width' => '10%',
                    'class' => 'center'
                )   
            ));
            
            foreach($category as $val) {
                $desc = 'Tỉnh thành: ';
                
                $city = $this->city_model->_Get_By_Id($val['city']);
                if($city) $desc.=$city['title'];
                
                $desc .= '<br>Diện tích: '.$val['area'].'m2';
                $desc .= '<br>Giá: '.$val['price'];
                $desc .= '<br>Số phòng: '.$val['sophong'];
                $desc .= '<br>Địa chỉ: '.$val['address'];
                $desc .= '<br>Tên: '.$val['guest_name'];
                $desc .= '<br>Số điện thoại: '.$val['guest_phone'];
                $this->table->add_row(
                    array(
                        array('data'=>'<img src="'.base_url('uploads/images/'.$val['image']).'" width="100">'),
                        array('data'=> '<a href="'.site_url($val['alias']).'" target="_blank">'.$val['title'].'</a><br>'.$desc,'class'=>'left'),
                        array('data'=> _Format_Date($val['create_time']), 'class'=>'center'),
                        array('data' => $val['content']),
                        array('data'=> '<a href="'.admin_url($this->uri->segment(2) . '/copy/' . $val['id']).'"><i class="fa fa-save"></i></a>&nbsp|&nbsp;<a href="'.admin_url($this->uri->segment(2) . '/delete/' . $val['id']).'"><i class="fa fa-trash"></i></a>',
                                'class'=>'center')
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