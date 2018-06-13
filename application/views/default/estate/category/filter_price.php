<div class="boxed-list">
<div class="boxed-heading-title">
<?php 
if(!isset($url_pathname)) {
    $url_pathname = $this->uri->segment(1); 
}
if(isset($title_search_price)) {
   echo $title_search_price;
} else 
    echo 'Xem theo giá';
?>
                                              
</div>
                                            <ul class="filter">
                                                <li><a href="<?=site_url($url_pathname.'/p1/-1')?>">Dưới 1 triệu</a></li>
                                                <li><a href="<?=site_url($url_pathname.'/p2/-1')?>">1 - 2 triệu</a></li>
                                                <li><a href="<?=site_url($url_pathname.'/p3/-1')?>">2 - 3 triệu</a></li>
                                                <li><a href="<?=site_url($url_pathname.'/p4/-1')?>">3 - 5 triệu</a></li>
                                                <li><a href="<?=site_url($url_pathname.'/p5/-1')?>">5 - 7 triệu</a></li>
                                                <li><a href="<?=site_url($url_pathname.'/p6/-1')?>">7 - 10 triệu</a></li>
                                                <li><a href="<?=site_url($url_pathname.'/p7/-1')?>">10 - 15 triệu</a></li>
                                                <li><a href="<?=site_url($url_pathname.'/p8/-1')?>">Trên 15 triệu</a></li>
                                            </ul>
                                            
                                        </div>