<!-- BEGIN Main Container -->  
<div class="main-container col1-layout wow bounceInUp animated"> 
    <div class="main">  
        <div class="container">
            <div class="row">    
                <div class="col-lg-9 col-md-9">
                    <div class="col-main">
    <!-- Endif Next Previous Product -->
  <div class="product-view row" itemscope itemtype="http://schema.org/Product" itemid="#product_base">
    <div id="messages_product_view"></div>
    <div class="product-essential">
   <form action="" method="post" id="product_addtocart_form">
    <div class="product-img-box col-lg-5 col-sm-5 col-xs-12">
      <div class="new-label new-top-left"><span> New </span></div>
      <div class="sale-label sale-top-right"><span> Sale </span></div>    
      
<script src="<?=base_url()?>theme/js/cloud-zoom.js" type="text/javascript"></script>
<div class="product-image">
  <div class="product-full"> 
  <?php
  $first_image = reset($product_images);
  ?>
    <img itemprop="image" id="product-zoom" src="<?=THUMB_URL.$first_image['image']?>" data-zoom-image="<?=IMAGE_URL.$first_image['image']?>" alt="" />  
    </div><!--product-full-->
                        <div class="more-views">
                        <div class="slider-items-products">
                          <div id="gallery_01" class="product-flexslider hidden-buttons product-img-thumb">
                            <div class="slider-items slider-width-col4 block-content">
                            <?php foreach($product_images as $image) { ?>
                                <div class="more-views-items"> 
                                    <a href="<?=THUMB_URL.$image['image']?>" data-image="<?=THUMB_URL.$image['image']?>" data-zoom-image="<?=IMAGE_URL.$image['image']?>"> 
                                        <img id="product-zoom"  src="<?=THUMB_URL.$image['image']?>" /> 
                                    </a>
                                  </div><!--more-views-items-->
                                <?php } ?>
                            </div> <!--slider-items slider-width-col4 block-content-->
                          </div> <!--gallery_01-->
                        </div> <!--slider-items-products-->
                      </div> <!--more-views-->
  </div> <!--product-image-->

           
      <div class="clear"></div>
    </div>
  

    <div class="product-shop col-lg-7 col-sm-7 col-xs-12">
    
    <div class="no-display">
      <input type="hidden" name="product" value="45" />
      <input type="hidden" name="related_product" id="related-products-field" value="" />
    </div>


     <div class="product-name">
	     <h1 itemprop="name"><?=$product['title']?></h1>
     </div> <!--product-name-->
     
     
      <div class="short-description">  
     <p><?=$product['short_content']?></p>
        </div>
      <span itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
        <meta itemprop="ratingValue" content="80"/> 
        <meta itemprop="reviewCount" content="1" /> 
        <meta itemprop="bestRating" content="100"/> 
        <meta itemprop="worstRating" content="0"/>
        
    </span> 
<div class="price-block">
     <div class="price-box">
     
        <span class="regular-price" id="product-price-45">
           Giá: <span class="price"><?=_Format_Price($product['price']).UNIT?></span>     
                                          
        </span>
        <div class="item-quycach">
                            <span>Quy cách: <?=$product['unit']?></span>
                        </div>
            <div class="ratings">
            <div class="rating-box">
                <?php
                        $rate = ($product['rate'] / 5) * 100;
                        ?>
                <div class="rating" style="width:<?=$rate?>%"></div>
            </div>
            
        </div>
     </div>
</div><!--price-block-->        
          


   
 <div class="add-to-box">                      
    
<div class="add-to-cart">
  
  <div class="pull-left">  
    <div class="custom pull-left">
          <button onClick="var result = document.getElementById('qty'); var qty = result.value; if( !isNaN( qty ) &amp;&amp; qty &gt; 0 ) result.value--;return false;" class="reduced items-count" type="button"><i class="fa fa-minus"></i></button>
          <input type="text" name="qty" id="qty"  maxlength="12" value="1" title="Quantity:" class="input-text qty" />
            <button onClick="var result = document.getElementById('qty'); var qty = result.value; if( !isNaN( qty )) result.value++;return false;" class="increase items-count" type="button"><i class="fa fa-plus"></i></button>
     </div> <!--custom pull-left-->
  </div> <!--pull-left-->     
  <button type="button" title="Thêm vào giỏ hàng" class="button btn-cart" onclick="addToCart('<?=$product['id']?>');"><span>Mua hàng</span></button>   
