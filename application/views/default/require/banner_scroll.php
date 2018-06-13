<?php
$banners = $this->main_model->_Get_Banner(11);
$banner_left = '';
foreach($banners as $banner) {
    if($banner['type']=='image') {
        if($banner['image']!='' && file_exists('./uploads/banners/'.$banner['image']))
            $banner_left .= '<a href="'.$banner['link'].'"  target="_blank"  style="" rel="nofollow"><img src="'.base_url('uploads/banners/'.$banner['image']).'" alt="" width="215" class="img-responsive"></a>';
    } elseif($banner['type']=='adsense') {
        $banner_left .= $banner['adsense'];
    } elseif($banner['type']=='html5') {
        $banner_left .= '<iframe frame-border="0" width="980px" height="90px" src="'.$banner['html5'].'"></iframe>';
    }
}
if($banner_left) :
?>
<style>
@media screen and (max-width: 768px) {
    #bannerScroll{
        display:none;
    }
}
</style>
<!--Banner float-->
                    <div id="bannerScroll">
                    <?=$banner_left?>
                    </div>
                    <script>
                    /*$(document).ready(function(){
                        var bannerScroll = $('#bannerScroll');
                        var boxFeature = $('.box-list-feature');
                       $(window).on('scroll', function() {
                            if($(window).scrollTop() > $('.col-list-feature').offset().top + boxFeature.height())
                                bannerScroll.css({'position': 'fixed', 'top': '0px'});
                            else {
                                bannerScroll.removeAttr('style');
                            }
                            if($('footer').length) {
                                if($(window).scrollTop() + bannerScroll.height() >= $('footer').offset().top){
                                    bannerScroll.css({'position':'relative', 'bottom':'auto', 'top': $('.col-list-left').height()-bannerScroll.height()-boxFeature.height() + 'px'});
                                }
                            }
                            else if($('.banner-home.bottom').length) {
                                if($(window).scrollTop() + bannerScroll.height() >= $('.banner-home.bottom').offset().top){
                                    bannerScroll.css({'position':'relative', 'bottom':'auto', 'top': $('.col-list-left').height()-bannerScroll.height()-boxFeature.height() + 'px'});
                                }
                            }
                            
                       }); 
                    });*/
                    </script>
                    <!--end Banner Float-->
<?php endif ?>