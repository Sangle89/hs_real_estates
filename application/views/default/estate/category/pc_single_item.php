<div class="col-md-6 col-xs-12 single_properties <?=$class?>">
							<div class="properties_details">
								<div class="img_holder">
									<a href="<?=site_url($result['alias'])?>" title="<?=$result['title']?>"> <img class="lazy" data-src="<?=ASSET_SERVER . 'image?image='.$thumb.'&thumb=200'?>" onerror="this.src='<?=base_url('theme/images/thumb.jpg')?>'" alt="<?=$result['title']?>"></a>
        	                   </div> <!-- End .img_holder -->

								<div class="text">
                                    <div class="properties_title">
                                        <h3 class="<?=$class?>"><a href="<?=site_url($result['alias'])?>" title="<?=$result['title']?>"><?=format_title(sub_string($result['title'], 100))?></a></h3>
								    </div>
									<div class="meta">
                                    <span class="price"><strong><?php
                                    
                                        if($result['price_unit']==0 || $result['price_number']==0) echo 'Thỏa thuận';
                                        else echo $result['price_number'].' '._Price_Label($result['price_unit']);
                                        ?></strong></span>
                                    <span><strong><?=$result['area']!=0 ? $result['area'].'m<sup>2</sup>':'Không xác định'?></strong></span>
                                    <span><strong><?php 
                                        if($result['district_title'] != '') echo $result['district_title'].", ";
                                        if($result['city_title']) echo $result['city_title'];
                                    ?></strong></span>
                                    </div>
                                    <p class="sumary">
                                    <?php
                                    echo sub_string(str_replace(" "," ",$result['content']), 100);
                                    ?>
                                    </p>
								</div> <!-- End .text -->
                                <span class="public-date"><?=_Format_Date($result['create_time'])?></span>
							</div> <!-- End .properties_details -->

						</div> <!-- End .single_properties -->