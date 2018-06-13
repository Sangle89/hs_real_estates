
<script type="text/javascript">
                $(document).ready(function(){
                    $('.btn-advance-search').click(function(){
                        $('#advanceSearchCollapse').toggleClass('in');
                        if($('#advanceSearchCollapse').hasClass('in')) {
                            $('#advanceSearchCollapse').removeClass('in');
                        } else {
                            $('#advanceSearchCollapse').addClass('in');
                        }
                        
                        return false;
                    });
                })
                </script>
        <nav class="nav-mobile">
            <div id="navover">
                <div class="mm-toggle-wrap">
                    <div class="mm-toggle"> <i class="fa fa-bars"></i> </div>
                    <div class="text-center mb-logo">
                    <?php if(isset($cur_page) && $cur_page=='home') : ?>
						<img src="<?=base_url()?>theme/images/mlogo.png" height="40" alt="Logo" id="logo">
					<?php else: ?>
                    <a href="<?=site_url()?>"><img height="40" src="<?=base_url()?>theme/images/mlogo.png" alt="Logo" id="logo"></a>
					<?php endif; ?>
                    </div>
                    <div class="mobile-search" style="position: absolute;top:8px;right:8px">
                        <a class="btn btn-info btn-advance-search" role="button" data-toggle="" href="#advanceSearchCollapse" aria-expanded="false" aria-controls="advanceSearchCollapse"><i class="fa fa-search"></i></a>
                    </div>
                </div>
            </div>
            <div id="mobile-menu">
                <div class="mb-user" style="padding: 15px;background: rgba(1, 95, 149, 0.76);text-align: center;color: #fff;">
                    <?php
                    if ($this->ion_auth->logged_in()):
                        $user = $this->ion_auth->user()->row();
                    ?>
                    <div class="avatar"><img src="<?=base_url('uploads/avatar/'.$user->avatar)?>" alt=""></div>
                    <a href="<?=site_url('trang-ca-nhan')?>">Tài khoản</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                    <a href="/dang-xuat.htm">Đăng xuất</a>
                    <?php else: ?>
                    <div class="avatar"><img src="/theme/images/avatar.png" alt=""></div>
                    <a href="/dang-nhap.htm">Đăng nhập</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                    <a href="/dang-ky.htm">Đăng ký</a>
                    <?php endif; ?>
                </div>
                
                <ul>
                    <li><a href="/">Trang chủ</a></li>
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