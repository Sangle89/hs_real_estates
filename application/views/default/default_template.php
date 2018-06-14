<!doctype html public "-//W3C//DTD HTML 4.0 Transitional//EN">
<html lang="vi-VN">
<head>
		<?php $this->load->view('default/require/head'); ?>
        <script>
        var base_url = '<?=site_url()?>';
        </script>
        <script type="text/javascript" src="<?=base_url()?>theme/js/jquery-2.1.4.js"></script>
        <script type="text/javascript" src="<?=base_url()?>theme/js/jquery-ui.min.js"></script>
</head>
<body class="<?=$cur_page?>">
<?php if($this->uri->segment(1)==''):?>
<h1 style="display: none;">Trang thông tin cho thuê mướn nhà trọ, phòng trọ, căn hộ chung cư, tìm người ở ghép tại Tp.HCM</h1>
<?php endif; ?>
		<header>
           <?php $this->load->view('default/require/nav'); ?>
        </header>
    <div class="boxed_wrapper">
        <?php $this->load->view('default/require/header'); ?>
        <?php echo $content_for_website; ?>
        <?php $this->load->view('default/require/footer'); ?>
        
        <div class="btnfixedpost hidden-xs" style="display: none;"><a href="/dang-tin-cho-thue-nha.htm" rel="nofollow"><img id="sm" src="/theme/images/buttonfly-miniv2.png">
        <img src="/theme/images/buttonflyv2.png" style="display: none;" id="lg"></a></div>
        <a class="go-to-top" id="go-to-top" style="display: none;" rel="nofollow"><img src="/theme/images/lendau.png"></a>
		<script type="text/javascript" src="<?=ASSET_SERVER?>theme/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?=ASSET_SERVER?>theme/js/jquery-ui.min.js"></script>
        <script type="text/javascript" src="<?=ASSET_SERVER?>theme/js/jquery.mobile-menu.js"></script>
		<script type="text/javascript" src="<?=ASSET_SERVER?>theme/js/jquery.validate.min.js"></script>
		<script type="text/javascript" src="<?=ASSET_SERVER?>theme/js/jquery.form.min.js"></script>
        <script type="text/javascript" src="<?=ASSET_SERVER?>theme/js/jquery-upload-file/js/jquery.uploadfile.min.js"></script>
        <script type="text/javascript" src="<?=ASSET_SERVER?>theme/js/select2/dist/js/select2.full.min.js"></script>
		<script type="text/javascript" src="<?=ASSET_SERVER?>theme/js/app.js?v=3.0"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.2/jquery.matchHeight-min.js"></script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.7/jquery.lazy.min.js"></script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.7/jquery.lazy.plugins.min.js"></script>
        <script>
		$(function() {
	$('.matchheight').matchHeight();
});
        $(document).ready(function() {
            $("#mobile-menu").mobileMenu({
            	MenuWidth: 220,
            	SlideSpeed : 300,
            	WindowsMaxWidth : 992,
            	PagePush : true,
            	FromLeft : true,
            	Overlay : true,
            	CollapseMenu : true,
            	ClassName : "mobile-menu"
             });
            var cwidth = 1010;
            var wbanner = 130;
            var wwidth = $(window).width();
            $('.banner_left').css('left', ((wwidth - cwidth) / 2) - wbanner + 'px');
            $('.banner_right').css('right', ((wwidth - cwidth) / 2) - wbanner + 'px');
            $('.btnfixedpost').on('mouseover',function(){
               $('#sm').hide();
               $('#lg').show(); 
            }).on('mouseout', function(){
                $('#sm').show();
               $('#lg').hide(); 
            });
			$("img.lazy").Lazy();
        });
        </script>
	</div>
    <script src="https://apis.google.com/js/platform.js" async defer>{lang: 'vi'}</script>
    <script src="https://sp.zalo.me/plugins/sdk.js"></script>
<div id="fb-root"></div>
<script>
	(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.9&appId=600372793366266";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
</script>
<script type="text/javascript" src="https://apis.google.com/js/plusone.js">
	{lang: 'vi'}
</script>
	</body>
</html>