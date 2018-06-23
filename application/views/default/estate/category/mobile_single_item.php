<li>
                    <div class="title-14">
                            <a id="MainContent_ProductHome_rptProductHome_hplTitle_0" title="<?=$result['title']?>" class="<?=$class?>" href="<?=site_url($result['alias'])?>"><?=format_title($result['title'])?></a>
                    </div>
                    <div class="image">
                        
                            <a id="MainContent_ProductHome_rptProductHome_hplAvatar_0" title="<?=$result['title']?>" href="<?=site_url($result['alias'])?>"><img id="MainContent_ProductHome_rptProductHome_imgAvatar_0" class="ProductImage" src="<?=base_url($image_resize)?>" onerror="this.src='<?=base_url('theme/images/mobile_thumb.jpg')?>'"></a>
                        
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