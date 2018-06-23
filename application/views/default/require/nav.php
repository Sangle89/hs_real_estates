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
            <img src="<?=ASSET_SERVER?>theme/images/logo.png" alt="Logo" id="logo" class="img-responsive">
            <?php else: ?>
            <a class="navbar-brand" href="<?=site_url()?>"><img src="<?=ASSET_SERVER?>theme/images/logo.png" alt="Logo" id="logo" class="img-responsive"></a>
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
            <ul class="nav navbar-nav navbar-right nav-user">
              
              <li>
                 <?php
                if ($this->ion_auth->logged_in()):
		          $user = $this->ion_auth->user()->row();
                  $unread_msg = $this->main_model->_Total_User_Msg_Unview($user->id);
                ?>
                <a class="dropdown" data-toggle="dropdown" href="#" rel="nofollow"><i class="fa fa-user"></i>&nbsp;Tài khoản: <?=$user->first_name?><span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?=base_url()?>/trang-ca-nhan/uspg-thong-tin-ca-nhan.htm" rel="nofollow"><i class="fa fa-user"></i> Thông tin cá nhân</a></li>
                        <li><a href="<?=base_url()?>/trang-ca-nhan/uspg-message.htm" rel="nofollow"><i class="fa fa-envelope"></i> Quản lý tin nhắn <span class="label label-danger pull-right"><?=$unread_msg?></span></a></li>
                        <li><a href="<?=base_url()?>/trang-ca-nhan/uspg-quan-ly-tin-rao.htm" rel="nofollow"><i class="fa fa-list"></i> Quản lý tin rao</a></li>
                        <li><a href="<?=base_url()?>/trang-ca-nhan/uspg-doi-mat-khau.htm" rel="nofollow"><i class="fa fa-lock"></i> Đổi mật khẩu</a></li>
                        <li role="separator" class="divider"></li>
                        <li> <a href="<?=site_url('dang-xuat')?>" class="login" rel="nofollow"><i class="fa fa-download fa-rotate-270"></i> Đăng xuất</a></li>
                    </ul>
                <?php else: ?>
                <a class="dropdown" data-toggle="dropdown" href="#" rel="nofollow"><i class="fa fa-user"></i>&nbsp;Tài khoản<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="javascript:;" id="btnLoginPopup" data-toggle="modal" data-target="#loginModal" rel="nofollow"><i class="fa fa-sign-in"></i> Đăng nhập</a></li>
                        <li><a href="javascript:;" id="btnRegisterPopup" data-toggle="modal" data-target="#registerModal" rel="nofollow"><i class="fa fa-pencil"></i> Đăng ký</a></li>
                    </ul>
                <?php endif; ?>
              </li>
              <li><a class="btn-dangtin" href="<?=site_url('dang-tin-cho-thue-nha')?>"><i class="fa fa-plus"></i> Đăng tin rao</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>
<?php if(USERTYPE == 'PC') : ?>
<!--popup login-->
<div id="loginModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="text-transform: capitalize;">đăng nhập</h4>
      </div>
      <div class="modal-body">
        <?php echo form_open(site_url('dang-nhap'), array('id'=>'loginForm', 'method'=>'post')); ?>
        <div class="form-group">
                <div class="input-group input-group-lg">
                    <span class="input-group-addon" id="icon-identity"><i class="fa fa-user"></i></span>
                    <input type="text" name="txtEmail" id="txtEmail" value="" placeholder="Email" class="form-control" required />
                    
                </div>
                <span id="errEmptyEmail" class="error" style="display: none;"><i class="fa fa-times"></i> Vui lòng nhập Email</span>
                <span id="errInvalidEmail" class="error" style="display: none;"><i class="fa fa-times"></i> Email không đúng định dạng</span>   
            </div>
            <div class="form-group">
                <div class="input-group input-group-lg">
                    <span class="input-group-addon" id="icon-identity"><i class="fa fa-key"></i></span>
                    <input type="password" name="txtPassword" value="" id="txtPassword" placeholder="Mật khẩu" class="form-control" required />
                    
                </div>
                <span id="errEmptyPassword" class="error" style="display: none;"><i class="fa fa-times"></i> Vui lòng nhập mật khẩu</span> 
            </div>
            <div class="form-group">
                <div class="pull-left"><label><input type="checkbox" name="remember_me" id="rememberMe" style="float: left;" />&nbsp;Ghi nhớ mật khẩu</label></div>
                <div class="pull-right"><a href="javascript:;" data-action="user-forgot" style="text-decoration: underline;" rel="nofollow">Quên mật khẩu ?</a></div>
                <div class="clearfix"></div>
                <span id="resMsg" class="error" style="display: none;"></span>
                <div class="text-center" style="margin-top: 15px;">
                    <input type="button" id="btnLoginAjax" value="Đăng nhập" class="btn btn-primary btn-block btn-lg" style="margin: 0 auto;"/>
                </div>
            </div>
        <?=form_close()?>
      </div>
      <div class="modal-footer">
         Bạn chưa phải là thành viên? <a data-action="user-register" href="javascript:;">đăng ký tài khoản</a>
      </div>
    </div>
  </div>
