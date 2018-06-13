<?php $this->load->view('default/require/breadcrumb'); ?>
        <section class="main-wrap-content property_listing">
            <div class="container">
                <div class="row">
                    
                    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                        <div class="main_title2"><label class="title_sidebar"><?=$content['title']?></label></div>
                        <div class="page-content">
                            <?=$content['content']?>
                        </div>
                        
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="main_title2"><label class="title_sidebar">Hướng dẫn</label></div>
                        <div class="" style="padding: 15px;background:#fff;border:1px solid #e7e7e7"><ul class="list-group">
                                <?php
                        $page_huongdan = $this->main_model->_Get_Page_By_Id(11);
                        ?>
                                <li><i class="fa fa-angle-right"></i>&nbsp;<a href="<?=site_url($page_huongdan['alias'])?>"><?=$page_huongdan['title']?></a></li>
                               <?php
                        if ($this->ion_auth->logged_in())
		{
		  $user = $this->ion_auth->user()->row();?>
            <li><i class="fa fa-angle-right"></i>&nbsp;<a href="<?=site_url('quan-ly-tin-dang')?>">Quản lý tin đăng</a></li>
            <li><i class="fa fa-angle-right"></i>&nbsp;<a href="<?=site_url('thong-bao-tu-ban-quan-tri')?>">Thông báo từ ban quản trị</a></li>
            <li><i class="fa fa-angle-right"></i>&nbsp;<a href="<?=site_url('dang-xuat')?>">Đăng xuất</a></li>
            <?php } ?>
                            </ul></div>
                    </div>
                    
                </div>
            </div>
        </section>
         <script>
                                            $(document).ready(function(){
                                                $.RealApp.captchaRefresh();
                                                $.RealApp.uploadPhoto();
                                                $.RealApp.postValidate();
                                            })
                                            
                                            </script>