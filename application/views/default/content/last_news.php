<?php
$category = $this->main_model->_Get_Content_Category_By_Id($category_id);
$results = $this->main_model->_Get_Content_By_Category($category_id, 6, 0);
?>
<style>
.last_news_list{
    padding:5px;
    border:1px solid #ddd;
}
.last_news_list a{
    color:#000;
}
.last_news_list .big_news{
    border-bottom: 1px solid #ddd;
    margin-bottom: 10px;
    padding-bottom: 10px;
}
.last_news_list .big_news h3{
    font-size: 14px;
    margin: 0 0 7px 0;
    color:#222;
    font-weight:bold;
}
.last_news_list .big_news .desc{
    font-size: 13px;
    text-align: justify;
}
.last_news_list .small_news{
    border-bottom: 1px solid #ddd;
    font-size:14px;
    margin: 0 0 10px 0;
    padding-bottom: 10px;
    text-align: justify;
}
.last_news_list .small_news:last-child{
    margin-bottom: 0;
    border-bottom: 0;
    padding-bottom: 0;
}
.last_news_list .small_news{
    position: relative;
    padding-left: 15px;
}
.last_news_list .small_news:before{
    font-family: "FontAwesome";
    content: "\f0c8";
    position: absolute;
    left: 2px;
    top: 7px;
    color: #000000;
    font-size: 5px;
    display: block!important;
}
</style>
<div style="margin-bottom: 15px;">
<h4 class="sitebar-heading" style="line-height: 20px;margin-bottom: 0;"><?=$category['title']?></h4>
<div class="last_news_list">
                    <?php foreach($results as $key => $result) { 
                        $image_resize = $this->image_model->resize($result['image'], 200, 200, 'contents');
                            if($key==0):
                            ?>
                            <article class="big_news">
                                <div class="row">
                                    <div class="col-md-12 title">
                                    <h3 style="min-height: inherit;"><a href="<?=site_url($result['category_alias'].'/'.$result['alias'])?>" title="<?=$result['title']?>"><?=sub_string($result['title'],60)?></a></h3>
    								</div> <!-- End .properties_title -->
                                    
        								<div class="col-md-4 col-xs-4 img_holder">
        									<a href="<?=site_url($result['category_alias'].'/'.$result['alias'])?>" title="<?=$result['title']?>"> <img src="<?=base_url($image_resize)?>" onerror="this.src='<?=base_url('theme/images/thumb.jpg')?>'" alt="<?=$result['title']?>" class="img-responsive"></a>
                	                   </div> <!-- End .img_holder -->
                                        <div class="col-md-8 col-xs-8 info">
        								    <div class="desc">
                                            <h4 style="margin: 0;font-weight:normal;font-size:13px">
                                            <?=sub_string($result['short_content'], 150)?>
                                            </h4>
                                            </div>
        								</div>
                                        
                                </div>
                            </article>
                            <?php else : ?>
                            <div class="small_news"><a href="<?=site_url($result['category_alias'].'/'.$result['alias'])?>" title="<?=$result['title']?>"><?=sub_string($result['title'],60)?></a></div>
                            <?php endif; } ?>
                            <div class="clearfix"></div>
</div></div>