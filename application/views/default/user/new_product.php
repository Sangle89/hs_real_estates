<link rel="stylesheet" type="text/css" href="<?=ASSET_SERVER?>/assets/dist/css/custom.css">
<style>
.upload_multi_image li.add_image{
    vertical-align: middle;
    text-align: center;
    border: 0;
    background: #38a345;
    cursor: pointer;
}
.upload_multi_image li.add_image a{
    color:#fff;
}
</style>
<script src="<?=ASSET_SERVER?>assets/plugins/ajaxupload/SimpleAjaxUploader.min.js"></script>
<script>
var num_image = 0;
function addImage(obj, limit) {
    if(num_image < limit) {
        $.ajax({
            url: '<?=ASSET_SERVER?>/ajax/add_image',
            type: 'post',
            dataType: 'html',
            success: function(html) {
                $(obj).parent().before(html);
            }
        });
        num_image++;
    } else {
        alert('Bạn chỉ được thêm tối đa ' + limit + ' tấm hình.');
    }
}
</script>
<section class="main-content">

            <div class="main-wrap-content">
                <div class="pad10">
                    <div class="row">
                <?php 
					if($this->ion_auth->logged_in())
						$this->load->view('default/user/sidebar')?>
                    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                        <?=$this->breadcrumb->output()?>
                        <div class="post-bg-title">
                            <h1 class="bluecolor">Đăng tin cho thuê nhà đất</h1>
                            <div class="graycolor">(Quý vị nhập thông tin bán đất hoặc bán nhà vào các mục dưới đây)</div>
                        </div>
                        <div class="form-dangky">
                        <?php echo validation_errors(); ?>
                            <form method="post" action="" class="form-post" id="formPost">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">Thông tin cơ bản</div>
                                    <div class="panel-body">
                                        <div class="row-post">
                                            <div class="col-1">
                                                Tiêu đề <span class="required">(*)</span>:
        										<span id="sessionNum_counter"></span>
                                            </div>
                                            <div class="col-5">
                                                <div class="input-group">
                                                    <input type="text" value="<?=set_value('title')?>" class="form-control" name="title" minlength="30" maxlength="99" id="txtSuggestTitle" aria-describedby="icon-countdown" placeholder="Vui lòng nhập Tiếng Việt có dấu để tin đăng được kiểm duyệt nhanh hơn" />
                                                    <span id="icon-countdown" class="input-group-addon">0/99</span>    
                                                </div>
                                                <span id="btnSuggestTitle" style="cursor: pointer;display: none;">Gởi ý tiêu đề</span>
                                                <input type="hidden" id="hddSuggestTitle" value="" />
        										<label id="errorTitle" class="error"></label>
                                            </div>
                                             <div class="clearfix"></div>
                                        </div>
                                        <div class="row-post">
                                            <div class="col-1">
                                                Loại nhà đất <span class="required">(*)</span>:
                                            </div>
                                            <div class="col-2">
                                                <select class="select2" id="listCategory2" name="category_id">
                                                    <option value="-1">--Chọn danh mục tin--</option>
                                                    <?php
                                                    $sub_category = $this->main_model->_Get_Real_Estate_Category(0);
                                                    foreach($sub_category as $sub) {?>
                                                        <option value="<?=$sub['id']?>" <?php if(isset($post['category_id']) && $post['category_id'] == $sub['id']) echo 'selected="selected"';?>><?=$sub['title']?></option>
                                                    <?php    
                                                    }
                                                    ?>
                                                </select>
                                                <label id="errorCategory" class="error"></label>
                                            </div>
                                            <div class="col-1 text-right">
                                                Quận/Huyện <span class="required">(*)</span>:
                                            </div>
                                            <div class="col-2">
                                                <select class="select2" id="listDistrict2" name="district_id">
                                                    <option value="-1" selected="selected">--Chọn Quận/Huyện--</option>
                                                    <?php
                                                    $all_district = $this->main_model->_Get_District(1);
                                                    foreach($all_district as $val) { 
                                        ?>
        								<option value="<?=$val['id']?>"><?=$val['title']?></option>
                                        <?php } ?>
                                                </select>
                                               <label id="errorDistrict" class="error"></label>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="row-post">
                                            <div class="col-1">
                                                Phường/Xã:
                                            </div>
                                            <div class="col-2">
                                               <select class="select2" id="listWard2" name="ward_id">
                                                    <option value="-1" selected="selected">--Chọn Phường/Xã--</option>
                                                </select>
                                            </div>
                                            <div class="col-1 text-right">
                                                Đường/Phố:
                                            </div>
                                            <div class="col-2">
                                               <select class="select2" id="listStreet2" name="street_id">
                                                    <option value="-1">--Chọn Đường/Phố--</option>
                                                </select>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        
                                        <div class="row-post">
                                            <div class="col-1">
                                                Giá:
                                            </div>
                                            <div class="col-2">
                                                <input type="text" value="<?=set_value('price_number')?>" class="form-control" name="price_number" id="txtPriceNumber" placeholder="0" />
        										<label id="errorPriceNumber" class="error"></label>
                                            </div>
                                            <div class="col-1 text-right">
                                                Đơn vị:
                                            </div>
                                            <div class="col-2">
                                                <select class="select2" id="listPriceUnit" name="price_unit">
                                                    <option value="-1">Chọn đơn vị</option>
                                                    <option value="1" selected="selected">Triệu/tháng</option>
                                                    <option value="2">Nghìn/tháng</option>
                                                    <option value="3">Nghìn/m2/tháng</option>
                                                </select>
                                                <label id="errorPriceUnit" class="error"></label>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        
                                        <div class="row-post">
                                            <div class="col-1">
                                                Diện tích:
                                            </div>
                                            <div class="col-2">
                                                <div class="input-group">
                                                    <input type="text" value="<?=set_value('area')?>" name="area" class="form-control" name="area" aria-describedby="icon-area" />
                                                    <span class="input-group-addon" id="icon-area">m<sup>2</sup></span>
                                                </div>
                                            </div>
                                            <div class="col-1 text-right">
                                                Dự án:
                                            </div>
                                            <div class="col-2">
                                                <select class="select2" id="listProject2" name="project_id">
                                                    <option value="-1">Chọn dự án</option>
                                                    <?php 
                                                    $projects = $this->main_model->_Get_Project();
                                                    foreach($projects as $project):
                                                    ?>
                                                    <option value="<?=$project['id']?>"><?=$project['title']?></option>
                                                    <?php endforeach ?>
                                                </select>
                                                <label id="errorProject" class="error"></label>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="row-post">
                                            <div class="col-1">
                                                Địa điểm:
                                            </div>
                                            <div class="col-5">
                                                <input type="text" value="<?=set_value('address')?>" class="form-control" name="address" id="txtAddress" />
                                                <input type="hidden" id="hddDiadiem" value="" />
                                            </div>
                                             <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-primary">
                                    <div class="panel-heading">Mô tả chi tiết</div>
                                    <div class="panel-body">
                                        <p style="margin-bottom: 15px;">Nhập nội dung về bất động sản tối đa 3000 từ <span class="required">(*)</span></p>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <textarea class="form-control" rows="10" name="content" placeholder=""><?=set_value('content')?></textarea>
        										<label id="errorContent" class="error"></label>
                                            </div>
                                           <div class="col-md-4">
                                            <p style="color: #666;font-size:12px;line-height: 20px;text-align: justify;"><i class="fa fa-play" style="color: #015f95;font-size:9px"></i>Giới thiệu chung về bất động sản của bạn. Ví dụ: Nhà mấy tầng, diện tích bao nhiêu, cơ sở hạ tầng xung quanh, an ninh, giao thông công cộng thế nào, có những tiện ích nào, ...
        <br><span style="color: red;">Lưu ý: tin rao chỉ để mệnh giá tiền Việt Nam Đồng.</span></p>
                                           </div>
                                             <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-primary">
                                    <div class="panel-heading">Thông tin khác</div>
                                    <div class="panel-body">
                                        <div style="margin-bottom: 15px;">Quý vị nên điền đầy đủ thông tin vào các mục dưới đây để tin đăng tạo được sự tin tưởng và rõ ràng hơn.</div>
                                        <div class="row-post">
                                            <div class="col-1">
                                                Mặt tiền:
                                            </div>
                                            <div class="col-2">
                                                <div class="input-group">
                                                    <input type="text" value="<?=set_value('mattien')?>" class="form-control" name="mattien" aria-describedby="icon-mattien" />
                                                    <span class="input-group-addon" id="icon-mattien">m</span>
                                                </div>
                                                
                                            </div>
                                            <div class="col-1 text-right">
                                                Đường trước nhà:
                                            </div>
                                            <div class="col-2">
                                                <div class="input-group">
                                                    <input type="text" value="<?=set_value('duongtruocnha')?>" class="form-control" name="duongtruocnha" aria-describedby="icon-duongtruocnha" />
                                                    <span class="input-group-addon" id="icon-duongtruocnha">m</span>
                                                </div>
                                                
                                            </div>
                                             <div class="clearfix"></div>
                                        </div>
                                        <div class="row-post">
                                            <div class="col-1">
                                                Số tầng:
                                            </div>
                                            <div class="col-2">
                                                <input type="text" value="<?=set_value('sotang')?>" class="form-control" name="sotang" />
                                            </div>
                                            <div class="col-1 text-right">
                                               Số phòng ngủ:
                                            </div>
                                            <div class="col-2">
                                                <input type="text" value="<?=set_value('sophong')?>" class="form-control" name="sophong" />
                                            </div>
                                             <div class="clearfix"></div>
                                        </div>
                                        <div class="row-post">
                                            
                                            <div class="col-1">
                                                Hướng BĐS:
                                            </div>
                                            <?php
                                            $huongnha = array(
                                            1 => 'Không xác định',
                                            2 => 'Đông',
                                            3 => 'Tây',
                                            4 => 'Nam',
                                            5 => 'Bắc',
                                            6 => 'Đông-Bắc',
                                            7 => 'Tây-Bắc',
                                            8 => 'Tây-Nam',
                                            9 => 'Đông-Nam' 
                                            );
                                            ?>
                                            <div class="col-2">
                                                <select class="select2" name="huongnha">
                                                    <option>--Chọn hướng nhà--</option>
                                                    <?php foreach($huongnha as $key=>$val) { ?>
                                                    <option value="<?=$key?>"><?=$val?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-1 text-right">
                                                Số Toilet:
                                            </div>
                                            <div class="col-2">
                                                <input type="text" value="<?=set_value('sotoilet')?>" class="form-control" name="sotoilet" />
                                            </div>
                                             <div class="clearfix"></div>
                                            
                                        </div>
                                        <div class="row-post">
                                        <div class="col-1 text-left">
                                                Nội thất:
                                            </div>
                                            <div class="col-5">
                                                <textarea class="form-control" name="noithat"></textarea>
                                            </div>
                                             <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-primary">
                                    <div class="panel-heading">Tiện ích</div>
                                    <div class="panel-body">
                                        <div class="row">
                                        <?php
                                        $utilities = $this->main_model->_Get_Utility();
                                        
                                        foreach($utilities as $item):
                                        ?>
                                        <label class="col-sm-2"><input type="checkbox" name="utilities[]" value="<?=$item['id']?>" />&nbsp;<?=$item['title']?></label>
                                        <?php endforeach?>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-primary">
                                    <div class="panel-heading">Hình ảnh & Video</div>
                                    <div class="panel-body">
                                        <div class="row-post">
                                            <div class="col-1">
                                                Hình ảnh:
                                                
                                            </div>
                                            <div class="col-5">
                                                <div style="margin-bottom: 15px;text-align: justify;">
                                                <p style="color: #666;">Tối đa 15 Hình. Định dạng hình: Jpg,. Jpeg. Dung lượng không quá 2 MB / 1 hình</p>
                                                <p>Tin rao có ảnh sẽ được xem nhiều hơn gấp 10 lần và được nhiều người gọi gấp 5 lần so với tin rao không có ảnh. Hãy đăng ảnh để được giao dịch nhanh chóng!</p>
                                                </div>
                                                <div id="progressOuterImages" class="progress progress-striped active" style="display:none;">
            <div id="progressBarImages" class="progress-bar progress-bar-success"  role="progressBarImage" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
        </div>
        <div id="msgBoxImages"></div>
                                                <ul class="upload_multi_image" id="uploadMultiImage">
                                                       <li class="add_image"><a id="uploadImages"><i class="fa fa-image"></i><span>Upload hình</span></a></li>
                                                </ul>
                                            </div>
                                             <div class="clearfix"></div>
                                        </div>
                                        <div class="row-post">
                                            <div class="col-1">
                                                Video:
                                            </div>
                                            <div class="col-5">
                                                <span style="display: block;"><i class="fa fa-video-camera" aria-hidden="true" style="color:#015f95;font-size:20px;"></i> Nếu bạn có nhu cầu Upload video, hãy liên hệ với chúng tôi để được hỗ trợ</span>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="panel panel-primary">
                                    <div class="panel-heading">Thông tin liên hệ</div>
                                    <div class="panel-body">
                                        <div class="row-post">
                                            <div class="col-1">
                                                Họ tên <span class="required">(*)</span>:
                                            </div>
                                            <div class="col-2">
                                                <input type="text" value="<?=isset($user) ? $user->first_name:''?>" class="form-control" name="guest_name" />
        										<label id="errorGuestName" class="error"></label>
                                            </div>
                                            <div class="col-1 text-right">
                                                Email:
                                            </div>
                                            <div class="col-2">
                                                <input type="text" value="<?=isset($user) ? $user->email:''?>" class="form-control" name="guest_email" />
        										<label id="errorGuestEmail" class="error"></label>
                                            </div>
                                             <div class="clearfix"></div>
                                        </div>
                                        
                                        <div class="row-post">
                                            <div class="col-1">
                                                Điện thoại:
                                            </div>
                                            <div class="col-2">
                                                <input type="text" value="<?=isset($user) ? $user->telephone:''?>" class="form-control" name="guest_telephone" />
                                            </div>
                                            <div class="col-1 text-right">
                                                Di động <span class="required">(*)</span>:
                                            </div>
                                            <div class="col-2">
                                                <input type="text" value="<?=isset($user) ? $user->mobiphone:''?>" class="form-control" name="guest_mobiphone" />
        										<label id="errorGuestMobiphone" class="error"></label>
                                            </div>
                                             <div class="clearfix"></div>
                                        </div>
                                        <div class="row-post">
                                            <div class="col-1">
                                                Địa chỉ:
                                            </div>
                                            <div class="col-5">
                                                <input type="text" value="<?=isset($user) ? $user->address:''?>" class="form-control" name="guest_address" />
        										<label id="errorGuestAddress" class="error"></label>
                                            </div>
                                             <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-primary">
                                    <div class="panel-heading">Loại tin rao</div>
                                    <div class="panel-body">
                                        <div class="row">
                                                    <div class="col-sm-4">
                                                        <label>Loại tin đăng</label>
                                                        <select class="select2" name="type_id" id="TypeID">
                                                          <option value="1">Tin đặc biệt</option>
                                                            <option value="2">Tin vip 1</option>
                                                            <option value="3">Tin vip 2</option>
                                                            <option value="4" selected="selected">Tin thường</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label>Ngày bắt đầu</label>
                                                        <input type="text" class="form-control datepicker" placeholder="Từ ngày" name="from_date" value="<?php echo date("d/m/Y", time()); ?>" />
        										      <label id="errorFromDate" class="error"></label>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label>Ngày kết thúc</label>
                                                        <input type="text" class="form-control datepicker" placeholder="Đến ngày" name="to_date" value="<?php echo date("d/m/Y", time() + (3600*24*30)); ?>" />
        										          <label id="errorToDate" class="error"></label>
                                                    </div>
                                                </div>
                                        <div class="clearfix"></div>
                                        <div class="row-post">
                                            <div class="col-6">
                                                <strong style="color: #015f95;display: block;margin-bottom: 7px;">Mô tả loại tin:</strong>
                                                <div id="type_preview">
                                                    <div id="preview_pro" class="type_preview pro"><span>Tin Vip Đặc Biệt: </span><span>- Hiệu quả gấp 30 lần so với tin thường<br />- Là loại tin được đăng tiêu đề bằng chữ IN HOA MÀU ĐỎ, khung màu đỏ, hiển thị ở top đầu trang tin và được hưởng nhiều ưu tiên nhất</span></div>
                                                    <div id="preview_vip1" class="type_preview vip1"><span>Tin Vip 1: </span><span>- Hiệu quả gấp 15 lần so với tin thường<br />- Là loại tin được đăng tiêu đề bằng chữ IN HOA MÀU ĐỎ, khung màu đỏ, nằm bên dưới tin VIP ĐẶC BIỆT và ở trên các tin vip 3</span></div>
                                                    <div id="preview_vip2" class="type_preview vip2"><span>Tin Vip 2: </span><span>- Hiệu quả gấp 3 lần so với tin thường<br />- Là loại tin đăng bằng chữ IN HOA MÀU CAM, khung màu cam, nằm bên dưới tin VIP 1 và ở trên các tin thường</span></div>
                                                    <div id="preview_normal" class="type_preview normal"><span>Tin thường: </span><span>- Được đăng miễn phí<br />- Là loại tin đăng bằng chữ màu xanh, khung màu xanh</span></div>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="panel panel-primary">
                                    <div class="panel-heading">Mã an toàn</div>
                                    <div class="panel-body">
                                        <div style="margin-bottom: 15px;">Nhập mã bảo mật hình bên, chứng minh bạn không phải Robot hoặc phần mềm đăng tin SPAM.</div>
                                        <div class="row-post">
                                            <div class="col-1">Mã an toàn <span class="required">(*)</span>:</div>
                                            <div class="col-5">
                                                <div style="float: left;margin-right: 5px;">
                                                <input type="text" class="form-control" placeholder="" name="captcha" style="display: inline-block;width:100px;"/>
        										</div>
                                                <div id="postCaptcha" style="float: left;"></div><a class="refresh-captcha" onclick="$.RealApp.captchaRefresh('#postCaptcha')" style="font-size: 22px;"><i class="fa fa-refresh" aria-hidden="true"></i></a><br />
                                                <div class="clearfix"></div>
                                                <label id="errorCaptcha" class="error"></label>
                                                <p style="margin: 5px 0 0 0;">(Trong trường hợp hiện ra thông báo "Mã an toàn bạn nhập vào chưa đúng" bạn vui lòng nhấn vào nút <i class="fa fa-refresh" aria-hidden="true"></i> để tạo mã an toàn mới và thử lại)</p>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="row-post">
                                    <div class="col-lg-12" style="text-align: center;">
                                        <button type="submit" class="btn btn-primary" id="btnDangtin"><i class="fa fa-check"></i>&nbsp;
                                        <?php 
                                        if($this->ion_auth->logged_in()) echo 'Đăng tin';
                                        else echo 'Đăng tin không cần tài khoản'; 
                                        ?>
                                        </button>&nbsp;
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <input type="hidden" id="hddLatitude" value="" />
                                <input type="hidden" id="hddLongtitude" value="" />
                                <input type="hidden" id="txtPositionX" value="" />
                                <input type="hidden" id="txtPositionY" value="" />
                                
                                <div>
                                    
                                <?php
                                if(!$this->ion_auth->logged_in()) :
                                ?><strong>Lưu ý</strong>
                                    <p style="text-align: justify;font-size:13px;color:#666">Quý khách đang sử dụng tính năng đăng tin nhanh của muonnha.com.vn. Tính năng này giúp Quý khách có thể đăng tin ngay mà không cần phải đăng ký hay đăng nhập như tại nhiều website khác. Tuy nhiên, để có thể quản lý được tin đăng của mình thuận lợi hơn thì Quý khách nên đăng ký và đăng nhập. Việc này cũng giúp Quý khách có thể đăng được nhiều tin hơn so với giới hạn tối đa 3 tin rao vặt nhà đất khi Quý khách không đăng nhập.</p>
                                <?php endif; ?>
                                    <p style="text-align: justify;font-size:13px;color:#666">Nếu gặp bất kỳ khó khăn gì trong việc đăng ký, đăng nhập, đăng tin hay trong việc sử dụng website nói chung, Quý vị hãy liên hệ ngay với chúng tôi theo số đt: <strong>0908 149 488</strong> hoặc email: <strong>muonnha.com.vn@gmail.com</strong> để được trợ giúp</p>
                                </div>
                                
                                
                            </form>
                        </div>
                        
                    </div>
                    <!--End col left-->
                    <?php 
					if(!$this->ion_auth->logged_in())
						$this->load->view('default/user/sidebar')?>
                    <!--End col Right-->
                </div>
                </div>
                
            </div>
        </section>
<script src="https://maps.google.com/maps/api/js?key=<?=API_KEY?>"></script> <!-- Gmap Helper -->
<script src="<?=ASSET_SERVER?>theme/js/MapControls.js"></script>
<script>
$(document).ready(function(){
    $('.datepicker').datepicker({
        dateFormat: 'dd/mm/yy'
    });
    $('#listCategory2').change(function(){
        var category = $(this).find('option:selected').text();
        var hddSuggestTitle = $('#hddSuggestTitle').val();
        $('#hddSuggestTitle').val(category.replace('---', ''));
    });
    $('#listCity2').change(function(){
        var category = $('#listCategory2').find('option:selected').text();
        var hddSuggestTitle = $('#hddSuggestTitle').val();
        var city = 'Hồ Chí Minh';//$('#listCity2').find('option:selected').text();
        var txtAddress = $('#txtAddress').val();
        $('#txtAddress').val(city);
        $('#hddDiadiem').val(city);
        $('#hddSuggestTitle').val(category.replace('---', '') +' '+ city);
        ShowLocation();
        
    });
    $('#listDistrict2').change(function(){
        var category = $('#listCategory2').find('option:selected').text();
        var hddSuggestTitle = $('#hddSuggestTitle').val();
        //var city = $('#listCity2').find('option:selected').text();
        var city = 'Hồ Chí Minh';
        var district = $('#listDistrict2').find('option:selected').text();
        var txtAddress = $('#txtAddress').val();
        
        $('#txtAddress').val(district + ', ' + city);
        $('#hddDiadiem').val(district + ', ' + city);
        $('#hddSuggestTitle').val(category.replace('---', '') + ' ' + district + ', ' + city);
        ShowLocation();
    });
    $('#listWard2').change(function(){
        var category = $('#listCategory2').find('option:selected').text();
        var hddSuggestTitle = $('#hddSuggestTitle').val();
        //var city = $('#listCity2').find('option:selected').text();
        var city = 'Hồ Chí Minh';
        var district = $('#listDistrict2').find('option:selected').text();
        var ward = $('#listWard2').find('option:selected').text();
        var txtAddress = $('#txtAddress').val();
        $('#txtAddress').val('Phường ' + ward + ", " + district + ", " + city);
        $('#hddDiadiem').val('Phường ' + ward + ", " + district + ", " + city);
        $('#hddSuggestTitle').val(category.replace('---', '') + ' Phường '+ward + ', ' + district + ' ' + city);
       ShowLocation();
    });
    $('#listStreet2').change(function(){
        var category = $('#listCategory2').find('option:selected').text();
        var hddSuggestTitle = $('#hddSuggestTitle').val();
        //var city = $('#listCity2').find('option:selected').text();
        var city = 'Hồ Chí Minh';
        var district = $('#listDistrict2').find('option:selected').text();
        var ward = $('#listWard2').find('option:selected').val() != -1 ? ', Phường ' + $('#listWard2').find('option:selected').text() : '';
        var street = $('#listStreet2').find('option:selected').text();
        var txtAddress = $('#txtAddress').val();
        $('#txtAddress').val('Đường ' + street + ward + ", " + district + ", " + city);
        $('#hddDiadiem').val('Đường ' + street + ward + ", " + district + ", " + city);
        
        $('#hddSuggestTitle').val(category.replace('---', '') + ' đường ' + street + ward + ' ' + district + ' ' + city);
        ShowLocation();
    });
    
    $('#btnSuggestTitle').on('click', function(){
        var suggestTitle = $('#hddSuggestTitle').val();
        var priceUnit = $('#listPriceUnit option:selected').val();
        var textPriceUnit = $('#listPriceUnit option:selected').text();
        if($('#txtPriceNumber').val()!='' && priceUnit != -1) {
            $('#txtSuggestTitle').val($('#hddSuggestTitle').val() +' Giá '+ $('#txtPriceNumber').val() + textPriceUnit);
        } else {
            $('#txtSuggestTitle').val($('#hddSuggestTitle').val());
        }
        
    });
    $('#TypeID').change(function(){
       var Type = $(this).find('option:selected').val();console.log(Type)
       if(parseInt(Type) == 1) {
            $('#type_preview div').hide();
            $('#preview_pro').show();
       } else if(parseInt(Type) == 2) {
            $('#type_preview div').hide();
            $('#preview_vip1').show();
       } else if(parseInt(Type) == 3) {
            $('#type_preview div').hide();
            $('#preview_vip2').show();
       } else if(parseInt(Type) == 4) {
            $('#type_preview div').hide();
            $('#preview_normal').show();
       }
    });
    $.RealApp.captchaRefresh('#postCaptcha');
    // $.RealApp.uploadPhoto();
    $.RealApp.postValidate();
    $.RealApp.titleLimitCharactor();
                                               
});
                                            
var count_images = 0;
var btn = document.getElementById('uploadImages'),
      progressBar = document.getElementById('progressBarImages'),
      progressOuter = document.getElementById('progressOuterImages'),
      msgBox = document.getElementById('msgBoxImages');
    var uploader = new ss.SimpleUpload({
        button: btn,
        url:  '<?=ASSET_SERVER?>upload/uploadRealEstate',
        name: 'uploadfile',
        allowedExtensions: ["jpg", "jpeg", "png", "gif", "JPG", "JPEG", "PNG", "GIF"],
        multipart: true,
        multiple: true,
        maxSize: 3072, // 3Mb
        hoverClass: 'hover',
        focusClass: 'focus',
        responseType: 'json',
        startXHR: function() {
            progressOuter.style.display = 'block'; // make progress bar visible
            this.setProgressBar( progressBar );
        },
        onExtError( filename, extension ) {
            alert('Định dạng file không hỗ trợ, vui lòng chọn hình ảnh có định dạng jpg|jpeg|png|gif.');
        },
        onSizeError( filename, fileSize ) {
            alert('Dung lượng file upload tối đa là 3Mb.');
        },
        onSubmit: function() {
            //msgBox.innerHTML = ''; // empty the message box
            //btn.innerHTML = 'Uploading...'; // change button text to "Uploading..."
            if(count_images>15) {
                alert('Bạn chỉ được upload tối đa 15 tấm hình.');
                return false;
            }    
        },
        onComplete: function( filename, response ) {
            //btn.innerHTML = 'Choose Another File';
            count_images++;
            progressOuter.style.display = 'none'; // hide progress bar when upload is completed
            
            if ( response.success === true ) {
                //msgBox.innerHTML = '<strong>' + ( filename ) + '</strong>' + ' successfully uploaded.';
                //$('#uploadImage img').attr( 'src', response.file_url );
                insertHtml = '<li id="row_images_'+count_images+'">';
                insertHtml += '<span><img src="<?=ASSET_SERVER?>uploads/images/'+response.file_name+'" width="120"></span>';
                if(count_images==1) {
                    insertHtml += '<label><input type="radio" name="image_default" value="'+count_images+'" checked="checked"> Hình đại diện</label>';
                } else {
                    insertHtml += '<label><input type="radio" name="image_default" value="'+count_images+'"> Hình đại diện</label>';
                } 
                insertHtml += '<br><input type="hidden" name="images[]" value="'+response.file_name+'"><a href="javascript:;" onclick="$(\'#row_images_'+count_images+'\').remove();">Xóa</a>';
                insertHtml += '</li>';
                $('#uploadImages').parent().before(insertHtml);
            } else {
                if ( response.msg )  {
                    msgBox.innerHTML = ( response.msg );
                } else {
                    msgBox.innerHTML = 'An error occurred and the upload failed.';
                }
            }
          },
          onError( filename, errorType, status, statusText, response, uploadBtn, fileSize ) {
            progressOuter.style.display = 'none';
            $('#uploadMultiImage').after('Error upload !');
          }
});

function removeImage(ElemID) {
    if($('#valueImage'+ElemID).val() != '') {
        $.ajax({
         url: '<?=ASSET_SERVER?>ajax/deleteImage/' + $('#valueImage'+ElemID).val(),
         type: 'get',
         success: function() {
              $('#uploadImage img').attr('src', '<?=ASSET_SERVER . 'assets/images/bg-upload-image.png'?>');
			  $('#uploadImage span').text('Click để upload ảnh');
         } ,
         onError: function() {
            alert('Error');
         }
      });
    }

    //$('#Image'+ElemID).remove();
    //if(num_image > 0) num_image--;
    /**/
}
</script>