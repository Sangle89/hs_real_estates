<section class="home_content" style="background: #f4f5f9;margin: 0;"> 
            <div class="main-wrap-content">
                <?php $this->load->view('default/home/banner1'); ?>
                <h2 style="text-align: center;font-weight: bold;color: #38a345;"><i class="fa fa-home"></i> Nhà cho thuê nổi bật</h2>
                <p style="text-align: center;font-size:16px;margin-bottom:30px;">Muonnha.com.vn đồng hành với bạn từ quá trình tìm kiếm cho đến khi giao dịch thành công ngôi nhà yêu thích của bạn.</p>
                <div class="row">
                    <?php
                    $real_estate_featured = $this->main_model->_Get_Real_Estate_Featured(9,0);
                    foreach($real_estate_featured as $result) { 
                        $thumb = $this->main_model->_Get_Real_Estate_Image($result['id']);  
                        //Resize 360x260
                        $image_resize = $this->image_model->resize($thumb, 360, 260, 'images');
                                  
                        if($result['type_id'] == 1)
                                $class = 'pro';
                        elseif($result['type_id'] == 2) 
                                 $class = 'vip1';
                        elseif($result['type_id'] == 3)
                                $class = 'vip2';
                        else
                                $class = 'normal';
                            ?>
                    <article class="col-md-4">
                        <div class="properties_grid feature">
								<div class="img_holder">
									<a href="<?=site_url($result['alias'])?>" title="<?=$result['title']?>"> <img src="<?=base_url($image_resize)?>" onerror="this.src='<?=base_url('theme/images/thumb1.jpg')?>'" alt="<?=$result['title']?>" class="img-responsive"></a>
        	                   </div> <!-- End .img_holder -->
                                <div class="info">
								    <h3 class="<?=$class?>"><a href="<?=site_url($result['alias'])?>" title="<?=$result['title']?>"><?=sub_string($result['title'],65)?></a></h3>
									<address><i class="fa fa-map-marker"></i> <?=$result['district_title']?>, Hồ Chí Minh</address>
                                    <div class="meta">
                                        <span class="area"><i class="fa fa-area-chart"></i>&nbsp;<?=$result['area']!=0 ? $result['area'].'m2':'Không xác định'?></span>
                                        <span class="price"><?php
                                        if($result['price_unit']==0 || $result['price_number'] == 0) echo 'Thỏa thuận';
                                        else echo $result['price_number'].' '._Price_Label($result['price_unit']);
                                        ?></span>
									   </div>
								</div>
                                
							</div> <!-- End .properties_details -->
                    </article>
                    <?php } ?>
                </div>
                
            </div>
            
</section>