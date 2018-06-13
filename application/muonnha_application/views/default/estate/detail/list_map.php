<div class="leftColumn property_type ">
    <div class="inner_section_title padding10">
        <div class="main_title">
            <h1 style="margin-top:0;"><?=$heading_title?></h1>
        </div><!--end main title-->
        <div class="search_result">
                            <h2>Tìm kiếm theo tiêu chí : 
                            <?php if($show_tag_link==false):?>
                            <strong style="color:#38a345"><?=$link_title?></strong>&nbsp;-&nbsp;<?=$sub_address?>
                            <?php else: ?>
                            <a href="<?=site_url($this->uri->segment(1))?>" style="color:#38a345"><?=$link_title?></a>
                            &nbsp;-&nbsp;<?=$sub_address?>
                            <?php endif; ?>
                            
                            <?php
                            //print_r($search_param);
                            if(isset($search_param['filter_area'])
                            || isset($search_param['filter_price'])
                            || isset($search_param['filter_bedroom'])
                            || isset($search_param['filter_project'])) {
                                
                                if(isset($search_param['filter_area']) && $search_param['filter_area']!=-1) {
                                    echo 'Diện tích: ';
                                    echo '<strong style="color: #38a345;">';
                                    if($search_param['filter_area'] == 0) echo 'Không xác định';
                                    elseif($search_param['filter_area'] == 1) echo '<=30m2';
                                    elseif($search_param['filter_area'] == 2) echo '30 - 50m2';
                                    elseif($search_param['filter_area'] == 3) echo '50 - 80m2';
                                    elseif($search_param['filter_area'] == 4) echo '80 - 100m2';
                                    elseif($search_param['filter_area'] == 5) echo '100 - 150m2';
                                    elseif($search_param['filter_area'] == 6) echo '150 - 200m2';
                                    elseif($search_param['filter_area'] == 7) echo '200 - 250m2';
                                    elseif($search_param['filter_area'] == 8) echo '250 - 300m2';
                                    elseif($search_param['filter_area'] == 9) echo '300 - 500m2';
                                    elseif($search_param['filter_area'] == 10) echo '>= 500m2';
                                    echo '</strong>. ';
                                }
                                
                                if(isset($search_param['filter_price']) && $search_param['filter_price']!=-1) {
                                    echo 'Giá: ';
                                    echo '<strong style="color: #38a345;">';
                                    if($search_param['filter_price'] == 0) echo 'Thỏa thuận';
                                    elseif($search_param['filter_price'] == 1) echo '<=500 triệu';
                                    elseif($search_param['filter_price'] == 2) echo '500 - 800 triệu';
                                    elseif($search_param['filter_price'] == 3) echo '800 - 1 tỷ';
                                    elseif($search_param['filter_price'] == 4) echo '1 - 2 tỷ';
                                    elseif($search_param['filter_price'] == 5) echo '2 - 3 tỷ';
                                    elseif($search_param['filter_price'] == 6) echo '3 - 5 tỷ';
                                    elseif($search_param['filter_price'] == 7) echo '5 - 7 tỷ';
                                    elseif($search_param['filter_price'] == 8) echo '7 - 10 tỷ';
                                    elseif($search_param['filter_price'] == 9) echo '10 - 20 tỷ';
                                    elseif($search_param['filter_price'] == 10) echo '20 - 30 tỷ';
                                    elseif($search_param['filter_price'] == 11) echo '>= 30 tỷ';
                                    echo '</strong>. ';
                                }
                                
                                if(isset($search_param['filter_bedroom']) && $search_param['filter_bedroom']!=-1) {
                                    echo 'Phòng ngủ: ';
                                    echo '<strong style="color: #38a345;">';
                                    if($search_param['filter_bedroom'] == 1) echo '1';
                                    elseif($search_param['filter_bedroom'] ==2) echo '2';
                                    elseif($search_param['filter_bedroom'] == 3) echo '3';
                                    elseif($search_param['filter_bedroom'] == 4) echo '4';
                                    elseif($search_param['filter_bedroom'] == 5) echo '5';
                                    echo '</strong>. ';
                                }
                            }
                            ?>
                            
                            </h2>
                            <div style="display: none;"><?=$hidden_content?></div>
        </div><!--end search result-->
        
        
    </div>
        <div class="tab-list">
                            <div class="list-tinrao"><span>Có <strong><?=number_format($total_result)?></strong> bất động sản</span></div>
                            <div class="list-sort">
                                <span>Sắp xếp theo</span>
                                <?php
                                
                                $order_options = array(
                                    1 => 'Thông thường',
                                    'time_desc' => 'Tin mới nhất',
                                    'price_asc' => 'Giá cao nhất',
                                    'price_desc' => 'Giá thấp nhất'
                                );
                                ?>
                                <form method="post" id="formOrder">
                                    <select name="order_by" onchange="$('#formOrder').submit();">
                                    <?php foreach($order_options as $key=>$val) : ?>
                                        <option value="<?=$key?>" <?=isset($order_by) && $key == $order_by ? 'selected':''?>><?=$val?></option>   
                                        <?php endforeach; ?>
                                </select>
                                </form>
                            </div>
                            <div class="clearfix"></div>
        </div><!--end tab list-->
        <div class="scrollContent">
            <?php 
                        $count = 1;
                        foreach($results as $result) { 
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
                        
                        <?php if($count==10) : ?>
                        
                        <?php
                    
                        $banners = $this->main_model->_Get_Banner(9);
                        $banner_left = '';
                                    foreach($banners as $banner) {
                                        if($banner['type']=='image') {
                                            if($banner['image']!='' && file_exists('./uploads/banners/'.$banner['image']))
                                            $banner_left .= '<a href="'.$banner['link'].'"  target="_blank"  style="" rel="nofollow"><img src="'.base_url('uploads/banners/'.$banner['image']).'" alt="" width="585" height="90" class="img-responsive"></a>';
                                        } elseif($banner['type']=='adsense') {
                                            $banner_left .= $banner['adsense'];
                                        } elseif($banner['type']=='html5') {
                                            $banner_left .= '<iframe frame-border="0" width="980px" height="90px" src="'.$banner['html5'].'"></iframe>';
                                        }
                                    }
                    if($banner_left) :
                    ?>
                    <div class="banner-list" style="padding: 15px 5px;"><?=$banner_left?></div>
                    <?php endif; ?>
                        
                        <?php endif; ?>
                        
						<div class="single_properties <?=$class?>">
							
							<div class="properties_details">
								<div class="properties_info">
										<div class="properties_title">
                                        <h3 class="<?=$class?>"><a href="<?=site_url($result['alias'])?>" title="<?=$result['title']?>"><?=$result['title']?></a></h3>
										</div> <!-- End .properties_title -->
								</div>
                                <div class="img_holder">
									<a href="<?=site_url($result['alias'])?>" title="<?=$result['title']?>"> <img src="<?=base_url('timthumb.php?image='.$thumb.'&w=150&h=100&zc=1')?>" onerror="this.src='<?=base_url('theme/images/thumb.jpg')?>'" alt="<?=$result['title']?>" class="img-responsive"></a>
        	                   </div> <!-- End .img_holder -->

								<div class="text">
									<p class="sumary">
                                    <?php
                                    echo utf8_substr(strip_tags(html_entity_decode($result['content'], ENT_QUOTES, 'UTF-8')), 0, 170) . '..';
                                    ?>
                                    </p>
                                    <div class="meta">
                                    <span>Giá: <strong><?php
                                        if($result['price_unit']==1) echo 'Thỏa thuận';
                                        else echo $result['price_number'].' '._Price_Label($result['price_unit']);
                                        ?></strong></span>
                                    <span>Diện tích: <strong><?=$result['area']!=0 ? $result['area'].'m2':'Không xác định'?></strong></span>
                                    <span>Quận/huyện: <strong><?=$result['district_title'].', '.$result['city_title']?></strong></span>
                                    
									</div>
								</div> <!-- End .text -->
                                <span class="public-date"><?=_Format_Date($result['create_time'])?></span>
							</div> <!-- End .properties_details -->

						</div> <!-- End .single_properties -->
                        <?php $count++; } ?>
             <?php
                    if(!empty($category_tags)) echo "<div class='tags-keyword' style='margin-top:10px'><strong>Tìm kiếm theo từ khóa:</strong> ".implode(" , ", $category_tags)."</div>";
                    ?>

					<div class="page_indicator">
						<?=$pagination?>
                        
					</div> <!-- End .page_indicator -->
                    <?php $this->load->view('default/require/footer'); ?>
        </div>
       
</div>
<div class="rightColumn">
    <div class="wrap-google-map">
        <div class="google-map-list" id="banner-google-map" data-zoom="<?=$zoom?>" data-address="<?=$google_map?>"></div>
    </div>
</div>
<div class="clearfix"></div>
<script src="https://maps.google.com/maps/api/js?key=<?=API_KEY?>"></script> <!-- Gmap Helper -->                  