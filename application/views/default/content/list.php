<?php //$this->load->view('default/require/breadcrumb', $search_param); ?>
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
.mobile_list {
    padding: 10px 5px 5px 5px;
}
.mobile_list .blog-tops{
    margin-bottom:10px;
}
.mobile_list .blog-tops .blogs{
    border:0;
    padding:0;
}
.mobile_list .blogs .blog-post .text h3 a{
    font-size: 14px;
}
.mobile_list .blogs{
    border:0;
    padding:0;
}
</style>
    <div class="main-wrap-content property_listing <?php if(USERTYPE == 'Mobile') echo 'mobile_list'?>">
        <div class="property_type row">
            <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 col-list-left">
            <?php if(USERTYPE == 'PC') : ?>
            <?=$this->breadcrumb->output()?>
            <?php endif ?>
            <h1 class="heading-title"><span><?=$category['title']?></span></h1>
            		<?php //if($cur_page==1) { ?>
                    <div class="blog-tops">
                    <div class="row">
                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                            <div class="single_news_feature">
                                <a href="<?=site_url($results[0]['category_alias'].'/'.$results[0]['alias'])?>"><img src="<?=base_url()?>uploads/contents/<?=$results[0]['image']?>" alt="<?=$results[0]['title']?>" class="img-responsive"></a>
                                <h2><a href="<?=site_url($results[0]['category_alias'].'/'.$results[0]['alias'])?>"><?=$results[0]['title']?></a></h2>
                                <p><?=sub_string($results[0]['short_content'],200)?></p>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                            <ul class="list_news_feature hidden-xs">
                            <?php if(count($results)>1) { ?>
                                <?php for($i=1; $i<count($results) && $i<=6; $i++) { ?>
                                <li><a href="<?=site_url($results[$i]['category_alias'].'/'.$results[$i]['alias'])?>"><?=$results[$i]['title']?></a></li>
                                <?php } ?>
                            <?php } ?>
                            </ul>
                            <div class="blogs visible-xs">
                            <?php if(count($results)>1) { ?>
                                <?php for($i=1; $i<count($results) && $i<=6; $i++) { ?>
                                <div class="blog-post">
								<div class="thumbnail">
									<a href="<?=site_url($results[$i]['category_alias'].'/'.$results[$i]['alias'])?>" title="<?=$results[$i]['title']?>"> <img src="<?=base_url()?>uploads/contents/<?=$results[$i]['image']?>" alt="<?=$results[$i]['image']?>" class="img-responsive"></a>
        	                   </div> <!-- End .img_holder -->

								<div class="text">
                                    <h3><a href="<?=site_url($results[$i]['category_alias'].'/'.$results[$i]['alias'])?>" title="<?=$results[$i]['title']?>"><?=$results[$i]['title']?></a></h3>
                                    <span class="public-date"><?=_Format_Date($results[$i]['create_time'])?></span>
								</div> <!-- End .text -->
                                <div class="clearfix"></div>
							</div> <!-- End .properties_details -->
                                <?php } ?>
                            <?php } ?>    
                            </div>
                        </div>
                    </div>
                    </div>
                    
                    <div class="blogs">
							<?php if(count($results) > 6):  for($i=7; $i<count($results); $i++) : ?>
							<div class="blog-post">
								<div class="thumbnail">
									<a href="<?=site_url($results[$i]['category_alias'].'/'.$results[$i]['alias'])?>" title="<?=$results[$i]['title']?>"> <img src="<?=base_url()?>uploads/contents/<?=$results[$i]['image']?>" alt="<?=$results[$i]['image']?>" class="img-responsive"></a>
        	                   </div> <!-- End .img_holder -->

								<div class="text">
                                    <h3><a href="<?=site_url($results[$i]['category_alias'].'/'.$results[$i]['alias'])?>" title="<?=$results[$i]['title']?>"><?=$results[$i]['title']?></a></h3>
                                    <span class="public-date"><?=_Format_Date($results[$i]['create_time'])?></span>
									<div class="summary">
                                       <?=sub_string($results[$i]['short_content'], 200)?>
                                    </div>
								</div> <!-- End .text -->
                                <div class="clearfix"></div>
							</div> <!-- End .properties_details -->
                        <?php endfor; endif ?>
                        
					</div> <!-- End .property_type -->
                    
                    <?php //} else {  ?>
                    

                    <?php //} ?>
					<div class="page_indicator">
						<?=$pagination?>
					</div> <!-- End .page_indicator -->
                    <div style="margin:20px 0">
                <?php echo $category['content']; ?>
                </div>
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
                    if($category['id'] == 1){
                        $this->load->view('default/content/last_news', array('category_id'=>2));
                        $this->load->view('default/content/last_news', array('category_id'=>3));
                    } elseif($category['id']==2){
                        $this->load->view('default/content/last_news', array('category_id'=>3));
                    } else {
                        $this->load->view('default/content/last_news', array('category_id'=>2));
                    }
                    
                    $this->load->view('default/require/sitebar_feature');
                    $this->load->view('default/require/sitebar_content_adv');
                    $this->load->view('default/require/top3_content'); 
                    ?>
                </div> <!-- End of column -->


			</div> <!-- End .row -->
		</div> <!-- End .property_listing -->
