<section class="main-content">
<?php $this->load->view('default/require/breadcrumb'); ?>
            <div class="main-wrap-content">
                <div class="pad10">
                <div class="row">
                    <?php $this->load->view('default/user/sidebar'); ?>
                    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                        <div class="user_main_title">Tin nhắn</div>
                        
                        <div class="well">
                            <p>Họ tên: <strong><?=$result['fullname']?></strong></p>
                            <p>Email: <strong><?=$result['email']?></strong></p>
                            <p>Số điện thoại: <strong><?=$result['phone']?></strong></p>
                            <p>Tin nhắn: <strong><?=$result['message']?></strong></p>
                            <p>Ngày gửi: <strong><?=_Format_Date($result['create_time'])?></strong></p>
                        </div>
                        
                        <?=$pagination?>
                    </div>
                    <a href="<?=site_url('trang-ca-nhan/uspg-message')?>" class="btn btn-default"><i class="fa fa-backward"></i> Quay lại</a>
                    
                </div>
                </div>
                
            </div>
        </section>