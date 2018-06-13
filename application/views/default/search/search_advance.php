<!-- _______________________Property Search option________________________ -->
						<div class="main_title2">
                            <h3 style="margin-top: 0;">Tìm kiếm</h3>
                        </div>
                        <div class="preperty_search">
							
							<form action="#">
                                <div class="selectmenu_type_1 address">
                                    <input type="text" name="" value="" placeholder="Nhập địa điểm: ví dụ Hà Nội" />
                                </div>
								<div class="selectmenu_type_1 space_fix single_form">
                                <select class="selectmenu" id="listCategory">
									<option selected="selected">Loại BĐS</option>
                                        <?php
                                $real_category_main = $this->main_model->_Get_Real_Estate_Category();
                         foreach($real_category_main as $category) { ?>
                                        <option value="<?=$category['id']?>"><?=$category['title']?></option>
                                        <?php
                                        $sub_category = $this->main_model->_Get_Real_Estate_Category($category['id']);
                                        foreach($sub_category as $sub) {?>
                                            <option value="<?=$sub['id']?>">---<?=$sub['title']?></option>
                                        <?php    
                                        }
                                        ?>
                                        <?php } ?>
									</select>
								</div> <!-- End .single_form -->

								<div class="selectmenu_type_2 space_fix single_form"> 
									<select class="selectmenu" id="listCity">
										<option selected="selected">Tình/Thành phố</option>
        								<?php
                                $all_city = $this->main_model->_Get_City();
                                foreach($all_city as $val) { 
                                ?>
								<option value="id"><?=$val['title']?></option>
                                <?php } ?>
									</select>
								</div> <!-- End .single_form -->

								<div class="selectmenu_type_2 space_fix single_form"> 
									<select class="selectmenu" id="listDistrict">
										<option selected="selected">Quận Huyện</option>
								<option>Quận 1</option>
								<option>Quận 2</option>
									</select>
								</div> <!-- End .single_form -->

								<div class="selectmenu_type_1 single_form">
									<select class="selectmenu" id="listArea">
										<option selected="selected" value="-1">Diện tích</option>
                                <option value="0">Không xác định</option>
								<option value="1"><= 30m2</a></option>
                                <option value="2">30-50m2</option>
                                <option value="3">50-80m2</option>
                                <option value="4">80-100m2</option>
                                <option value="5">100-150m2</option>
                                <option value="6">150-200m2</option>
                                <option value="7">200-250m2</option>
                                <option value="8">250-300m2</option>
                                <option value="9">300-500m2</option>
                                <option value="10">> 500m2</option>
									</select>
								</div> <!-- End .single_form -->

								<div class="selectmenu_type_1 single_form">
									<select class="selectmenu" id="listPrice">
											<option selected="selected" value="-1">Mức giá</option>
								<option value="0">Thỏa thuận</option>
								<option value="1">< 500 triệu</option>
								<option value="2">500-800 triệu</option>
                                <option value="3">800 - 1 tỷ</option>
                                <option value="4">1 - 2 tỷ</option>
                                <option value="5">2 - 3 tỷ</option>
                                <option value="6">3 - 5 tỷ</option>
                                <option value="7">5 - 7 tỷ</option>
                                <option value="8">7 - 10 tỷ</option>
                                <option value="9">10 - 20 tỷ</option>
                                <option value="10">20 - 30 tỷ</option>
                                <option value="11">> 30 tỷ</option>
									</select>
								</div> <!-- End .single_form -->
                                <div id="searchAdvance" style="display: none;">
                                    <div class="selectmenu_type_1 space_fix single_form">
        							<select class="selectmenu" id="listWard">
        								<option selected="selected">Phường xã</option>
        								
        							</select>
        						</div> <!-- End .single_form -->
        
        						
                                <div class="selectmenu_type_1 space_fix single_form">
        							<select class="selectmenu" id="listStreet">
        								<option selected="selected">Đường Phố</option>
        								
        							</select>
        						</div> <!-- End .single_form -->
                                
                                <div class="selectmenu_type_1 space_fix single_form">
        							<select class="selectmenu" id="listBedroom">
        								<option selected="selected">Số phòng ngủ</option>
        							<option value="1">1</option>
        								<option value="2">2</option>
        								<option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
        							</select>
        						</div> <!-- End .single_form -->
                                
                                <div class="selectmenu_type_1 space_fix single_form">
        							<select class="selectmenu" id="listProject">
        								<option selected="selected">Dự án</option>
        								<?php 
                                $projects  = $this->main_model->_Get_Project();
                                foreach($projects as $val) { 
                                ?>
								<option value="<?=$val['id']?>"><?=$val['title']?></option>
                                <?php } ?>
        							</select>
        						</div> <!-- End .single_form -->
                                </div>
                                
                                <div class="advance_search_group">
                                    <a id="btnSearchAdvance" rel="nofollow" class="advance_search"><i class="fa fa-cog"></i> Tìm nâng cao</a>
                                    <button class="search"><i class="fa fa-search"></i> Tìm</button>
                                    <div class="clearfix"></div>
                                </div>
                                
                                
							</form>
						</div> <!-- End .preperty_search -->