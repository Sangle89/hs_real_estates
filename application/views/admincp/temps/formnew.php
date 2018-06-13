<?php
$category_id = isset($post['category_id']) ? $post['category_id'] : 0;
$city_id = isset($post['city_id']) ? $post['city_id'] : 0;
$district_id = isset($post['district_id']) ? $post['district_id'] : 0;
$ward_id = isset($post['ward_id']) ? $post['ward_id'] : 0;
$street_id = isset($post['street_id']) ? $post['street_id'] : 0;
$project_id = isset($post['project_id']) ? $post['project_id'] : 0;

$price_number = isset($post['price_number']) ? $post['price_number'] : 0;
$price_unit = isset($post['price_unit']) ? $post['price_unit'] : 0;
$area = isset($post['area']) ? $post['area'] : 0;
$address = isset($post['address']) ? $post['address'] : '';
$mattien = isset($post['mattien']) ? $post['mattien'] : '';
$duongtruocnha = isset($post['duongtruocnha']) ? $post['duongtruocnha'] : '';
$sotang = isset($post['sotang']) ? $post['sotang'] : '';
$sophong = isset($post['sophong']) ? $post['sophong'] : '';
$sotoilet = isset($post['sotoilet']) ? $post['sotoilet'] : '';
$huongnha = isset($post['huongnha']) ? $post['huongnha'] : '';

$title = isset($post['title']) ? $post['title'] : '';
$keyword = isset($post['keywords']) ? $post['keywords'] : '';
$description = isset($post['description']) ? $post['description'] : '';
$content = isset($post['content']) ? $post['content'] : '';
$video = isset($post['video']) ? $post['video'] : '';
$type_id = isset($post['type_id']) ? $post['type_id'] : '';
$from_date = isset($post['from_date']) ? _convert_date2($post['from_date']) : '';
$to_date = isset($post['to_date']) ? _convert_date2($post['to_date']) : '';
$sort_order = isset($post['sort_order']) ? $post['sort_order'] : '';
$status = isset($post['status']) ? $post['status'] : 'active';
$create_time = isset($post['create_time']) ? _convert_date2($post['create_time']) : _convert_date2(date("Y-m-d H:i:s", time()));
$featured = isset($post['featured']) ? $post['featured'] : 0;

$views1 = isset($post['views1']) ? $post['views1'] : 0;
$views2 = isset($post['views2']) ? $post['views2'] : 0;

$create_by = isset($post['create_by']) ? $post['create_by'] : 0;

$guest_fullname = isset($post['guest_fullname']) ? $post['guest_fullname'] : '';
$guest_address = isset($post['guest_address']) ? $post['guest_address'] : '';
$guest_telephone = isset($post['guest_telephone']) ? $post['guest_telephone'] : '';
$guest_mobiphone = isset($post['guest_mobiphone']) ? $post['guest_mobiphone'] : '';
$guest_email = isset($post['guest_fullname']) ? $post['guest_email'] : '';

