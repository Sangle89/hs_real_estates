 <!-- Static navbar -->
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <?php if($cur_page == 'home') : ?>
            <img src="<?=base_url()?>theme/images/logo.png" alt="Logo" id="logo" class="img-responsive">
            <?php else: ?>
            <a class="navbar-brand" href="/"><img src="<?=base_url()?>theme/images/logo.png" alt="Logo" id="logo" class="img-responsive"></a>
            <?php endif; ?>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
            <?php
                            //Lấy danh sách danh mục tin
                            $real_category_main = $this->main_model->_Get_Real_Estate_Category(0);
                           foreach($real_category_main as $category) { ?>
					       
                               <li class="sub-menu-holder"><a href="<?=site_url($category['alias'].'-ho-chi-minh')?>"><?=$category['title']?></a></li>
                           
                           <?php } ?>
                           <?php
                           $content_category = $this->main_model->_Get_Content_Category();
                           foreach($content_category as $category) { 
                           $sub_category = $this->main_model->_Get_Content_Category($category['id']);
                           ?>
					       <li class="sub-menu-holder dropdown"><a href="<?=site_url($category['alias'])?>"><?=$category['title']?><span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                <?php foreach($sub_category as $sub) : ?>
					       			<li><a href="<?=site_url($sub['alias'])?>"><?=$sub['title']?></a></li>
                                <?php endforeach ?>
					       		</ul>
                           </li>
                           <?php } ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li class="btn-dangtin"><a href="/dang-tin-cho-thue-nha.htm"><i class="fa fa-plus"></i> Đăng tin rao</a></li>
              <?php
              if ($this->ion_auth->logged_in())
		      {
		          $user = $this->ion_auth->user()->row();
                  $unread_msg = $this->main_model->_Total_User_Msg_Unview($user->id);
                ?>
               <li><a class="dropdown" data-toggle="dropdown" href="<?=site_url('trang-ca-nhan')?>" rel="nofollow">Xin chào: <?=$user->email?><span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/trang-ca-nhan/uspg-thong-tin-ca-nhan.htm" rel="nofollow"><i class="fa fa-user"></i> Thông tin cá nhân</a></li>
                        <li><a href="/trang-ca-nhan/uspg-message.htm" rel="nofollow"><i class="fa fa-envelope"></i> Quản lý tin nhắn <span class="label label-danger pull-right"><?=$unread_msg?></span></a></li>
                        <li><a href="/trang-ca-nhan/uspg-quan-ly-tin-rao.htm" rel="nofollow"><i class="fa fa-list"></i> Quản lý tin rao</a></li>
                        <li><a href="/trang-ca-nhan/uspg-doi-mat-khau.htm" rel="nofollow"><i class="fa fa-lock"></i> Đổi mật khẩu</a></li>
                        <li role="separator" class="divider"></li>
                        <li> <a href="<?=site_url('dang-xuat')?>" class="login" rel="nofollow"><i class="fa fa-download fa-rotate-270"></i> Đăng xuất</a></li>
                    </ul>
               </li> 
               
	           <?php	  
		      }else{ 
                ?>
						<li><a href="/dang-ky.htm" rel="nofollow"><i class="fa fa-pencil"></i> Đăng ký</a></li>
              <li><a href="/dang-nhap.htm" rel="nofollow"><i class="fa fa-sign-in"></i> Đăng nhập</a></li>
                        <?php } ?>
              
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>