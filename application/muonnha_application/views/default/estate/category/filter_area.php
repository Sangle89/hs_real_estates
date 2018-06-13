<div class="boxed-list">
                                            <div class="boxed-heading-title">
                                                <?php if(isset($title_list_category)) {
                                                echo str_replace('theo phường', 'theo diện tích', $title_list_category);
                                            } else echo 'Xem theo diện tích'?>
                                            </div>
                                            <ul class="filter">
                                                <li><a href="<?=site_url($this->uri->segment(1).'/-1/a1')?>">Dưới 20m<sup>2</sup></a></li>
                                                <li><a href="<?=site_url($this->uri->segment(1).'/-1/a2')?>">20 - 30m<sup>2</sup></a></li>
                                                <li><a href="<?=site_url($this->uri->segment(1).'/-1/a3')?>">30 - 50m<sup>2</sup></a></li>
                                                <li><a href="<?=site_url($this->uri->segment(1).'/-1/a4')?>">50 - 60m<sup>2</sup></a></li>
                                                <li><a href="<?=site_url($this->uri->segment(1).'/-1/a5')?>">60 - 70m<sup>2</sup></a></li>
                                                <li><a href="<?=site_url($this->uri->segment(1).'/-1/a6')?>">70 - 80m<sup>2</sup></a></li>
                                                <li><a href="<?=site_url($this->uri->segment(1).'/-1/a7')?>">80 - 90m<sup>2</sup></a></li>
                                                <li><a href="<?=site_url($this->uri->segment(1).'/-1/a8')?>">90 - 100m<sup>2</sup></a></li>
                                                <li><a href="<?=site_url($this->uri->segment(1).'/-1/a9')?>">Trên 100m<sup>2</sup></a></li>
                                            </ul>
                                        </div>