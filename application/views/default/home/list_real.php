<?php
if(USERTYPE == 'PC') :
?>
<section class="home_content" style="background: #f4f5f9;margin: 0;"> 
            <div class="main-wrap-content">
                <?php $this->load->view('default/home/banner1'); ?>
                <h2 style="text-align: center;font-weight: bold;color: #38a345;"><i class="fa fa-home"></i> Nhà cho thuê nổi bật</h2>
                <p style="text-align: center;font-size:16px;margin-bottom:30px;">Muonnha.com.vn đồng hành với bạn từ quá trình tìm kiếm cho đến khi giao dịch thành công ngôi nhà yêu thích của bạn.</p>
                <div class="row">
                    <?php
                    $real_estate_featured = $this->main_model->_Get_Real_Estate_Featured(9,0);
                    foreach($real_estate_featured as $result) { 
                        $thumb = $this->main_model->_Get_Real_Estate_Image($result['id']);  
                        //Resize 360x260
                        $result['image_resize'] = $this->image_model->resize($thumb, 360, 260, 'images');
                                  
                        if($result['type_id'] == 1)
                                $class = 'pro';
                        elseif($result['type_id'] == 2) 
                                 $class = 'vip1';
                        elseif($result['type_id'] == 3)
                                $class = 'vip2';
                        else
                                $class = 'normal';
                        $this->load->view('default/home/real_estate_single', array('result' => $result));
                         } ?>
                </div>
                
            </div>
            
</section>
<?php endif ?>
<?php if(USERTYPE == 'Mobile') : ?>
<section style="padding: 0 5px;margin-top:15px;">
<style>
.group-prd{margin:0 -5px;list-style:none;padding:0}
.group-prd>li{float:left;padding:0 5px;border-bottom:1px solid #eee}
.group-prd.group-1cl{margin-right:0;margin-left:0}
.group-1cl>li{width:100%;padding:8px 11px 8px 0}
.group-2cl>li{width:50%}
.group-3cl>li{width:33.333%}
.group-4cl>li{width:25%}
.group-5cl>li{width:20%}
.group-prd > li .title-14{margin-bottom:5px;font-weight:700}
.group-prd .box-prd{display:inline-block;width:100%;background:#fff;border:1px solid #d2d2d2}
.group-prd .box-prd:hover{box-shadow:0 1px 2px rgba(0,0,0,.15);-moz-box-shadow:0 1px 2px rgba(0,0,0,.15);-webkit-box-shadow:0 1px 2px rgba(0,0,0,.15)}
.group-prd .image{overflow:hidden;text-align:center;position:relative}
.group-prd .content{padding-top:10px}
.group-prd .box-prd .content{padding:10px}
.group-prd .title-2row{height:40px;line-height:20px;overflow:hidden}
.group-prd .title-3row{height:54px;line-height:18px;overflow:hidden}
.group-prd .content>:last-child{margin-bottom:0!important}
.group-prd.group-flipVer .content{padding-top:0;padding-bottom:10px}
.group-prd.group-horPrd .image{float:left}
.group-prd.group-horPrd .content{display:table;padding:0 0 0 10px}
.group-prd .title-14 a{text-transform:normal;font-weight:700;color:#015f95;font-size:14px}
.group-prd .title-14 a.vip1,.group-prd .title-14 a.vip2{color:red;text-transform:uppercase}
.group-prd .content{padding:10px}
.group-prd.group-horPrd .content .row{overflow:hidden;height:100%}
.group-prd.group-horPrd .content .price .text{font-weight:700;color:#38a345}
.group-prd.group-horPrd .content .area .text{font-weight:700}
</style>
<h2 style="text-align: center;font-weight: bold;color: #38a345;font-size:15px;"><i class="fa fa-home"></i> Nhà cho thuê nổi bật</h2>
<p style="text-align: center;font-size:12px;margin-bottom:15px;">Muonnha.com.vn đồng hành với bạn từ quá trình tìm kiếm cho đến khi giao dịch thành công ngôi nhà yêu thích của bạn.</p>     
<ul class="group-prd group-horPrd group-1cl list-prd-hp clearfix">
<?php
                    $real_estate_featured = $this->main_model->_Get_Real_Estate_Featured(9,0);
                    foreach($real_estate_featured as $result) :
                        $thumb = $this->main_model->_Get_Real_Estate_Image($result['id']);  
                        //Resize 360x260
                        $image_resize = $this->image_model->resize($thumb, 123, 90, 'images');
                                  
                        if($result['type_id'] == 1)
                                $class = 'pro';
                        elseif($result['type_id'] == 2) 
                                 $class = 'vip1';
                        elseif($result['type_id'] == 3)
                                $class = 'vip2';
                        else
                                $class = 'normal';
                            ?>
    <li>
                    <div class="title-14">
                            <a id="MainContent_ProductHome_rptProductHome_hplTitle_0" title="<?=$result['title']?>" class="<?=$class?>" href="<?=site_url($result['alias'])?>"><?=format_title($result['title'])?></a>
                    </div>
                    <div class="image">
                        
                            <a id="MainContent_ProductHome_rptProductHome_hplAvatar_0" title="<?=$result['title']?>" href="<?=site_url($result['alias'])?>"><img id="MainContent_ProductHome_rptProductHome_imgAvatar_0" class="ProductImage" src="<?=base_url($image_resize)?>"></a>
                        
                    </div>
                    <div class="content">
                        <div class="price">
                            <span class="lable"></span><span class="text"><?php
                                        if($result['price_unit']==0 || $result['price_number'] == 0) echo 'Thỏa thuận';
                                        else echo $result['price_number'].' '._Price_Label($result['price_unit']);
                                        ?></span>
                        </div>
                        <div class="area">
                            <span class="lable"></span><span class="text"><?=$result['area']!=0 ? $result['area'].'m2':'Không xác định'?></span>
                        </div>
                        <div class="address">
                            <?=$result['district_title']?>, Hồ Chí Minh
                        </div>
                    </div>
                </li>
                <?php endforeach; ?>
</ul>
</section>
<?php endif ?>