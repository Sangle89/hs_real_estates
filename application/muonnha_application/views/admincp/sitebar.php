<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">Menu</li>
        <li class="active treeview">
          <a href="<?=admin_url()?>">
            <i class="fa fa-dashboard"></i> <span>Trang chủ</span>
            
          </a>
        </li>
        
		<li><a href="<?=admin_url('category')?>"><i class="fa fa-circle-o"></i> Danh mục tin</a></li>
            <li><a href="<?=admin_url('real_estate')?>"><i class="fa fa-circle-o"></i> Tin đăng</a></li>
            <li><a href="<?=admin_url('city')?>"><i class="fa fa-circle-o"></i> Tỉnh /TP</a></li>
            <li><a href="<?=admin_url('street')?>"><i class="fa fa-circle-o"></i> Đường phố</a></li>
            <li><a href="<?=admin_url('project')?>"><i class="fa fa-circle-o"></i> Dự án</a></li>
            <li><a href="<?=admin_url('footer_link')?>"><i class="fa fa-circle-o"></i> Liên kết nổi bật</a></li>
        <?php
        $content_category = $this->content_category_model->_Get_All_Category_Main();
        foreach($content_category as $category) {?>
        <li>
            <a href="<?=admin_url('content/index/'.$category['id'])?>"><i class="fa fa-th"></i> <span><?=$category['title']?></span></a>
        </li>
        <?php    
        }
        ?>
        <li>
          <a href="<?=admin_url('banner')?>">
            <i class="fa fa-th"></i> <span>Banner quảng cáo</span>
            
          </a>
        </li>
        <li>
          <a href="<?=admin_url('user')?>">
            <i class="fa fa-th"></i> <span>Thành viên</span>
            
          </a>
        </li>
        
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Cài đặt</span>
            <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?=admin_url('setting/website')?>"><i class="fa fa-circle-o"></i> Cấu hình website</a></li>
            <li><a href="<?=admin_url('setting/email')?>"><i class="fa fa-circle-o"></i> Cấu hình email</a></li>
          </ul>
        </li>
        
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>