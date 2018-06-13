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
$content = isset($post['content']) ? str_replace("<br /><br />", "<br />", nl2br($post['content'])) : '';
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

$tag1 = isset($post['tag1']) ? $post['tag1'] : '';
$tag2 = isset($post['tag2']) ? $post['tag2'] : '';
$tag3 = isset($post['tag3']) ? $post['tag3'] : '';
$tag4 = isset($post['tag4']) ? $post['tag4'] : '';
$tag5 = isset($post['tag5']) ? $post['tag5'] : '';
$tag6 = isset($post['tag6']) ? $post['tag6'] : '';
?>
	<div class="row">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">
            <div class="box box-primary">
                <div class="box-header with-border">
              <h3 class="box-title">Đăng tin</h3>
    
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              </div>
            </div>
            
                <?php
                echo validation_errors();
            //if(validation_errors()) echo '<div class="alert alert-danger fade in">'.validation_errors().'</div>';
                $action = $id ? admin_url($this->uri->segment(2) . '/change/'.$id) : admin_url($this->uri->segment(2) . '/add');
                echo form_open_multipart($action, array('method'=>'post','id'=>'myForm', 'class'=>'smart-form')); 
            ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                            <label>Danh mục <span class="required">*</span></label>
                            <?=_Dropdown('category_id', $dropdown_category, $category_id)?>
                        </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                            
                        <div class="form-group">
                            <label>Dự án</label>
                            <?=_Dropdown('project_id', $dropdown_project, $project_id)?>
                        </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                            
                        <div class="form-group">
                            <label>Tỉnh/TP <span class="required">*</span></label>
                            <?=_Dropdown('city_id', $dropdown_city, $city_id)?>
                        </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                            
                        <div class="form-group">
                            <label>Quận/huyện <span class="required">*</span></label>
                            <?=_Dropdown('district_id', $dropdown_district, $district_id)?>
                        </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                            
                        <div class="form-group">
                            <label>Phường/xã</label>
                            <?=_Dropdown('ward_id', $dropdown_ward, $ward_id)?>
                        </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                            
                        <div class="form-group">
                            <label>Đường phố</label>
                            <?=_Dropdown('street_id', $dropdown_street, $street_id)?>
                        </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                            <label>Giá <span class="required">*</span></label>
                            <?=_Input('price_number', $price_number).form_error('price_number')?>
                        </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                            
                        <div class="form-group">
                            <label>Mức giá <span class="required">*</span></label>
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
                        </div>
                        
                        <div class="form-group">
                            <label>Tiêu đề <span class="required">*</span></label>
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
                            <label>Nội dung <span class="required">*</span></label>
                            <?=_TextEditor('content', $content)?>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6 col-xs-6">
                                    <label>Từ khóa 1</label>
                                    <?=_Input('tag1', $tag1)?>
                                </div>
                                <div class="col-md-6 col-xs-6">
                                    <label>Từ khóa 2</label>
                                    <?=_Input('tag2', $tag2)?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-xs-6">
                                    <label>Từ khóa 3</label>
                                    <?=_Input('tag3', $tag3)?>
                                </div>
                                <div class="col-md-6 col-xs-6">
                                    <label>Từ khóa 4</label>
                                    <?=_Input('tag4', $tag4)?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-xs-6">
                                    <label>Từ khóa 5</label>
                                    <?=_Input('tag5', $tag5)?>
                                </div>
                                <div class="col-md-6 col-xs-6">
                                    <label>Từ khóa 6</label>
                                    <?=_Input('tag6', $tag6)?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                            
                        <div class="form-group">
                            <label>Địa điểm</label>
                            <?=_Input('address', $address).form_error('address')?>
                        </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                            
                        <div class="form-group">
                            <label>Diện tích</label>
                            <?=_Input('area', $area).form_error('area')?>
                        </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                            <label>Mặt tiền</label>
                            <?=_Input('mattien', $mattien).form_error('mattien')?>
                        </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                            <label>Đường trước nhà</label>
                            <?=_Input('duongtruocnha', $duongtruocnha).form_error('duongtruocnha')?>
                        </div>
                            </div>
                        </div>
                    <div class="row">
                            <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                            <label>Số tầng</label>
                            <?=_Input('sotang', $sotang).form_error('sotang')?>
                        </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                            
                        
                        <div class="form-group">
                            <label>Số phòng ngủ</label>
                            <?=_Input('sophong', $sophong).form_error('sophong')?>
                        </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                            
                        <div class="form-group">
                            <label>Toilet</label>
                            <?=_Input('sotoilet', $sotoilet).form_error('sotoilet')?>
                        </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                            
                        <div class="form-group">
                            <label>Hướng nhà</label>
                            <?=_Dropdown('huongnha', array(
                        1 => 'Không xác định',
                        2 => 'Đông',
                        3 => 'Tây',
                        4 => 'Nam',
                        5 => 'Bắc',
                        6 => 'Đông-Bắc',
                        7 => 'Tây-Bắc',
                        8 => 'Tây-Nam',
                        9 => 'Đông-Nam' 
                    ), $huongnha)?>
                        </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                            <label>Loại tin <span class="required">*</span></label>
                            <?=_Dropdown('type_id', array(
                        1 => 'Tin đặc biệt',
                        2 => 'Tin vip 1',
                        3 => 'Tin vip 2',
                        4 => 'Tin thường'
                   ), $type_id)?>
                        </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                            <label>Thời gian</label><br />
                            <?=_Input_Date('from_date', $from_date) . ' - ' . _Input_Date('to_date', $to_date)?>
                        </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                            <label>Ngày đăng</label><br />
                            <?=_Input_Date('create_time', $create_time)?>
                        </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                            
                        <div class="form-group">
                            <label>Thứ tự</label><br />
                            <?=_Input('sort_order', $sort_order)?>
                        </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                            
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
                            </div>
                            <div class="col-lg-6 col-md-6">
                            
                        <div class="form-group">
                            <label>Trạng thái</label>
                            <?=_Status('status', $status)?>
                        </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                            
                        <div class="form-group">
                            <label>View thật</label>
                            <?=_Input('views1', $views1)?>
                        </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                            
                        <div class="form-group">
                            <label>View ảo</label>
                            <?=_Input('views2', $views2)?>
                        </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Video</label>
                            <?=_Input('video', $video)?>
                        </div>
                        
                        
                        <div class="form-group">
                            <label>Hình ảnh</label>
                            <div id="progressOuterImages" class="progress progress-striped active" style="display:none;">
    <div id="progressBarImages" class="progress-bar progress-bar-success"  role="progressBarImage" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
