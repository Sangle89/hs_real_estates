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
.mobile_detail{
    padding:5px;
}
.mobile_detail .main_title{
    font-size: 18px;
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
    <!-- Gmap Helper -->
    <div class="main-wrap-content property_listing">
        <div class="product-detail-desc row">
            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 col-list-left">
            <?php if(USERTYPE == 'PC') : ?>
            <?=$this->breadcrumb->output()?>
            <?php endif ?>
                <div class="property_detail <?php if(USERTYPE == 'Mobile') echo 'mobile_detail'?>">
                    <h1 class="main_title" style="margin-top:0;"><?=format_title($real_estate['title'])?></h1>
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
                        <?php $this->load->view('default/estate/detail/real_image'); ?>
                        <?php $this->load->view('default/estate/detail/real_banner'); ?>
                        <?php $this->load->view('default/estate/detail/real_info'); ?>
                                           
                                            <div class="share" style="margin:20px 0 0">
                                                <div class="fb-share-button" data-href="<?=current_url()?>" data-layout="button_count" data-size="small" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?=current_url()?>%2F&amp;src=sdkpreparse">Chia sẻ</a></div>
                                            </div>
                                            <div class="note" style="margin-bottom: 10px;">
                                                <strong>(*)Lưu ý</strong>
                                                <div>Quý vị đang xem nội dung tin rao "
                                                    <?=$real_estate['title']?>". Mọi thông tin liên quan tới tin rao này là do người đăng tin đăng tải và chịu trách nhiệm. Chúng tôi luôn cố gắng để có chất lượng thông tin tốt nhất, nhưng chúng tôi không đảm bảo và không chịu trách nhiệm về bất kỳ nội dung nào liên quan tới tin rao này. Nếu quý vị phát hiện có sai sót hay vấn đề gì xin hãy thông báo cho chúng tôi để được khắc phục và xử lý.</div>
                                            </div>
                                            <?php $this->load->view('default/estate/detail/real_banner2'); ?>
                </div>
                <!-- End .property_type -->
                 <?php $this->load->view('default/estate/detail/real_related'); ?>
                    
                </div>
                
                <?php if($link_view_more!=''):?>
                <div class="text-right" style="padding: 5px;font-size:14px;background: #f5f5f5">
                    <a href="<?=site_url($link_view_more)?>" rel="nofollow">Xem thêm các tin khác tại khu vực này</a>&nbsp;&raquo;
                </div>
                <?php endif; ?>
                
            </div>
            <!-- End of column -->
            <?php $this->load->view('default/estate/detail/sidebar', array('url_pathname' => $url_pathname)); ?>
            

        </div>
        <!-- End .row -->

    </div>
<div id="btn-contact-fixed" class="btn btn-info hidden" style="position:fixed;bottom:0;right:40px;display:none;z-index:99999"><i class="fa fa-envelope"></i> Liên hệ người cho thuê</div>
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
</script>