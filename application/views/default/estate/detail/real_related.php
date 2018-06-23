<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#cungkhuvuc" aria-controls="cungkhuvuc" role="tab" data-toggle="tab">Tin rao cùng khu vực</a></li>
    <li role="presentation"><a href="#cungkhoanggia" aria-controls="cungkhoanggia" role="tab" data-toggle="tab">Tin rao cùng khoảng giá</a></li>
</ul>
<div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="cungkhuvuc">
                        <?php if($result_by_location) : ?>
                            <?php if(USERTYPE=='PC'): ?>
                            <div class="property_listing grid">
                                <div class="property_type row">
                            <?php else: ?>
                                <ul class="group-prd group-horPrd group-1cl list-prd-hp clearfix">
                            <?php endif ?>
                                    <?php foreach($result_by_location as $result) { 
                            $district = $this->main_model->_Get_District_By_Id($result['district_id']);
                            $city = $this->main_model->_Get_City_By_Id($result['city_id']);
							 $thumb = $this->main_model->_Get_Real_Estate_Image($result['id']);  
                             //Resize 150x150
                           // $image_resize = $this->image_model->resize($thumb, 150, 150, 'images');
                             if($result['type_id'] == 1)
                                $class = 'pro';
                            elseif($result['type_id'] == 2) 
                                 $class = 'vip1';
                            elseif($result['type_id'] == 3)
                                $class = 'vip2';
                            else
                                $class = 'normal'; 
                            
                            if(USERTYPE == 'PC')
                            $this->load->view('default/estate/category/pc_single_item', array('result'=>$result, 'thumb'=>$thumb));
                            else{
                                $image_resize = $this->image_model->resize($thumb, 123, 90, 'images');
                                $this->load->view('default/estate/category/mobile_single_item', array('result'=>$result, 'image_resize'=>$image_resize));
                            }
                            
                             } ?>

                            <?php if(USERTYPE=='PC'): ?>
                                </div>
                            </div>
                            <?php else: ?>
                                </ul>
                            <?php endif ?>

                            <?php endif; ?>

                    </div>

                    <div role="tabpanel" class="tab-pane" id="cungkhoanggia">

                        <?php if($result_by_price): ?>

                            <?php if(USERTYPE=='PC'): ?>
                            <div class="property_listing grid">
                                <div class="property_type row">
                            <?php else: ?>
                                <ul class="group-prd group-horPrd group-1cl list-prd-hp clearfix">
                            <?php endif ?>

                                    <?php foreach($result_by_price as $result) { 

                            $district = $this->main_model->_Get_District_By_Id($result['district_id']);
                            $city = $this->main_model->_Get_City_By_Id($result['city_id']);
							 $thumb = $this->main_model->_Get_Real_Estate_Image($result['id']); 
                              //Resize 150x150
                           // $image_resize = $this->image_model->resize($thumb, 150, 150, 'images');  
                             if($result['type_id'] == 1)
                                $class = 'pro';
                            elseif($result['type_id'] == 2) 
                                 $class = 'vip1';
                            elseif($result['type_id'] == 3)
                                $class = 'vip2';
                            else
                                $class = 'normal';
                            if(USERTYPE == 'PC')
                                $this->load->view('default/estate/category/pc_single_item', array('result'=>$result, 'thumb'=>$thumb));
                            else{
                                $image_resize = $this->image_model->resize($thumb, 123, 90, 'images');
                                $this->load->view('default/estate/category/mobile_single_item', array('result'=>$result, 'image_resize'=>$image_resize));
                            }
                            } ?>

                                <?php if(USERTYPE=='PC'): ?>
                                </div>
                            </div>
                            <?php else: ?>
                                </ul>
                            <?php endif ?>
                            <?php endif; ?>

</div>