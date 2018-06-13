<section class="homepage">
    <div class="main-wrap-content">
    <h2>Tìm kiếm</h2>
    <div class="" style="margin-bottom: 10px;">
                <input type="text" name="keyword" id="search_input" value="" placeholder="Nhập từ khóa tìm kiếm" class="form-control" />
            </div>
        <form class="search_advance" method="post" action="<?=site_url('search')?>">
            <div class="row">
            <div class="col-md-3 col-xs-12">
                <div class="form-group">
                <select class="selectmenu" id="listCategory">
                <?php $real_category_main = $this->main_model->_Get_Real_Estate_Category();?>
								<option selected="selected" value="0">Loại Bất động sản</option>
								<?php foreach($real_category_main as $category) { ?>
                                <option value="<?=$category['id']?>"><?=sub_string($category['title'], 20)?></option>
                                <?php
                                $sub_category = $this->main_model->_Get_Real_Estate_Category($category['id']);
                                foreach($sub_category as $sub) {?>
                                    <option value="<?=$sub['id']?>">-<?=sub_string($sub['title'], 20)?></option>
                                <?php    
                                }
                                ?>
                                <?php } ?>
				</select>
                <input type="hidden" name="CatID" id="CatID" value="-1" />
                </div>
            </div>
            <div class="col-md-3 col-xs-12">
                <div class="form-group">
                <select class="selectmenu" id="listDistrict">
								<option selected="selected">Quận/Huyện</option>
                                <?php
                                $all_city = $this->main_model->_Get_District(1);
                                foreach($all_city as $val) { 
                                ?>
								<option value="<?=$val['id']?>"><?=sub_string($val['title'], 20)?></option>
                                <?php } ?>
							</select>
                <input type="hidden" name="DistrictID" id="DistrictID" value="-1" />
                </div>
            </div>
            <div class="col-md-3 col-xs-12">
                <div class="form-group">
                <select class="selectmenu" id="listWard">
								<option selected="selected">Phường xã</option>
								
							</select>
                 <input type="hidden" name="WardID" id="WardID" value="-1" />
                </div>
            </div>
            <div class="col-md-3 col-xs-12">
                <div class="form-group">
                <select class="selectmenu" id="listStreet">
								<option selected="selected">Đường Phố</option>
							</select>
                <input type="hidden" name="StreetID" id="StreetID" value="-1" />
                </div>
            </div>
            </div>
            <div class="row">
            <div class="col-md-3 col-xs-12">
                <div class="form-group">
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
            </div>
            <div class="col-md-3 col-xs-12">
                <div class="form-group">
                <select class="selectmenu" id="listPrice">
								<option selected="selected" value="-1">Mức giá</option>
								<option value="0">Thỏa thuận</option>
								<option value="1">Dưới 1 triệu</option>
								<option value="2">1 triệu - 2 triệu</option>
                                <option value="3">2 triệu - 3 triệu</option>
                                <option value="4">3 triệu - 5 triệu</option>
                                <option value="5">5 triệu - 7 triệu</option>
                                <option value="6">7 triệu - 10 triệu</option>
                                <option value="7">10 triệu - 15 triệu</option>
                                <option value="8">Trên 15 triệu</option>
							</select>
                            <input type="hidden" name="Price" id="Price" value="-1" />
                </div>
            </div>
            <div class="col-md-3 col-xs-12">
                <div class="form-group">
                <select class="" id="listArea">
								<option selected="selected" value="-1">Diện tích</option>
                                <option value="0">Không xác định</option>
								<option value="1">Dưới 20 m2</a></option>
                                <option value="2">20 - 30 m2</option>
                                <option value="3">30 - 50 m2</option>
                                <option value="4">50 - 60 m2</option>
                                <option value="5">60 - 70 m2</option>
                                <option value="6">70 - 80 m2</option>
                                <option value="7">80 - 90 m2</option>
                                <option value="8">90 - 100 m2</option>
                                <option value="9">Trên 100 m2</option>
							</select>
                            <input type="hidden" name="Area" id="Area" value="-1" />
                </div>
            </div>
            <div class="col-md-3 col-xs-12">
                <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-search"></i> Tìm kiếm</button>
            </div>
            </div>
        </form>  
    </div>
</section>