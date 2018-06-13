<!-- _______________________Property Search option________________________ -->
						<div class="main_title2">
                            <label class="title_sidebar">Tìm kiếm</label>
                        </div>
                        
<div class="preperty_search">
						
    <form action="<?=site_url('search')?>" method="post" id="searchForm">
                                <div class="selectmenu_type_1 address">
                                    <input type="text" name="" value="" placeholder="Nhập địa điểm: ví dụ Gò Vấp" />
                                </div>
                                <div class="form-group row">
                                    <div class="col-xs-6">
                                        <div class="selectmenu_type_1 space_fix single_form">
                                            <select class="selectmenu" id="listCategory" name="category_id">
										<option selected="selected">Loại BĐS</option>
                                        <?php 
                                $real_category_main = $this->main_model->_Get_Real_Estate_Category();
                                
                         foreach($real_category_main as $category) { ?>
                                        <option value="<?=$category['id']?>" <?=$category['id']==$category_id ? 'selected':''?>><?=$category['title']?></option>
                                        <?php
                                        $sub_category = $this->main_model->_Get_Real_Estate_Category($category['id']);
                                        foreach($sub_category as $sub) {?>
                                            <option value="<?=$sub['id']?>" <?=$sub['id']==$category_id ? 'selected':''?>>-<?=$sub['title']?></option>
                                        <?php    
                                        }
                                        ?>
                                        <?php } ?>
									</select><input type="hidden" name="CatID" id="CatID" value="<?=$category_id?>" />
								</div> <!-- End .single_form -->

                                    </div>
                                    <div class="col-xs-6">
                                        <div class="selectmenu_type_2 space_fix single_form"> 
                                            <select class="selectmenu" id="listCity" name="city_id">
										<option selected="selected">Tình/Thành phố</option>
        								<?php
                                $all_city = $this->main_model->_Get_City();
                                foreach($all_city as $val) { 
                                ?>
								<option value="<?=$val['id']?>" <?=$val['id']==$city_id ? 'selected':''?>><?=$val['title']?></option>
                                <?php } ?>
									</select><input type="hidden" name="CityID" id="CityID" value="<?=$city_id==0?'-1':$city_id?>" />
								</div> <!-- End .single_form -->
                                    </div>
                                </div>
								
								<div class="form-group row">
                                    <div class="col-xs-6">
                                        <div class="selectmenu_type_2 space_fix single_form"> 
        				<select class="selectmenu" id="listDistrict">
                                            <option selected="selected">Quận/Huyện</option>
                                            <?php
                                            if($city_id) {
                                                $districts = $this->main_model->_Get_District($city_id);
                                                foreach($districts as $district) {
                                                    if($district['id'] == $district_id)
                                                        echo '<option value="'.$district['id'].'" selected>'.$district['title'].'</option>';
                                                    else
                                                        echo '<option value="'.$district['id'].'">'.$district['title'].'</option>';
                                                }
                                            }
                                            ?>
                                        </select><input type="hidden" name="DistrictID" id="DistrictID" value="<?=$district_id==0?'-1':$district_id?>" />
					</div> <!-- End .single_form -->
                                    </div>
                                    <div class="col-xs-6">
                                        
								<div class="selectmenu_type_1 single_form">
									<select class="selectmenu" id="listArea">
										<option value="-1" <?=$filter_area==-1?'selected="selected"':''?>>Diện tích</option>
                                <option value="0" <?=$filter_area==0?'selected="selected"':''?>>Không xác định</option>
								<option value="1" <?=$filter_area==1?'selected="selected"':''?>><= 30m2</a></option>
                                <option value="2" <?=$filter_area==2?'selected="selected"':''?>>30-50m2</option>
                                <option value="3" <?=$filter_area==3?'selected="selected"':''?>>50-80m2</option>
                                <option value="4" <?=$filter_area==4?'selected="selected"':''?>>80-100m2</option>
                                <option value="5" <?=$filter_area==5?'selected="selected"':''?>>100-150m2</option>
                                <option value="6" <?=$filter_area==6?'selected="selected"':''?>>150-200m2</option>
                                <option value="7" <?=$filter_area==7?'selected="selected"':''?>>200-250m2</option>
                                <option value="8" <?=$filter_area==8?'selected="selected"':''?>>250-300m2</option>
                                <option value="9" <?=$filter_area==9?'selected="selected"':''?>>300-500m2</option>
                                <option value="10" <?=$filter_area==10?'selected="selected"':''?>>> 500m2</option>
									</select><input type="hidden" name="Area" id="Area" value="<?=$filter_area?>" />
								</div> <!-- End .single_form -->
                                    </div>
                                </div>
                                
                                
								<div class="form-group row">
                                    <div class="col-xs-6">
                                        
								<div class="selectmenu_type_1 single_form">
									<select class="selectmenu" id="listPrice">
										<option value="-1" <?=$filter_price==-1?'selected="selected"':''?>>Mức giá</option>
								<option value="0" <?=$filter_price==0?'selected="selected"':''?>>Thỏa thuận</option>
								<option value="1" <?=$filter_price==1?'selected="selected"':''?>>< 500 triệu</option>
								<option value="2" <?=$filter_price==2?'selected="selected"':''?>>500-800 triệu</option>
                                <option value="3" <?=$filter_price==3?'selected="selected"':''?>>800 - 1 tỷ</option>
                                <option value="4" <?=$filter_price==4?'selected="selected"':''?>>1 - 2 tỷ</option>
                                <option value="5" <?=$filter_price==5?'selected="selected"':''?>>2 - 3 tỷ</option>
                                <option value="6" <?=$filter_price==6?'selected="selected"':''?>>3 - 5 tỷ</option>
                                <option value="7" <?=$filter_price==7?'selected="selected"':''?>>5 - 7 tỷ</option>
                                <option value="8" <?=$filter_price==8?'selected="selected"':''?>>7 - 10 tỷ</option>
                                <option value="9" <?=$filter_price==9?'selected="selected"':''?>>10 - 20 tỷ</option>
                                <option value="10" <?=$filter_price==10?'selected="selected"':''?>>20 - 30 tỷ</option>
                                <option value="11" <?=$filter_price==11?'selected="selected"':''?>>> 30 tỷ</option>
									</select><input type="hidden" name="Price" id="Price" value="<?=$filter_price?>" />
								</div> <!-- End .single_form -->
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="selectmenu_type_1 space_fix single_form">
        							<select class="selectmenu" id="listWard">
        								<option selected="selected">Phường xã</option>
        								<?php
                                                                        if($district_id) {
                                                                            $wards = $this->main_model->_Get_Ward($district_id);
                                                                            foreach($wards as $ward) {
                                                                                if($ward['id'] == $ward_id)
                                                        echo '<option value="'.$ward['id'].'" selected>'.$ward['title'].'</option>';
                                                    else
                                                        echo '<option value="'.$ward['id'].'">'.$ward['title'].'</option>';
                                                                            }
                                                                        }
                                                                        ?>
        							</select><input type="hidden" name="WardID" id="WardID" value="<?=$ward_id==0?'-1':$ward_id?>" />
        						</div> <!-- End .single_form -->
                                    </div>
                                </div>
                                
                                
								<div class="form-group row">
                                    <div class="col-xs-6">
                                        
                                <div class="selectmenu_type_1 space_fix single_form">
        							<select class="selectmenu" id="listStreet">
        								<option selected="selected">Đường Phố</option>
        							<?php
                                                                if($district_id) {
                                                                            $streets = $this->main_model->_Get_Street_By_District($district_id);
                                                                            foreach($streets as $street) {
                                                                                if($street['id'] == $street_id)
                                                        echo '<option value="'.$street['id'].'" selected>'.$street['title'].'</option>';
                                                    else
                                                        echo '<option value="'.$street['id'].'">'.$street['title'].'</option>';
                                                                            }
                                                                        }
                                                                        ?>
        							</select> <input type="hidden" name="StreetID" id="StreetID" value="<?=$street_id==0?'-1':$street_id?>" />
        						</div> <!-- End .single_form -->
                                    </div>
                                    <div class="col-xs-6">
                                    
                                <div class="selectmenu_type_1 space_fix single_form">
        							<select class="selectmenu" id="listBedroom">
        								<option selected="selected">Số phòng ngủ</option>
        								<option value="1" <?=$filter_bedroom==1?'selected="selected"':''?>>1</option>
        								<option value="2" <?=$filter_bedroom==2?'selected="selected"':''?>>2</option>
        								<option value="3" <?=$filter_bedroom==3?'selected="selected"':''?>>3</option>
                                        <option value="4" <?=$filter_bedroom==4?'selected="selected"':''?>>4</option>
                                        <option value="5" <?=$filter_bedroom==5?'selected="selected"':''?>>5</option>
        							</select> <input type="hidden" name="Bedroom" id="Bedroom" value="<?=$filter_bedroom?>" />
        						</div> <!-- End .single_form -->
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <div class="col-xs-6">
                                        
                                <div class="selectmenu_type_1 space_fix single_form">
        							<select class="selectmenu" id="listProject">
        								<option selected="selected">Dự án</option>
        								<?php 
                                $projects  = $this->main_model->_Get_Project();
                                foreach($projects as $val) { 
                                ?>
								<option value="<?=$val['id']?>" <?=isset($filter_project) && $val['id']==$filter_project ? 'selected="selected"':''?>><?=$val['title']?></option>
                                <?php } ?>
        							</select> <input type="hidden" name="ProjectID" id="ProjectID" value="<?=isset($filter_project) ? $filter_project : ''?>" />
        						</div> <!-- End .single_form -->
                                    </div>
                                    <div class="col-xs-6">
                                        <button class="search" id="buttonSearch"><i class="fa fa-search"></i> Tìm kiếm</button>
                                    </div>
                                </div>
							</form>
						</div> <!-- End .preperty_search -->