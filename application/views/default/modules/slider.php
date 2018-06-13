<ul class="bxslider">
<?php foreach($slides as $val) { ?>
            <li><img src="<?=IMAGE_URL.$val['image']?>" alt="" class="img-responsive"></li>
            <?php } ?>
          </ul>

          <div id="bx-pager">
          <?php foreach($slides as $key=>$val) { ?>
            <a data-slide-index="<?=$key?>" href=""><img src="<?=IMAGE_URL.$val['image']?>" alt="" class="img-responsive"></a>
            <?php } ?>
          </div>