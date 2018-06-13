<form class="search-form" method="post" action="<?=base_url('search')?>"> 
                        <div class="row">
                            <div class="col-md-8 col-xs-6">
                                <!--<div class="input-group pull-left">
                                    <input class="form-control" name="s" type="text" placeholder="Nhập từ khóa tìm kiếm..." />
                                    <span class="input-group-addon" onClick="$('.search-form').submit();"><i class="fa fa-search"></i></span>
                                </div>-->
                            </div>
                            <div class="col-md-4 col-xs-6">
                                <a class="btn btn-primary btn-advance-search" role="button" data-toggle="" href="#advanceSearchCollapse" aria-expanded="false" aria-controls="advanceSearchCollapse">Tìm kiếm nâng cao <b class="caret"></b></a>
                            </div>
                        </div>
                        <div class="collapse" id="advanceSearchCollapse">
                            <div class="row">
                                            <div class="col-md-4">
                                            <?php
                                            $real_category_main = $this->main_model->_Get_Real_Estate_Category();
                                            ?>
                                                <select class="selectmenu" id="listCategory">
                								<option selected="selected" value="0">Loại Bất động sản</option>
                								<?php foreach($real_category_main as $category) { ?>
                                                <option value="<?=$category['id']?>" <?php if($category['id']==$category_id) echo 'selected="selected"'?>><?=sub_string($category['title'], 20)?></option>
                                                <?php
                                                $sub_category = $this->main_model->_Get_Real_Estate_Category($category['id']);
                                                foreach($sub_category as $sub) {?>
                                                    <option value="<?=$sub['id']?>" <?php if(isset($category_id) && $sub['id']==$category_id) echo 'selected="selected"'?>>-<?=sub_string($sub['title'], 20)?></option>
                                                <?php    
                                                }
                                                ?>
                                                <?php } ?>
                							</select>
                                            <input type="hidden" name="CatID" id="CatID" value="<?=isset($category_id) ? $category_id : '-1'?>" />
                                            </div>
                                            
                                            <div class="col-md-4">
                                                <select class="selectmenu" id="listDistrict">
                    								<option selected="selected" value="0">Quận/Huyện</option>
                                                    <?php
                                $all_city = $this->main_model->_Get_District(1);
                                foreach($all_city as $val) { 
                                ?>
								<option value="<?=$val['id']?>" <?=isset($district_id) && $val['id'] == $district_id ? 'selected="selected"':''?>><?=sub_string($val['title'], 20)?></option>
                                <?php } ?>
                    							</select>
                                                <input type="hidden" name="DistrictID" id="DistrictID" value="<?php if(!isset($district_id)) echo '-1'; else echo $district_id; ?>" />
                                            </div>
                                  <div class="col-md-4">
                                    <select class="selectmenu" id="listWard">
        								<option selected="selected">Phường xã</option>
        								<?php
                                        if($district_id) {
                                                                            $wards = $this->main_model->_Get_Ward($district_id);
                                                                            foreach($wards as $ward) {
                                                                                if(isset($ward_id) && $ward['id'] == $ward_id)
                                                        echo '<option value="'.$ward['id'].'" selected>'.$ward['title'].'</option>';
                                                    else
                                                        echo '<option value="'.$ward['id'].'">'.$ward['title'].'</option>';
                                                                            }
                                        }?>
        							</select>
                                     <input type="hidden" name="WardID" id="WardID" value="<?php if(!isset($ward_id)) echo '-1'; else echo $ward_id; ?>" />
                                </div>          
                           </div>
                           <div class="row">
                                <div class="col-md-4">
                                    <select class="selectmenu" id="listStreet">
        								<option selected="selected">Đường Phố</option>
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
                                     <input type="hidden" name="StreetID" id="StreetID" value="<?php if(!isset($street_id)) echo '-1'; else echo $street_id; ?>" />
                                </div>
                                <div class="col-md-4">
                                    <select class="selectmenu" id="listPrice">
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
                                    <input type="hidden" name="Price" id="Price" value="<?php if(!isset($filter_price)) echo '-1'; else echo $filter_price; ?>" />
                                </div>
                                <div class="col-md-4">
                                    <select class="selectmenu" id="listArea">
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
                                    <input type="hidden" name="Area" id="Area" value="<?php if(!isset($filter_area)) echo '-1'; else echo $filter_area; ?>" />
                                </div>
                           </div>
                           <div class="row">
                                <div class="col-md-4">
                                    <select class="selectmenu" id="listProject">
        								<option selected="selected">Dự án</option>
                                        <?php
                                        $all_project = $this->main_model->_Get_Project();
                                        foreach($all_project as $val) { 
                                        ?>
        								<option value="<?=$val['id']?>"><?=sub_string($val['title'], 20)?></option>
                                        <?php } ?>
        							</select>
                                    <input type="hidden" name="ProjectID" id="ProjectID" value="-1" />
                                </div>
                                <div class="col-md-4">
                                    <select class="" id="listDirection">
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
                                    <input type="hidden" name="Direction" id="Direction" value="-1" />
                                </div>
                                <div class="col-md-4 text-center">
                                    <button type="submit" style="margin: 0;" class="btn btn-primary btn-block"><i class="fa fa-search"></i> Tìm kiếm</button>   
                                </div>
                           </div>
                                        
                        </div>
                        
                    </form>