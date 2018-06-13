<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">

                <div class="sidebar_style_two">
                
                    <div id="sidebar-box-fixed" style="display:none;background: #fff;z-index: 999;">
                    <?php $this->load->view('default/require/search_sidebar', $search_param); ?>
                    <div class="boxed boxed-agency">
                        <div class="box-heading-title" style="position:relative">Thông tin người cho thuê <span id="btn-close-popup" style="position:absolute;right:7px;top:4px;display:none;cursor:pointer;"><i class="fa fa-times"></i></span></div>
                        <?php
                        $userid = $real_estate['create_by'];
                        
                        if($userid > 0) {
                            $user_info = $this->ion_auth->user($userid)->row();
                            $avatar = base_url('uploads/avatar/'.$user_info->avatar);
                            $fullname = $user_info->first_name;
                            $address = $user_info->address;
                            $email = $user_info->email;
                            $mobiphone = $user_info->mobiphone;
                            $total = $this->main_model->_Count_Real_Estate_By_User(array('user_id' => $userid));
                        } else {
                            $avatar = base_url('theme/images/avatar.png');
                            $fullname = $real_estate['guest_fullname'];
                            $address = $real_estate['guest_address'];
                            $email = $real_estate['guest_email'];
                            $mobiphone = $real_estate['guest_mobiphone'];
                            $total = $this->main_model->_Count_Real_Estate_Guest($email);
                        }
                        ?>
                        <div style="display:none"><?php print_r($real_estate)?></div>
                        <div class="row">
                            <div class="col-xs-4">
                                <img src="<?=$avatar?>" alt="avatar" onerror="this.src='<?=base_url('theme/images/avatar.png')?>'" class="agency-avatar img-responsive">
                            </div>
                            <div class="col-xs-8">
                                <div class="agency-name"><a href="#"><?=$fullname?></a></div>
                                <?php if($address!=''):?><p class="agency-address"><i class="fa fa-map-marker"></i> <?=$address?></p><?php endif; ?>
                                <?php if($email!=''):?><p class="agency-address"><i class="fa fa-envelope"></i> <?=$email?></p><?php endif; ?>
                                <div class="agency-count-post">Tổng số tin rao (<?=$total?>)</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <a class="btn btn-default btn-block btn-chat-agency"><i class="fa fa-comment"></i> Gửi tin nhắn</a>
                            </div>
                            <div class="col-xs-6">
                                <a class="btn btn-primary btn-agency-call" href="tel:<?=$mobiphone?>"><i class="fa fa-phone"></i> <?=$mobiphone?></a>
                            </div>
                        </div>

                    </div>

                    <!--
                    <div class="boxed boxed-contact-agency">
                        <div class="box-heading-title">Liên hệ người cho thuê</div>
                        <?php echo form_open("", array( 'id' => 'frmContactAgency' ))?>
                            <div class="form-group">
                                <input type="text" class="form-control" name="fullname" id="txtContactFullname" placeholder="Họ tên" />
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <input type="text" name="email" id="txtContactEmail" class="form-control" placeholder="Email" />
                                    </div>
                                    <div class="col-xs-6">
                                        <input type="text" name="phone" id="txtContactPhone" class="form-control" placeholder="Số điện thoại" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" rows="3" name="msg" id="txtContactMsg" placeholder="Nội dung"></textarea>
                            </div>
                            <div class="pull-left">
                                <input type="text" name="captcha" id="txtContactCaptcha" class="form-control" placeholder="Captcha" style="width:100px;display:inline-block;float:left" />
                                <div id="captcha" style="float: left;"></div><a class="refresh-captcha" onclick="$.RealApp.captchaRefresh()" style="font-size: 22px;"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                            </div>
                            <div class="pull-right">
                                <button type="button" type="submit" id="btnContactSubmit" class="btn btn-primary">Gửi</button>
                            </div>
                            <div class="clearfix"></div>
                            <input type="hidden" name="to_user_id" value="<?=$userid?>" />
                            <input type="hidden" name="to_email" value="<?=$email?>" />
                        <?php echo form_close(); ?>
                    </div>
                    -->
                    </div>
                    <?php $this->load->view('default/require/search_sidebar', $search_param); ?>
                    <?php // $this->load->view('default/require/box_mxh'); ?>
                       
                        <!--Banner QC-->

                        <?php if(USERTYPE == "PC") : ?>
                            <?php
                        $banners = $this->main_model->_Get_Banner(5);
                        $banner_left = '';
                                    foreach($banners as $banner) {
                                        if($banner['type']=='image') {
                                            if($banner['image']!='' && file_exists('./uploads/banners/'.$banner['image']))
                                            $banner_left .= '<a href="'.$banner['link'].'"  target="_blank"  style="" rel="nofollow"><img src="'.base_url('uploads/banners/'.$banner['image']).'" alt="" width="425" height="250" class="img-responsive"></a>';
                                        } elseif($banner['type']=='adsense') {
                                            $banner_left .= $banner['adsense'];
                                        } elseif($banner['type']=='html5') {
                                            $banner_left .= '<iframe frame-border="0" width="980px" height="90px" src="'.$banner['html5'].'"></iframe>';
                                        }
                                    }
                    if($banner_left) :
                    ?>
                                <div class="banner-footer" style="margin-bottom: 15px;">
                                    <?=$banner_left?>
                                </div>
                                <?php endif; ?>
                                    <?php endif; ?>
                                        <!--End banner QC-->
                                        <div class="boxed-list">
                                            <!-- Main_title2__________ -->
                                           <div class="boxed-heading-title">
                                                <?php echo isset($title_list_category) ? $title_list_category : 'Danh mục tin đăng'?>
                                            </div>
                                            <!-- End Main_title2______ -->
                                            <ul>
                                                <?php
                            foreach($list_category as $category) {
                            ?>
                                                    <li>
                                                        <h3 style="margin: 0;"><a href="<?=site_url($category['alias'])?>"><?=$category['title']?></a> (<?=$category['total']?>)</h3></li>
                                                    <?php } ?>
                                            </ul>
                                        </div>
                                        <?php if(isset($list_link_location) && !empty($list_link_location)) : ?>
                                        <div class="boxed-list">
                                            <div class="boxed-heading-title">
                                                Liên kết nổi bật
                                            </div>
                                            <ul>
                                            <?php
                                            foreach($list_link_location as $category){?>
                                            <li><h3 style="margin: 0;"><a href="<?=($category['link'])?>"><?=$category['title']?></a></h3></li>
                                            <?php } ?>
                                            </ul>
                                        </div>
                                        <?php endif; ?>
                                         <?php $this->load->view('default/estate/category/filter_price', array('url_pathname' => $url_pathname)); ?>     
                                        <?php $this->load->view('default/estate/category/filter_area', array('url_pathname' => $url_pathname)); ?>       
                                        
                                        
                                        <!-- End .commercial_video -->
                                        <!--Banner QC-->
                                        <?php if(USERTYPE == "PC") : ?>
                                            <?php
                        $banners = $this->main_model->_Get_Banner(10);
                        $banner_left = '';
                                    foreach($banners as $banner) {
                                        if($banner['type']=='image') {
                                            if($banner['image']!='' && file_exists('./uploads/banners/'.$banner['image']))
                                            $banner_left .= '<a href="'.$banner['link'].'"  target="_blank"  style="" rel="nofollow"><img src="'.base_url('uploads/banners/'.$banner['image']).'" alt="" width="425" height="250" class="img-responsive"></a>';
                                        } elseif($banner['type']=='adsense') {

                                            $banner_left .= $banner['adsense'];

                                        } elseif($banner['type']=='html5') {

                                            $banner_left .= '<iframe frame-border="0" width="980px" height="90px" src="'.$banner['html5'].'"></iframe>';

                                        }

                                    }

                    if($banner_left) :

                    ?>

                                                <div class="banner-footer" style="margin-bottom: 15px;">
                                                    <?=$banner_left?>
                                                </div>

                                                <?php endif; ?>

                                                    <?php endif; ?>
                </div>
                <!-- End .sidebar_style_two -->
                
                <?php $this->load->view('default/require/top3_content'); ?>
            </div>
            <!-- End of column -->