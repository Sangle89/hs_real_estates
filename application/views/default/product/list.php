
<!-- BEGIN Main Container col2-left -->                 
<div class="main-container col2-left-layout bounceInUp animated">      
      <div class="container">                      
       <div class="row">
          <div class="col-sm-12">  
          <div class="col-main">      
            <h2 class="page-heading">
                    <span class="page-heading-title"><?=$category['title']?></span>
            </h2> <!--page-heading-->
               
               <input type="hidden" name="category_id" value="<?=$category_id?>" />
<!-- BEGIN CATEGORY PRODUCTS -->
<div class="category-products">
    <ul class="products-grid">       
        <?php foreach($products as $product)  { ?>
        
<li class="item col-lg-3 col-md-3 col-sm-4 col-xs-6">
  <div class="item-inner">
    <div class="item-img">
      <div class="item-img-info">
        <a href="<?=site_url($product['alias'])?>" title="<?=$product['title']?>" class="product-image">
            <img id="product-collection-image-45" class="img-responsive" src="<?=IMAGE_URL.$product['image']?>" alt="" />
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
                        <?php
                        $rate = ($product['rate'] / 5) * 100;
                        ?>
                        <div class="rating" style="width: <?=$rate?>%"></div>
                    </div> <!--rating-box-->
                </div> <!--ratings-->
                <div class="item-quycach">
                            <span>Quy cách: <?=$product['unit']?></span>
                        </div>
                <div class="item-price">
                <div class="price-box">
                    <span class="regular-price" id="product-price-45">
                        <span class="price"><?=_Format_Price($product['price']).UNIT?></span>                                    
                    </span>
                </div>
             </div><!--item-price-->
             <div class="action">
                <button type="button"  title="Add to Cart" class="button btn-cart" onclick="addToCart('<?=$product['id']?>')"><span>Mua hàng</span></button>
             </div><!--action-->
       </div><!--item-content-->
     </div><!--info-inner-->
    </div><!--item-info-->
  </div><!--item-inner-->
</li> <!-- item col-lg-4 col-md-4 col-sm-4 col-xs-6 -->
        <?php } ?>
   </ul>        
   <script type="text/javascript">decorateGeneric($$('ul.products-grid'), ['odd','even','first','last'])</script>
   
</div> <!--category-products-->
            
            <div class="clearfix"></div>
            <div class="">
            <?=$pagination?>
            </div>
     
           </div><!--col-main-->   
           
         </div>


       </div> <!--row-->
      </div><!--container-->
    </div> <!--main-container col2-left-layout-->  
