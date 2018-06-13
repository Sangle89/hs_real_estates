<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

		<title>Admin Control Panel</title>
		<meta name="description" content="">
		<meta name="author" content="">
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		
		<!-- #CSS Links -->
		<!-- Basic Styles -->
		<link rel="stylesheet" type="text/css" media="screen" href="<?=base_url()?>public/<?=ADMIN_FOLDER?>/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="<?=base_url()?>public/<?=ADMIN_FOLDER?>/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>public/<?=ADMIN_FOLDER?>/fine-uploader/fine-uploader-new.css" />
		<!-- Smart<?=ADMIN_FOLDER?> Styles : Caution! DO NOT change the order -->
		<!--<link rel="stylesheet" type="text/css" media="screen" href="<?=base_url()?>public/<?=ADMIN_FOLDER?>/css/smart<?=ADMIN_FOLDER?>-production-plugins.min.css">-->
		<link rel="stylesheet" type="text/css" media="screen" href="<?=base_url()?>public/<?=ADMIN_FOLDER?>/css/smartadmin-production.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="<?=base_url()?>public/<?=ADMIN_FOLDER?>/css/smartadmin-skins.min.css">

		<link rel="stylesheet" type="text/css" media="screen" href="<?=base_url()?>public/plugins/jquery-window/css/jquery.window.css"> 
		<!-- Smart<?=ADMIN_FOLDER?> RTL Support -->
		<link rel="stylesheet" type="text/css" media="screen" href="<?=base_url()?>public/<?=ADMIN_FOLDER?>/css/smartadmin-rtl.min.css"> 
        
        <link rel="stylesheet" type="text/css" media="screen" href="<?=base_url()?>public/plugins/bootstrap-img-upload/css/bootstrap-imgupload.min.css">
        
        <link rel="stylesheet" type="text/css" media="screen" href="<?=base_url()?>public/<?=ADMIN_FOLDER?>/css/jquery.timepicker.css"> 
        
		<!-- Demo purpose only: goes with demo.js, you can delete this css when designing your own WebApp -->
		<link rel="stylesheet" type="text/css" media="screen" href="<?=base_url()?>public/<?=ADMIN_FOLDER?>/css/demo.min.css">

		<!-- #FAVICONS -->
		<link rel="shortcut icon" href="img/favicon/favicon.ico" type="image/x-icon">
		<link rel="icon" href="img/favicon/favicon.ico" type="image/x-icon">

		<!-- #GOOGLE FONT -->
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">

		<!-- #APP SCREEN / ICONS -->
		<!-- Specifying a Webpage Icon for Web Clip 
			 Ref: https://developer.apple.com/library/ios/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html -->
		<link rel="apple-touch-icon" href="<?=base_url()?>public/<?=ADMIN_FOLDER?>/img/splash/sptouch-icon-iphone.png">
		<link rel="apple-touch-icon" sizes="76x76" href="<?=base_url()?>public/<?=ADMIN_FOLDER?>/img/splash/touch-icon-ipad.png">
		<link rel="apple-touch-icon" sizes="120x120" href="<?=base_url()?>public/<?=ADMIN_FOLDER?>/img/splash/touch-icon-iphone-retina.png">
		<link rel="apple-touch-icon" sizes="152x152" href="<?=base_url()?>public/<?=ADMIN_FOLDER?>/img/splash/touch-icon-ipad-retina.png">
		
		<!-- iOS web-app metas : hides Safari UI Components and Changes Status Bar Appearance -->
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		
		<!-- Startup image for web apps -->
		<link rel="apple-touch-startup-image" href="<?=base_url()?>public/<?=ADMIN_FOLDER?>/img/splash/ipad-landscape.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
		<link rel="apple-touch-startup-image" href="<?=base_url()?>public/<?=ADMIN_FOLDER?>/img/splash/ipad-portrait.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
		<link rel="apple-touch-startup-image" href="<?=base_url()?>public/<?=ADMIN_FOLDER?>/img/splash/iphone.png" media="screen and (max-device-width: 320px)">
        
        <!-- Generic page styles -->
<link rel="stylesheet" href="<?=base_url()?>public/plugins/fileupload/style.css">
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="<?=base_url()?>public/plugins/fileupload/jquery.fileupload.css">
<link rel="stylesheet" href="<?=base_url()?>public/plugins/fileupload/jquery.fileupload-ui.css">
<!-- CSS adjustments for browsers with JavaScript disabled -->
<noscript><link rel="stylesheet" href="<?=base_url()?>public/plugins/fileupload/jquery.fileupload-noscript.css"></noscript>
<noscript><link rel="stylesheet" href="<?=base_url()?>public/plugins/fileupload/jquery.fileupload-ui-noscript.css"></noscript>
<!-- The file upload form used as target for the file upload widget -->
<style>
#tinyscrollbar1{
    min-height: 100%;
}
        input[type="text"],input[type="textarea"],input[type="email"],input[type="password"] {
            
        }
        .fileinput-button {
            padding: 5px 10px;
        }
        .btn-trash {
            padding-left: 10px!important;
            padding-right: 10px!important; 
        }
        .error{color:red;}
        .alert p.error{color:#ffffff;}
        #bgPopup{
        position: absolute;
        width:100%;
        height:100%;
        background: #000;
        opacity:.7;
        display: none;
        z-index: 1;
    }
    .jarviswidget-color-blueDark .nav-tabs li:not(.active) a{
        color:#333!important;
    }
    .nav-tabs.bordered+.tab-content{
        margin-bottom: 15px;
    }
</style>
<script>
var base_url = "<?=base_url()?>";
</script>      
<script src="<?=base_url()?>public/<?=ADMIN_FOLDER?>/js/jquery.min.js"></script>
<script src="<?=base_url()?>public/<?=ADMIN_FOLDER?>/js/jquery-ui.min.js"></script>
<script src="<?=base_url()?>public/<?=ADMIN_FOLDER?>/js/admin_function.js"></script>
<?php $this->load->view(ADMIN_FOLDER . '/require/script'); 
        
        ?>