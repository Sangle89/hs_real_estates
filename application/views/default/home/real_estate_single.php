<article class="col-md-4">
    <div class="properties_grid feature">
        <div class="img_holder">
            <a href="<?=site_url($result['alias'])?>" title="<?=$result['title']?>"> <img src="<?=base_url($image_resize)?>" onerror="this.src='<?=ASSET_SERVER.'theme/images/thumb_350x250.jpg'?>'" alt="<?=$result['title']?>" class="lazy img-responsive"></a>
        	                   </div>
                                <div class="info">
								    <h3 class="<?=$class?>"><a href="<?=site_url($result['alias'])?>" title="<?=$result['title']?>"><?=format_title(sub_string($result['title'],65))?></a></h3>
									<address><i class="fa fa-map-marker"></i> <?=$result['district_title']?>, Hồ Chí Minh</address>
                                    <div class="meta">
                                        <span class="area"><i class="fa fa-area-chart"></i>&nbsp;<?=$result['area']!=0 ? $result['area'].'m2':'Không xác định'?></span>
                                        <span class="price"><?php
                                        if($result['price_unit']==0 || $result['price_number'] == 0) echo 'Thỏa thuận';
                                        else echo $result['price_number'].' '._Price_Label($result['price_unit']);
                                        ?></span>
									   </div>
    </div>
</div>
</article>