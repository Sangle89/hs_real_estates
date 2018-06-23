<style>

</style>
<script>
$(document).ready(function() {
    $('#button-advance-search').on('click', function() {
       $('.search_advance').toggleClass('show'); 
    });
})
</script>
<?php if(USERTYPE == 'PC') : ?>
<section class="search_top hidden-xs">
    <div class="main-wrap-content">
        <div class="inner_search">
        <div class="search_title">Tìm thuê nhà cùng Muonnha.com.vn</div>
        <div class="input-group input-group-lg">
          <input type="text" class="form-control" placeholder="Nhập địa chỉ, tên đường..." id="search_input" aria-describedby="basic-addon1">
          <span class="input-group-addon btn-search" id="basic-addon1"><i class="fa fa-search"></i></span>
          <span class="input-group-addon btn-advance" id="button-advance-search">Nâng cao</span>
        </div>
        <form class="search_advance" method="post" action="<?=site_url('search')?>">
            <div class="row">
            <div class="col-md-3">
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
            <div class="col-md-3">
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
            <div class="col-md-3">
                <select class="selectmenu" id="listWard">
								<option selected="selected">Phường xã</option>
								
							</select>
                 <input type="hidden" name="WardID" id="WardID" value="-1" />
            </div>
            <div class="col-md-3">
                <select class="selectmenu" id="listStreet">
								<option selected="selected">Đường Phố</option>
							
							</select>
        <input type="hidden" name="StreetID" id="StreetID" value="-1" />
            </div>
            </div>
            <div class="row">
            <div class="col-md-3">
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
            <div class="col-md-3">
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
            <div class="col-md-3">
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
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-search"></i> Tìm kiếm</button>
            </div>
            </div>
        </form>
        </div>
        
    </div>
</section>
<?php endif ?>
<?php if(USERTYPE == 'Mobile') : ?>
<style>
.banner {
    background-image: url(<?=base_url('theme/images/mbanner.png?v=3')?>);
	background-color:#cee7f4;
    height: 150px;
    width: 100%;
    float: left;
    background-position: bottom center;
    background-repeat: no-repeat;
    position: relative;
    padding: 20px 15px 0 15px;
}
.search-home {
    background: #fff;
    height: 40px;
    border: 0;
    border-radius: 20px;
    padding: 7px 20px;
	line-height: 40px;
	color:#222;
    z-index: 1;
    opacity: .8;
    line-height: 26px;
    font-size: 15px;
}
.search-home a {
    color: #000;
}
</style>
<section class="search-top visible-xs" style="margin-bottom: 10px;height:150px;">
    <div class="banner">
        <div class="search-home">
            <i class="fa fa-search"></i>&nbsp;<a href="<?=site_url('tim-kiem-tin-rao')?>">Tìm kiếm bất động sản cho bạn</a>
        </div>
    </div>
</section>
<?php endif ?>