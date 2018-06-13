<section class="main-content">
<?php $this->load->view('default/require/breadcrumb'); ?>
            <div class="main-wrap-content">
                <div class="pad10">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 col-lg-offset-2 col-sm-offset-2">
                        <div class="panel panel-default panel-login">
                        <?php echo form_open('auth/reset_password/' . $code);?>
                            <div class="panel-heading">Đặt lại mật khẩu</div>
                            <div class="panel-body">
                                <div id="infoMessage"><?php echo $message;?></div>
                                

	<div class="form-group">
		<label for="new_password" class="col-lg-4 col-md-4">Mật khẩu mới</label> 
		<div class="col-lg-8 col-md-8"><?php echo form_input($new_password,'','class="form-control"');?></div>
        <div class="clearfix"></div>
	</div>

	<div class="form-group">
		<label class="col-lg-4 col-md-4">Nhập lại mật khẩu mới</label>
		<div class="col-lg-8 col-md-8"><?php echo form_input($new_password_confirm, '', 'class="form-control"');?></div>
         <div class="clearfix"></div>
	</div>

	<?php echo form_input($user_id);?>
	<?php echo form_hidden($csrf); ?>

	


                            </div>
                            <div class="panel-footer">
                                <div class="form-group" style="text-align: center;margin:15px 0"><?php echo form_submit('submit','Cập nhật','class="btn btn-primary"');?></div>
                            </div>
                            <?php echo form_close();?>
                        </div>



                        </div>
                        
                    </div>
                </div>
                
                    
                    
                </div>
            </div>
        </section>