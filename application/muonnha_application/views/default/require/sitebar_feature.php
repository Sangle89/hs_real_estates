<div style="margin-bottom: 15px;">
<div class="sitebar-heading">Nhà cho thuê nổi bật</div>
                    <?php
                            $real_estate_featured = $this->main_model->_Get_Real_Estate_Featured(12,0);
                            foreach($real_estate_featured as $result) { 
                                $thumb = $this->main_model->_Get_Real_Estate_Image($result['id']);    
                            if($result['type_id'] == 1)
                                $class = 'pro';
                            elseif($result['type_id'] == 2) 
                                 $class = 'vip1';
                            elseif($result['type_id'] == 3)
                                $class = 'vip2';
                            else
                                $class = 'normal';
                            ?>
                            <article class="post">
                                
                                <div class="properties_grid" style="margin-bottom: 0;border-top: 0;">
                                    <div class="row">
                                    <div class="col-md-12 title">
                                    <div class="<?=$class?>" style="min-height: inherit;font-size: 14px;font-weight: bold;"><a href="<?=site_url($result['alias'])?>" title="<?=$result['title']?>" rel="nofollow"><?=sub_string($result['title'],60)?></a></div>
    								</div> <!-- End .properties_title -->
        								<div class="col-md-4 col-xs-4 img_holder">
        									<a href="<?=site_url($result['alias'])?>" title="<?=$result['title']?>" rel="nofollow"> <img src="<?=base_url('timthumb.php?image='.$thumb.'&w=200&h=200&zc=1')?>" onerror="this.src='<?=base_url('theme/images/thumb.jpg')?>'" alt="<?=$result['title']?>" class="img-responsive"></a>
                	                   </div> <!-- End .img_holder -->
                                        <div class="col-md-8 col-xs-8 info">
        								    
                                            <div class="meta">
                                                <p><span>Giá</span><span>: <?php
                                                if($result['price_unit']==0) echo 'Thỏa thuận';
                                                else echo $result['price_number'].' '._Price_Label($result['price_unit']);
                                                ?></span></p>
                                                <p><span>Diện tích</span><span>: <?=$result['area']!=0 ? $result['area'].'m2':'Không xác định'?></span></p>
                                                <p><span>Quận/huyện</span><span>: <?=$result['district_title']?></span></p>
                                                <p><span>Ngày đăng</span><span>: <?=_Format_Date($result['create_time'])?></span></p>
        									</div>
        								</div>
                                    </div>
                                    
        							</div> <!-- End .properties_details -->
                            </article>
                            <?php } ?>
                            <div class="clearfix"></div>
</div>