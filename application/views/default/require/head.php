<meta charset="UTF-8">
<title><?=$title?></title>
<meta name="robots" content="<?php if($this->uri->segment(1) == 'tim-kiem-tin-rao') echo 'noindex, nofollow'; else echo 'index, follow'?>">
<meta name="description" content="<?=$description?>">
<meta name="keywords" content="<?=$keywords?>" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link href="/theme/images/favicon.png?v=1" rel="shortcut icon" type="image/x-icon">
        <meta name="abstract" content="Cho thuê nhà Hồ Chí Minh">
        <meta name="area" content="Cho thuê, cho mướn nhà, phòng trọ tại Hồ Chí Minh">
        <meta name="placename" content="Việt Nam">
        <meta name="author" content="Muonnha.com.vn">
        <meta name="copyright" content="&copy;2016 Muonnha.com.vn">
        <meta name="revisit-after" content="1 days" >
		<meta name="msvalidate.01" content="D6029192640B58A51BA0EFE091CE1CE7" />
        <?php if($this->uri->segment(1) == ''):?>
		<link rel="canonical" href="<?=base_url()?>" >
		<?php endif ?>
        <!-- Meta for Facebook -> Image size 1200 x 630 -->
        <meta property="og:title" content="<?=$title?>">
        <meta property="og:type" content="article">
        <meta property="og:url" content="<?=current_url()?>">
        <meta property="og:image" content="<?=isset($image) ? $image : ""?>">
        <meta property="og:description" content="<?=$description?>">
        <meta property="og:site_name" content="Cho thuê nhà Hồ Chí Minh">
        <meta property="article:tag" content="Cho thuê, cho mướn nhà, phòng trọ tại Hồ Chí Minh">
        <meta property="article:author" content="https://www.facebook.com/muonnha.com.vn">
        <meta property="article:publisher" content="https://www.facebook.com/muonnha.com.vn">
        <meta property="og:see_also" content="https://muonnha.com.vn">
        <meta property="fb:app_id" content="">
        <meta property="fb:admins" content="">
        <meta property="op:markup_url" content="<?=current_url()?>">
        
        <!-- Meta for Google -> Image size 250 x 250 -->
        <meta itemprop="name" content="<?=$title?>">
        <meta itemprop="description" content="<?=current_url()?>">
        <meta itemprop="image" content="<?=isset($image) ? $image : ""?>">
        <meta name="author" itemprop="author" content="muonnha.com.vn">
        <link rel="publisher" href="">
        <link rel="author" href="muonnha.com.vn">
        
		<!-- Favicon -->
		<link rel="icon" href="/favicon.ico">
		<!-- Custom Css -->
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,700,600,700italic,600italic" />
        <link rel="stylesheet" type="text/css" href="<?=ASSET_SERVER?>theme/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="<?=ASSET_SERVER?>theme/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="<?=ASSET_SERVER?>theme/plugins/jquery-ui/jquery-ui.css?v=3.2">
        <link rel="stylesheet" type="text/css" href="<?=ASSET_SERVER?>theme/plugins/select2/css/select2.min.css?v=3.2">
		<link rel="stylesheet" type="text/css" href="<?=ASSET_SERVER?>theme/css/style.css?v=3.3">
		<!-- Color css -->
		<link rel="stylesheet" id="jssDefault" href="<?=ASSET_SERVER?>theme/css/theme-default.css?v=3.2">
        <link rel="stylesheet" id="jssDefault" href="<?=ASSET_SERVER?>theme/css/jquery.mobile-menu.css?v=3">
		<link rel="stylesheet" type="text/css" href="<?=ASSET_SERVER?>theme/css/responsive/responsive.css?v=3.3">
        <link rel="stylesheet" type="text/css" href="<?=ASSET_SERVER?>theme/js/jquery-upload-file/css/uploadfile.css?v=3.2" />
        <link rel="stylesheet" type="text/css" href="<?=ASSET_SERVER?>theme/js/select2/dist/css/select2.min.css?v=3.2">

		<!--[if lt IE 9]>
			<script src="<?=ASSET_SERVER?>theme/js/html5shiv.js"></script>
		<![endif]-->
		 <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-65067329-9', 'auto');
      ga('send', 'pageview');
    </script>
    <script src="https://apis.google.com/js/platform.js" async defer></script>
	<script>var base_url='<?=base_url()?>';</script>
 <?php if(isset($schema)) echo $schema; ?>