<div class="boxed-list">
<div class="boxed-heading-title">
<?php 
if(!isset($url_pathname)) {
    $url_pathname = $this->uri->segment(1); 
}
if(isset($title_search_area)) {
    echo $title_search_area;
} else 
    echo 'Xem theo diện tích';
?>
</div>
                                            <ul class="filter">
                                                <li><a href="<?=site_url($url_pathname.'/-1/a1')?>">Dưới 20m<sup>2</sup></a></li>
                                                <li><a href="<?=site_url($url_pathname.'/-1/a2')?>">20 - 30m<sup>2</sup></a></li>
                                                <li><a href="<?=site_url($url_pathname.'/-1/a3')?>">30 - 50m<sup>2</sup></a></li>
                                                <li><a href="<?=site_url($url_pathname.'/-1/a4')?>">50 - 60m<sup>2</sup></a></li>
                                                <li><a href="<?=site_url($url_pathname.'/-1/a5')?>">60 - 70m<sup>2</sup></a></li>
                                                <li><a href="<?=site_url($url_pathname.'/-1/a6')?>">70 - 80m<sup>2</sup></a></li>
                                                <li><a href="<?=site_url($url_pathname.'/-1/a7')?>">80 - 90m<sup>2</sup></a></li>
                                                <li><a href="<?=site_url($url_pathname.'/-1/a8')?>">90 - 100m<sup>2</sup></a></li>
                                                <li><a href="<?=site_url($url_pathname.'/-1/a9')?>">Trên 100m<sup>2</sup></a></li>
                                            </ul>
</div>