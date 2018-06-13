<div id="breadcrumbs">
        <div class="breadcrumbs-bg box-100">
            <div class="breadcrumbs"><a href="http://actioncoach.asia">Trang chủ</a> <span>//</span> Liên hệ</div>
        </div>
        
    </div>
    
    <div class="introduce box-100">
        
        <div class="introduce-bg col-lg-12" style="padding: 20px;">
            <div id="map" style="margin-bottom: 20px;">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2770.911230835181!2d106.68298834926715!3d10.837291659201307!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTDCsDUwJzE1LjQiTiAxMDbCsDQwJzU4LjEiRQ!5e0!3m2!1svi!2s!4v1470414639140" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <?php
                    $lienhe = $this->page_model->_Get_Page_By_Id(6);
                    echo $lienhe['content'];
                    ?>
                </div>
                
                <div class="col-lg-6 col-md-6">
                <?php if($this->session->flashdata('success')) { ?>
                <div class="alert alert-success"><?=$this->session->flashdata('success')?></div>
                <?php } ?>
                    <form class="form" method="post" action="">
                        <div class="form-group">
                            <div class="col-lg-2 col-md-2">Họ tên</div>
                            <div class="col-lg-10 col-md-10">
                                <input type="text" class="form-control" name="fullname" required />
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-2 col-md-2">Email</div>
                            <div class="col-lg-10 col-md-10">
                                <input type="text" class="form-control" name="email"  required/>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-2 col-md-2">Số điện thoại</div>
                            <div class="col-lg-10 col-md-10">
                                <input type="text" class="form-control" name="phone" required />
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-2 col-md-2">Địa chỉ</div>
                            <div class="col-lg-10 col-md-10">
                                <input type="text" class="form-control" name="address" required />
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-2 col-md-2">Nội dung</div>
                            <div class="col-lg-10 col-md-10">
                                <textarea class="form-control" name="message" required></textarea>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="col-lg-12 text-right"><input type="submit" name="submit" class="btn btn-primary" value="Gửi" /></div>
                    </form>
                </div>
            </div>
            
        </div>
        
        <div class="clearfix"></div>
    </div>