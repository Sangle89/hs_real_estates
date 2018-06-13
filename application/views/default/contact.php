<style>
.contact label{
    font-weight: bold;
}
.contact form .btn{
    border-radius: 0;
    padding: 6px 25px;
}
</style>
<div class="main-wrap-content property_listing contact">
    <div class="property_type row">
        <div class="col-md-12">
            <?=$this->breadcrumb->output()?>
        </div>
    </div>
    <div class="row">
                <div class="col-lg-6 col-md-6">
                    <?php
                    echo $page_content['content'];
                    ?>
                </div>
                
                <div class="col-lg-6 col-md-6">
                <?php if($this->session->flashdata('success')) { ?>
                <div class="alert alert-success">Gửi thành công !</div>
                <?php } ?>
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Liên hệ</strong></div>
                    <div class="panel-body">
                    <form class="form" method="post" action="">
                        <div class="form-group">
                            <div class="col-lg-12 col-md-12">
                                <label>Họ tên *</label>
                                <div class="form-group">
                                <input type="text" class="form-control" name="fullname" maxlength="50" required />
                                <?=form_error('fullname')?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-12 col-md-12">
                                <label>Email *</label>
                                <div class="form-group">
                                <input type="text" class="form-control" name="email" maxlength="50" required/>
                                <?=form_error('email')?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-12 col-md-12">
                                <label>Số điện thoại *</label>
                                <div class="form-group">
                                <input type="text" class="form-control" name="phone" maxlength="20" required />
                                <?=form_error('phone')?>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-lg-12 col-md-12">
                                <label>Nội dung *</label>
                                <div class="form-group">
                                <textarea class="form-control" name="message" maxlength="2000" required></textarea>
                                <?=form_error('message')?>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="col-lg-12 text-right"><input type="submit" name="submit" class="btn btn-primary" value="Gửi" /></div>
                    </form>
                    </div>
                </div>
                </div>
            </div>
</div>