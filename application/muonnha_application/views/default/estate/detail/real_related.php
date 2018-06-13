<ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#cungkhuvuc" aria-controls="cungkhuvuc" role="tab" data-toggle="tab">Tin rao cùng khu vực</a></li>
                    <li role="presentation"><a href="#cungkhoanggia" aria-controls="cungkhoanggia" role="tab" data-toggle="tab">Tin rao cùng khoảng giá</a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="cungkhuvuc">
                        <?php if($result_by_location) : ?>
                            <div class="property_listing grid">
                                <div class="property_type row">
                                    <?php foreach($result_by_location as $result) { 
                            $district = $this->main_model->_Get_District_By_Id($result['district_id']);
                            $city = $this->main_model->_Get_City_By_Id($result['city_id']);
							 $thumb = $this->main_model->_Get_Real_Estate_Image($result['id']);  
                             //Resize 150x150
                            $image_resize = $this->image_model->resize($thumb, 150, 150, 'images');
                             if($result['type_id'] == 1)
                                $class = 'pro';
                            elseif($result['type_id'] == 2) 
                                 $class = 'vip1';
                            elseif($result['type_id'] == 3)
                                $class = 'vip2';
                            else
                                $class = 'normal'; 
                            ?>

                                        <div class="col-lg-6 col-md-6">

                                            <div class="single_properties <?=$class?>">

                                                <div class="properties_details">
                                                    <div class="img_holder">
                                                        <a href="<?=site_url($result['alias'])?>" title="<?=$result['title']?>"> <img src="<?=base_url($image_resize)?>" onerror="this.src='<?=base_url('theme/images/thumb.jpg')?>'" alt="<?=$result['title']?>" class="img-responsive"></a>
                                                    </div>
                                                    <!-- End .img_holder -->

                                                    <div class="text">
                                                        <div class="properties_title" style="min-height: 36px;">
                                                            <h3 class="<?=$class?>"><a href="<?=site_url($result['alias'])?>" title="<?=$result['title']?>"><?=sub_string($result['title'], 100)?></a></h3>
                                                        </div>
                                                        
                                                        <div class="meta">
                                                            <span class="price"><strong><?php
                                        if($result['price_unit']==0 || $result['price_number']==0) echo 'Thỏa thuận';
                                        else echo $result['price_number'].' '._Price_Label($result['price_unit']);
                                        ?></strong></span>
                                                            <span><strong><?=$result['area']!=0 ? $result['area'].'m2':'Không xác định'?></strong></span>
                                                            <span><strong><?=$district['title'].', '.$city['title']?></strong></span>

                                                        </div>
                                                        <p class="sumary" style="margin:0;padding:0">
                                                            <?php
                                    echo utf8_substr(strip_tags(html_entity_decode($result['content'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..';
                                    ?>
                                                        </p>
                                                    </div>
                                                    <!-- End .text -->
                                                    
                                                </div>
                                                <!-- End .properties_details -->

                                            </div>
                                            <!-- End .single_properties -->

                                        </div>

                                        <?php } ?>

                                </div>

                            </div>

                            <?php endif; ?>

                    </div>

                    <div role="tabpanel" class="tab-pane" id="cungkhoanggia">

                        <?php if($result_by_price): ?>

                            <div class="property_listing grid">

                                <div class="property_type row">

                                    <?php foreach($result_by_price as $result) { 

                            $district = $this->main_model->_Get_District_By_Id($result['district_id']);
                            $city = $this->main_model->_Get_City_By_Id($result['city_id']);
							 $thumb = $this->main_model->_Get_Real_Estate_Image($result['id']); 
                              //Resize 150x150
                            $image_resize = $this->image_model->resize($thumb, 150, 150, 'images');  
                             if($result['type_id'] == 1)
                                $class = 'pro';
                            elseif($result['type_id'] == 2) 
                                 $class = 'vip1';
                            elseif($result['type_id'] == 3)
                                $class = 'vip2';
                            else
                                $class = 'normal';
                             ?>

                                        <div class="col-lg-6 col-md-6">

                                            <div class="single_properties <?=$class?>">

                                                <div class="properties_details">
                                                    <div class="img_holder">
                                                        <a href="<?=site_url($result['alias'])?>" title="<?=$result['title']?>"> <img src="<?=base_url($image_resize)?>" onerror="this.src='<?=base_url('theme/images/thumb.jpg')?>'" alt="<?=$result['title']?>" class="img-responsive"></a>
                                                    </div>
                                                    <!-- End .img_holder -->

                                                    <div class="text">
                                                        <div class="properties_title" style="min-height: 36px;">
                                                            <h3 class="<?=$class?>"><a href="<?=site_url($result['alias'])?>" title="<?=$result['title']?>"><?=sub_string($result['title'], 100)?></a></h3>
                                                        </div>
                                                        
                                                        <div class="meta">
                                                            <span class="price"><strong><?php
                                        if($result['price_unit']==0 || $result['price_number']==0) echo 'Thỏa thuận';
                                        else echo $result['price_number'].' '._Price_Label($result['price_unit']);
                                        ?></strong></span>
                                                            <span><strong><?=$result['area']!=0 ? $result['area'].'m2':'Không xác định'?></strong></span>
                                                            <span><strong><?=$district['title'].', '.$city['title']?></strong></span>

                                                        </div>
                                                        <p class="sumary" style="margin: 0;padding:0">
                                                            <?php
                                    echo utf8_substr(strip_tags(html_entity_decode($result['content'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..';
                                    ?>
                                                        </p>
                                                    </div>
                                                    <!-- End .text -->
                                                   
                                                </div>
                                                <!-- End .properties_details -->

                                            </div>
                                            <!-- End .single_properties -->

                                        </div>

                                        <?php } ?>

                                </div>

                            </div>

                            <?php endif; ?>

                    </div>