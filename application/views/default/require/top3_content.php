<div class="" style="border: 1px solid #ddd;">
    <div class="sitebar-heading"><h4 style="margin: 0;color:#fff;font-size:16px;font-weight:bold;">Có thể bạn quan tâm</h4></div>
    <ul class="list_news_feature sidebar-list-feature sitebar-list-category" style="height: auto;margin:0">
    <?php
        $banners = $this->main_model->_Get_Banner(1);
                    foreach($banners as $banner) {?>
                    
        <li><h3 style="margin: 0;font-size:14px;line-height:22px"><a href="<?=$banner['link']?>"><?=$banner['title']?></a></h3></li>
                    <?php    
                    }
                    ?>
    </ul>
</div>