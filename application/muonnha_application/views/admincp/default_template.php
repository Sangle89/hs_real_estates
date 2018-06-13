
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="<?php echo md5(time())?>">
  <title><?php echo $title?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/jquery-ui/jquery-ui.css">
  <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/jquery-upload-file/css/uploadfile.custom.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/dist/css/AdminLTE.css">
  <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/sweetalert/dist/sweetalert.css">
  <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/select2/select2.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/dist/css/skins/_all-skins.min.css">
<link rel="stylesheet" href="<?php echo base_url()?>assets/dist/css/custom.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <!-- jQuery 2.2.3 -->
<script>
var BASE_URL = '<?php echo base_url()?>';
var ADMIN_FOLDER = '<?php echo ADMIN_FOLDER?>';
var ADMIN_URL = '<?php echo base_url(ADMIN_FOLDER)?>';
var IMG_LOADING = 'loading.gif';
</script>
<script src="<?php echo base_url()?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url()?>assets/bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url()?>assets/plugins/fastclick/fastclick.js"></script>

<script src="<?php echo base_url()?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/sweetalert/dist/sweetalert.min.js"></script>

<!-- Sparkline -->
<script src="<?php echo base_url()?>assets/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?php echo base_url()?>assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- SlimScroll 1.3.0 -->
<script src="<?php echo base_url()?>assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- ChartJS 1.0.1 -->
<script src="<?php echo base_url()?>assets/plugins/chartjs/Chart.min.js"></script>
<!--jQuery Upload File-->
<script src="<?php echo base_url()?>assets/plugins/jquery.form.js"></script>
<script src="<?php echo base_url()?>assets/plugins/jquery-upload-file/js/jquery.uploadfile.min.js"></script>

<script src="<?php echo base_url()?>assets/plugins/select2/select2.full.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/select2/select2.full.min.js"></script>
<script>
$(function () {
    'use strict';
    var city = $('select[name="city_id"]');
    var district = $('select[name="district_id"]');
    var ward = $('select[name="ward_id"]');
    var street = $('select[name="street_id"]');
    
    //City event
    city.change(function(){
       var selected = city.find('option:selected').val();
       $.ajax({
            url: '<?php echo admin_url('ajax/loadDistrict')?>',
            type: 'post',
            data: {city_id: selected},
            success: function(data) {
                district.html(data);
                //$("select.select2").select2();
            }
       });
       
       $.ajax({
            url: '<?php echo admin_url('ajax/loadStreet')?>',
            type: 'post',
            data: {city_id: selected},
            success: function(data) {
                street.html(data);
                
               // $("select.select2").select2();
            }
       });
       
    });
    
    //District event
    district.change(function(){
       var selected = district.find('option:selected').val();
       $.ajax({
            url: '<?php echo admin_url('ajax/loadWard')?>',
            type: 'post',
            data: {district_id: selected},
            success: function(data) {
                ward.html(data);
                
                $("select.select2").select2();
            }
       });
	   //Load street
	   $.ajax({
            url: '<?php echo admin_url('ajax/loadStreet')?>',
            type: 'post',
            data: {district_id: selected},
            success: function(data) {
                street.html(data);
                
                $("select.select2").select2();
            }
       });
    });
    
    //Tìm kiếm nhanh
    var tableList = $('#tableList');
    var searchInput = $('#searchInput');
    searchInput.keyup(function(){
        var dataType = searchInput.attr('data-type');
        var cat_id = <?php echo $this->uri->segment(4) ? (int)$this->uri->segment(4) : 0?>;
        $.ajax({
           type: 'post',
           url: '<?php echo base_url().ADMIN_FOLDER?>/ajax/' + dataType,
           data: {q: $(this).val(), cat_id: cat_id},
           beforeSend: function() {
                $('#loading').css('display', 'block');
           },
           success: function(html) {
               tableList.find('tbody').html(html); 
               $('#loading').css('display', 'none');
           } 
        });
    });
    
    $('button[name="delete_checked"]').on('click',function(e){
        e.preventDefault();
        var form = $('#formList');
        var conf = confirm('Bạn có chắc chắn muốn xóa ?');
        if(conf == true) {
            $('input[name="delete_checked"]').val(1);
            form.submit();
            return true;
        } else {
            return false;
        }
        /*var form = $('#formList');
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this imaginary file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        }, function(isConfirm){
            if (isConfirm) form.submit();
        });*/
    });

    
});

