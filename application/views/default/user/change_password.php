<section class="main-content">
<?php $this->load->view('default/require/breadcrumb'); ?>
            <div class="main-wrap-content">
                <div class="pad10">
                <div class="row">
                    <?php $this->load->view('default/user/sidebar'); ?>
                    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                        <div class="user_main_title">Thay đổi mật khẩu</div>
                        <div class="form-dangky">
                            <form method="post" action="" id="formRegister" enctype="multipart/form-data">
                                <?php 
                                if($this->session->flashdata('message')) echo '<div class="alert alert-success">'.$this->session->flashdata('message').'</div>';
                                ?>
                                
                                <table>
                                    <tr>
                                        <td>Mật khẩu hiện tại <span class="required">(*)</span></td>
                                        <td><?=form_password($curpassword)?>
                                        <label id="error_curpassword" class="error"></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Mật khẩu mới <span class="required">(*)</span></td>
                                        <td><?=form_password($password)?>
                                        <label id="error_password" class="error"></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Xác nhận mật khẩu mới <span class="required">(*)</span></td>
                                        <td><?=form_password($password_confirm)?>
                                        <label id="error_repassword" class="error"></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><button type="submit" name="submit" class="btn btn-primary"><i class="fa fa-refresh"></i>&nbsp;Cập nhật</button></td>
                                    </tr>
                                </table>
                                
                                <input type="hidden" name="id" value="<?=$user_id?>" />
                            </form>
                        </div>
                        
                    </div>
                    
                </div>
                </div>
                
            </div>
        </section>