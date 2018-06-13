
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?=base_url()?>assets/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url()?>assets/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?=base_url()?>assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <link rel="stylesheet" href="<?=base_url()?>assets/plugins/jquery-ui/jquery-ui.css">
  <link rel="stylesheet" href="<?=base_url()?>assets/plugins/jquery-upload-file/css/uploadfile.custom.css">
  <link rel="stylesheet" href="<?=base_url()?>assets/plugins/select2/select2.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_url()?>assets/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?=base_url()?>assets/plugins/sweetalert/dist/sweetalert.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?=base_url()?>assets/dist/css/skins/_all-skins.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/dist/css/custom.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <!-- jQuery 2.2.3 -->
  <script>
  var ADMIN_URL = '<?= base_url(ADMIN_FOLDER)?>/';
  </script>
<script src="<?=base_url()?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?=base_url()?>assets/bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="<?=base_url()?>assets/plugins/fastclick/fastclick.js"></script>

<script src="<?=base_url()?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="<?=base_url()?>assets/plugins/sweetalert/dist/sweetalert.min.js"></script>

<!-- Sparkline -->
<script src="<?=base_url()?>assets/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?=base_url()?>assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?=base_url()?>assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- SlimScroll 1.3.0 -->
<script src="<?=base_url()?>assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- ChartJS 1.0.1 -->
<script src="<?=base_url()?>assets/plugins/chartjs/Chart.min.js"></script>
<!--jQuery Upload File-->
<script src="<?=base_url()?>assets/plugins/jquery.form.js"></script>
<script src="<?=base_url()?>assets/plugins/jquery-upload-file/js/jquery.uploadfile.min.js"></script>
<script src="<?=base_url()?>assets/plugins/select2/select2.full.min.js"></script>
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
            url: '<?=admin_url('ajax/loadDistrict')?>',
            type: 'post',
            data: {city_id: selected},
            success: function(data) {
                district.html(data);
                //$("select.select2").select2();
            }
       });
    });
    
    //District event
    district.change(function(){
       var selected = district.find('option:selected').val();
       $.ajax({
            url: '<?=admin_url('ajax/loadWard')?>',
            type: 'post',
            data: {district_id: selected},
            success: function(data) {
                ward.html(data);
                
                $("select.select2").select2();
            }
       });
       
       $.ajax({
            url: '<?=admin_url('ajax/loadStreet')?>',
            type: 'post',
            data: {district_id: selected},
            success: function(data) {
                street.html(data);
                
               // $("select.select2").select2();
            }
       });
       
    });
    
    //Ward event
    ward.change(function(){
       var selected = ward.find('option:selected').val();
       /*$.ajax({
            url: '<?=admin_url('ajax/loadStreet')?>',
            type: 'post',
            data: {ward_id: selected},
            success: function(data) {
                street.html(data);
                
                $("select.select2").select2();
            }
       });*/
    });
    /*$( ".datepicker" ).datepicker({
        dateFormat: 'dd/mm/yy'
    });*/
    
    //Tìm kiếm nhanh
    var tableList = $('#tableList');
    var searchInput = $('#searchInput');
    searchInput.keyup(function(){
        var dataType = searchInput.attr('data-type');
        var cat_id = <?=$this->uri->segment(4) ? (int)$this->uri->segment(4) : 0?>;
        $.ajax({
           type: 'post',
           url: '<?=base_url(ADMIN_FOLDER)?>/ajax/' + dataType,
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
    
    $('select[name="create_by"]').change(function() {
        var selected = $(this).find('option:selected').val();
        $('#ajaxLoading').css('display', 'block');
        $.ajax({
           url: '<?=base_url(ADMIN_FOLDER.'/ajax/get_user')?>',
           data: {user_id: selected},
           type: 'get',
           dataType: 'json',
           success: function(res) {
                $('input[name="guest_fullname"]').val(res.first_name);
                $('input[name="guest_telephone"]').val(res.telephone);
                $('input[name="guest_mobiphone"]').val(res.mobiphone);
                $('input[name="guest_address"]').val(res.address);
                $('input[name="guest_email"]').val(res.email);
                $('#ajaxLoading').css('display', 'none');
           } 
        });
    })
});

function confirmDelete(_msg, _href) {
    swal({
      title: "Bạn có chắc muốn xóa?",
      //text: _msg,
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Xóa!",
      cancelButtonText: "Hủy",
      closeOnConfirm: false
    },
    function(){
      //swal("Deleted!", "Your imaginary file has been deleted.", "success");
      window.location.href = _href;
    });
}
</script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div id="loading">Loading...</div>
<div class="wrapper">

  <header class="main-header">

    <!-- Logo -->
    <a href="index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b>LT</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Admin</b>LTE</span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?=base_url()?>uploads/avatar/<?=$avatar?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?=$user_group . $group?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?=base_url()?>uploads/avatar/<?=$avatar?>" class="img-circle" alt="User Image">

                <p>
                  <?=$user->first_name .' '.$user->last_name?>
                  <small></small>
                </p>
              </li>
              
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?=admin_url('user/edit_user/'.$user_id)?>" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="<?=admin_url('logout')?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
         
        </ul>
      </div>

    </nav>
  </header>
  <?php $this->load->view(ADMIN_FOLDER.'/sitebar'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$heading_title?>
        <small></small>
      </h1>
      
      <?=$this->breadcrumb->output()?>
    </section>

    <!-- Main content -->
    <section class="content">
      <?php echo $content_for_website; ?>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      
    </div>
    <strong>Copyright &copy; 2016 <a href="#"></a>.</strong> All rights reserved.
  </footer>

       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>

</div>
<!-- ./wrapper -->
<!-- AdminLTE App -->
<script src="<?=base_url()?>assets/dist/js/app.js"></script>
</body>
</html>
