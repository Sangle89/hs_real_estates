<nav>
<ul>
    <?php foreach($this->config->item('admin_menu') as $menu) { 
        if($this->uri->segment(2) == $menu['controller'])
            $class='active';
        else
            $class = '';
        ?>
        
        <li class="<?=$class?>">
            <a href="<?=(!empty($menu['childs'])) ? '#': $menu['href']?>" title="<?=$menu['title']?>"><i class="<?=$menu['icon']?>"></i><span class="<?=(!empty($menu['childs'])) ? 'menu-item-parent':''?>"><?=$menu['title']?></span></a>
			<?php if(!empty($menu['childs'])) { ?>
            <ul>
                <?php
                    if(isset($menu['childs'])) { 
                 foreach($menu['childs'] as $child) { ?>
                <li class="<?=$child['id']?>" id=""><a href="<?=!empty($child['childs']) ? '#' : $child['href']?>" title=""><?=$child['title']?></a>
                <?php if(isset($child['childs'])) { ?>
                    <ul>
                        <?php foreach($child['childs'] as $child2) { ?>
                            <li><a href="<?=$child2['href']?>"><?=$child2['title']?></a></li>
                        <?php } ?>
                    </ul>
                <?php }?>
                </li>
                <?php } 
                }?>
            </ul>
            <?php } ?>				
        </li>
     <?php } ?>
</ul>	
</nav>