</div>
<div id="msgBoxImages"></div>
                            <ul class="upload_multi_image" id="uploadMultiImage">
								<?php
                                        $count = 1;
                                        foreach($images as $image) :
                                        ?>
                                        <li id="row_images_<?=$count?>"><span><img src="<?=base_url()?>/uploads/images/<?=$image['image']?>" width="120"></span>
                                        <label><input type="radio" name="image_default" value="<?=$count?>" <?=$image['is_default']==1?'checked="checked"':''?>> Hình đại diện</label>
                                        <br><input type="hidden" name="images[]" value="<?=$image['image']?>"><a href="javascript:;" onclick="$('#row_images_<?=$count?>').remove();">Xóa</a>
                                        </li>
                                        <?php 
                                        $count++;
                                        endforeach;?>
                                <li class="add_image"><a id="uploadImages" style="display:block"><i class="fa fa-plus"></i><span>Upload hình</span></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <label>Người đăng tin <span class="required">*</span></label>
                                    <?=_Dropdown('create_by', $dropdown_user, $create_by).'<span id="ajaxLoading" style="display:none;">Loading...</span>'?>
                                </div>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>Họ tên <span class="required">*</span></label>
                                    <?=_Input('guest_fullname', $guest_fullname)?>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>Địa chỉ <span class="required">*</span></label>
                                    <?=_Input('guest_address', $guest_address)?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>Số điện thoại <span class="required">*</span></label>
                                    <?=_Input('guest_telephone', $guest_telephone)?>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>Di động <span class="required">*</span></label>
                                    <?=_Input('guest_mobiphone', $guest_mobiphone)?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>Email <span class="required">*</span></label>
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
 CKEditorReplace('content');               
 ?>
		</article>
	</div>
<script src="<?php echo base_url()?>assets/plugins/ajaxupload/SimpleAjaxUploader.min.js"></script>
<script type="text/javascript">

var count_images =  <?=isset($post['id']) ? $this->real_estate_model->_Count_Images($post['id']) : 0?>;
var btn = document.getElementById('uploadImages'),
      progressBar = document.getElementById('progressBarImages'),
      progressOuter = document.getElementById('progressOuterImages'),
      msgBox = document.getElementById('msgBoxImages');
    var uploader = new ss.SimpleUpload({
        button: btn,
        url:  '<?= site_url()?>admincp/common/uploadRealEstate',
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
                insertHtml += '<span><img src="' + BASE_URL + 'uploads/images/'+response.file_name+'" width="120"></span>';
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
            alert(statusText);
            //msgBox.innerHTML = 'Unable to upload file 1';
          }
});

function removeImage(ElemID) {
  
    if($('#valueImage'+ElemID).val() != '') {
        $.ajax({
         url: 'ajax/deleteImage/' + $('#valueImage'+ElemID).val(),
         type: 'get',
         success: function() {
              $('#uploadImage img').attr('src', '<?=base_url('assets/images/bg-upload-image.png')?>');
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