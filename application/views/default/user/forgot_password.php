<section class="main-content">
            <div class="main-wrap-content">
            <?php if(USERTYPE == 'PC') : ?>
                <div class="pad10">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 col-lg-offset-4 col-sm-offset-4">
                        <div class="panel panel-default panel-login">
                            <div class="panel-heading">Quên mật khẩu</div>
                            <div class="panel-body">
                            <?php echo form_open("quen-mat-khau");?>
                            <div id="infoMessage"><?php echo $message;?></div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon" id="icon-user"><i class="fa fa-user"></i></span>
                                    <?php echo form_input($identity,'','placeholder="Nhập Email đăng ký" class="form-control"');?>
                                </div>
                                <div class="text-center" style="margin: 15px 0;"><?php echo form_submit('submit', 'Gửi', 'class="btn btn-primary btn-block"');?></div>
                            </div>
                            <div class="form-group">
                                    <input type="text" class="form-control captcha" name="captcha" style="display: inline-block;width:auto" placeholder="Captcha" />
                                          <div id="captcha" style="display: inline-block;"></div>
                                            <a class="refresh-captcha" onclick="$.RealApp.captchaRefresh()" style="font-size: 22px;"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                                            <label id="error_captcha" class="error"></label>
                                            <?php echo form_error('captcha', '<label class="error" style="display:block;">', '</label>')?>
                            </div>
                            <?php echo form_close();?>        
                            </div>
                        </div>
                        
                    </div>
                    
                    
                </div>
                </div>
                <?php endif ?>
                
                <?php if(USERTYPE == 'Mobile') : ?>
                <style>
                .tab-links {margin: 15px 0;display: table;width:100%}
                .tab-links a{display: table-cell;color:#222;font-weight:bold;width:50%;border:1px solid #38a345;padding:5px;text-align: center;text-transform: capitalize;}
                .tab-links a.active{background:#38a345;color:#fff}
                #loginForm .form-control{height:32px;line-height: 32px;}
                #loginForm button.btn{padding-left:20px;padding-right:20px;}
                </style>
                <h4 style="text-align: center;margin:15px 0;font-weight:normal">Khôi phục mật khẩu</h4>
                <?php echo form_open("quen-mat-khau", array('id'=>'loginForm'));?>
                            <div id="infoMessage"><?php echo $message;?></div>
                            <div class="form-group">
                                <?php echo form_input($identity,'','placeholder="Nhập Email đăng ký" class="form-control"');?>
                                <?php echo form_error('identity', '<label class="error" style="display:block;">', '</label>')?>
                            </div>
                            <div class="form-group">
                                    <input type="text" class="form-control captcha" name="captcha" style="display: inline-block;width:auto" placeholder="Captcha" />
                                          <div id="captcha" style="display: inline-block;"></div>
                                            <a class="refresh-captcha" onclick="$.RealApp.captchaRefresh()" style="font-size: 22px;"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                                            <label id="error_captcha" class="error"></label>
                                            <?php echo form_error('captcha', '<label class="error" style="display:block;">', '</label>')?>
                            </div>
                            <div class="text-center" style="margin: 15px 0;"><?php echo form_submit('submit', 'Gửi', 'class="btn btn-primary "');?></div>
                            <?php echo form_close();?>      
                <?php endif ?>
            </div>
        </section>
 <script>
 $(document).ready(function(){
 $.RealApp.captchaRefresh();
 })
 </script>