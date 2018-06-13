<style>
#searchForm input[type="text"] {
    height:33px;
}
#searchForm .form-group{
    margin-bottom: 10px;
}
#searchForm .ui-state-default{
    font-size:13px;
}
.ui-menu .ui-menu-item{
    font-size:13px;
}
</style>
<div class="panel panel-default search-box" style="margin-bottom: 15px;">
    <div class="panel-heading boxed-heading-title" style="background: #38a345;color:#fff;text-align: center;">Tìm kiếm nhà cho thuê</div>
    <div class="panel-body" style="background: #e6e6fa;">
        <form action="<?=site_url('search')?>" method="post" id="searchForm">
            <div class="form-group">
                <input type="text" name="keyword" id="search_input" value="" placeholder="Nhập từ khóa tìm kiếm" class="form-control" />
            </div>
                        <div class="form-group">
                        <?php
                        $real_category_main = $this->main_model->_Get_Real_Estate_Category();
                        ?>
							<select class="form-control" id="listCategory" name="CatID">
								<option selected="selected" value="-1">Loại Bất động sản</option>
								<?php foreach($real_category_main as $category) { ?>
                                <option <?php if(isset($category_id) && $category['id']==$category_id) echo 'selected="selected"'?> value="<?=$category['id']?>"><?=sub_string($category['title'], 20)?></option>
                                <?php
                                $sub_category = $this->main_model->_Get_Real_Estate_Category($category['id']);
                                foreach($sub_category as $sub) {?>
                                    <option value="<?=$sub['id']?>" <?php if(isset($category_id) && $sub['id']==$category_id) echo 'selected="selected"'?>>-<?=sub_string($sub['title'], 20)?></option>
                                <?php    
                                }
                                ?>
                                <?php } ?>
							</select>
                        </div>
                        <div class="form-group">
							<select class="form-control" id="listDistrict" name="DistrictID">
								<option value="-1" selected="selected">Quận/Huyện</option>
                                <?php
                                $all_city = $this->main_model->_Get_District(1);
                                foreach($all_city as $val) { 
                                ?>
								<option value="<?=$val['id']?>" <?=isset($district_id) && $val['id'] == $district_id ? 'selected="selected"':''?>><?=sub_string($val['title'], 20)?></option>
                                <?php } ?>
							</select>
                        </div>
                        <div class="form-group">
							<select class="form-control" id="listWard" name="WardID">
								<option value="-1" selected="selected">Phường xã</option>
                                <?php
                                if($district_id) {
                                $wards = $this->main_model->_Get_Ward($district_id);
                                foreach($wards as $ward) {
                                if(isset($ward_id) && $ward['id'] == $ward_id)
                                echo '<option value="'.$ward['id'].'" selected>'.$ward['title'].'</option>';
                                else
                                echo '<option value="'.$ward['id'].'">'.$ward['title'].'</option>';                                      }
                                }?>
							</select>
                        </div>
						<div class="form-group">
							<select class="form-control" id="listStreet" name="StreetID">
								<option value="-1" selected="selected">Đường Phố</option>
       	                        <?php
                                 if($district_id) {
                                 $streets = $this->main_model->_Get_Street_By_District($district_id);
                                 foreach($streets as $street) {
                                 if(isset($street_id) && $street['id'] == $street_id)
                                 echo '<option value="'.$street['id'].'" selected>'.$street['title'].'</option>';
                                 else
                                 echo '<option value="'.$street['id'].'">'.$street['title'].'</option>';
                                 }
                                 }
                                 ?>
							</select>
                        </div>
                        <div class="form-group">
							<select class="form-control" id="listProject" name="ProjectID">
								<option value="-1" selected="selected">Dự án</option>
                                <?php
                                $all_project = $this->main_model->_Get_Project();
                                foreach($all_project as $val) { 
                                ?>
								<option value="<?=$val['id']?>"><?=sub_string($val['title'], 20)?></option>
                                <?php } ?>
							</select>
                        </div>
						<div class="form-group">
							<select class="form-control" id="listPrice" name="Price">
								<option selected="selected" value="-1">Mức giá</option>
								<option value="0" <?=$filter_price==0?'selected="selected"':''?>>Thỏa thuận</option>
								<option value="1" <?=$filter_price==1?'selected="selected"':''?>>Dưới 1 triệu</option>
								<option value="2" <?=$filter_price==2?'selected="selected"':''?>>1 triệu - 2 triệu</option>
                                <option value="3" <?=$filter_price==3?'selected="selected"':''?>>2 triệu - 3 triệu</option>
                                <option value="4" <?=$filter_price==4?'selected="selected"':''?>>3 triệu - 5 triệu</option>
                                <option value="5" <?=$filter_price==5?'selected="selected"':''?>>5 triệu - 7 triệu</option>
                                <option value="6" <?=$filter_price==6?'selected="selected"':''?>>7 triệu - 10 triệu</option>
                                <option value="7" <?=$filter_price==7?'selected="selected"':''?>>10 triệu - 15 triệu</option>
                                <option value="8" <?=$filter_price==8?'selected="selected"':''?>>Trên 15 triệu</option>
							</select>
                        </div>
                        <div class="form-group">
							<select class="form-control" id="listArea" name="Area">
								<option selected="selected" value="-1">Diện tích</option>
                                <option value="0" <?=$filter_area==0?'selected="selected"':''?>>Không xác định</option>
        								<option value="1" <?=$filter_area==1?'selected="selected"':''?>>Dưới 20 m2</a></option>
                                        <option value="2" <?=$filter_area==2?'selected="selected"':''?>>20 - 30 m2</option>
                                        <option value="3" <?=$filter_area==3?'selected="selected"':''?>>30 - 50 m2</option>
                                        <option value="4" <?=$filter_area==4?'selected="selected"':''?>>50 - 60 m2</option>
                                        <option value="5" <?=$filter_area==5?'selected="selected"':''?>>60 - 70 m2</option>
                                        <option value="6" <?=$filter_area==6?'selected="selected"':''?>>70 - 80 m2</option>
                                        <option value="7" <?=$filter_area==7?'selected="selected"':''?>>80 - 90 m2</option>
                                        <option value="8" <?=$filter_area==8?'selected="selected"':''?>>90 - 100 m2</option>
                                        <option value="9" <?=$filter_area==9?'selected="selected"':''?>>Trên 100 m2</option>
							</select>
                        </div>
                        <div class="form-group">
                                <select class="form-control" id="listDirection" name="Direction">
                                    <option value="-1">Hướng nhà</option>
                                    <option value="1">Không xác định</option>
                                    <option value="2">Đông</option>
                                    <option value="3">Tây</option>
                                    <option value="4">Nam</option>
                                    <option value="5">Bắc</option>
                                    <option value="6">Đông-Bắc</option>
                                    <option value="7">Tây-Bắc</option>
                                    <option value="8">Tây-Nam</option>
                                    <option value="9">Đông-Nam</option>
                                </select>
                        </div>
						<input type="hidden" id="searchUrl" value="" />
                        <label id="searchError" style="display: none;text-align: center;color:red;display: block;"></label>
						<div class="text-center"><button class="btn btn-warning btn-block" id="buttonSearch"><i class="fa fa-search"></i> Tìm kiếm</button>
                        </div>
						<div class="clearfix"></div>
                       
					</form>
                     <div id="search-loading" class="loading" style="display: none;"></div>
     </div>
</div>