<?php if(USERTYPE == 'PC') : ?>
<section class="main-content">
            <div class="main-wrap-content">
            <div class="pad10">
            <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 col-lg-offset-4 col-sm-offset-4">
                        <div class="panel panel-default panel-login">
                            <div class="panel-heading">Đăng ký thành viên</div>
                            <div class="panel-body">
                            <form method="post" action="" id="formRegister" enctype="multipart/form-data">
                                <p>Mời Quý vị đăng ký thành viên để được hưởng nhiều lợi ích và hỗ trợ từ chúng tôi!</p>
                                <div class="form-group">
                                    <input type="text" name="first_name" value="" class="form-control" placeholder="Họ tên" />
                                    <?php echo form_error('first_name', '<label class="error" style="display:block;">', '</label>')?>
                                    <label id="error_fullname" class="error"></label>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="email" value="<?=set_value('email')?>" placeholder="Email" />
                                    <label id="error_email" class="error"></label>
                                    <?php echo form_error('email', '<label class="error" style="display:block;">', '</label>')?>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6 col-xs-6">
                                            <input type="password" class="form-control" name="password" id="password" placeholder="Mật khẩu" />
                                        <label id="error_password" class="error"></label>
                                        <?php echo form_error('password', '<label class="error" style="display:block;">', '</label>')?>
                                        </div>
                                        <div class="col-md-6 col-xs-6">
                                            <input type="password" class="form-control" name="repassword" placeholder="Nhập lại mật khẩu" />
                                        <label id="error_repassword" class="error"></label>
                                        <?php echo form_error('repassword', '<label class="error" style="display:block;">', '</label>')?>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <input type="text" class="form-control" name="mobiphone" value="<?=set_value('mobiphone')?>" placeholder="Số di động" />
                                        <label id="error_mobiphone" class="error"></label>
                                        <?php echo form_error('mobiphone', '<label class="error" style="display:block;">', '</label>')?>
                                </div>
                                <div class="form-group">
                                    <label for="gender_nam"><input type="radio" id="gender_nam" name="gender" value="1" checked="checked" /> Nam</label>&nbsp;&nbsp;&nbsp;
                                    <label for="gender_nu"><input type="radio" id="gender_nu" name="gender" value="0" /> Nữ</label>
                                </div>
                                <div class="form-group">
                                    <div class="row" >
                                        <div class="col-xs-6">
                                            <select class="select2" name="city" id="listCity2">
                                                <option value="-1">Tỉnh/thành phố</option>
                                                <?php
                                                $all_city = $this->main_model->_Get_City();
                                                foreach($all_city as $val) { 
                                                ?>
                								<option value="<?=$val['id']?>"><?=$val['title']?></option>
                                                <?php } ?>
                                            </select><label id="error_city" class="error"></label>
                                        </div>
                                        <div class="col-xs-6">
                                            <select class="select2" name="district" id="listDistrict2">
                                                <option value="-1">Quận/Huyện</option>
                                                
                                            </select>
                                            
                                            <label id="error_district" class="error"></label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="type_personal"><input type="radio" id="type_personal" name="account_type" value="1" checked="checked" /> Cá nhân</label>&nbsp;&nbsp;&nbsp;
                                    <label for="type_company"><input type="radio" id="type_company" name="account_type" value="0" /> Doanh nghiệp</label>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control captcha" name="captcha" style="display: inline-block;width:auto" placeholder="Captcha" />
                                          <div id="captcha" style="display: inline-block;"></div>
                                            <a class="refresh-captcha" onclick="$.RealApp.captchaRefresh()" style="font-size: 22px;"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                                            <label id="error_captcha" class="error"></label>
                                            <?php echo form_error('captcha', '<label class="error" style="display:block;">', '</label>')?>
                                </div>
                                <div class="form-group">
                                    
                                </div>
                                <p class="note1">(Mã an toàn có phân biệt chữ hoa, chữ thường. Trong trường hợp hiện ra thông báo "Mã an toàn bạn nhập vào chưa đúng" bạn vui lòng nhấn vào nút <i class="fa fa-refresh" aria-hidden="true"></i> để tạo mã an toàn mới và thử lại)</p>
                                        <p class="note2">
                                        <strong>Chúng tôi sẽ gửi đến hộp thư của bạn 1 email xác nhận đăng ký thành viên sau khi đăng ký thành viên hoàn tất.</strong> <br />
                                        </p>
                                        <p>Chú ý: bạn không thể thay đổi những thông tin: email, số điện thoại di động sau khi đăng ký</p>
                                <p class="note3">
                                        Nếu gặp bất kỳ khó khăn gì trong việc đăng ký, đăng nhập, đăng tin hay trong việc sử dụng website nói chung, Quý vị hãy liên hệ ngay với chúng tôi theo email: <strong><a href="mailto:muonnha.com.vn@gmail.com" rel="nofollow">muonnha.com.vn@gmail.com</a></strong> để được trợ giúp
                                </p>
                                <div style="text-align: center;margin: 15px 0;"><input type="submit" value="Đăng ký" class="btn btn-primary btn-block"></div>
                            </form>
                            </div>
                            <div class="panel-footer">
                                <p class="text-center" style="margin:15px 0;">Đã là thành viên? <a href="<?=site_url('dang-nhap')?>" style="text-decoration: underline;" rel="nofollow">Đăng nhập</a></p>
                            </div>
                        </div>
                        
                    </div>
                    
                </div>
            </div>
                
            </div>
        </section>