</div>
<!--popup Register-->
<div id="registerModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="text-transform: capitalize;">Đăng ký tài khoản</h4>
      </div>
      <div class="modal-body">
        <?php echo form_open(site_url('dang-ky'), array('id'=>'registerForm', 'method'=>'post', 'class'=>'panel-login')); ?>
            <p>Mời Quý vị đăng ký thành viên để được hưởng nhiều lợi ích và hỗ trợ từ chúng tôi!</p>
            <div class="alert alert-success" id="loginAlertMsg" style="display: none;"></div>
                                <div class="form-group">
                                    <input type="text" name="first_name" id="txtFullname" value="" class="form-control input-lg" placeholder="Họ tên" />
                                    <label id="error_fullname" class="error"></label>
                                    <span id="errFullname" style="display: none;" class="error">Vui lòng nhập Họ tên</span>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control input-lg" id="txtRegEmail" name="email" value="<?=set_value('email')?>" placeholder="Email" />
                                    <label id="error_email" class="error"></label>
                                    <span id="errRegEmail" style="display: none;" class="error">Vui lòng nhập Email</span>
                                    <span id="errInvalidEmail" style="display: none;" class="error">Email không đúng định dạng</span>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6 col-xs-6">
                                            <input type="password" class="form-control input-lg" id="txtRegPassword" name="password" id="password" placeholder="Mật khẩu" />
                                            <span id="errRegPassword" style="display: none;" class="error">Vui lòng nhập mật khẩu</span>
                                        </div>
                                        <div class="col-md-6 col-xs-6">
                                            <input type="password" class="form-control input-lg" id="txtRegRePassword" name="repassword" placeholder="Nhập lại mật khẩu" />
                                            <span id="errRegRePassword" style="display: none;" class="error">Vui lòng nhập lại mật khẩu</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <input type="text" class="form-control input-lg" name="mobiphone" id="txtMobiPhone" value="<?=set_value('mobiphone')?>" placeholder="Số di động" />
                                    <span id="errMobiPhone" style="display: none;" class="error">Vui lòng nhập Số điện thoại</span>
                                </div>
                                <div class="form-group">
                                    <label for="gender_nam"><input type="radio" id="gender_nam" name="gender" value="1" checked="checked" /> Nam</label>&nbsp;&nbsp;&nbsp;
                                    <label for="gender_nu"><input type="radio" id="gender_nu" name="gender" value="0" /> Nữ</label>
                                </div>
                                <div class="form-group">
                                    <div class="row" >
                                        <div class="col-xs-6">
                                            <select class="select2" name="city" id="listCity3" style="width: 100%;">
                                                <option value="-1">Tỉnh/thành phố</option>
                                                <?php
                                                $all_city = $this->main_model->_Get_City();
                                                foreach($all_city as $val) { 
                                                ?>
                								<option value="<?=$val['id']?>"><?=$val['title']?></option>
                                                <?php } ?>
                                            </select>
                                            <span id="errCity" style="display: none;" class="error">Vui lòng chọn tỉnh thành</span>
                                        </div>
                                        <div class="col-xs-6">
                                            <select class="select2" name="district" id="listDistrict3" style="width: 100%;">
                                                <option value="-1">Quận/Huyện</option>
                                            </select>
                                            <span id="errDistrict" style="display: none;" class="error">Vui lòng chọn Quận/huyện</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="type_personal"><input type="radio" id="type_personal" name="account_type" value="1" checked="checked" /> Cá nhân</label>&nbsp;&nbsp;&nbsp;
                                    <label for="type_company"><input type="radio" id="type_company" name="account_type" value="0" /> Doanh nghiệp</label>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control captcha" name="captcha" style="display: inline-block;width:auto" placeholder="Captcha" />
                                          <div id="regCaptcha" style="display: inline-block;"></div>
                                            <a class="refresh-captcha" onclick="$.RealApp.captchaRefresh('#regCaptcha')" style="font-size: 22px;"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                                            <span id="errCaptcha" class="error" style="display: none;">Vui lòng nhập mã captcha</span>
                                            <?php echo form_error('captcha', '<label class="error" style="display:block;">', '</label>')?>
                                </div>
                                <p class="note1">(Mã an toàn có phân biệt chữ hoa, chữ thường. Trong trường hợp hiện ra thông báo "Mã an toàn bạn nhập vào chưa đúng" bạn vui lòng nhấn vào nút <i class="fa fa-refresh" aria-hidden="true"></i> để tạo mã an toàn mới và thử lại)</p>
                                        <p class="note2">
                                        <strong>Chúng tôi sẽ gửi đến hộp thư của bạn 1 email xác nhận đăng ký thành viên sau khi đăng ký thành viên hoàn tất.</strong> <br />
                                        </p>
                                        <p>Chú ý: bạn không thể thay đổi những thông tin: email, số điện thoại di động sau khi đăng ký</p>
                                <p class="note3">
                                        Nếu gặp bất kỳ khó khăn gì trong việc đăng ký, đăng nhập, đăng tin hay trong việc sử dụng website nói chung, Quý vị hãy liên hệ ngay với chúng tôi theo email: <strong><a href="mailto:muonnha.com.vn@gmail.com" rel="nofollow">muonnha.com.vn@gmail.com</a></strong> để được trợ giúp
                                </p>  
                                <div id="resRegMsg" style="display: none;"></div>
                <div class="text-center" style="margin-top: 15px;">
                    <input type="button" id="btnRegisterAjax" value="Đăng ký" class="btn btn-primary btn-block btn-lg" style="margin: 0 auto;"/>
                </div>  
            <?=form_close()?>
      </div>
      <div class="modal-footer">
         Bạn đã có tài khoản? <a href="javascript:;" data-action="user-login">Đăng nhập</a>
      </div>
    </div>
  </div>
