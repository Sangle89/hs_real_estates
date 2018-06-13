<?php if(!empty($list_category)) : ?>
                                        <div class="boxed-list">
                                            <!-- Main_title2__________ -->
                                            <div class="boxed-heading-title">
                                                <?php echo isset($title_list_category) ? $title_list_category : 'Danh mục tin đăng'?>
                                            </div>
                                            <!-- End Main_title2______ -->
                                            <ul>
                                            <?php
                                                foreach($list_category as $category) {
                                            ?>
                                                    <li>
                                                        <h3 style="margin: 0;"><a href="<?=site_url($category['alias'])?>"><?=$category['title']?></a> (<?=$category['total']?>)</h3></li>
                                                    <?php } ?>
                                            </ul>
                                        </div>
                                        <?php endif ?>