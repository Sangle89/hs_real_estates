 <div class="row">

                                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                        <div class="title_info green">Đặc điểm nổi bật</div>
                                                    

                                                    <table class="featured_properties">

                                                        <tr>

                                                            <td>Mã số</td>

                                                            <td>
                                                                <?=$real_estate['id']?>
                                                            </td>

                                                        </tr>

                                                        <tr>

                                                            <td>Loại tin rao</td>

                                                            <td>
                                                                <?=$category['title']?>
                                                            </td>

                                                        </tr>

                                                        <tr>

                                                            <td>Ngày đăng tin</td>

                                                            <td>
                                                                <?=_convert_date2($real_estate['from_date'])?>
                                                            </td>

                                                        </tr>

                                                        <tr>

                                                            <td>Ngày hết hạn</td>

                                                            <td>
                                                                <?=_convert_date2($real_estate['to_date'])?>
                                                            </td>

                                                        </tr>

                                                        <?php if($real_estate['huongnha']) : ?>

                                                            <tr>

                                                                <td>Hướng nhà</td>

                                                                <td>
                                                                    <?=_Direction_Label($real_estate['huongnha'])?>
                                                                </td>

                                                            </tr>

                                                            <?php endif; ?>
<?php if($real_estate['area']):?>

                                                                            <tr>
                                                                                <td>Diện tích</td>
                                                                                <td>
                                                                                    <?=($real_estate['area']!=0) ? $real_estate['area'].' (m2)':'Không xác định'?>
                                                                                </td>
                                                                            </tr>
                                                                            <?php endif; ?>
                                                                                <?php if($real_estate['mattien']) : ?>
                                                                                    <tr>
                                                                                        <td>Mặt tiền</td>

                                                                                        <td>
                                                                                            <?=($real_estate['mattien']!=0?$real_estate['mattien'].' (m)':'Không xác định')?>
                                                                                        </td>

                                                                                    </tr>

                                                                                    <?php endif; ?>

                                                                                        <?php if($real_estate['sotang'] > 0) : ?>

                                                                                            <tr>

                                                                                                <td>Số tầng</td>

                                                                                                <td>
                                                                                                    <?=$real_estate['sotang']?> (tầng)</td>

                                                                                            </tr>

                                                                                            <?php endif; ?>

                                                                                                <?php if($real_estate['sophong']>0) : ?>

                                                                                                    <tr>

                                                                                                        <td>Số phòng ngủ</td>

                                                                                                        <td>
                                                                                                            <?=$real_estate['sophong']?> (phòng)</td>

                                                                                                    </tr>

                                                                                                    <?php endif; ?>

                                                                                                        <?php if($real_estate['sotoilet']) : ?>

                                                                                                            <tr>

                                                                                                                <td>Số toilet</td>

                                                                                                                <td>
                                                                                                                    <?=$real_estate['sotoilet']?> (phòng)</td>

                                                                                                            </tr>

                                                        <?php endif; ?>
                                                        <?php if($real_estate['noithat']) : ?>

                                                            <tr>

                                                                <td>Nội thất</td>

                                                                <td>
                                                                    <?=($real_estate['noithat'])?>
                                                                </td>

                                                            </tr>

                                                            <?php endif; ?>

                                                    </table>

                                                </div>

                                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                                                    <div class="title_info green">Thông tin liên hệ</div>
                           
                                                    <table class="featured_properties">

                                                        <?php if($detail_user['name']!=''):?>

                                                            <tr>

                                                                <td width="80">Họ tên</td>

                                                                <td>
                                                                    <?=$detail_user['name']?>
                                                                </td>

                                                            </tr>

                                                        <?php endif; ?>
                                                        <?php if($detail_user['address']!=''):?>

                                                                    <tr>

                                                                        <td>Địa chỉ</td>

                                                                        <td>
                                                                            <?=$detail_user['address']?>
                                                                        </td>

                                                                    </tr>

                                                                    <?php endif; ?>

                                                                        <?php if($detail_user['telephone']!=''):?>

                                                                            <tr>

                                                                                <td>Điện thoại</td>

                                                                                <td>
                                                                                    <?=$detail_user['telephone']?>
                                                                                </td>

                                                                            </tr>

                                                                            <?php endif; ?>

                                                                                <?php if($detail_user['mobiphone']!=''):?>

                                                                                    <tr>

                                                                                        <td>Di động</td>

                                                                                        <td>
                                                                                            <?=$detail_user['mobiphone']?>
                                                                                        </td>

                                                                                    </tr>

                                                                                    <?php endif; ?>

                                                                                        <?php if($detail_user['email']!=''):?>

                                                                                            <tr>

                                                                                                <td>Email</td>

                                                                                                <td>
                                                                                                    <?=$detail_user['email']?>
                                                                                                </td>

    </tr>

<?php endif; ?>

                                                    </table>

                                                </div>

                                            </div>