?>
	<div class="row">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">
            <div class="box box-default">
                <div class="box-header with-border">
              <h3 class="box-title">Select2</h3>
    
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
              </div>
            </div>
            
                <?php
            if(validation_errors()) echo '<div class="alert alert-danger fade in">'.validation_errors().'</div>';
                $action = $id ? admin_url($this->uri->segment(2) . '/change/'.$id) : admin_url($this->uri->segment(2) . '/add');
                echo form_open_multipart($action, array('method'=>'post','id'=>'myForm', 'class'=>'smart-form')); 
            ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                            <label>Danh mục</label>
                            <?=_Dropdown('category_id', $dropdown_category, $category_id)?>
                        </div>
                        <div class="form-group">
                            <label>Tỉnh/TP</label>
                            <?=_Dropdown('city_id', $dropdown_city, $city_id)?>
                        </div>
                        <div class="form-group">
                            <label>Quận/huyện</label>
                            <?=_Dropdown('district_id', $dropdown_district, $district_id)?>
                        </div>
                        <div class="form-group">
                            <label>Phường/xã</label>
                            <?=_Dropdown('ward_id', $dropdown_ward, $ward_id)?>
                        </div>
                        <div class="form-group">
                            <label>Đường phố</label>
                            <?=_Dropdown('street_id', $dropdown_street, $street_id)?>
                        </div>
                        <div class="form-group">
                            <label>Dự án</label>
                            <?=_Dropdown('project_id', $dropdown_project, $project_id)?>
                        </div>
                        <div class="form-group">
                            <label>Giá</label>
                            <?=_Input('price_number', $price_number).form_error('price_number')?>
                        </div>
                        <div class="form-group">
                            <label>Mức giá</label>
                            <?=_Dropdown('price_unit', array(
                        1 => 'Thỏa thuận',
                        2 => 'Triệu',
                        3 => 'Tỷ',
                        4 => 'Cây vàng',
                        5 => 'USD',
                        6 => 'USD/m2',
                        7 => 'Trăm nghìn/m2',
                        8 => 'Triệu/m2',
                        9 => 'Chỉ vàng/m2',
                        10 => 'Cây vàng/m2' 
                    ), $price_unit)?>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                            <label>Địa điểm</label>
                            <?=_Input('address', $address).form_error('address')?>
                        </div>
                        <div class="form-group">
                            <label>Diện tích</label>
                            <?=_Input('area', $area).form_error('area')?>
                        </div>
                        <div class="form-group">
                            <label>Mặt tiền</label>
                            <?=_Input('mattien', $mattien).form_error('mattien')?>
                        </div>
                        <div class="form-group">
                            <label>Đường trước nhà</label>
                            <?=_Input('duongtruocnha', $duongtruocnha).form_error('duongtruocnha')?>
                        </div>
                        <div class="form-group">
                            <label>Số tầng</label>
                            <?=_Input('sotang', $sotang).form_error('sotang')?>
                        </div>
                        <div class="form-group">
                            <label>Số phòng</label>
                            <?=_Input('sophong', $sophong).form_error('sophong')?>
                        </div>
                        <div class="form-group">
                            <label>Toilet</label>
                            <?=_Input('sotoilet', $sotoilet).form_error('sotoilet')?>
                        </div>
                        <div class="form-group">
                            <label>Hướng nhà</label>
                            <?=_Dropdown('huongnha', array(
                        1 => 'Không xác định',
                        2 => 'Đông',
                        3 => 'Tây',
                        4 => 'Nam',
                        5 => 'Bắc',
                        6 => 'Đông bắc',
                        7 => 'Tây bắc',
                        8 => 'Tây nam',
                        9 => 'Đông nam' 
                    ), $huongnha)?>
                        </div>
                        <div class="form-group">
                            <label>Tiêu đề</label>
                            <?=_Input('title', $title)?>
                        </div>
                        <div class="form-group">
                            <label>Từ khóa</label>
                            <?=_Input('keywords', $keyword)?>
                        </div>
                        <div class="form-group">
                            <label>Mô tả từ khóa</label>
                            <?=_Input('description', $description)?>
                        </div>
                        <div class="form-group">
                            <label>Nội dung</label>
                            <?=_TextEditor('content', $content)?>
                        </div>
                        <div class="form-group">
                            <label>Video</label>
                            <?=_Input('video', $video)?>
                        </div>
                        <div class="form-group">
                            <label>Loại tin</label>
                            <?=_Dropdown('type_id', array(
                        1 => 'Tin đặc biệt',
                        2 => 'Tin vip 1',
                        3 => 'Tin vip 2',
                        4 => 'Tin thường'
                   ), $type_id)?>
                        </div>
                        <div class="form-group">
                            <label>Thời gian</label>
                            <?=_Input_Date('from_date', $from_date) . ' - ' . _Input_Date('to_date', $to_date)?>
                        </div>
                        <div class="form-group">
                            <label>Hình ảnh</label>
                            <ul class="upload_multi_image" id="uploadMultiImage">
                                <li class="add_image">
                                    <a onclick="addImage(this, 1000);"><i class="fa fa-plus"></i><span>Thêm hình</span></a>
                                </li>
                            </ul>
                        </div>
                        <div class="form-group">
                            <label>Ngày đăng</label>
                            <?=_Input_Date('create_time', $create_time)?>
                        </div>
                        <div class="form-group">
                            <label>Thứ tự</label>
                            <?=_Input('sort_order', $sort_order)?>
                        </div>
                        <div class="form-group">
                            <label>Nổi bật</label>
                            <?=_Radio('featured', array(
                        array(
                            'title' => 'Có',
                            'value' => 1
                        ),
                        array(
                            'title' => 'Không',
                            'value' => 0
                        ),
                    ), array($featured))?>
                        </div>
                        <div class="form-group">
                            <label>Trạng thái</label>
                            <?=_Status('status', $status)?>
                        </div>
                        <div class="form-group">
                            <label>View thật</label>
                            <?=_Input('views1', $views1)?>
                        </div>
                        <div class="form-group">
                            <label>View ảo</label>
                            <?=_Input('views2', $views2)?>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>Họ tên</label>
                                    <?=_Input('guest_fullname', $guest_fullname)?>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>Địa chỉ</label>
                                    <?=_Input('guest_address', $guest_address)?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>Số điện thoại</label>
                                    <?=_Input('guest_telephone', $guest_telephone)?>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>Di động</label>
                                    <?=_Input('guest_mobiphone', $guest_mobiphone)?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <?=_Input('guest_email', $guest_email)?>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label></label>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                 echo widget_submit(array(
                    _Submit('save', 'Lưu lại','save')
                ));
                ?>
            </div>
            <?php
            echo form_close();
            ?>
            </div>
            
            
            
            <?php 
                
               
                
 CKEBasic('content');               
 ?>
		</article>
	</div>
<script src="<?php echo base_url()?>assets/plugins/ajaxupload/SimpleAjaxUploader.min.js"></script>
<script type="text/javascript">
var num_image = <?=isset($post['id']) ? $this->real_estate_model->_Count_Images($post['id']) : 0?>;
function addImage(obj, limit) {
    if(num_image < limit) {
        $.ajax({
            url: ADMIN_URL + '/real_estate/add_image',
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
<?php if($post['id']) : ?>
$(document).ready(function() {
   $.ajax({
        url: ADMIN_URL + '/real_estate/load_image/<?=$post['id']?>',
        type: 'get',
        dataType: 'html',
        success: function(html) {
            $('#uploadMultiImage li').before(html);
        },
        error: function() {
            alert('Error');
        }
   }); 
});
<?php endif; ?>
</script>