</div>
<!--popup forgot-->
<div id="forgotModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="text-transform: capitalize;">Quên mật khẩu</h4>
      </div>
      <div class="modal-body">
        <?php echo form_open(site_url('quen-mat-khau'), array('id'=>'forgotForm', 'method'=>'post')); ?>
        <div class="form-group">
                <div class="input-group input-group-lg">
                    <span class="input-group-addon" id="icon-identity"><i class="fa fa-user"></i></span>
                    <input type="text" name="email" id="txtEmail" value="" placeholder="Email" class="form-control" required />
                </div>
                <span class="error emptyEmail" style="display: none;"><i class="fa fa-times"></i> Vui lòng nhập Email</span>
                <span class="error invalidEmail" style="display: none;"><i class="fa fa-times"></i> Email không đúng định dạng</span>   
            </div>
            <div class="form-group">
                <span id="forgotMsg" class="error" style="display: none;"></span>
                <div class="text-center" style="margin-top: 15px;">
                    <input type="button" id="btnForgotAjax" value="Gửi" class="btn btn-primary btn-block btn-lg" style="margin: 0 auto;"/>
                </div>
            </div>
        <?=form_close()?>
      </div>
      <div class="modal-footer">
         Bạn đã là thành viên? <a data-action="user-login" href="javascript:;">Đăng nhập</a>
      </div>
    </div>
  </div>
</div>
<style>
@media screen and (min-width:1200px){
    #registerModal{margin-right:-17px;overflow-y: scroll;}
}
</style>
<?php endif ?>