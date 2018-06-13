<!DOCTYPE html>
<html lang="vi-VN">
<head>
		<?php $this->load->view('default/require/head'); ?>
        <script>
        var base_url = '<?=site_url()?>';
        </script>
        <script type="text/javascript" src="<?=base_url()?>theme/js/jquery-2.1.4.js"></script>
        <script type="text/javascript" src="<?=base_url()?>theme/js/jquery-ui.min.js"></script>
</head>
<body class="category">
    <div class="layout">
        <header>
           <?php $this->load->view('default/require/nav'); ?>
        </header>
    <?php $this->load->view('default/require/header'); ?>
    <?php $this->load->view('default/require/breadcrumb'); ?>
    
    <div class="columns">
        <?php echo $content_for_website; ?>
        
        
        <div class="btnfixedpost" style="display: none;"><a href="/dang-tin-nha-ban.htm" rel="nofollow"><img id="sm" src="/theme/images/buttonfly-miniv2.png">
        <img src="/theme/images/buttonflyv2.png" style="display: none;" id="lg"></a></div>
        <a class="go-to-top" id="go-to-top" style="display: none;" rel="nofollow"><img src="/theme/images/lendau.png"></a>
		<script type="text/javascript" src="<?=base_url()?>theme/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?=base_url()?>theme/js/jquery-ui.min.js"></script>
		<script type="text/javascript" src="<?=base_url()?>theme/js/jquery.tooltipster.min.js"></script>
        <script type="text/javascript" src="<?=base_url()?>theme/js/jquery.mobile-menu.js"></script>
        <script type="text/javascript" src="<?=base_url()?>theme/js/jquery.lazyloadxt.js"></script>
		<script type="text/javascript" src="<?=base_url()?>theme/js/jquery.validate.min.js"></script>
		<script type="text/javascript" src="<?=base_url()?>theme/js/jquery.form.min.js"></script>
        <script type="text/javascript" src="<?=base_url()?>theme/js/jquery-upload-file/js/jquery.uploadfile.min.js"></script>
        <script type="text/javascript" src="<?=base_url()?>theme/js/select2/dist/js/select2.full.min.js"></script>
		<script type="text/javascript" src="<?=base_url()?>theme/js/app.js"></script>
        <script>
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
        });
        </script>
	</div>
    </div>
		
    <script src="https://apis.google.com/js/platform.js" async defer>{lang: 'vi'}</script>
	</body>
</html>