function confirmDelete() {
    var conf = confirm('Bạn có chắc chắn muốn xóa ?');
    if(conf == true)
        return true;
    else
        return false;
}

function check_all(source){
checkboxes = document.getElementsByName('results[]');
		for(var i in checkboxes)
			checkboxes[i].checked = source.checked;
}
function JS_bodau_tv(cataname_id, seo_name, id)
{
    var str = $(cataname_id).val();
    str = str.toLowerCase();
    str = str.trim();
    str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g,"a");
    str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g,"e");
    str = str.replace(/ì|í|ị|ỉ|ĩ/g,"i");
    str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g,"o");
    str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g,"u");
    str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g,"y");
    str = str.replace(/đ/g,"d");
    str = str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'| |\"|\&|\#|\[|\]|~|$|_/g,"-");
    str = str.replace(/-+-/g,"-");
    str = str.replace(/^\-+|\-+$/g,"");
    if(id == "" || id == 0) $(seo_name).val(str);
}
</script>
</head>
<body class="hold-transition skin-blue layout-top-nav">
<div id="loading">Loading...</div>
<div class="wrapper">

  <header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
          <?php $this->load->view(ADMIN_FOLDER . '/sidebar'); ?>
          
        </div>
        <!-- /.navbar-collapse -->
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- Messages: style can be found in dropdown.less-->
            <li class="messages-menu">
              <!-- Menu toggle button -->
              <a href="<?=site_url()?>" class="" target="_blank">
                <i class="fa fa-eye"></i> Xem website
              </a>
              
            </li>
            <!-- /.messages-menu -->

            <!-- User Account Menu -->
            <li class="dropdown user user-menu">
              <!-- Menu Toggle Button -->
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="<?php echo base_url()?>uploads/avatar/<?php echo $avatar?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo  $group?></span>
              </a>
              <ul class="dropdown-menu">
                <!-- The user image in the menu -->
                <li class="user-header">
                  <img src="<?php echo base_url()?>uploads/avatar/<?php echo $avatar?>" class="user-image" alt="User Image">

                  <p>
                    <?php echo $user->full_name?>
                    <small></small>
                  </p>
                </li>
                
                <!-- Menu Footer-->
                <li class="user-footer">
                  <div class="pull-left">
                    <a href="<?php echo admin_url('user/edit_user/'.$user_id)?>" class="btn btn-default btn-flat">Thông tin</a>
                  </div>
                  <div class="pull-right">
                    <a href="<?php echo admin_url('logout')?>" class="btn btn-default btn-flat">Thoát</a>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </div>
        <!-- /.navbar-custom-menu -->
      </div>
      <!-- /.container-fluid -->
    </nav>
  </header>
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="container-fluid">
        <!-- Content Header (Page header) -->
    

    <!-- Main content -->
    <section class="content">
      <?php echo $content_for_website; ?>
    </section>
    <!-- /.content -->
    </div>
    
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      
    </div>
    <strong>Copyright &copy; 2016 Phát triển bởi <a href="mailto:slevan89@gmail.com">SangIT</a> | Email: <a href="mailto:slevan89@gmail.com">slevan89@gmail.com</a> | Tel: 0906.493.124 | Skype: levansang_bp_1989</strong>
  </footer>

       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>

</div>
<!-- ./wrapper -->
<!-- AdminLTE App -->
<script src="<?php echo base_url()?>assets/dist/js/app.js"></script>
</body>
</html>
