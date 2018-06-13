<?php $this->load->view('default/require/breadcrumb', $search_param); ?>
    <style>
    .show{
        display:block;
    }
    .wrap-utility{
        display:none;
    }
    .boxed-detail-utility .boxed-detail-heading-title{
        cursor: pointer;
    }
    </style>
    <!-- owl.carousel -->
    <style>
        .single-gallery-carousel-thumbnail-box.owl-carousel .owl-item img {
            opacity: 0.4;
        }
        
        .single-gallery-carousel-thumbnail-box.owl-carousel .owl-item.current img {
            opacity: 1;
        }
        .sidebar-fixed{position: fixed;bottom:0px;border:1px solid #777;padding:5px;background:#fff;z-index:9999}
    </style>
    <script type="text/javascript">
        $(document).ready(function(e) {
            var count = $('#myGallery img').length;
            if (count > 1) {
                Galleria.loadTheme('<?=base_url()?>theme/js/galleria/themes/classic/galleria.classic.min.js');

                $('#myGallery').galleria({
                    showInfo: false,
                    extend: function() {
                        this.$('info').hide();
                    }
                });
            }
            if (count == 1) {
                $('.galleria-thumbnails-container, .galleria-image-nav, .galleria-counter').remove();
                $('.gv_gallery, .gv_galleryWrap').height(413);
                $('#myGallery').css({
                    'background': '#FFF',
                    'text-align': 'center',
                    'padding': '10px 10px 6px',
                    'border': '1px solid #CCC'
                });
                $('#myGallery li').css({
                    'list-style': 'none'
                });
            } else if (count == 0) {
                $("#divmyGallery").hide();
                $('#myGallery').hide();
            }
            var sidebar = $('#sidebar-box-fixed').offset().top;
            var sidebarWidth = $('#sidebar-box-fixed').width();
            var sidebarHeight = $('#sidebar-box-fixed').height();
            var wWidth = $(window).width();
            var mainWidth = $('.main-wrap-content').width();
			
			var contentHeight = $('.property_detail').height();
            /*$(window).scroll(function() {
				if($(window).scrollTop() > sidebar + sidebarHeight) {
					if(!$('#sidebar-box-fixed').hasClass('sidebar-fixed'))
						$('#btn-contact-fixed').show();
				} else {
					$('#sidebar-box-fixed').removeClass('sidebar-fixed').removeAttr('style');
					$('#btn-contact-fixed').hide();
				}	
				
            });*/
            $('#btn-contact-fixed').show();
			$('#btn-contact-fixed').on('click', function(){
                
				$('#sidebar-box-fixed').css({'width': sidebarWidth + 'px','right': + (wWidth-mainWidth) / 2 + 'px'}).toggleClass('sidebar-fixed').show();
				$('#btn-contact-fixed').hide();
				$('#btn-close-popup').show();
			});
			$('#btn-close-popup').on('click', function(){
				$('#sidebar-box-fixed').hide();
				$('#btn-contact-fixed').show();
			});
        });
		function inViewport($ele) {
    var lBound = $(window).scrollTop(),
        uBound = lBound + $(window).height(),
        top = $ele.offset().top,
        bottom = top + $ele.outerHeight(true);

    return (top > lBound && top < uBound)
        || (bottom > lBound && bottom < uBound)
        || (lBound >= top && lBound <= bottom)
        || (uBound >= top && uBound <= bottom);
}
        function toggle_utility() {
            $('.wrap-utility').toggleClass('show');
        }
    </script>
    <script type="text/javascript" src="<?=base_url()?>theme/js/galleria/galleria-1.3.5.min.js"></script>
    <script type="text/javascript" src="<?=base_url()?>theme/js/galleria/galleria.flickr.min.js"></script>
    <script type="text/javascript" src="<?=base_url()?>theme/js/jquery-ui.min.js"></script>
    <script src="https://maps.google.com/maps/api/js?key=<?=API_KEY?>"></script>
    <!-- Gmap Helper -->
    <div class="main-wrap-content property_listing">
        <div class="product-detail-desc row">
            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 col-list-left">
                <div class="property_detail">
                    <h1 class="main_title" style="margin-top:0;"><?=$real_estate['title']?></h1>
                    <h2 class="result_address" style="margin: 0;">
                            <i class="fa fa-map-marker"></i>
                            <b>Khu vực: </b><a href="<?=site_url($search_alias)?>"><?=$search_title?></a> - <?=$locations?>
                    </h2>
                    <div class="result_price">
                        
                            <b>Giá: </b><span><strong>
                        <?php
                        if($real_estate['price_unit']==0 || $real_estate['price_number']==0) 
                            echo 'Thỏa thuận';
                        else 
                            echo $real_estate['price_number'].' '._Price_Label($real_estate['price_unit']);
                                    ?>
                        </strong></span>
                        <b>Diện tích: </b><span><strong><?=($real_estate['area']>0) ? $real_estate['area'].' m<sup>2</sup>':'Không xác định'?></strong></span>
                        
                    </div>
                    
                    <div class="title_info green">Thông tin mô tả</div>
                    <div class="detail_desc">
                        <?php 
							$content = 	nl2br($real_estate['content']);
							$content = str_replace("<br /><br />", "<br />", $content);
                            $content = str_replace("<br><br>", "<br />", $content);
                            $content = str_replace("<br>\n<br>", "<br />", $content);
                            $content = preg_replace('/<h3(.*?)>(.*?)<\/h3>/', '', $content);
                            echo $content;
						?>
                    </div>
                    <?php
   $utilities = $this->main_model->_Get_Real_Estate_Utility($real_estate['id']);
   					if(!empty($utilities)):
   ?>
                    <div class="title_info green">Tiện ích</div>
                    <div class="detail_utility" style="padding: 10px;background:#eaf5ff;">
                        
                    <div class="row">
                    <?php foreach($utilities as $item):?>
                        <div class="col-xs-2">
                            <label><i class="fa fa-check"></i> <?php echo $item['title']?></label>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    </div>
<?php endif ?>
                    <div class="tags-keyword">
                        <?php 
							if($real_estate['tag1']!='' || $real_estate['tag2']!='' || $real_estate['tag3']!='' || $real_estate['tag4']!='' || $real_estate['tag5'] != '' || $real_estate['tag6'] != ''):
							?>
                            <strong>Tìm kiếm theo từ khóa: </strong>
                            <?php endif; ?>
                                <?php 
                            $tags = array();
                            if($real_estate['tag1']!=''){
                                $tags[] = '<a href="'.site_url('tags/'.$real_estate['tag1_alias']).'">'.$real_estate['tag1'].'</a>';
                            }
                            if($real_estate['tag2']!=''){
                                $tags[] = '<a href="'.site_url('tags/'.$real_estate['tag2_alias']).'">'.$real_estate['tag2'].'</a>';
                            }
                            if($real_estate['tag3']!=''){
                                $tags[] = '<a href="'.site_url('tags/'.$real_estate['tag3_alias']).'">'.$real_estate['tag3'].'</a>';
                            }
                            if($real_estate['tag4']!=''){
                                $tags[] = '<a href="'.site_url('tags/'.$real_estate['tag4_alias']).'">'.$real_estate['tag4'].'</a>';
                            }
                            if($real_estate['tag5']!=''){
                                $tags[] = '<a href="'.site_url('tags/'.$real_estate['tag5_alias']).'">'.$real_estate['tag5'].'</a>';
                            }
                            if($real_estate['tag6']!=''){
                                $tags[] = '<a href="'.site_url('tags/'.$real_estate['tag6_alias']).'">'.$real_estate['tag6'].'</a>';
                            }
                            echo implode(" , ",$tags);
                            ?>

                    </div>

                    <?php if($real_estate['video']) { ?>
                        <div class="" style="margin-bottom: 10px;">
                            <div class="boxed-detail-heading-title" style="margin-bottom: 0;">Video</div>
                            <div style="padding: 10px 10px 6px;border:1px solid #ddd">
                                <?php
                                $video_id = _Get_Youtube_Id($real_estate['video']);
                                echo '<iframe width="100%" height="450" src="https://www.youtube.com/embed/'.$video_id.'" frameborder="0" allowfullscreen></iframe>';
                                ?>
                                </div>
                        </div>

                        <?php } ?>
                        <?php $this->load->view('default/estate/real_image'); ?>
                        <?php $this->load->view('default/estate/real_banner'); ?>
                        <?php $this->load->view('default/estate/real_info'); ?>
                                           
                                            <div class="share" style="margin:20px 0 0">
                                                <div class="fb-share-button" data-href="<?=current_url()?>" data-layout="button_count" data-size="small" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?=current_url()?>%2F&amp;src=sdkpreparse">Chia sẻ</a></div>
                                            </div>
                                            <div class="note" style="margin-bottom: 10px;">
                                                <strong>(*)Lưu ý</strong>
                                                <div>Quý vị đang xem nội dung tin rao "
                                                    <?=$real_estate['title']?>". Mọi thông tin liên quan tới tin rao này là do người đăng tin đăng tải và chịu trách nhiệm. Chúng tôi luôn cố gắng để có chất lượng thông tin tốt nhất, nhưng chúng tôi không đảm bảo và không chịu trách nhiệm về bất kỳ nội dung nào liên quan tới tin rao này. Nếu quý vị phát hiện có sai sót hay vấn đề gì xin hãy thông báo cho chúng tôi để được khắc phục và xử lý.</div>
                                            </div>
                                            <?php $this->load->view('default/estate/real_banner2'); ?>
                </div>
                <!-- End .property_type -->
                 <?php $this->load->view('default/estate/real_related'); ?>
                    
                </div>
                
                <?php if($link_view_more!=''):?>
                <div class="text-right" style="padding: 5px;font-size:14px;background: #f5f5f5">
                    <a href="<?=site_url($link_view_more)?>" rel="nofollow">Xem thêm các tin khác tại khu vực này</a>&nbsp;&raquo;
                </div>
                <?php endif; ?>
                
            </div>
            <!-- End of column -->
            <?php $this->load->view('default/estate/sidebar'); ?>
            

        </div>
        <!-- End .row -->

    </div>
<div id="btn-contact-fixed" class="btn btn-info" style="position:fixed;bottom:0;right:40px;display:none;z-index:99999"><i class="fa fa-envelope"></i> Liên hệ người cho thuê</div>
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