</div> <!--add-to-cart-->
                             
                
<div class="email-addto-box social">
   <ul class="link">
        <li class="fb">
			<a href="http://www.facebook.com/share.php?u=<?=current_url()?>&amp;t=" rel="nofollow" target="_blank" style="text-decoration:none;">
				
			</a>
			</li>
            <li class="tw">
			<a href="http://twitter.com/home?status=%20-%20<?=current_url()?>" rel="nofollow" target="_blank" style="text-decoration:none;">
				
			</a>
			</li>
            <li class="googleplus">
			<a href="https://plus.google.com/share?url=<?=current_url()?>" rel="nofollow" target="_blank" style="text-decoration:none;">	
			</a>
			</li>
   </ul>  <!--add-to-links-->

</div> <!--email-addto-box-->  
</div> <!--add-to-box-->            

</div> <!--product-shop-->  


</form>


</div> <!--product-essential-->




  </div> <!--product-view-->
  <div class="maincontent" style="padding: 10px;border:1px solid #f6f6f6;margin-top: 15px;">
     <?php echo $product['content']?>
  </div>
 

</div> <!--col-main-->
                </div><!--End left-->
                <div class="col-lg-3 col-md-3">
                    <div class="huongdan">
                        <?php
                $content = $this->page_model->_Get_By_Id(3);
                echo $content['content'];
                ?>
                    </div>
                </div> <!--End right-->           
            

  <div class="product-collateral col-lg-12 col-sm-12 col-xs-12">
    <!-- Tabs -->
        
  </div> <!--product-collateral col-lg-12 col-sm-12 col-xs-12-->
  

<script type="text/javascript">
    var lifetime = 3600;
    var expireAt = Mage.Cookies.expires;
    if (lifetime > 0) {
        expireAt = new Date();
        expireAt.setTime(expireAt.getTime() + lifetime * 1000);
    }
    Mage.Cookies.set('external_no_cache', 1, expireAt);
</script>
 
   </div><!--row-->
  </div><!--container-->    
	    </div><!--main--> 
          </div> <!--col1-layout-->

      <!-- Related Products -->
      

<!-- BEGIN CATEGORY PRODUCTS -->


<div class="container">
  <div class="related-pro">
    <div class="slider-items-products">
     <div class="related-block">
      <div id="related-products-slider" class="product-flexslider hidden-buttons">
        <div class="home-block-inner">
          <div class="block-title">
            <h2>Sản phẩm cùng loại</h2>
            <div class="hidden-xs hidden-sm"></div> 
          </div>
           
        </div> <!--home-block-inner-->

       <div class="slider-items slider-width-col4 products-grid block-content">
          
          <?php foreach($products as $product)  { ?>
        
<div class="item">
  <div class="item-inner">
    <div class="item-img">
      <div class="item-img-info">
        <a href="<?=site_url($product['alias'])?>" title="<?=$product['title']?>" class="product-image">
            <img id="product-collection-image-45" class="img-responsive" src="<?=THUMB_URL.$product['image']?>" alt="" />
        </a>
        
      </div><!--item-img-info-->
    </div><!--item-img-->
    <div class="item-info">
     <div class="info-inner">
       <div class="item-title">
          <a href="<?=site_url($product['alias'])?>" title="<?=$product['title']?>"><?=$product['title']?></a>
       </div><!--item-title-->
              <div class="item-content">
                <div class="ratings">
                    <div class="rating-box">
                        <div class="rating" style="width: 80%"></div>
                    </div> <!--rating-box-->
                </div> <!--ratings-->
                <div class="item-price">
                <div class="price-box">
                    <span class="regular-price" id="product-price-45">
                        <span class="price"><?=_Format_Price($product['price'])?></span>                                    
                    </span>
                </div>
             </div><!--item-price-->
           
       </div><!--item-content-->
     </div><!--info-inner-->
    </div><!--item-info-->
  </div><!--item-inner-->
</div> <!-- item col-lg-4 col-md-4 col-sm-4 col-xs-6 -->
        <?php } ?>       
          
               
          </div><!--slider-items slider-width-col4 products-grid-->
      </div><!--product-flexslider hidden-buttons-->

     </div><!--related-block-->
    </div><!--slider-items-products-->
  </div><!--related-pro-->
</div><!--container-->   
  <!-- end related product -->

  <!-- end related product -->