<div style="border:1px solid #ddd;margin-bottom: 15px;" class="box-list-feature">
                    <div class="sitebar-heading">Tin nổi bật</div>
                    <ul class="list_news_feature sidebar-list-feature" style="height: auto;margin: 0 0 15px 0;">
                        <?php 
                        $featured_news = $this->main_model->_Get_Content_Feature(6);
                        foreach($featured_news as $item) : ?>
                        <li>
                        <div class="thumb">
                            <a href="<?=site_url($category['alias'].'/'.$item['alias'])?>"><img src="<?=base_url('timthumb.php?image='.$item['image'].'&w=100&h=100&zc=1&folder=contents')?>" alt=""/></a>
                        </div>
                        <a href="<?=site_url($category['alias'].'/'.$item['alias'])?>" title="<?=$item['title']?>"><?=sub_string($item['title'], 50)?></a>
                        <div class="clearfix"></div>
                        </li>
                        
                        <?php endforeach?>
                    </ul>
                    </div>