<?php
$user = $this->ion_auth->user()->row();
if(!empty($user)){
    $avatar = $user->avatar;
    $fullname = $user->first_name;
    $unread_msg = $this->main_model->_Total_User_Msg_Unview($user->id);
}
    
?>
<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
<?php if(!empty($user)) : ?>
<div class="sidebar">
                        <div class="panel panel-primary">
                            <div class="panel-heading">Trang cá nhân</div>
                            <div class="panel-body">
                                <div class="useravatar">
                                    <img src="<?=base_url('uploads/avatar/'.$avatar)?>" class="img-responsive" onerror="this.src='<?=base_url('theme/images/avatar.png')?>'" alt="">
                                </div>
                                <div class="userfullname"><?=$fullname?></div>
                                <div class="userbalance"></div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">Thông tin cá nhân</div>
                            <div class="panel-body">
                                <ul class="list-group">
                                  <li><a href="<?=site_url('trang-ca-nhan/uspg-thong-tin-ca-nhan')?>">Thông tin cá nhân</a></li>
                                  <li><a href="<?=site_url('trang-ca-nhan/uspg-doi-mat-khau')?>">Đổi mật khẩu</a></li> 
                                  <li><a href="<?=site_url('dang-xuat')?>">Đăng xuất</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">Quản lý tin rao</div>
                            <div class="panel-body">
                            <ul class="list-group">
                            <li><a href="<?=site_url('trang-ca-nhan/uspg-quan-ly-tin-rao')?>">Quản lý tin rao</a></li>
                            <li><a href="<?=site_url('trang-ca-nhan/uspg-message')?>">Quản lý tin nhắn </a><span class="label label-danger pull-right"><?=$unread_msg?></span></li>
                            </ul>
                        </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">Tiện ích</div>
                            <div class="panel-body">
                                <ul class="list-group">
                                  <li><a href="<?=site_url('tien-ich/uspg-thong-bao-tu-ban-quan-tri')?>">Thông báo từ ban quản trị</a></li>
                                </ul>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">Hướng dẫn</div>
                            <div class="panel-body">
                                <ul class="list-group">
                                  <?php
                                $page_huongdan = $this->main_model->_Get_Page_By_Id(11);
                                ?>
                                <li><a href="<?=site_url('huong-dan/'.$page_huongdan['alias'])?>"><?=$page_huongdan['title']?></a></li>
                                </ul>
                            </div>
                        </div>
                 </div></div>