<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>

	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body {
		margin: 0 15px 0 15px;
	}

	p.footer {
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}

	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}
    #loading{
        position: fixed;
        width:100%;
        height:100%;
        top:0;
        left:0;
        background: rgba(0,0,0,.3);
        text-align: center;
    }
    #loading img {
        margin-top: 40%;
    }
	</style>
</head>
<body>
<div id="container">
    <h1>Total: <?=count($arrLinks)?></h1>
<div id="finish">
<div id="loading" style="display: none;"><img src="<?=base_url('loading.gif')?>"/></div>
</div>
<script src="<?=base_url('theme/js/jquery-2.1.4.js')?>"></script>
<script>
var URLs = <?=json_encode($arrLinks)?>;
var i = 0;
var msg;
var start = false;
function crawlHTML(i) {
    $('#loading').css({'display': 'block'});
    $.ajax({
        url: '<?=base_url('tool/import/crawler')?>',
        type: 'POST',
        dataType: 'json',
        data: {url: URLs[i], index: i},
        complete: function() {
           // console.log('Complete')      
        },
        success: function(res) {
            console.log('result -->' + i);
            console.log(res);
            msg = res.url;
            msg+= res.success===true ? ' -> OK !':' -> Not OK!';
            $('#loading').before('<p>' + msg + '</p>');
            $('#loading').css({'display': 'none'});
           
        }
    });
}
if(start === true) {
    setInterval(function() {
        crawlHTML(i);
        i++;
    }, 5000);    
}
</script>
	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>
</body>
</html>