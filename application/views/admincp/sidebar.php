<ul class="nav navbar-nav">
    <li class="treeview">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Tin đăng <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
			<li><a href="<?=admin_url('category')?>"><i class="fa fa-circle-o"></i> Danh mục tin</a></li>
            <li><a href="<?=admin_url('real_estate')?>"><i class="fa fa-circle-o"></i> Tin đăng</a></li>
            <li><a href="<?=admin_url('project')?>"><i class="fa fa-circle-o"></i> Dự án</a></li>
            <li><a href="<?=admin_url('utility')?>"><i class="fa fa-circle-o"></i> Tiện ích</a></li>
            <li><a href="<?=admin_url('footer_content')?>"><i class="fa fa-circle-o"></i> Nội dung chân trang</a></li>
			<li><a href="<?=admin_url('tags')?>"><i class="fa fa-circle-o"></i> Từ khóa (Tags)</a></li>
			<li><a href="<?=admin_url('category_tags')?>"><i class="fa fa-circle-o"></i> Từ khóa danh mục</a></li>
			<li><a href="<?=admin_url('seo')?>"><i class="fa fa-circle-o"></i> Mô tả danh mục</a></li>
		  </ul>
	  </li>
      <li class="treeview">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Liên kết <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
			<li><a href="<?=admin_url('footer_link')?>"><i class="fa fa-circle-o"></i> Liên kết nổi bật</a></li>
			<li><a href="<?=admin_url('real_estate_link')?>"><i class="fa fa-circle-o"></i> Liên kết nổi bật sidebar</a></li>
            <li><a href="<?=admin_url('most_search_link')?>"><i class="fa fa-circle-o"></i> Liên kết tìm kiếm nhiều</a></li>
          </ul>
      </li>
      <li class="treeview">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Quét tin tự động <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
			<li><a href="<?=admin_url('crawlersite')?>"><i class="fa fa-circle-o"></i> Demo</a></li>
			<li><a href="<?=admin_url('crawler_tool')?>"><i class="fa fa-circle-o"></i> Phongtro123</a></li>
			<li><a href="<?=admin_url('crawler_tool/kenhnhatro')?>"><i class="fa fa-circle-o"></i> Kenhnhatro</a></li>
          </ul>
      </li>
      <li class="treeview">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Nội dung <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
			<li><a href="<?=admin_url('content_category')?>"><i class="fa fa-circle-o"></i> Danh mục</a></li>
			<li><a href="<?=admin_url('content')?>"><i class="fa fa-circle-o"></i> Tin tức</a></li>
          </ul>
      </li>
      <li class="treeview">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Khu vực <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
			<li><a href="<?=admin_url('city')?>"><i class="fa fa-circle-o"></i> Tỉnh /TP</a></li>
            <li><a href="<?=admin_url('street')?>"><i class="fa fa-circle-o"></i> Đường phố</a></li>
		  </ul>
      </li>    
         <li>
          <a href="<?=admin_url('banner')?>"><span>Quảng cáo</span>
            
          </a>
        </li>
        <li>
          <a href="<?=admin_url('page')?>"><span>Bài viết</span>
            
          </a>
        </li>
		<li>
          <a href="<?=admin_url('user')?>"><span>Thành viên</span>
            
          </a>
        </li>
        <li><a href="<?php echo admin_url('contact')?>"><span>Liên hệ</span></a></li>
        <li class="treeview">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Cài đặt <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
		  <li><a href="<?php echo admin_url('export')?>">Export tin đăng</a></li>
		  <li><a href="<?php echo admin_url('setting/deleteid')?>">Xóa tin đăng</a></li>
            <li><a href="<?php echo admin_url('setting/website')?>">Cấu hình website</a></li>
            <li><a href="<?php echo admin_url('setting/email')?>">Cấu hình email</a></li>
            <li><a href="<?php echo admin_url('setting/cleancache')?>">Xóa cache</a></li>
          </ul>
        </li>
          </ul>