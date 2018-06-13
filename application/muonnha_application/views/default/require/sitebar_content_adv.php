<?php
                    $banners = $this->main_model->_Get_Banner(13);
                    $banner_left = '';
                    foreach($banners as $banner) {
                                        if($banner['type']=='image') {
                                            if($banner['image']!='' && file_exists('./uploads/banners/'.$banner['image']))
                                            $banner_left .= '<a href="'.$banner['link'].'"  target="_blank"  style="" rel="nofollow"><img src="'.base_url('uploads/banners/'.$banner['image']).'" alt="" width="425" height="250" class="img-responsive"></a>';
                                        } elseif($banner['type']=='adsense') {

                                            $banner_left .= $banner['adsense'];

                                        } elseif($banner['type']=='html5') {

                                            $banner_left .= '<iframe frame-border="0" width="980px" height="90px" src="'.$banner['html5'].'"></iframe>';

                                        }

                    }
                    if($banner_left) {?>
                        <div style="margin-bottom: 15px;">
                            <?=$banner_left?>
                        </div>
                    <?php
                    }
                    ?>