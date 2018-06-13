<script>
$(document).ready(function() {
   $('#btnSearch').on('click', function() {
        var category_id = $('#CategoryID option:selected').val();
        var city_id = $('#CityID option:selected').val();
        var district_id = $('#DistrictID option:selected').val();
        var partket = $('#PartketID option:selected').val();
        var status = $('#Status option:selected').val();
        var create_by = $('#UserID option:selected').val();
        var from_date = $('#FromDate').val();
        var to_date = $('#ToDate').val();
        var unit = $('#unit option:selected').val();
        var sortby = $('#sortBy option:selected').val();
        window.location.href = '/<?=ADMIN_FOLDER?>/real_estate?category_id=' + category_id + '&city_id='+city_id+'&district_id='+district_id+'&partket='+partket+'&status='+status+'&create_by='+create_by+'&from_date='+from_date+'&to_date='+to_date+'&unit='+unit+'&sortby='+sortby; 
   }); 
});
</script>
    <div class="" style="padding: 5px 10px; background: #eeeeee;">
        <div class="pull-left">
            Tổng cộng: <?=$total?> | <?=$total_page?> trang
        </div>
        <div class="pull-right">
            <?php
            $button_add = _Button_Add(admin_url($this->uri->segment(2) . '/add'));
            echo $button_add;
            ?>
        </div>
        <div class="clearfix"></div>
    </div>
    
    <div style="margin: 10px 0;">
       <form method="post" action="" id="searchForm" enctype="multipark/form-data"> 
    <div class="row">
        <div class="col-lg-2">
            <label>Tìm theo tiêu đề: </label>
            <?php echo _Input('search_input', '', 'form-control', 'id="searchInput" data-type="search_real_estate" placeholder="Nhập từ khóa cần tìm.."'); ?>
        </div>
        <div class="col-lg-2">
            <label>Tìm theo danh mục:</label>
            <select class="form-control" name="category_id" id="CategoryID">
                <option value="-1">--Tất cả--</option>
                <?php
                $main_category = $this->category_model->_Get_All_Main();
                foreach($main_category as $cat):
                ?>
                <option value="<?=$cat['id']?>" class="level1" <?php if(isset($_GET['category_id']) && $_GET['category_id']==$cat['id']) echo 'selected="selected"'?>><?=$cat['title']?></option>
                <?php
                $sub_category = $this->category_model->_Get_All_Sub($cat['id']);
                foreach($sub_category as $sub):
                ?>
                    <option value="<?=$sub['id']?>" class="level2" <?php if(isset($_GET['category_id']) && $_GET['category_id']==$sub['id']) echo 'selected="selected"'?>>---<?=$sub['title']?></option>
                <?php endforeach; ?>
                <?php
                endforeach; ?>
            </select>
        </div>
        <div class="col-lg-2">
            <label>Tìm theo tỉnh/tp:</label>
            <select class="form-control select2" name="city_id" id="CityID">
                <option value="-1">--Tất cả--</option>
                <?php
                $city = $this->city_model->_Get_All();
                foreach($city as $row):
                ?>
                <option value="<?=$row['id']?>" <?php if(isset($_GET['city_id']) && $_GET['city_id']==$row['id']) echo 'selected="selected"'?>><?=$row['title']?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="col-lg-2">
            <label>Tìm theo quận huyện:</label>
            <select class="form-control select2" name="district_id" id="DistrictID">
                <option value="-1">--Tất cả--</option>
                <?php
                if(isset($_GET['city_id']) && $_GET['city_id']!=-1) {
                    $districts = $this->district_model->_Get_All($_GET['city_id']);
                    foreach($districts as $row) :?>
                    <option value="<?=$row['id']?>" <?php if(isset($_GET['district_id']) && $_GET['district_id']==$row['id']) echo 'selected="selected"'?>><?=$row['title']?></option>
                    <?php
                    endforeach; 
                
                }
                ?>
            </select>
        </div>
        <div class="col-lg-2">
            <label>Tìm theo gói tin:</label>
            <select class="form-control" name="partket" id="PartketID">
                <option value="-1">--Tất cả--</option>
                <option value="1" <?php if(isset($_GET['partket']) && $_GET['partket']==1) echo 'selected="selected"'?>>Tin đặc biệt</option>
                <option value="2" <?php if(isset($_GET['partket']) && $_GET['partket']==2) echo 'selected="selected"'?>>Tin vip 1</option>
                <option value="3" <?php if(isset($_GET['partket']) && $_GET['partket']==3) echo 'selected="selected"'?>>Tin vip 2</option>
                <option value="4" <?php if(isset($_GET['partket']) && $_GET['partket']==4) echo 'selected="selected"'?>>Tin thường</option>
            </select>
        </div>
        <div class="col-lg-2">
            <label>Tìm theo trạng thái:</label>
            <select class="form-control" id="Status" name="status">
                <option value="-1">--Tất cả--</option>
                <option value="active" <?php if(isset($_GET['status']) && $_GET['status']=='active') echo 'selected="selected"'?>>Đã duyệt</option>
                <option value="hide" <?php if(isset($_GET['status']) && $_GET['status']=='hide') echo 'selected="selected"'?>>Chưa duyệt</option>
                <option value="expirate" <?php if(isset($_GET['status']) && $_GET['status']=='expirate') echo 'selected="selected"'?>>Đã hết hạn</option>
                <option value="locked" <?php if(isset($_GET['status']) && $_GET['status']=='locked') echo 'selected="selected"'?>>Đang khóa</option>
                
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-2">
            <label>đơn vị:</label>
            <select class="form-control" id="unit" name="unit">
                <option value="-1">--Tất cả--</option>
                <option value="1" <?php if(isset($_GET['unit']) && $_GET['unit']==1) echo 'selected="selected"'?>>Triệu/tháng</option>
                <option value="2" <?php if(isset($_GET['unit']) && $_GET['unit']==2) echo 'selected="selected"'?>>Nghìn/tháng</option>
                <option value="3" <?php if(isset($_GET['unit']) && $_GET['unit']==3) echo 'selected="selected"'?>>Nghìn/m2/tháng</option>
            </select>
        </div>
        <div class="col-lg-2">
            <label>Tìm theo user:</label>
            <select class="form-control select2" name="create_by" id="UserID">
                <option value="-1">--Tất cả--</option>
                <option value="0">Khách vãng lai</option>
                <?php
                $users = $this->ion_auth->users()->result_array();
                foreach($users as $row):
                ?>
                <option value="<?=$row['id']?>" <?php if(isset($_GET['create_by']) && $_GET['create_by']==$row['id']) echo 'selected="selected"'?>><?=$row['email']?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-lg-2">
            <label>Từ ngày: </label>
            <input type="text" name="from_date" id="FromDate" class="form-control datepicker" value="<?=isset($_GET['from_date'])?$_GET['from_date']:''?>" />
        </div>
        <div class="col-lg-2">
            <label>Đến ngày: </label>
            <input type="text" name="to_date" id="ToDate" class="form-control datepicker" value="<?=isset($_GET['to_date'])?$_GET['to_date']:''?>" />
        </div>
        <div class="col-lg-2">
            <label>Sắp xếp:</label>
            <select class="form-control" id="sortBy" name="sortby">
                <option value="-1">--Mặc định--</option>
                <option value="price_asc" <?php if(isset($_GET['sortby']) && $_GET['sortby']=='price_asc') echo 'selected="selected"'?>>Giá tăng dần</option>
                <option value="price_desc" <?php if(isset($_GET['sortby']) && $_GET['sortby']=='price_desc') echo 'selected="selected"'?>>Giá giảm dần</option>
            </select>
        </div>
        <div class="col-lg-2">
            <label>&nbsp;</label>
            <button type="button" class="btn btn-danger btn-block" id="btnSearch">Tìm kiếm</button>
        </div>
    </div>
    </form>
    
    </div>
    <!-- row -->
	<div class="row">

		<!-- NEW WIDGET START -->
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">
            
        <?php
        echo _Show_Message('success', $this->session->flashdata('message'));
        ?>
        <?php 
            echo form_open_multipart(current_url(),array('method'=>'post'));
            ?>
            
            <table class="table table-bordered table-hover table-striped table-list" id="tableList">
                <thead>
                    <tr>
                        <th>Mã tin</th>
                        <th>Tiêu đề</th>
                        <th class="center">Loại tin</th>
                        <th class="center">Ngày tạo</th>
                        <th class="center">Trạng thái</th>
                        <th class="center">Nổi bật</th>
                        <th class="center">Xem (thật/ảo)</th>
                        <th class="center">Đăng bởi</th>
                        <th class="center">Tùy chọn</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(!empty($category)):
                    foreach($category as $val) :
                        if($val['type_id'] == 1)
                                    $class = '<span class="label label-danger">Vip đặc biệt</span>';
                                elseif($val['type_id'] == 2) 
                                     $class = '<span class="label label-warning">vip 1</span>';
                                elseif($val['type_id'] == 3)
                                    $class = '<span class="label label-primary">vip 2</span>';
                                else
                                    $class = '<span class="label label-info">Tin thường</span>';
                        
                        if($val['status']=='active') $status = '<i class="fa fa-check-square" style="color:#3c8dbc"></i>';
                        else $status = '<i class="fa fa-times" style="color:red"></i>';
        				
        				if($val['featured']==1) $featured = '<i class="fa fa-check-square" style="color:#3c8dbc"></i>';
                        else $featured = '<i class="fa fa-times" style="color:red"></i>';
        				
                        $view1 = number_format($val['views1']);
                        $view2 = number_format($val['views2']);
                        
                        $category = $this->category_model->_Get_By_Id($val['category_id']);
                        $city = $this->city_model->_Get_By_Id($val['city_id']);
                        $district = $this->district_model->_Get_By_Id($val['district_id']);
                        $area = $val['area'] ;
                        $price = $val['price_number']. _Price_Label($val['price_unit']);
                        $guest_name = $val['guest_fullname'];
                        $guest_mobiphone = $val['guest_mobiphone'];
                    ?>
                    <tr id="row<?=$val['id']?>">
                        <td><?=$val['id']?></td>
                        <td><a href="<?=site_url($val['alias'])?>" target="_blank" title="Xem chi tiết"><?php echo $val['title']?></a><br />
                            Nhóm tin: <strong><?=$category['title']?></strong><br />
                            Khu vực : <strong><?=$district['title'].', '.$city['title']?></strong><br />
                            Giá: <strong><?=$price?></strong><br />
                            Diện tích: <strong><?=$area?>m2</strong><br />
                            Tên liên hệ: <strong><?=$guest_name?></strong><br />
                            Số điện thoại: <strong><?=$guest_mobiphone?></strong><br />
                        </td>
                        <td class="center"><?=$class?></td>
                        <td class="center"><?=_Format_Date($val['create_time'])?></td>
                        <td class="center">
                        <?php if($val['status']=='active'):?>
                        <a href="<?=admin_url('real_estate/status/'.$row['id'].'/hide')?>" class="label label-success">Hiện</a>
                        <?php else: ?>
                        <a href="<?=admin_url('real_estate/status/'.$row['id'].'/active')?>" class="label label-danger">Ẩn</a>
                        <?php endif; ?>
                        </td>
                        <td class="center">
                        <?php if($val['featured']=='active'):?>
                        <a href="<?=admin_url('real_estate/featured/'.$row['id'].'/hide')?>" class="label label-success">Có</a>
                        <?php else: ?>
                        <a href="<?=admin_url('real_estate/featured/'.$row['id'].'/active')?>" class="label label-danger">Không</a>
                        <?php endif; ?>
                        </td>
                        <td  class="center"><?=$view1.' / '.$view2?></td>
                        <td class="center"><?=$val['post_by']?></td>
                        <td class="center">
                        <a class="btn btn-warning btn-sm" href="<?=admin_url($this->uri->segment(2) . '/change/' . $val['id'])?>"><i class="fa fa-pencil"></i> Sửa</a>&nbsp|&nbsp;
                        <a class="btn btn-danger btn-sm" href="<?=admin_url($this->uri->segment(2) . '/delete/' . $val['id'])?>" onclick="return confirmDelete();"><i class="fa fa-trash"></i> Xóa</a>
                        </td>
                    </tr>
                    <?php endforeach; 
                    else:
                    ?>
                    <tr>
                        <td class="center" colspan="8">Không có dữ liệu</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            
        <?php
        echo form_close();
       
        echo $pagination;
        ?>
		</article>
		<!-- WIDGET END -->

	</div>

	<!-- end row -->