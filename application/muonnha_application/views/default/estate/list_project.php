<?php $this->load->view('default/require/breadcrumb', $search_param); ?>
<style>
.nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus{border:0}
.project-detail {
    font-size:14px;
}
.project-detail h2,
.project-detail h3,
.project-detail h4,
.project-detail h5,
.project-detail h6{
    font-size:15px;
    margin: 0 0 7px 0;
}
.img-responsive{
    max-width: 100%!important;
    height:auto!important;
    display: inline-block;
}
</style>
<script>
$(document).ready(function(){
    $('.project-detail').find('img').removeAttr('style').addClass('img-responsive');
})
</script>
    <div class="main-wrap-content property_listing">
        <div class="property_type row">
            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 col-list-left">
                <div class="main_title">
                <h1 style="margin-top:0;"><?=$heading_title?></h1>
            </div>
            <?php if($this->uri->segment(1)!='tags') : ?>
            <h2 class="result_address">Tìm kiếm theo tiêu chí : 
                            <?php if($show_tag_link==false):?>
                            <a href="<?=current_url()?>" style="color:#38a345;font-weight:bold"><?=$link_title?></a>&nbsp;-&nbsp;<?=$sub_address?>
                            <?php else: ?>
                            <a href="<?=site_url($this->uri->segment(1))?>" style="color:#38a345;font-weight: bold;"><?=$link_title?></a>
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
                                    elseif($search_param['filter_area'] == 1) echo '<=20m<sup>2</sup>';
                                    elseif($search_param['filter_area'] == 2) echo '20 - 30m<sup>2</sup>';
                                    elseif($search_param['filter_area'] == 3) echo '30 - 50m<sup>2</sup>';
                                    elseif($search_param['filter_area'] == 4) echo '50 - 60m<sup>2</sup>';
                                    elseif($search_param['filter_area'] == 5) echo '60 - 70m<sup>2</sup>';
                                    elseif($search_param['filter_area'] == 6) echo '70 - 80m<sup>2</sup>';
                                    elseif($search_param['filter_area'] == 7) echo '80 - 90m<sup>2</sup>';
                                    elseif($search_param['filter_area'] == 8) echo '90 - 100m<sup>2</sup>';
                                    elseif($search_param['filter_area'] == 9) echo '>= 100<sup>2</sup>';
                                    echo '</strong>. ';
                                }
                                
                                if(isset($search_param['filter_price']) && $search_param['filter_price']!=-1) {
                                    echo 'Giá: ';
                                    echo '<strong style="color: #38a345;">';
                                    if($search_param['filter_price'] == 0) echo 'Thỏa thuận';
                                    elseif($search_param['filter_price'] == 1) echo '<=1 triệu';
                                    elseif($search_param['filter_price'] == 2) echo '1 - 2 triệu';
                                    elseif($search_param['filter_price'] == 3) echo '2 - 3 triệu';
                                    elseif($search_param['filter_price'] == 4) echo '3 - 5 triệu';
                                    elseif($search_param['filter_price'] == 5) echo '5 - 7 triệu';
                                    elseif($search_param['filter_price'] == 6) echo '7 - 10 triệu';
                                    elseif($search_param['filter_price'] == 7) echo '10 - 15 triệu';
                                    elseif($search_param['filter_price'] == 8) echo '>= 15 triệu';
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
                            <?php endif ?>
                            <div style="display: none;"><?=$hidden_content?></div>
                            <div class="clearfix"></div>
                    <?php if(!empty($list_most_search_link)):?>
                            <div class="top-links">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a>Khu vực được tìm kiếm nhiều nhất</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active">
                                        <div class="row">
                                        <?php
                                        foreach($list_most_search_link as $link):
                                        ?>
                                        <div class="col-md-4">
                                        <a href="<?=$link['link']?>">&raquo; <?=$link['title']?></a></div>
                                        <?php endforeach ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif ?>
                            
                <ul class="nav nav-tabs" role="tablist" style="border-bottom: 0;margin-bottom: 2px;margin-top: 0;">
                    <li role="presentation" class="active" style="width: auto;"><a href="#listproject" aria-controls="listproject" role="tab" data-toggle="tab">Danh sách tin rao (<?=number_format($total_result)?>)</a></li>
                    <li role="presentation" style="width: auto;"><a href="#detailproject" aria-controls="detailproject" role="tab" data-toggle="tab">Thông tin dự án</a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="listproject">
                        <div class="tab-list" style="margin-bottom: 10px;">
                            <div class="list-tinrao"><span><strong><?=$heading_title?></strong></span></div>
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
                        
                        <div class="row">
                            <?php 
                            $list_ignore = array();
                            if(count($results) > 0) :
                        $count = 1;
                        foreach($results as $result) {
                            $list_ignore[] = $result['id'];
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
                        
                        
						<div class="col-md-6 col-xs-12 single_properties <?=$class?>">
							
							<div class="properties_details">
								<div class="img_holder">
									<a href="<?=site_url($result['alias'])?>" title="<?=$result['title']?>"> <img src="<?=base_url('timthumb.php?image='.$thumb.'&w=150&h=150&zc=1')?>" onerror="this.src='<?=base_url('theme/images/thumb.jpg')?>'" alt="<?=$result['title']?>" class="img-responsive"></a>
        	                   </div> <!-- End .img_holder -->

								<div class="text">
                                    <div class="properties_title">
                                        <h3 class="<?=$class?>"><a href="<?=site_url($result['alias'])?>" title="<?=$result['title']?>"><?=sub_string($result['title'], 100)?></a></h3>
								    </div>
									<div class="meta">
                                    <span class="price"><strong><?php
                                    
                                        if($result['price_unit']==0 || $result['price_number']==0) echo 'Thỏa thuận';
                                        else echo $result['price_number'].' '._Price_Label($result['price_unit']);
                                        ?></strong></span>
                                    <span><strong><?=$result['area']!=0 ? $result['area'].'m<sup>2</sup>':'Không xác định'?></strong></span>
                                    <span><strong><?=$result['district_title'].', '.$result['city_title']?></strong></span>
                                    </div>
                                    <p class="sumary">
                                    <?php
                                    echo sub_string($result['content'], 130);
                                    ?>
                                    </p>
								</div> <!-- End .text -->
                                
							</div> <!-- End .properties_details -->

						</div> <!-- End .single_properties -->
                        <?php $count++; }
                        else: ?>
                        <p style="text-align: center;margin: 15px 0;">Không có tin đăng trong mục này</p>
                        <?php endif ?>
                        <div class="clearfix"></div>
                        <?php if(!empty($results2)) : ?>
                        <div class="col-md-12">
                        <div style="font-size: 16px;color:#00588b;font-weight:bold;margin-bottom: 5px;">Có thể bạn quan tâm</div>
                        </div>
                        <?php
                        
                        $count = 1;
                        foreach($results2 as $result) { 
                            if(!in_array($result['id'], $list_ignore)) :
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
                        
                        
						<div class="col-md-6 col-xs-12 single_properties <?=$class?>">
							
							<div class="properties_details">
								<div class="img_holder">
									<a href="<?=site_url($result['alias'])?>" title="<?=$result['title']?>"> <img src="<?=base_url('timthumb.php?image='.$thumb.'&w=150&h=150&zc=1')?>" onerror="this.src='<?=base_url('theme/images/thumb.jpg')?>'" alt="<?=$result['title']?>" class="img-responsive"></a>
        	                   </div> <!-- End .img_holder -->

								<div class="text">
                                    <div class="properties_title">
                                        <h3 class="<?=$class?>"><a href="<?=site_url($result['alias'])?>" title="<?=$result['title']?>"><?=sub_string($result['title'], 100)?></a></h3>
								    </div>
									<div class="meta">
                                    <span class="price"><strong><?php
                                    
                                        if($result['price_unit']==-1) echo 'Thỏa thuận';
                                        else echo $result['price_number'].' '._Price_Label($result['price_unit']);
                                        ?></strong></span>
                                    <span><strong><?=$result['area']!=0 ? $result['area'].'m<sup>2</sup>':'Không xác định'?></strong></span>
                                    <span><strong><?=$result['district_title'].', '.$result['city_title']?></strong></span>
                                    </div>
                                    <p class="sumary">
                                    <?php
                                    echo sub_string($result['content'], 130);
                                    ?>
                                    </p>
								</div> <!-- End .text -->
                                
							</div> <!-- End .properties_details -->

						</div> <!-- End .single_properties -->
                        <?php $count++;endif; }
                        ?>
                        <?php endif; ?>
                        
                        </div>
                
             <?php
                    if(!empty($category_tags)) echo "<div class='tags-keyword' style='margin-top:10px'><strong>Tìm kiếm theo từ khóa:</strong> ".implode(" , ", $category_tags)."</div>";
                    ?>

					<div class="page_indicator">
						<?=$pagination?>
					</div> <!-- End .page_indicator -->
                    </div><!--end List Project-->
                    <div role="tabpanel" class="tab-pane" id="detailproject">
                        <div class="tab-list" style="margin-bottom: 10px;">
                            <div class="list-tinrao"><span><strong><?=$heading_title?></strong></span></div>
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
                        
                        <div style="padding-top: 15px;" class="project-detail"><?=$project['content']?></div>
                    </div><!--end Detail Project-->
                </div>
                            
                <div style="margin: 15px; 0">
                <?php echo $category_content; ?>
                </div>
                
            </div>
            
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">

                <div class="sidebar_style_two">
                    <div id="sidebar-box-fixed" style="background: #fff;z-index: 999;">
                        

                    </div>
                    <?php //$this->load->view('default/require/box_mxh'); ?>
                        <br>

                        <!--Banner QC-->

                        <?php if(USERTYPE == "PC") : ?>
                            <?php
                        $banners = $this->main_model->_Get_Banner(5);
                        $banner_left = '';
                                    foreach($banners as $banner) {
                                        if($banner['type']=='image') {
                                            if($banner['image']!='' && file_exists('./uploads/banners/'.$banner['image']))
                                            $banner_left .= '<a href="'.$banner['link'].'"  target="_blank"  style="" rel="nofollow"><img src="'.base_url('uploads/banners/'.$banner['image']).'" alt="" width="425" height="250" class="img-responsive"></a>';
                                        } elseif($banner['type']=='adsense') {
                                            $banner_left .= $banner['adsense'];
                                        } elseif($banner['type']=='html5') {
                                            $banner_left .= '<iframe frame-border="0" width="980px" height="90px" src="'.$banner['html5'].'"></iframe>';
                                        }
                                    }
                    if($banner_left) :
                    ?>
                                <div class="banner-footer" style="margin-bottom: 15px;">
                                    <?=$banner_left?>
                                </div>
                                <?php endif; ?>
                                    <?php endif; ?>
                                        <!--End banner QC-->
                                        <?php if(!empty($list_category)) : ?>
                                        <div class="boxed-list">
                                            <!-- Main_title2__________ -->
                                            <div class="boxed-heading-title">
                                                <?php echo isset($title_list_category) ? $title_list_category : 'Danh mục tin đăng'?>
                                            </div>
                                            <!-- End Main_title2______ -->
                                            <ul>
                                            <?php
                                                foreach($list_category as $category) {
                                            ?>
                                                    <li>
                                                        <h3 style="margin: 0;"><a href="<?=site_url($category['alias'])?>"><?=$category['title']?></a> (<?=$category['total']?>)</h3></li>
                                                    <?php } ?>
                                            </ul>
                                        </div>
                                        <?php endif ?>
                                       
                                        
                                        <div class="boxed-list">
                                            <div class="boxed-heading-title">
                                            <?php if(isset($title_list_category)) {
                                                echo str_replace('theo phường', 'theo giá', $title_list_category);
                                            } else echo 'Xem theo giá';
                                            
                                            ?>
                                                
                                            </div>
                                            <ul class="filter">
                                                <li><a href="<?=site_url($search_url.'/p1/-1')?>">Dưới 1 triệu</a></li>
                                                <li><a href="<?=site_url($search_url.'/p2/-1')?>">1 - 2 triệu</a></li>
                                                <li><a href="<?=site_url($search_url.'/p3/-1')?>">2 - 3 triệu</a></li>
                                                <li><a href="<?=site_url($search_url.'/p4/-1')?>">3 - 5 triệu</a></li>
                                                <li><a href="<?=site_url($search_url.'/p5/-1')?>">5 - 7 triệu</a></li>
                                                <li><a href="<?=site_url($search_url.'/p6/-1')?>">7 - 10 triệu</a></li>
                                                <li><a href="<?=site_url($search_url.'/p7/-1')?>">10 - 15 triệu</a></li>
                                                <li><a href="<?=site_url($search_url.'/p8/-1')?>">Trên 15 triệu</a></li>
                                            </ul>
                                            
                                        </div>
                                        
                                        <div class="boxed-list">
                                            <div class="boxed-heading-title">
                                                <?php if(isset($title_list_category)) {
                                                echo str_replace('theo phường', 'theo diện tích', $title_list_category);
                                            } else echo 'Xem theo diện tích'?>
                                            </div>
                                            <ul class="filter">
                                                <li><a href="<?=site_url($search_url.'/-1/a1')?>">Dưới 20m<sup>2</sup></a></li>
                                                <li><a href="<?=site_url($search_url.'/-1/a2')?>">20 - 30m<sup>2</sup></a></li>
                                                <li><a href="<?=site_url($search_url.'/-1/a3')?>">30 - 50m<sup>2</sup></a></li>
                                                <li><a href="<?=site_url($search_url.'/-1/a4')?>">50 - 60m<sup>2</sup></a></li>
                                                <li><a href="<?=site_url($search_url.'/-1/a5')?>">60 - 70m<sup>2</sup></a></li>
                                                <li><a href="<?=site_url($search_url.'/-1/a6')?>">70 - 80m<sup>2</sup></a></li>
                                                <li><a href="<?=site_url($search_url.'/-1/a7')?>">80 - 90m<sup>2</sup></a></li>
                                                <li><a href="<?=site_url($search_url.'/-1/a8')?>">90 - 100m<sup>2</sup></a></li>
                                                <li><a href="<?=site_url($search_url.'/-1/a9')?>">Trên 100m<sup>2</sup></a></li>
                                            </ul>
                                        </div>
                                        <!-- End .commercial_video -->
                                        <!--Banner QC-->
                                        <?php if(USERTYPE == "PC") : ?>
                                            <?php
                        $banners = $this->main_model->_Get_Banner(10);
                        $banner_left = '';
                                    foreach($banners as $banner) {
                                        if($banner['type']=='image') {
                                            if($banner['image']!='' && file_exists('./uploads/banners/'.$banner['image']))
                                            $banner_left .= '<a href="'.$banner['link'].'"  target="_blank"  style="" rel="nofollow"><img src="'.base_url('uploads/banners/'.$banner['image']).'" alt="" width="425" height="250" class="img-responsive"></a>';
                                        } elseif($banner['type']=='adsense') {

                                            $banner_left .= $banner['adsense'];

                                        } elseif($banner['type']=='html5') {

                                            $banner_left .= '<iframe frame-border="0" width="980px" height="90px" src="'.$banner['html5'].'"></iframe>';

                                        }

                                    }

                    if($banner_left) :

                    ?>

                                                <div class="banner-footer" style="margin-bottom: 15px;">
                                                    <?=$banner_left?>
                                                </div>

                                                <?php endif; ?>

                                                    <?php endif; ?>
                </div>
                <!-- End .sidebar_style_two -->
<?php $this->load->view('default/require/top3_content'); ?>
            </div>
            
        </div>
            <!-- End of column -->
        </div>
        <!-- End .row -->

    </div>
<div id="btn-contact-fixed" class="btn btn-info" style="position:fixed;bottom:0;right:40px;display:none;z-index:99999"><i class="fa fa-envelope"></i> Liên hệ người bán</div>
<script src="https://maps.googleapis.com/maps/api/js?key=<?=API_KEY?>&libraries=places"></script>
<script type="text/javascript">
$(document).ready(function(){
    $.RealApp.captchaRefresh();
    $('#btnContactSubmit').on('click', function() {
        $('#frmContactAgency').submit();
    });
    $('#frmContactAgency').on('submit', function() {
       if($('#frmContactAgency input[name="fullname"]').val() == '') {
        alert('Vui lòng nhập họ tên');
        $('#frmContactAgency input[name="fullname"]').focus();
       } else if($('#frmContactAgency input[name="email"]').val() == '') {
        alert('Vui lòng nhập Email');
        $('#frmContactAgency input[name="email"]').focus();
       } else if($('#frmContactAgency input[name="phone"]').val() == '') {
        alert('Vui lòng nhập Số điện thoại');
        $('#frmContactAgency input[name="phone"]').focus();
       } else if($('#frmContactAgency textarea[name="msg"]').val() == ''){
            alert('Vui lòng nhập nội dung');
            $('#frmContactAgency input[name="msg"]').focus();
       } else if($('#frmContactAgency textarea[name="captcha"]').val() == ''){
            alert('Vui lòng nhập mã an toàn');
            $('#frmContactAgency input[name="captcha"]').focus();
       } else {
		   $('#btnContactSubmit').text('Đang gửi..').attr('disabled','disabled');
            $.ajax({
               url: 'ajax/contact_agency',
               type: 'post',
               dataType: 'json',
               data: $('#frmContactAgency').serialize(),
               success: function(res) {
                    if(res.success == false) {
                        alert(res.msg);
                    } else {
                        $('#frmContactAgency input[name="fullname"]').val('');
                        $('#frmContactAgency input[name="email"]').val('');
                        $('#frmContactAgency input[name="phone"]').val('');
                        $('#frmContactAgency input[name="captcha"]').val('');
                        $('#frmContactAgency textarea[name="msg"]').val('');
                        $('#btnContactSubmit').text('Đã gửi');
                        alert(res.msg);
                        
                    }
               }
            });
       }
       return false; 
    });
});
var API_KEY = '<?=API_KEY?>';
var map;
var infowindow;
var _lat = '';
var _lng = '';
var latlng = '';
var ArrContent = [];
function getLatLng() {
	
	geocoder = new google.maps.Geocoder();
    geocoder.geocode({
               'address': '<?=$real_estate['address']?>' 
         }, function(results, status){console.log(status);
                if(status == google.maps.GeocoderStatus.OK) {
                   //latlng.push(results[0].geometry.location.lat());
				   //latlng.push(results[0].geometry.location.lng());
				   
				   return results[0].geometry.location;
				
         }
    });
	return latlng;
}
getLatLng('<?=$real_estate['address']?>');

                                                       $(document).ready(function() {
															
															
															
                                                            $('#listDistance input[type="radio"]').on('change', function() {
                                                                var selected = [];
                                                                $.each($('.utility:checked'), function(a, b) {
                                                                        selected.push($(b).val());
                                                                });
                                                                
                                                                $('#RadiusCurrent').text($('#listDistance input[type="radio"]:checked').val() + 'm');
																//Load ajax
																$('#loadingUtility').show();
																$('#displayUtility').html('');
                                                                /*$.ajax({
                                                                   url: '/api/place.php',
                                                                   type: 'post',
                                                                   dataType: 'html',
                                                                   data: {radius: $('#listDistance input[type="radio"]:checked').val(), 
                                                                        type: selected,
                                                                        lat: latlng[0],
                                                                        lng: latlng[1]
                                                                   },
                                                                   success: function(html) {
                                                                    $('#displayUtility').html(html);
																	$('#loadingUtility').hide();
                                                                   } 
                                                                });*/
                                                                initMap(selected, $('#listDistance input[type="radio"]:checked').val());
                                                                
                                                            });
                                                            
                                                            $('.utility').change(function() {
                                                                var selected = [];
                                                                $.each($('.utility:checked'), function(a, b) {
                                                                    selected.push($(b).val());
                                                                });
                                                                //Load ajax
																$('#loadingUtility').show();
																$('#displayUtility').html('');
                                                                /*$.ajax({
                                                                   url: '/api/place.php',
                                                                   type: 'post',
                                                                   dataType: 'html',
                                                                   data: {radius: $('#listDistance input[type="radio"]:checked').val(), 
                                                                        type: selected,
                                                                        lat: latlng[0],
                                                                        lng: latlng[1]
                                                                   },
                                                                   success: function(html) {
                                                                    $('#displayUtility').html(html);
																	$('#loadingUtility').hide();
                                                                   } 
                                                                });*/
                                                                initMap(selected, $('#listDistance input[type="radio"]:checked').val());
                                                            })
                                                        });

                                                        function initMap(Type, Radius) {
															//var latlng = getLatLng();
                                                            geocoder = new google.maps.Geocoder();
    geocoder.geocode({
               'address': '<?=$real_estate['address']?>' 
         }, function(results, status){console.log(status);
                if(status == google.maps.GeocoderStatus.OK) {
                   _lat = (results[0].geometry.location.lat());
				   _lng = (results[0].geometry.location.lng());
				   
				   var pyrmont = {
                                                                lat: parseFloat(_lat),
                                                                lng: parseFloat(_lng)
                                                            };
                                                            var fromName = '<?=$real_estate['address']?>';
                                                            
                                                            map = new google.maps.Map(document.getElementById('map'), {
                                                                center: pyrmont,
                                                                zoom: 15,
																zoomControl: true,
																  scaleControl: false,
																  scrollwheel: false,
																  disableDoubleClickZoom: true,
                                                            });

                                                            infowindow = new google.maps.InfoWindow({
                                                                maxWidth: 200
                                                            });

                                                            var marker = new google.maps.Marker({
                                                                map: map,
                                                                position: pyrmont
                                                            });

                                                            var service = new google.maps.places.PlacesService(map);
                                                            
                                                            for(i=0; i<Type.length;i++) {
                                                                    service.nearbySearch({
                                                                    location: pyrmont,
                                                                    radius: parseInt(Radius),
                                                                    type: Type[i]
                                                                }, callback);    
                                                            }
                                                            

                                                            //Ve hinh tron
                                                            var cityCircle = new google.maps.Circle({
                                                                strokeColor: '#FF0000',
                                                                strokeOpacity: 0.8,
                                                                strokeWeight: 2,
                                                                fillColor: '#FF0000',
                                                                fillOpacity: 0.35,
                                                                map: map,
                                                                center: pyrmont,
                                                                radius: parseInt(Radius)
                                                            });
				   
			}
        });
														}
														
														var rad = function(x) {
														  return x * Math.PI / 180;
														};
														
														var getDistance = function(p1, p2) {console.log(p1);
														  var R = 6378137; // Earth’s mean radius in meter
														  var dLat = rad(p2.lat() - p1.lat);
														  var dLong = rad(p2.lng() - p1.lng);
														  var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
															Math.cos(rad(p1.lat)) * Math.cos(rad(p2.lat())) *
															Math.sin(dLong / 2) * Math.sin(dLong / 2);
														  var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
														  var d = R * c;
														  return d; // returns the distance in meter
														};

                                                        function callback(results, status) {
                                                            var TableOpen = '<div style="max-height:200px;overflow:auto;margin-bottom:20px;border:1px solid #ddd"><table class="table">';
                                                            var TableClose = '</table></div>';
                                                            var Store = [];
                                                            var Restaurant = [];
                                                            var Bank = [];
                                                            var Church = [];
                                                            var ATM = [];
                                                            var Hospital = [];
                                                            var BusStation = [];
                                                            var Loging = [];
                                                            var TableContent = '';
															var LatLng = getLatLng('<?=$real_estate['address']?>');
                                                            
                                                            if (status === google.maps.places.PlacesServiceStatus.OK) {
                                                                for (var i = 0; i < results.length; i++) {
                                                                    createMarker(results[i]);
                                                                    var distance;
																	
                                                                    distance = getDistance(LatLng, results[i].geometry.location);
                                                                    results[i].distance = distance;
                                                                    for(j=0; j<results[i].types.length; j++) {
                                                                        if(results[i].types[j]=="restaurant"){
                                                                            Restaurant.push(results[i]);
                                                                        } 
                                                                        if(results[i].types[j]=="store"){
                                                                            Store.push(results[i]);
                                                                        } 
                                                                        if(results[i].types[j]=="bank"){
                                                                            Bank.push(results[i]);
                                                                        }
                                                                        if(results[i].types[j]=="church"){
                                                                            Church.push(results[i]);
                                                                        } 
                                                                        if(results[i].types[j]=="atm"){
                                                                            ATM.push(results[i]);
                                                                        }
                                                                        if(results[i].types[j]=="hospital"){
                                                                            Hospital.push(results[i]);
                                                                        }
                                                                        if(results[i].types[j]=="bus_station"){
                                                                            BusStation.push(results[i]);
                                                                        }
                                                                        if(results[i].types[j]=="loging"){
                                                                            Loging.push(results[i]);
                                                                        }
                                                                    }
                                                                    
                                                                }
                                                            }
                                                            if(Restaurant!='' && $('input[type="checkbox"][value="restaurant"]').prop('checked')) {
                                                                TableContent = '<table class="table no-border" style="margin:0"><tr><th width="45%">Nhà hàng('+Restaurant.length+')</th><th width="45%">Địa chỉ</th><th width="10%">Khoảng cách</th></tr></table>';
                                                                TableContent += TableOpen;
                                                                for(i=0; i<Restaurant.length;i++) {
                                                                    TableContent +='<tr><td width="45%">'+Restaurant[i].name+'</td><td width="45%">'+Restaurant[i].vicinity+'</td><td width="10%">'+Restaurant[i].distance+'</td></tr>';
                                                                }
                                                                TableContent += TableClose;
                                                                ArrContent['restaurant'] = TableContent;
                                                            }
                                                            if(Store!='' && $('input[type="checkbox"][value="store"]').prop('checked')) {
                                                                TableContent = '<table class="table no-border" style="margin:0"><tr><th width="45%">Cửa hàng('+Store.length+')</th><th width="45%">Địa chỉ</th><th width="10%">Khoảng cách</th></tr></table>';
                                                                TableContent += TableOpen;
                                                                for(i=0; i<Store.length;i++) {
                                                                    TableContent +='<tr><td width="45%">'+Store[i].name+'</td><td width="45%">'+Store[i].vicinity+'</td><td>'+Store[i].distance+'</td></tr>';
                                                                }
                                                                TableContent += TableClose;
                                                                ArrContent['store'] = TableContent;
                                                            }
                                                            
                                                            if(Bank!='' && $('input[type="checkbox"][value="bank"]').prop('checked')) {
                                                                TableContent = '<table class="table no-border" style="margin:0"><tr><th width="45%">Ngân hàng('+Bank.length+')</th><th width="45%">Địa chỉ</th><th width="10%">Khoảng cách</th></tr></table>';
                                                                TableContent += TableOpen;
                                                                for(i=0; i<Bank.length;i++) {
                                                                    TableContent +='<tr><td width="45%">'+Bank[i].name+'</td><td width="45%">'+Bank[i].vicinity+'</td><td>'+Bank[i].distance+'</td></tr>';
                                                                }
                                                                TableContent += TableClose;
                                                                ArrContent['bank'] = TableContent;
                                                            }
                                                            if(Church!='' && $('input[type="checkbox"][value="church"]').prop('checked')) {
                                                                TableContent = '<table class="table no-border" style="margin:0"><tr><th width="45%">Nhà thờ('+Church.length+')</th><th width="45%">Địa chỉ</th><th width="10%">Khoảng cách</th></tr></table>';
                                                                TableContent += TableOpen;
                                                                for(i=0; i<Church.length;i++) {
                                                                    TableContent +='<tr><td width="45%">'+Church[i].name+'</td><td width="45%">'+Church[i].vicinity+'</td><td>'+Church[i].distance+'</td></tr>';
                                                                }
                                                                TableContent += TableClose;
                                                                ArrContent['church'] = TableContent;
                                                            }
                                                            if(ATM!='' && $('input[type="checkbox"][value="atm"]').prop('checked')) {
                                                                TableContent = '<table class="table no-border" style="margin:0"><tr><th width="45%">ATM('+ATM.length+')</th><th width="45%">Địa chỉ</th><th width="10%">Khoảng cách</th></tr></table>';
                                                                TableContent += TableOpen;
                                                                for(i=0; i<ATM.length;i++) {
                                                                    TableContent +='<tr><td width="45%">'+ATM[i].name+'</td><td width="45%">'+ATM[i].vicinity+'</td><td>'+ATM[i].distance+'</td></tr>';
                                                                }
                                                                TableContent += TableClose;
                                                                ArrContent['atm'] = TableContent;
                                                            }
                                                            if(Hospital!='' && $('input[type="checkbox"][value="hospital"]').prop('checked')) {
                                                                TableContent = '<table class="table no-border" style="margin:0"><tr><th width="45%">Bệnh viện('+Hospital.length+')</th><th width="45%">Địa chỉ</th><th width="10%">Khoảng cách</th></tr></table>';
                                                                TableContent += TableOpen;
                                                                for(i=0; i<Hospital.length;i++) {
                                                                    TableContent +='<tr><td width="45%">'+Hospital[i].name+'</td><td width="45%">'+Hospital[i].vicinity+'</td><td>'+Hospital[i].distance+'</td></tr>';
                                                                }
                                                                TableContent += TableClose;
                                                                ArrContent['hospital'] = TableContent;
                                                            }
                                                            if(BusStation!='' && $('input[type="checkbox"][value="bus_station"]').prop('checked')) {
                                                                TableContent = '<table class="table no-border" style="margin:0"><tr><th width="45%">Trạm xe('+BusStation.length+')</th><th width="45%">Địa chỉ</th><th width="10%">Khoảng cách</th></tr></table>';
                                                                TableContent += TableOpen;
                                                                for(i=0; i<BusStation.length;i++) {
                                                                    TableContent +='<tr><td width="45%">'+BusStation[i].name+'</td><td width="45%">'+BusStation[i].vicinity+'</td><td>'+BusStation[i].distance+'</td></tr>';
                                                                }
                                                                TableContent += TableClose;
                                                                ArrContent['bus_station'] = TableContent;
                                                            }
                                                            if(Loging!='' && $('input[type="checkbox"][value="loging"]').prop('checked')) {
                                                                TableContent = '<table class="table no-border" style="margin:0"><tr><th width="45%">Khách sạn, nhà nghỉ('+Loging.length+')</th><th width="45%">Địa chỉ</th><th width="10%">Khoảng cách</th></tr></table>';
                                                                TableContent += TableOpen;
                                                                for(i=0; i<Loging.length;i++) {
                                                                    TableContent +='<tr><td width="45%">'+Loging[i].name+'</td><td width="45%">'+Loging[i].vicinity+'</td><td>'+Loging[i].distance+'</td></tr>';
                                                                }
                                                                TableContent += TableClose;
                                                                ArrContent['loging'] = TableContent;
                                                            }
                                                            
                                                            var append_html = '';
                                                            if($('input[type="checkbox"][value="restaurant"]').prop('checked') && ArrContent['restaurant']!='undefined') {
                                                                append_html = ArrContent['restaurant'];
                                                            }
                                                            if($('input[type="checkbox"][value="store"]').prop('checked') && ArrContent['store']!='undefined') {
                                                                append_html += ArrContent['store'];
                                                            }
                                                            if($('input[type="checkbox"][value="bank"]').prop('checked') && ArrContent['bank']!='undefined') {
                                                                append_html += ArrContent['bank'];
                                                            }
                                                            if($('input[type="checkbox"][value="church"]').prop('checked') && ArrContent['church']!='undefined') {
                                                                append_html += ArrContent['church'];
                                                            }
                                                            if($('input[type="checkbox"][value="atm"]').prop('checked') && ArrContent['atm']!='undefined') {
                                                                append_html += ArrContent['atm'];
                                                            }
                                                            if($('input[type="checkbox"][value="hospital"]').prop('checked') && ArrContent['hospital']!='undefined') {
                                                                append_html += ArrContent['hospital'];
                                                            }
                                                            if($('input[type="checkbox"][value="bus_station"]').prop('checked') && ArrContent['bus_station']!='undefined') {
                                                                append_html += ArrContent['bus_station'];
                                                            }
                                                            if($('input[type="checkbox"][value="loging"]').prop('checked') && ArrContent['loging']!='undefined') {
                                                                append_html += ArrContent['loging'];
                                                            }
                                                            $('#displayUtility').html(append_html);
                                                            $('#loadingUtility').hide();
                                                        }

                                                        function createMarker(place) {
                                                            var placeLoc = place.geometry.location;
                                                            var marker = new google.maps.Marker({
                                                                map: map,
																//icon: '<?=base_url('theme/images/places/icon-bus.png')?>',
                                                                position: place.geometry.location
                                                            });

                                                            //Service distance
                                                            var LatLng = getLatLng('<?=$real_estate['address']?>');
                                                            var fromName = '<?=$real_estate['address']?>';
                                                            var distance = '';
                                                            
                                                            distance = getDistance(LatLng, placeLoc);
                                                            google.maps.event.addListener(marker, 'mouseover', function() {
                                                                infowindow.setContent('<div><strong>' + place.name + '</strong></div>' + '<div>' + place.vicinity + '</div><div><strong>Khoảng cách:</strong> ' + distance + '</div>');
                                                                infowindow.open(map, this);
                                                                
                                                            });
                                                            google.maps.event.addListener(marker, 'mouseout', function() {
                                                                infowindow.close();
                                                            });
                                                            
                                                            return distance;
                                                        }
var _default = ['store'];
                                                        initMap(_default, 1000);
</script>