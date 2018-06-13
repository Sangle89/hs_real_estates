<style>
.panel-login{
    border-radius: 7px;
    -webkit-box-shadow: -3px 2px 5px 0px rgba(153,153,153,1);
    -moz-box-shadow: -3px 2px 5px 0px rgba(153,153,153,1);
    box-shadow: -3px 2px 5px 0px rgba(153,153,153,1);
    border: 1px solid #929292;
}
.panel-login .panel-heading{
    padding: 20px;
    text-align: center;
    text-transform: uppercase;
    border-top-left-radius: 7px;
    border-top-right-radius: 7px;
    background:#fff;
    color:#015f95;
    font-size: 20px;
    border-bottom: 0;
}
.panel-login .panel-body {
    padding: 0px 30px;
	border-top:0;
}
.panel-login .panel-footer {
    border-bottom-left-radius: 7px;
    border-bottom-right-radius: 7px;
}
.panel-login input[type="submit"]{
    border-radius: 7px;
    padding: 10px 20px;
    font-weight: bold;
}
.panel-login .input-group{
    width:100%;
}
.panel-login .input-group span{
    width:48px;
}
</style>
        <section class="main-content">
        <?php $this->load->view('default/require/breadcrumb'); ?>
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 col-lg-offset-4 col-sm-offset-4">
                        <div class="panel panel-default panel-login">
                            <div class="panel-heading">Đăng nhập</div>
                            <div class="panel-body">
                            <?php echo form_open(site_url('dang-nhap'), array('id'=>'loginform', 'method'=>'post')); ?>
                            <?php 
                            if($this->session->flashdata('message')) 
								echo '<div class="alert alert-success">'.$this->session->flashdata('message').'</div>'; 
                            ?>
                                <div class="form-group">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-addon" id="icon-identity"><i class="fa fa-user"></i></span>
                                    <?php echo form_input($identity);?>
                                </div>   
                                </div>
                                <div class="form-group">
                                <div class="input-group  input-group-lg">
                                    <span class="input-group-addon" id="icon-identity"><i class="fa fa-key"></i></span>
                                    <?php echo form_input($password);?>
                                </div> 
                                </div>
                                <div class="form-group">
                                    <div class="pull-left"><label><input type="checkbox" />&nbsp;Ghi nhớ mật khẩu</label></div>
                                    <div class="pull-right"><a href="<?=site_url('quen-mat-khau')?>" style="text-decoration: underline;" rel="nofollow">Quên mật khẩu ?</a></div>
                                    <div class="clearfix"></div>
                                    <div class="text-center" style="margin-top: 15px;">
                                    <input type="submit" value="Đăng nhập" class="btn btn-primary btn-block" style="margin: 0 auto;">
                                    
                                    </div>
                                </div>
                            <?=form_close()?>
                            </div>
                            <div class="panel-footer">
                                <p class="text-center" style="margin:15px 0;">Bạn chưa phải là thành viên? <a href="<?=site_url('dang-ky')?>" rel="nofollow" style="text-decoration: underline;">Đăng ký tại đây</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>