<?php endif ?>
<?php if(USERTYPE == 'Mobile') : ?>
<style>
                .tab-links {margin: 15px 0;display: table;width:100%}
                .tab-links a{display: table-cell;color:#222;font-weight:bold;width:50%;border:1px solid #38a345;padding:5px;text-align: center;text-transform: capitalize;}
                .tab-links a.active{background:#38a345;color:#fff}
                #loginForm .form-control{height:32px;line-height: 32px;}
                #loginForm button.btn{padding-left:20px;padding-right:20px;}
                </style>
                
<section class="main-content">
    <div class="container">
    <div class="tab-links">
                    <a href="<?=base_url('dang-nhap')?>" rel="nofollow">đăng nhập</a>
                    <a class="active" rel="nofollow" href="<?=base_url('dang-ky')?>">đăng ký</a>
                </div>
        <form method="post" action="" id="formRegister" enctype="multipart/form-data">
                                <p>Mời Quý vị đăng ký thành viên để được hưởng nhiều lợi ích và hỗ trợ từ chúng tôi!</p>
                                <div class="form-group">
                                    <input type="text" name="first_name" value="" class="form-control" placeholder="Họ tên" />
                                    <?php echo form_error('first_name', '<label class="error" style="display:block;">', '</label>')?>
                                    <label id="error_fullname" class="error"></label>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="email" value="<?=set_value('email')?>" placeholder="Email" />
                                    <label id="error_email" class="error"></label>
                                    <?php echo form_error('email', '<label class="error" style="display:block;">', '</label>')?>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6 col-xs-6">
                                            <input type="password" class="form-control" name="password" id="password" placeholder="Mật khẩu" />
                                        <label id="error_password" class="error"></label>
                                        <?php echo form_error('password', '<label class="error" style="display:block;">', '</label>')?>
                                        </div>
                                        <div class="col-md-6 col-xs-6">
                                            <input type="password" class="form-control" name="repassword" placeholder="Nhập lại mật khẩu" />
                                        <label id="error_repassword" class="error"></label>
                                        <?php echo form_error('repassword', '<label class="error" style="display:block;">', '</label>')?>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <input type="text" class="form-control" name="mobiphone" value="<?=set_value('mobiphone')?>" placeholder="Số di động" />
                                        <label id="error_mobiphone" class="error"></label>
                                        <?php echo form_error('mobiphone', '<label class="error" style="display:block;">', '</label>')?>
                                </div>
                                <div class="form-group">
                                    <label for="gender_nam"><input type="radio" id="gender_nam" name="gender" value="1" checked="checked" /> Nam</label>&nbsp;&nbsp;&nbsp;
                                    <label for="gender_nu"><input type="radio" id="gender_nu" name="gender" value="0" /> Nữ</label>
                                </div>
                                <div class="form-group">
                                    <div class="row" >
                                        <div class="col-xs-6">
                                            <select class="select2" name="city" id="listCity2">
                                                <option value="-1">Tỉnh/thành phố</option>
                                                <?php
                                                $all_city = $this->main_model->_Get_City();
                                                foreach($all_city as $val) { 
                                                ?>
                								<option value="<?=$val['id']?>"><?=$val['title']?></option>
                                                <?php } ?>
                                            </select><label id="error_city" class="error"></label>
                                        </div>
                                        <div class="col-xs-6">
                                            <select class="select2" name="district" id="listDistrict2">
                                                <option value="-1">Quận/Huyện</option>
                                                
                                            </select>
                                            
                                            <label id="error_district" class="error"></label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="type_personal"><input type="radio" id="type_personal" name="account_type" value="1" checked="checked" /> Cá nhân</label>&nbsp;&nbsp;&nbsp;
                                    <label for="type_company"><input type="radio" id="type_company" name="account_type" value="0" /> Doanh nghiệp</label>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control captcha" name="captcha" style="display: inline-block;width:auto" placeholder="Captcha" />
                                          <div id="captcha" style="display: inline-block;"></div>
                                            <a class="refresh-captcha" onclick="$.RealApp.captchaRefresh()" style="font-size: 22px;"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                                            <label id="error_captcha" class="error"></label>
                                            <?php echo form_error('captcha', '<label class="error" style="display:block;">', '</label>')?>
                                </div>
                                <div class="form-group">
                                    
                                </div>
                                <p class="note1">(Mã an toàn có phân biệt chữ hoa, chữ thường. Trong trường hợp hiện ra thông báo "Mã an toàn bạn nhập vào chưa đúng" bạn vui lòng nhấn vào nút <i class="fa fa-refresh" aria-hidden="true"></i> để tạo mã an toàn mới và thử lại)</p>
                                        <p class="note2">
                                        <strong>Chúng tôi sẽ gửi đến hộp thư của bạn 1 email xác nhận đăng ký thành viên sau khi đăng ký thành viên hoàn tất.</strong> <br />
                                        </p>
                                        <p>Chú ý: bạn không thể thay đổi những thông tin: email, số điện thoại di động sau khi đăng ký</p>
                                <p class="note3">
                                        Nếu gặp bất kỳ khó khăn gì trong việc đăng ký, đăng nhập, đăng tin hay trong việc sử dụng website nói chung, Quý vị hãy liên hệ ngay với chúng tôi theo email: <strong><a href="mailto:muonnha.com.vn@gmail.com" rel="nofollow">muonnha.com.vn@gmail.com</a></strong> để được trợ giúp
                                </p>
                                <div style="text-align: center;margin: 15px 0;"><input type="submit" value="Đăng ký" class="btn btn-primary"></div>
                            </form>
    </div>
</section>
<?php endif ?>
        <script>
                                            $(document).ready(function(){
                                                $.RealApp.captchaRefresh();
                                                $.RealApp.uploadAvatar();
                                                $.RealApp.registerValidate();
                                            })
                                            
                                            </script>