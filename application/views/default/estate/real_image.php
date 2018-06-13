<?php if(!empty($real_estate_images)) : ?>

                                <div class="boxed-detail-heading-title" style="margin-bottom: 0;">Hình ảnh</div>


                                <div class="slider_wrapper">

                                    <div class="pd-slide" id="divmyGallery">
                                        <ul id="myGallery" style="margin: 0 !important;">
                                            <?php
                             foreach($real_estate_images as $image) { ?>
                                                <li>
                                                    <img src="<?=base_url()?>uploads/images/<?=$image['image']?>" style="max-width: 100%; max-height: 380px;" alt="<?=$real_estate['title']?>" title="" class="img-responsive" /></li>
                                                <?php } ?>
                                        </ul>
                                    </div>

                                </div>

                                <?php endif; ?>