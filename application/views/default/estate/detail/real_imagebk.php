<style>
.tabs-image > li{
    width:auto;
}
</style>

<ul class="nav nav-tabs tabs-image" role="tab">
    <li class="active"><a href="#tabImage" data-toggle="tab" role="tab"><i class="fa fa-image"></i> Hình ảnh</a></li>
    <li><a href="#tabMap" data-toggle="tab" role="tab"><i class="fa fa-map-marker"></i> Bản đồ</a></li>
</ul>
<div class="tab-content">
    <div class="tab-pane active" id="tabImage">
    <?php if(!empty($real_estate_images)) : ?>
        <div class="slider_wrapper">
            <div class="pd-slide" id="divmyGallery">
                <ul id="myGallery" style="margin: 0 !important;">
                <?php foreach($real_estate_images as $image) { 
                $image_resize = $this->image_model->resize($image['image'], 786, 484, 'images');    
                ?>
                <li><img src="<?=base_url($image_resize)?>" alt="<?=$real_estate['title']?>" title="" class="img-responsive" /></li>
                <?php } ?>
                </ul>
            </div>
        </div>
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