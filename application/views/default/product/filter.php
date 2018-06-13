<?php foreach($products as $product)  { ?>
        
<li class="item col-lg-3 col-md-3 col-sm-4 col-xs-6">
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
             <div class="action">
                <button type="button"  title="Add to Cart" class="button btn-cart" onclick=""><span>Mua hàng</span></button>
             </div><!--action-->
       </div><!--item-content-->
     </div><!--info-inner-->
    </div><!--item-info-->
  </div><!--item-inner-->
</li> <!-- item col-lg-4 col-md-4 col-sm-4 col-xs-6 -->
        <?php } ?>
