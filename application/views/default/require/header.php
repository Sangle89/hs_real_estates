<nav class="nav-mobile">
            <div id="navover">
                <div class="mm-toggle-wrap">
                    <div class="mm-toggle"> <i class="fa fa-bars"></i> </div>
                    <div class="text-center mb-logo">
                    <?php if(isset($cur_page) && $cur_page=='home') : ?>
						<img src="<?=base_url()?>theme/images/mlogo.svg" height="45" alt="Logo" id="logo">
					<?php else: ?>
                    <a href="<?=site_url()?>"><img height="45" src="<?=base_url()?>theme/images/mlogo.svg" alt="Logo" id="logo"></a>
					<?php endif; ?>
                    </div>
					<?php if($this->uri->segment(1) != '') : ?>
                    <div class="mobile-search" style="position: absolute;top:12px;right:8px">
                    <?php if(isset($scroll_to_search) && $scroll_to_search == true): ?>
                        <a class="btn btn-info btn-advance-search" id="scrollToSearch" href="javascript:;" rel="nofollow" aria-expanded="false"><i class="fa fa-search"></i></a>
                    <script>
                    $(document).ready(function() {
                        $('#scrollToSearch').on('click', function() {
                           $('html,body').animate({
                                scrollTop: $('.sidebar_style_two').offset().top - 54
                           }, 800); 
                        });
                    })
                    </script>
                    <?php else : ?>
                        <a class="btn btn-info btn-advance-search" href="<?=site_url('tim-kiem-tin-rao')?>" rel="nofollow" aria-expanded="false"><i class="fa fa-search"></i></a>
                    <?php endif; ?>
                    </div>
					<?php endif ?>
                </div>
            </div>
            <div id="mobile-menu">
                <div class="mb-user" style="padding: 15px;background: rgba(1, 95, 149, 0.76);text-align: center;color: #fff;">
                    <?php
                    if ($this->ion_auth->logged_in()):
                        $user = $this->ion_auth->user()->row();
                    ?>
                    <div class="avatar"><img src="<?=base_url('uploads/avatar/'.$user->avatar)?>" alt=""></div>
                    <a href="<?=site_url('trang-ca-nhan')?>">Tài khoản</a>&nbsp;&nbsp;
                    <a href="/dang-xuat.htm">Đăng xuất</a>
                    <?php else: ?>
                    <div class="avatar"><img src="/theme/images/avatar.png" alt=""></div>
                    <a href="/dang-nhap.htm">Đăng nhập</a>&nbsp;&nbsp;
                    <a href="/dang-ky.htm">Đăng ký</a>
                    <?php endif; ?>
                </div>
                
                <ul>
                    <li><a href="<?=site_url()?>">Trang chủ</a></li>
                    <?php
                            //Lấy danh sách danh mục tin
                            $real_category_main = $this->main_model->_Get_Real_Estate_Category(0);
                           foreach($real_category_main as $category) { ?>
							<li><a href="<?=site_url($category['alias'].'-ho-chi-minh')?>"><?=$category['title']?></a></li>
                           <?php } ?>
                           <?php
                           $content_category = $this->main_model->_Get_Content_Category();
                           foreach($content_category as $category) { 
                           ?>
					       <li><a href="<?=site_url($category['alias'])?>"><?=$category['title']?></a></li>
                           <?php } ?>
                    <li><a href="/dang-tin-cho-thue-nha.htm">Đăng tin</a></li>
                   
                </ul>
            </div>
        </nav>