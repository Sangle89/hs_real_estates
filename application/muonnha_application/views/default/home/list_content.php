<script type="text/javascript" src="<?=base_url()?>theme/js/jquery-ui.min.js"></script>
<style>
.homepage .panel{background: transparent;}
.homepage .panel-default > .panel-heading{
    background:#38a345;
    text-align: center;
    padding: 7px;
    color:#fff;
    font-size: 15px;
    border-radius: 5px 5px 0 0;
}
.homepage .panel-default > .panel-body{
    background: url('/theme/images/ts_bg.jpg') bottom left no-repeat #fff;
    padding-top: 20px;padding-bottom: 20px;border:1px solid #ddd}
.ui-state-default,
.ui-state-default:hover{
    border:1px solid #ddd;
    border-radius: 5px 5px 5px 5px;
    background: transparent;
}
.col-left{
    width:67%;
    float:left;
}
.col-right{
    width:33%;
    float:left;
    overflow: hidden;
}
.big-news{
    margin-bottom: 15px;
}
.big-news:after{
    content:"";
    display: block;
    clear: both;
}
.big-news .left{
    width:46%;
    float:left;
    margin-right: 4%;
}
.big-news .right{
    float:left;
    width:50%;
}
.big-news img {
    max-width: 100%;
}
.list-news{
    
}
.list-news ul {
    margin-left: 10px;
    padding: 10px;
    border: 1px solid #ddd;
    margin-bottom: 10px;
}
.list-news ul li {
    border-bottom: 1px solid #ddd;
    margin-bottom: 5px;
    padding-bottom: 5px;
    display: table;
    width:100%;
}
.list-news ul li >div{
    display: table-cell;
    vertical-align: top;
}
.list-news ul li div.title{
    padding-right: 10px;
    font-weight:bold;
}
.list-news ul li div.thumb img{
    width:120px;
    height: 67px;
    max-width: 120px!important;
}
.list-news ul li a{
    color:#000
}
.list-news ul li:last-child{
    margin-bottom: 0;
    border-bottom: 0;
}
.banner-home{
    margin-bottom: 10px;
}
.banner-home.nomargin{
    margin-bottom: 0;
}
@media only screen and (max-width:768px){
    .banner-home{
        width:100%;
    }
}
.top3home{
    margin-left: -5px;
    margin-right: -5px;
    margin-bottom: 10px;
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
@media only screen and (max-width:768px) {
    .col-middle, .col-left{
        display:none;
    }
    .col-right{
        float:none;
        width:100%;
        
    }
}
</style>
<style>
.heading-title{
    margin: 0 0 10px 0;
    font-size:17px;
}
.heading-title span{
    display: inline-block;
    line-height: 25px;
    position: relative;
    background:#eceeed;
    padding:0 10px;
    border-left:3px solid #38a345;
    font-size:16px;
    font-weight:bold;
}
.heading-title span:after{
    content: "";
    position: absolute;
    right: -13px;
    top: 0;
    border-left: 13px solid #eceeed;
    border-top: 13px solid transparent;
    border-bottom: 13px solid transparent;
    z-index: 999;
}
</style>
<?php 
$big_news = !empty($results) ? $results[0]:'';
//print_r($big_news);
?>
	<section class="home_content" style="background: #fff;padding: 0">
            <div class="main-wrap-content">
            <?php $this->load->view('default/home/banner2'); ?>
            <h2 style="text-align: center;font-weight: bold;color: #38a345;margin:25px 0 15px 0">Tin tức, kinh nghiệm cho thuê nhà</h2>
            <p style="text-align: center;font-size:16px;margin-bottom:30px;">Góc nhìn thị trường, kinh nghiệm và kiến thức giao dịch cần biết khi đi thuê hoặc cho thuê</p>   
                <div class="col-left">
                    <div class="big-news">
                            <div class="left">
                            <div class="heading-title"><span><?=$big_news['category_title']?></span></div>
                            <h3 class="entry-title"><a href="<?=site_url($big_news['category_alias'].'/'.$big_news['alias'])?>" rel="bookmark" title="<?=$big_news['title']?>"><?=$big_news['title']?></a></h3>
                    		  <p><?=utf8_substr(strip_tags(html_entity_decode($big_news['short_content'], ENT_QUOTES, 'UTF-8')), 0, 170) . '..'?></p>
                            <a class="readmore" rel="nofollow" href="<?=site_url($big_news['category_alias'].'/'.$big_news['alias'])?>">[Xem thêm]</a>
                            </div>
                            <div class="right">
                                    <a href="<?=site_url($big_news['category_alias'].'/'.$big_news['alias'])?>"><img src="<?=base_url('uploads/contents/'.$big_news['image'])?>" onerror="this.src=''"></a>
                            </div>
                    </div>
                    
                    <div class="clearfix"></div>
                    <div class="top3home">
                    <?php
                    $banners = $this->main_model->_Get_Banner(1);
                    foreach($banners as $banner) {?>
                        <div class="item">
                            <div class="news">
                                <a href="<?=$banner['link']?>"><img src="<?=base_url('uploads/banners/'.$banner['image'])?>" alt="<?=$banner['title']?>">
                                    <p class="title"><?=$banner['title']?></p>
                                </a>
                            </div>
                        </div>
                    <?php    
                    }
                    ?>
                        <div class="clearfix"></div>
                    </div>
                </div>
                
                <div class="col-right">
                    <div class="list-news">
                        <ul>
                        <?php foreach($results as $key => $item): 
                        if($key > 0):
                             //Resize 150x150
                            $image_resize = $this->image_model->resize($item['image'], 120, 67, 'contents');
                        ?>
                            <li>
                                <div class="title">
                                <a href="<?=site_url($item['category_alias'].'/'.$item['alias'])?>"><?=$item['title']?></a>
                                </div>
                                <div class="thumb">
                                <a href="<?=site_url($item['category_alias'].'/'.$item['alias'])?>"><img src="<?=base_url($image_resize)?>" class="<?=$item['title']?>"/></a>
                                </div>
                            </li>
                        <?php endif; endforeach ?>
                        </ul>
                    </div>
                </div>
                <div class="clearfix"></div>
                <hr />
			</div>
		</section>