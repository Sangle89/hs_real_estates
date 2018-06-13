<style>
.footer_links{
    padding: 10px 0;
    border-top:1px solid #ddd;
    text-align: left;
}
.footer_links a{
    display: inline-block;
    padding: 0 10px;
    border-right:1px solid #ddd;
    color:#000;
}
.footer_links a:last-child{
    border:0;
}
</style>
<footer id="footer">
            <div class="main-wrap-content">
            <div class="top-footer">
                <div class="container">
                    <div class="row">
                    <div class="col-md-12">
                            <!--End banner QC-->
                        <div class="padding">
                            <p class="text1">Tại sao bạn lại chọn Muonnha.com.vn?</p>
                            <p class="text2">Với tôn chỉ vươn mình trở thành website hàng đầu về kênh thông tin cho thuê mướn trong các lĩnh vực: <strong>Cho thuê phòng trọ, cho thuê nhà, cho thuê căn hộ, cho thuê mặt bằng, cho thuê văn phòng, tìm người ở ghép</strong> chúng tôi không ngừng nỗ lực cải tiến công nghệ và những tiện ích hàng đầu nhằm đẩy mạnh sự hiệu quả, tăng tốc độ cho thuê của khách hàng ở mức tối đa.</p>
                            <p class="text3">Chúng tôi luôn mong muốn trở thành cầu nối tuyệt vời nhất cho khách hàng và người đi thuê nhà</p>
                            <p class="text5">Bạn đang có nhà đất cần cho thuê ?</p>
                            <p class="text6">Không phải lo tìm người đi thuê</p>
                            <a class="btn btn-danger" href="<?=base_url('dang-tin-cho-thue-nha.htm')?>" rel="nofollow">Đăng tin ngay</a>
                            <p class="text6" style="margin-top: 7px;">Bạn chỉ cần đăng tin – Việc tìm người đi thuê hãy để chúng tôi lo thay bạn.</p>
                        </div>
                    </div>
                    </div>
                    <!--Banner QC-->
                     <?php if($cur_page == 'home') : ?>
                    <div class="footer-links">
                        <div class="row">
                                    <?php
                                    $footer_link = $this->main_model->_Get_Footer_Link(0);
                                    foreach($footer_link as $col) {
                                    ?>
						<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 matchheight">
							<div class="useful_link">
                                <h2><a href="<?=$col['link']?>"><?=$col['title']?></a></h2>
								<div>
                                <?php
                                $child = $this->main_model->_Get_Footer_Link($col['id']);
                                 foreach($child as $row) { ?>
									<h3><a href="<?=($row['link'])?>" class="tran3s"><?=$row['title']?></a></h3>
                                    <?php } ?>
                                </div>
							</div> <!-- End .useful_link -->
						</div>
                        <?php } ?>
                                    
                                </div>
                    </div>
                        
                        <?php endif; ?>

                    <div class="bottom_footer">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <img src="<?=base_url('theme/images/logo-footer.svg')?>">
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-left">
                                <div class="footer-menu">
                                    <a href="/gioi-thieu-muonnha.htm" rel="nofollow" class="" title="Giới thiệu muonnha.com.vn">Giới thiệu</a>
                                    <a href="/quy-dinh-su-dung.htm" rel="nofollow" class="" title="Quy định sử dụng">Quy định sử dụng</a>
                                    <a href="<?=site_url('lien-he')?>" rel="nofollow">Liên hệ</a>
                                </div>
                                <div class="footer-slogan">
                                    <p>Trải nghiệm của các bạn cũng như sự hiệu quả của tin rao là ưu tiên hàng đầu của chúng tôi.</p>
                                    <p><strong>MỌI CHI TIẾT XIN VUI LÒNG LIÊN HỆ:</strong> Email: muonnha.com.vn@gmail.com
                                       
                                    </p>
                                </div>
                                <p class="noti">Website đang thử nghiệm.</p>
                            </div>
                            
                        </div>

                    </div>
                        <?php
                        $links = $this->main_model->_Get_Footer_Link_By_Position(2);
                        if($links) : 
                        ?>
                        <div class="footer_links">
                            <strong>Liên kết website:</strong>
                            <?php foreach($links as $link) : ?>
                            <a href="<?=$link['link']?>" title="<?=$link['title']?>"><?=$link['title']?></a>
                            <?php endforeach ?>
                        </div>
                        <?php endif ?>
                </div>
            </div>
            </div>
            
            <!-- End .bottom_footer -->
        </footer>