<section class="main-content">
<?php $this->load->view('default/require/breadcrumb'); ?>
        <section class="home_content">
            <div class="main-wrap-content">
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
                            <?php echo form_close();?>        
                            </div>
                        </div>
                        
                    </div>
                    
                    
                </div>
                </div>
                
            </div>
        </section>
