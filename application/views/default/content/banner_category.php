<style>
.top3home{
    margin-left: -5px;
    margin-right: -5px;
    margin-bottom: 10px;
    margin-top: 10px;
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
</style>

<h4 style="border-top: 1px solid #ccc;"><span style="display: inline-block;padding: 4px 0;border-top:1px solid #3d9e11;margin-top: -1px;">Khu vực cho thuê được quan tâm</span></h4>
<div class="top3home">
                    <?php
                    $banners = $this->main_model->_Get_Banner(15, $content_cat_id);
                    foreach($banners as $banner) {
                    $image_resize = $this->image_model->resize($banner['image'], 300, 200, 'banners');    
                    ?>
                        <div class="item">
                            <div class="news">
                                <a href="<?=$banner['link']?>"><img src="<?=base_url($image_resize)?>" height="150" width="100%" alt="<?=$banner['title']?>">
                                    <p class="title"><?=$banner['title']?></p>
                                </a>
                            </div>
                        </div>
                    <?php    
                    }
                    ?>
                        <div class="clearfix"></div>
                    </div>