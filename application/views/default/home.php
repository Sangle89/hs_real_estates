<script type="text/javascript" src="<?=base_url()?>theme/js/jquery-ui.min.js"></script>
<style>
.homepage .panel{background: transparent;}
.homepage .panel-default > .panel-heading{
    background:#38a345;
    text-align: center;
    padding: 7px;
    color:#fff;
    font-size: 15px;
    border-radius: 5px 5px 0 0;
}
.homepage .panel-default > .panel-body{
    background: url('/theme/images/ts_bg.jpg') bottom left no-repeat #fff;
    padding-top: 20px;padding-bottom: 20px;border:1px solid #ddd}
.ui-state-default,
.ui-state-default:hover{
    border:1px solid #ddd;
    border-radius: 5px 5px 5px 5px;
    background: transparent;
}
.col-left{
    width:629px;
    float:left;
}
.col-middle, .col-right{
    width:310px;
    float:left;
    overflow: hidden;
}
.big-news{
    width: 65%;
    float:left;
}
.big-news img {
    max-width: 100%;
}
.list-news{
    width: 35%;
    float:left;
    
}
.list-news ul {
    margin-left: 10px;
    padding: 10px;
    border: 1px solid #ddd;
    margin-bottom: 10px;
}
.list-news ul li {
    border-bottom: 1px solid #ddd;
    margin-bottom: 5px;
    padding-bottom: 5px;
}
.list-news ul li a{
    color:#000
}
.list-news ul li:last-child{
    margin-bottom: 0;
    border-bottom: 0;
}
.banner-home{
    height:250px;
    width:300px;
    margin-bottom: 10px;
}
.banner-home.nomargin{
    margin-bottom: 0;
}
@media only screen and (max-width:768px){
    .banner-home{
        width:100%;
    }
}
.top3home{
    margin-left: -5px;
    margin-right: -5px;
    margin-bottom: 10px;
}
.top3home .item{
    width:33.33333%;
    padding-left: 5px;
    padding-right: 5px;
    float:left;
}
.top3home .item .news{
    position: relative;
}
.top3home .item .news img{
    max-width: 100%;
}
.top3home .item .title{
    position: absolute;
    bottom: 0;
    left:0;
    width:100%;
    z-index: 9;
    padding: 2px 10px;
    line-height: 17px;
    margin:0;
    background: rgba(0,0,0,0.3);
}
.top3home .item .news a{
    color:#fff;
}
.top3home .item .news a:hover{
    text-decoration: underline;
}
@media only screen and (max-width:768px) {
    .col-middle, .col-left{
        display:none;
    }
    .col-right{
        float:none;
        width:100%;
        
    }
}
</style>
<?php 
$big_news = !empty($results) ? $results[0]:'';
//print_r($big_news);
?>
		<section class="homepage">
            <div class="main-wrap-content">
                <div class="col-left">
                    <div class="big-news">
                        <a href="<?=site_url($big_news['category_alias'].'/'.$big_news['alias'])?>"><img src="<?=base_url('uploads/contents/'.$big_news['image'])?>"></a>
                        <div class="entry-overlay-meta">
                  		    <h3 class="entry-title"><a href="<?=site_url($big_news['category_alias'].'/'.$big_news['alias'])?>" rel="bookmark" title="<?=$big_news['title']?>"><?=$big_news['title']?></a></h3>
                    		  <p><?=utf8_substr(strip_tags(html_entity_decode($big_news['short_content'], ENT_QUOTES, 'UTF-8')), 0, 170) . '..'?></p>
                       	</div>
                    </div>
                    <div class="list-news">
                        <ul>
                        <?php foreach($results as $key => $item): 
                        if($key > 0):?>
                            <li><a href="<?=site_url($item['category_alias'].'/'.$item['alias'])?>"><?=$item['title']?></a></li>
                        <?php endif; endforeach ?>
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                    <div class="top3home">
                    <?php
                    $banners = $this->main_model->_Get_Banner(1);
                    foreach($banners as $banner) {?>
                        <div class="item">
                            <div class="news">
                                <a href="<?=$banner['link']?>"><img src="<?=base_url('uploads/banners/'.$banner['image'])?>" alt="<?=$banner['title']?>">
                                    <p class="title"><?=$banner['title']?></p>
                                </a>
                            </div>
                        </div>
                    <?php    
                    }
                    ?>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="col-middle">
                <?php
                    $banners = $this->main_model->_Get_Banner(2);
                    $banner_left = '';
                    foreach($banners as $key => $banner) {
                        if($key > 0) $nomargin = ' nomargin';
                        else $nomargin = '';
                        if($banner['type']=='image') {
                            if($banner['image']!='' && file_exists('./uploads/banners/'.$banner['image']))
                            $banner_left .= '<div class="banner-home'.$nomargin.'"><a href="'.$banner['link'].'"  target="_blank"  style="" rel="nofollow"><img src="'.base_url('uploads/banners/'.$banner['image']).'" alt="" width="300" height="170" class="img-responsive"></a></div>';
                        } elseif($banner['type']=='adsense') {
                            $banner_left .= '<div class="banner-home'.$nomargin.'">'.$banner['adsense'].'</div>';
                        } elseif($banner['type']=='html5') {
                            $banner_left .= '<div class="banner-home'.$nomargin.'"><iframe frame-border="0" width="980px" height="90px" src="'.$banner['html5'].'"></iframe></div>';
                        }
                    }
                    echo $banner_left;
                    ?>
                </div>
                <div class="col-right">
                    <div class="panel panel-default" style="margin-left: 10px;">
                            <div class="panel-heading">Tìm kiếm nhà cho thuê</div>
                            <div class="panel-body">
                            <form action="<?=site_url('search')?>" method="post" id="searchForm">
                        <div class="">
                        <?php
                        $real_category_main = $this->main_model->_Get_Real_Estate_Category();
                        
                        ?>
						<div class="selectmenu_type_1 space_fix single_form">
							<select class="selectmenu" id="listCategory">
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
						</div> <!-- End .single_form -->    
                        </div>
                        
                        <div class="">
                            <div class="selectmenu_type_1 space_fix single_form"> 
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
						</div> <!-- End .single_form -->
                        </div>
                        
                        <div class="">
                            <div class="selectmenu_type_1 space_fix single_form">
							<select class="selectmenu" id="listWard">
								<option selected="selected">Phường xã</option>
								
							</select>
                             <input type="hidden" name="WardID" id="WardID" value="-1" />
						</div> <!-- End .single_form -->
                        </div>
						

						<div class="">
                            <div class="selectmenu_type_1 space_fix single_form">
							<select class="selectmenu" id="listStreet">
								<option selected="selected">Đường Phố</option>
							
							</select>
                             <input type="hidden" name="StreetID" id="StreetID" value="-1" />
						</div> <!-- End .single_form -->
                        </div>
                        
                        <div class="">
                            <div class="selectmenu_type_1 space_fix single_form"> 
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
						</div> <!-- End .single_form -->
                        </div>
                        
                        
						<div class="">
                            <div class="selectmenu_type_1 space_fix single_form">
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
						</div> <!-- End .single_form -->
                        </div>
                        <div class="">
                            <div class="selectmenu_type_1 space_fix single_form">
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
						</div> <!-- End .single_form -->
                        </div>
                        <div>
                            <div class="selectmenu_type_1 space_fix single_form">
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
                        </div>
                        
                        
						<input type="hidden" id="searchUrl" value="" />
						<div class="text-center"><button class="btn btn-primary" id="buttonSearch"><i class="fa fa-search"></i> Tìm kiếm</button>
                           
                        </div>
						<div class="clearfix"></div>

					</form>
                            </div>
                        </div>
                </div>
                <div class="clearfix"></div>
                <hr />
			</div>
		</section>

		<!-- End Find Home Table _________________________ -->

        <section class="home_content" style="padding:0">
            <div class="main-wrap-content">
                <h2 style="text-align: center;font-weight: bold;color: #38a345;"><i class="fa fa-home"></i> Nhà cho thuê nổi bật</h2>
                <div class="row">
                    <?php
                            $real_estate_featured = $this->main_model->_Get_Real_Estate_Featured(12,0);
                            foreach($real_estate_featured as $result) { 
                                $thumb = $this->main_model->_Get_Real_Estate_Image($result['id']);    
                            if($result['type_id'] == 1)
                                $class = 'pro';
                            elseif($result['type_id'] == 2) 
                                 $class = 'vip1';
                            elseif($result['type_id'] == 3)
                                $class = 'vip2';
                            else
                                $class = 'normal';
                            ?>
                    <article class="col-md-3">
                        <div class="properties_grid">
								<div class="img_holder">
									<a href="<?=site_url($result['alias'])?>" title="<?=$result['title']?>"> <img src="<?=base_url('timthumb.php?image='.$thumb.'&w=300&h=200&zc=1')?>" onerror="this.src='<?=base_url('theme/images/thumb1.jpg')?>'" alt="<?=$result['title']?>" class="img-responsive"></a>
        	                   </div> <!-- End .img_holder -->
                                <div class="info">
								    <div class="title">
                                        <h3 class="<?=$class?>"><a href="<?=site_url($result['alias'])?>" title="<?=$result['title']?>"><?=sub_string($result['title'],60)?></a></h3>
										</div> <!-- End .properties_title -->
                                    <div class="meta">
                                        <p><span>Giá</span><span>: <?php
                                        if($result['price_unit']==0) echo 'Thỏa thuận';
                                        else echo $result['price_number'].' '._Price_Label($result['price_unit']);
                                        ?></span></p>
                                        <p><span>Diện tích</span><span>: <?=$result['area']!=0 ? $result['area'].'m2':'Không xác định'?></span></p>
                                        <p><span>Quận/huyện</span><span>: <?=$result['district_title']?></span></p>
                                        <p><span>Ngày đăng</span><span>: <?=_Format_Date($result['create_time'])?></span></p>
									</div>
								</div>
                                
							</div> <!-- End .properties_details -->
                    </article>
                    <?php } ?>
                </div>
                
            </div>
            <div class="main-wrap-content">
                <div class="row">
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <h3 style="margin: 0 0 10px 0;font-size: 16px;font-weight: 600;">Cho thuê bất động sản trên Muonnha.com.vn</h3>
                        <p>Muonnha.com.vn có hơn 100.000+ tin <a href="<?=base_url()?>" style="font-weight: bold;">cho thuê bất động sản</a> tại Tp Hồ Chí Minh. Chúng tôi liệt kê danh sách nhiều thông tin nhà đất nhất phục vụ mọi nhu cầu, từ cho thuê phòng trọ, cho thuê nhà, cho thuê căn hộ, cho thuê mặt bằng, cho thuê văn phòng cho tới tìm người ở ghép. Bạn là Chủ nhà cho thuê hay gia đình cần nhà để ở? Muonnha.com.vn đều có thể giúp bạn. Tìm tin cho thuê nhà mới nhất bằng cách sử dụng công cụ tìm kiếm hoặc các đường link ngay trên trang chủ.</p>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <form class="form-newsletter">
                            <p style="margin: 0 0 10px 0;font-size: 16px;font-weight: 600;">Đăng ký nhận bản tin</p>
                            <div class="input-group">
                              <input type="text" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="input-newsletter-email">
                              <span class="input-group-addon" id="input-newsletter-email">Đăng ký</span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
</section>