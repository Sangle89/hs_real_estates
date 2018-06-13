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
    <div class="panel-body">
        <form action="<?=site_url('search')?>" method="post" id="searchForm">
            <div class="form-group">
                <input type="text" name="keyword" value="" placeholder="Nhập từ khóa tìm kiếm" class="form-control" />
            </div>
                        <div class="form-group">
                        <?php
                        $real_category_main = $this->main_model->_Get_Real_Estate_Category();
                        ?>
							<select class="form-control" id="listCategory" name="CatID">
								<option selected="selected" value="-1">Loại Bất động sản</option>
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
                        </div>
                        <div class="form-group">
							<select class="form-control" id="listDistrict" name="DistrictID">
								<option value="-1" selected="selected">Quận/Huyện</option>
                                <?php
                                $all_city = $this->main_model->_Get_District(1);
                                foreach($all_city as $val) { 
                                ?>
								<option value="<?=$val['id']?>"><?=sub_string($val['title'], 20)?></option>
                                <?php } ?>
							</select>
                        </div>
                        <div class="form-group">
							<select class="form-control" id="listWard" name="WardID">
								<option value="-1" selected="selected">Phường xã</option>
							</select>
                        </div>
						<div class="form-group">
							<select class="form-control" id="listStreet" name="StreetID">
								<option value="-1" selected="selected">Đường Phố</option>
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
                        </div>
                        <div class="form-group">
							<select class="form-control" id="listArea" name="Area">
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