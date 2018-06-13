<div class="banner-adv">
                <?php
                    $banners = $this->main_model->_Get_Banner(2);
                    $banner_left = '';
                    foreach($banners as $key => $banner) {
                        if($key > 0) $nomargin = ' nomargin';
                        else $nomargin = '';
                        if($banner['type']=='image') {
                            if($banner['image']!='' && file_exists('./uploads/banners/'.$banner['image']))
                            $banner_left .= '<div class="banner-home'.$nomargin.'"><a href="'.$banner['link'].'"  target="_blank"  style="" rel="nofollow"><img src="'.base_url('uploads/banners/'.$banner['image']).'" alt="" width="300" height="170" class="img-responsive"></a></div>';
                        } elseif($banner['type']=='adsense') {
                            $banner_left .= '<div class="banner-home'.$nomargin.'">'.$banner['adsense'].'</div>';
                        } elseif($banner['type']=='html5') {
                            $banner_left .= '<div class="banner-home'.$nomargin.'"><iframe frame-border="0" width="980px" height="90px" src="'.$banner['html5'].'"></iframe></div>';
                        }
                    }
                    echo $banner_left;
                    ?>
                </div>