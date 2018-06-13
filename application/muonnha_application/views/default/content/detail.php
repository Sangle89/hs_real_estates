<?php //$this->load->view('default/require/breadcrumb', $search_param); ?>
<style>
.related-topic li{
    position: relative;
    padding-left: 15px;
}
.related-topic li:before{
    font-family: "FontAwesome";
    content: "\f0c8";
    position: absolute;
    left: 0;
    top: 5px;
    color: #015f95;
    font-size: 6px;
}
.related-topic li a{
    font-size:13px;
    font-weight:bold;
    margin: 0 0 5px 0;
}
.sevenPostZalo{
    text-align: left;
    margin: 10px 0;
}
.fb-like{
    float:left;
    margin-right: 5px;
    margin-top: 3px;
}
.sevenPostZalo ul {
    display: inline-block;
}
.the-seven-share li{
    display: inline-block;
    margin-right: 5px;
}
.the-seven-share li a span{
    display: inline-block;
    width:24px;
    height:24px;
    background-size: 100% 100%;
}
.ti-facebook{
    background:url('/theme/images/facebook.png');
}
.ti-zalo{
    background:url('/theme/images/zalo.jpg');
}
.ti-google{
    background:url('/theme/images/google.png');
}
</style>
    <div class="main-wrap-content property_listing">
        <div class="property_type row">
            <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 col-list-left">
            <?=$this->breadcrumb->output()?>
				<div class="main_title"><h1 style="margin: 0 0 5px 0;"><?=$content['title']?></h1></div>
                
                <p class="pull-left meta">
                    <span class="date" style="color:#ccc;display: block;margin-bottom: 10px;"><?=_Format_Date($content['create_time'])?></span>
                    <strong>Cùng chủ đề:</strong> <span class="category"><a href="<?=site_url($category['alias'])?>"><?=$category['title']?></a></span>
                </p>
                <div class="clearfix"></div>	    
                <ul class="related-topic" style="margin: 0 0 15px 0;padding:0">
                    <?php
                    for($i=0; $i<2; $i++):
                    ?>
                    <li><a href="<?=site_url($category['alias'].'/'.$contents[$i]['alias'])?>" title="<?=$contents[$i]['title']?>"><?=$contents[$i]['title']?></a></li>
                    <?php endfor?>
                </ul>
                <div class="blog-content"><?=$content['content']?></div>
                
                <div class="sevenPostZalo">
                	<div class="fb-like" data-href="<?=current_url()?>" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true" data-share="false"></div>
                    <ul class="the-seven-share">
                		<li class="btnFacebook"><a href="javascript:fbshareCurrentPage()" rel="nofollow" title="Chia sẽ Facebook" target="_blank" alt="Share on Facebook"><span class="ti-facebook"></span></a></li>
                		<li class="btnSevenZalo zalo-share-button" data-href="<?=current_url()?>" data-oaid="539973473463920862" data-layout="icon-text" data-customize="true"><a href="javascript:;" rel="nofollow" title="Chia sẻ Zalo"><span class="ti-zalo"></span></a></li>
                		<script language="javascript">
                			function fbshareCurrentPage()
                			{window.open("https://www.facebook.com/sharer/sharer.php?u="+escape(window.location.href)+"&t="+document.title, '', 
                			'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');
                			return false; }
                		</script>
                		<li class="btnGooglez"><a href="javascript:googleshareCurrentPage()"  rel="nofollow" target="_blank" title="Chia sẽ Google+" alt="Share on Google +"><span class="ti-google"></span></a></li>
                		<script language="javascript">
                			function googleshareCurrentPage()
                			{window.open("https://plus.google.com/share?url="+escape(window.location.href)+"&t="+document.title, '', 
                			'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=450,width=500');
                			return false; }
                		</script>
                	</ul>
                    <g:plusone></g:plusone>
                    <div class="clearfix"></div>
                </div><!-- end sevenPostShare -->
                
                
                <h4 style="border-top: 1px solid #ccc;"><span style="display: inline-block;padding: 4px 0;border-top:1px solid #3d9e11;margin-top: -1px;">Tin liên quan</span></h4>
                <?php 
                if(USERTYPE == 'PC') : ?>
                <div class="row" style="margin-bottom: 15px;">
                <?php for($i=2; $i<5;$i++) : 
                $image_resize = $this->image_model->resize($contents[$i]['image'], 300, 200, 'contents');
                ?>
                    <div class="col-md-4">
                        <article>
                            <a href="<?=site_url($category['alias'].'/'.$contents[$i]['alias'])?>"><img src="<?=base_url($image_resize)?>" alt="<?=$contents[$i]['title']?>" class="img-responsive"/></a>
                            <h3 style="margin: 7px 0;font-size:14px;font-weight:normal;"><a style="color: #000;" href="<?=site_url($category['alias'].'/'.$contents[$i]['alias'])?>"><?=$contents[$i]['title']?></a></h3>
                        </article>
                    </div>
                <?php endfor ?>
                </div>
                <hr />
                <div class="row">
                    <div class="col-md-6">
                        <ul class="related-posts" style="padding-right: 5px;">
                        <?php for($i=5; $i<count($contents) && $i<8; $i++) : ?>
                        <li style="margin-bottom: 5px;"><h3 style="margin: 0;font-size:14px;font-weight:normal"><a style="color: #000;" href="<?=site_url($category['alias'].'/'.$contents[$i]['alias'])?>" title="<?=$contents[$i]['title']?>"><?=$contents[$i]['title']?></a></h3></li>
                        <?php endfor ?>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="related-posts" style="padding-right: 5px;">
                        <?php for($i=8; $i<count($contents); $i++) : ?>
                        <li style="margin-bottom: 5px;"><h3 style="margin: 0;font-size:14px;font-weight:normal"><a style="color: #000;" href="<?=site_url($category['alias'].'/'.$contents[$i]['alias'])?>" title="<?=$contents[$i]['title']?>"><?=$contents[$i]['title']?></a></h3></li>
                        <?php endfor ?>
                        </ul>
                    </div>
                    
                </div>
                <?php else : ?>
                <?php for($i=2; $i<count($contents); $i++) : 
                $image_resize = $this->image_model->resize($content[$i]['image'], 300, 200, 'contents');
                ?>
                <article>
                <div class="row">
                    <div class="col-xs-4">
                       <a href="<?=site_url($category['alias'].'/'.$contents[$i]['alias'])?>" class="thumbnail" style="margin-bottom: 0;"><img src="<?=base_url($image_resize)?>" alt="<?=$contents[$i]['title']?>" class="img-responsive"/></a> 
                    </div>
                    <div class="col-xs-8">
                        <h3 style="margin: 7px 0;font-size:14px;font-weight:normal;"><a style="color: #000;" href="<?=site_url($category['alias'].'/'.$contents[$i]['alias'])?>"><?=$contents[$i]['title']?></a></h3>
                    </div>
                </div>
                <hr style="margin: 5px 0;" />
                </article>
                <?php endfor; ?>
                <?php endif; ?>
                
                <?php
                    $this->load->view('default/content/banner_category', array('content_cat_id' => $content['category_id']));
                    $this->load->view('default/require/content_detail_adv_bottom');
                ?>
            </div> <!-- End of column -->
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 col-list-feature">
				    <?php $this->load->view('default/require/news_feature'); ?>
                    <?php $this->load->view('default/require/news_most_view'); ?>
                    <?php $this->load->view('default/require/banner_scroll'); ?>
                </div> <!-- End of column -->
                    
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <?php
                    $this->load->view('default/require/sitebar_content_adv_top');
                    ?>
                    <div style="border:1px solid #ddd;margin-bottom: 15px;">
    				    <div class="sitebar-heading">Kinh nghiệm</div>
                        <ul class="list_news_feature sidebar-list-feature sitebar-list-category" style="height: auto;margin: 0">
                        <?php
                        $sub_category = $this->main_model->_Get_Content_Category(1);
                        foreach($sub_category as $sub):
                        ?>
                        <li><a href="<?=site_url($sub['alias'])?>" title="<?=$sub['title']?>"><?=$sub['title']?></a></li>
                        <?php endforeach ?>
                        </ul>
                    </div>
                    <?php  
                    $this->load->view('default/content/last_news', array('category_id'=>2));
                    $this->load->view('default/content/last_news', array('category_id'=>3));
                    $this->load->view('default/require/sitebar_feature');
                    $this->load->view('default/require/sitebar_content_adv');
                    $this->load->view('default/require/top3_content'); 
                    ?>
                </div> <!-- End of column -->


			</div> <!-- End .row -->
		</div> <!-- End .property_listing -->
