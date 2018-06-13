<div class="boxed-list">
                                            <div class="boxed-heading-title">
                                            <?php if(isset($title_list_category)) {
                                                echo str_replace('theo phường', 'theo giá', $title_list_category);
                                            } else echo 'Xem theo giá'?>
                                                
                                            </div>
                                            <ul class="filter">
                                                <li><a href="<?=site_url($this->uri->segment(1).'/p1/-1')?>">Dưới 1 triệu</a></li>
                                                <li><a href="<?=site_url($this->uri->segment(1).'/p2/-1')?>">1 - 2 triệu</a></li>
                                                <li><a href="<?=site_url($this->uri->segment(1).'/p3/-1')?>">2 - 3 triệu</a></li>
                                                <li><a href="<?=site_url($this->uri->segment(1).'/p4/-1')?>">3 - 5 triệu</a></li>
                                                <li><a href="<?=site_url($this->uri->segment(1).'/p5/-1')?>">5 - 7 triệu</a></li>
                                                <li><a href="<?=site_url($this->uri->segment(1).'/p6/-1')?>">7 - 10 triệu</a></li>
                                                <li><a href="<?=site_url($this->uri->segment(1).'/p7/-1')?>">10 - 15 triệu</a></li>
                                                <li><a href="<?=site_url($this->uri->segment(1).'/p8/-1')?>">Trên 15 triệu</a></li>
                                            </ul>
                                            
                                        </div>