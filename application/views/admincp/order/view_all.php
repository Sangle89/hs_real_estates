<section id="widget-grid" class="form-list">

	<!-- row -->
	<div class="row">

		<!-- NEW WIDGET START -->
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">
        <?php
        echo _Show_Message('success', $this->session->flashdata('message'));
        ?>
        <?php echo widget_open($title);
            echo form_open_multipart(current_url(),array('method'=>'post'));
            $button_add = _Button_Add(admin_url($this->uri->segment(2) . '/add'));
            $button_update = _Submit('submit_sort','Cập nhật');
            $this->table->set_heading(array(
                array('data' => form_label('Tổng cộng: ['.$total .'] / [' . $total_page.'] Trang', 'thongke'), 'colspan'=>6)
            ));
            $this->table->add_row(
                array(
                    'data' => '#ID',
                    'width' => '5%',
                    'class' => 'center'
                ),
                array(
                    'data' => 'Họ tên',
                    'width' => '10%'
                ),
				
                array(
                    'data' => 'Ngày tạo',
                    'width' => '10%',
                    'class' => 'center'
                ),
                array(
                    'data' => 'Chi tiết',
                    'width' => '20%',
                    'class' => 'center'
                ),
                array(
                    'data' => 'Trạng thái',
                    'width' => '10%',
                    'class' => 'center'
                ),
                array(
                    'data' => 'Tùy chọn',
                    'width' => '10%',
                    'class' => 'center'
                )
            );
            
            foreach($category as $val) {
                
                $detail = $this->order_model->_Get_Order_Detail($val['id']);
                
                $html = '<table class="table table-bordered table-order-detail">';
                $html .= '<thead><tr><th>Tên SP</th><th>Giá</th><th>Số lượng</th></tr></thead><tbody>';
                $total = 0;
                foreach($detail as $row) {
                    
                    $product = $this->product_model->_Get_By_Id($row['product_id']);
                    $total += $row['quantity'] * $row['price'];
                    $html .= '
                        <tr>
                            <td>'.$product['title'].'</td>
                            <td>'.number_format($row['price']).'</td>
                            <td>'.number_format($row['quantity']).'</td>
                        </tr>
                    ';
                }
                $html .= '</tbody><tfoot><tr><td colspan="3">Tổng cộng: '.number_format($total).'</td></tr></tfoot>';
                $html .= '</table>';
                
                $this->table->add_row(
                    array(
                        array('data'=>$val['code'],'class'=>'center'),
                        array('data'=>$val['name'].'<br>'.$val['phone'].'<br>'.$val['email'],'class'=>'left'),
						
                        array('data'=> _Format_Date($val['create_time']), 'class'=>'center'),
                        array('data'=>$html),
						array('data'=>$val['status'], 'class'=>'center'),
                        //array('data'=> _Show_Status('orders',$val['id'],'status', $val['status']), 'class'=>'center'),
                        array('data'=>_Button_Change(admin_url($this->uri->segment(2) . '/view/' . $val['id'])).'&nbsp;'.
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