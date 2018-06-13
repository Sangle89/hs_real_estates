<?php if(isset($list_link_location) && !empty($list_link_location)) : ?>
                                        <div class="boxed-list">
                                            <div class="boxed-heading-title">
                                                Liên kết nổi bật
                                            </div>
                                            <ul>
                                            <?php
                                            foreach($list_link_location as $category){?>
                                            <li><h3 style="margin: 0;"><a href="<?=($category['link'])?>"><?=$category['title']?></a></h3></li>
                                            <?php } ?>
                                            </ul>
                                        </div>
                                        <?php endif; ?>