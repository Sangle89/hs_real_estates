<script type="text/javascript" src="<?=base_url()?>theme/plugins/lightslider/js/lightslider.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>theme/plugins/lightslider/css/lightslider.min.css"/>
<style>
.tabs-image > li{
    width:auto;
}
.lSSlideWrapper{
	border:1px solid #ddd;
}
.lightSlider.lsGrab>*{
	text-align:center;
}
</style>
<script>
$(document).ready(function(e) {
    $('#image-gallery').lightSlider({
                gallery:true,
                item:1,
                thumbItem:7,
                slideMargin: 0,
                speed:800,
                auto:true,
                loop:true,
				pause: 4000,
                onSliderLoad: function() {
                    $('#image-gallery').removeClass('cS-hidden');
                }  
            }); 
});
</script>
<ul class="nav nav-tabs tabs-image" role="tab">
    <li class="active"><a href="#tabImage" data-toggle="tab" role="tab"><i class="fa fa-image"></i> Hình ảnh</a></li>
    <li><a href="#tabMap" data-toggle="tab" role="tab"><i class="fa fa-map-marker"></i> Bản đồ</a></li>
</ul>
<div class="tab-content" style="margin-bottom:15px;">
    <div class="tab-pane active" id="tabImage" style="margin-top: 10px;">
    <?php if(!empty($real_estate_images)) : ?>
		<ul id="image-gallery" class="gallery list-unstyled cS-hidden">
		<?php foreach($real_estate_images as $image) { 
                $image_resize = $this->image_model->resize($image['image'], 786, 484, 'images');    
                ?>
            <li data-thumb="<?=base_url($image_resize)?>"><img src="<?=base_url($image_resize)?>" alt="<?=$real_estate['title']?>" title="" class="img-responsive" /></li>
		<?php } ?>
		</ul>
    <?php endif; ?>
    </div>
    <div class="tab-pane" id="tabMap" style="padding-top: 10px;margin-bottom: 15px;">
        <div id="ggMap" style="width: 100%;border:1px solid #ddd"></div>
    </div>
</div>
<script src="https://maps.googleapis.com/maps/api/js?key=<?=API_KEY?>&libraries=places"></script>
<script>
$(document).ready(function() {
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
      var target = $(e.target).attr("href") // activated tab
      if(target == '#tabMap') {
        $.ajax({
                url: '<?=base_url('utility/loadmap')?>',
                dataType: 'html',
                type: 'POST',
                data: {address: '<?=$real_estate['address']?>'},
                success: function(html) {
                    $('#ggMap').html(html);
                    initMap('atm', 1000);
                }
            })
      }
    });
})
</script>