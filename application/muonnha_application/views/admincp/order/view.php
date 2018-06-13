<div class="row">
	<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
		<h1 class="page-title txt-color-blueDark">
			<i class="fa fa-table fa-fw "></i> 
				Home 
			<span>&gt; 
				Quản lý đơn hàng
			</span>
		</h1>
	</div>
</div>
<section id="widget-grid" class="">
	<div class="row">
        <article class="col-xs-12 col-sm-12 col-md-6 col-lg-6 sortable-grid ui-sortable" style="display: none!important;">
            <?php
                echo widget_open('Thông tin khách hàng: '); 
					$this->table->add_row(
                        array('data'=>'Họ tên', 'width'=>'20%'),
                        form_label($user->first_name .' '. $user->last_name)
                    );
                    $this->table->add_row(array(
                        'Số điện thoại',
                        form_label($user->phone)
                    ));
                    $this->table->add_row(array(
                        'Email',
                        form_label($user->email)
                    ));
                    $this->table->add_row(array(
                        'Địa chỉ',
                        form_label($user->address)
                    ));
                    
                    echo $this->table->generate();
                
                echo widget_close();
            ?>
        </article>
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">
            <?php
                echo widget_open('Thông tin khách hàng: '); 
                $this->table->add_row(
                        array('data'=>'Họ tên', 'width' => '20%'),
                        form_label($order['fullname'])
                    );
                    $this->table->add_row(array(
                        'Số điện thoại',
                        form_label($order['phone'])
                    ));
                    $this->table->add_row(array(
                        'Email',
                        form_label($order['email'])
                    ));
                    
                    $this->table->add_row(array(
                        'Địa chỉ',
                        form_label($order['address'])
                    ));
                    $this->table->add_row(array(
                        'Địa chỉ giao hàng',
                        form_label($order['address1'])
                    ));
                    $this->table->add_row(array(
                        'Hình thức thanh toán',
                        form_label($order['payment'])
                    ));
                    
                    echo $this->table->generate();
                echo widget_close();
            ?>
        </article>
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">
            <?php
                echo widget_open('Mã đơn hàng ' . $order['code'] .' | ngày tạo ' . _Format_Date($order['create_time'])); 
                echo form_open_multipart(admin_url('order/view/' . $this->uri->segment(4)), array('method'=>'post','id'=>'myForm', 'class'=>'smart-form')); 
             
                //Table detail
                $this->table->set_heading('Tên sản phẩm', 'Giá', 'Số lượng', 'Sub total');
				$total = 0;
                foreach($order['detail'] as $product) {
                    
                    $this->table->add_row(
                        array('data' => $product['title']),
                        array('data' => number_format($product['price'])),
                        array('data' => $product['quantity']),
						array('data' => number_format($product['quantity'] * $product['price']))
                    );
					$total += $product['price'] * $product['quantity'];
                }
                
                
                $this->table->add_row(
                    array('data' => 'Tổng cộng'),
                    array('data' => number_format($total)),
                    array('data' => 'Trạng thái'),
                    array('data' => form_dropdown('status', array('pending'=>'Pending', 'success'=>'Success'), $order['status'], 'class="form-control"'))
                );
				
                echo $this->table->generate();
                echo widget_submit(array(
					_Submit('save', 'Lưu lại','save')
				));
                echo form_close(); 
                echo widget_close(); ?>
		</article>
	</div>
</section>
<script>
var nav_active = 'orders';
</script>