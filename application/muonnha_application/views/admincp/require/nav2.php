<nav>
				<ul>
					<li class="active">
						<a href="<?=admin_url()?>" title="Dashboard"><i class="fa fa-lg fa-fw fa-home"></i> <span class="menu-item-parent">Home</span></a>
						
					</li>
					<li class="top-menu-invisible">
						<a href="#"><i class="fa fa-lg fa-fw fa-cube txt-color-blue"></i> <span class="menu-item-parent">Nội dung</span></a>
						<ul>
							<li class="">
								<a href="<?=admin_url('content_category')?>" title="Dashboard"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Nhóm tin</span></a>
							</li>
							
                            <?php 
                            $main_category = $this->content_category_model->_Get_All_Category_Main();
                            foreach($main_category as $lv1) {?>
                                <li>
								<a href="<?=admin_url('content/index/0/'.$lv1['id'])?>"><i class="fa fa-pagelines"></i> <?=$lv1['title']?></a>
                                <?php $sub_category = $this->content_category_model->_Get_All_Category_Sub($lv1['id']);?>
                                <?php if($sub_category) { ?>
                                <ul>
                                <?php foreach($sub_category as $lv2) { ?>
                                    <li><a href="<?=admin_url('content/index/0/'.$lv2['id'])?>"><?=$lv2['title']?></a></li>
                                <?php } ?>
                                </ul>
                                <?php } ?>
							</li>
                            <?php    
                            }
                            ?>
                            
							<li>
								<a href="<?=admin_url('page')?>"><i class="fa fa-stack-overflow"></i> Trang nội dung</a>
							</li>
							<li>
								<a href="<?=admin_url('gioithieu')?>"><i class="fa fa-stack-overflow"></i> Trang giới thiệu</a>
							</li>
                            <li>
								<a href="<?=admin_url('duan_layout')?>"><i class="fa fa-stack-overflow"></i> Dự án trang chủ</a>
							</li>
						</ul>
					</li>
					<li>
						<a href="<?=admin_url('duan')?>"><i class="fa fa-lg fa-fw fa-inbox"></i> <span class="menu-item-parent">Dự án</span></a>
						<ul>
                        <?php foreach($all_duan as $val) { ?>
							<li>
								<a href="#"><?=$val['title']?> </a>
                                <ul>
									<li>
										<a href="<?=admin_url('duan_gioithieu/index/' . $val['id'])?>"><i class="fa fa-file-text-o"></i> Giới thiệu</a>
									</li>
									<li>
										<a href="<?=admin_url('duan_bietthu/index/' . $val['id'])?>"><i class="fa fa-home"></i> Biệt thự</a>
									</li>
                                    <li>
										<a href="<?=admin_url('duan_matbang/index/' . $val['id'])?>"><i class="fa fa-map-marker"></i> Mặt bằng</a>
									</li>
                                    <li>
										<a href="<?=admin_url('duan_thuvien/index/' . $val['id'])?>"><i class="fa fa-image"></i> Thư viện</a>
									</li>
                                    <li>
										<a href="<?=admin_url('duan_tienich/index/' . $val['id'])?>"><i class="fa fa-image"></i> Tiện ích</a>
									</li>
                                    <li>
										<a href="<?=admin_url('duan_tintuc/index/' . $val['id'])?>"><i class="fa fa-file-text-o"></i> Tin tức</a>
									</li>
                                    <li>
										<a href="<?=admin_url('duan_tiendo/index/' . $val['id'])?>"><i class="fa fa-file-text-o"></i> Tiến độ</a>
									</li>
                                    <li>
										<a href="<?=admin_url('duan_thongtindautu/change/' . $val['id'])?>"><i class="fa fa-file-text-o"></i> Thông tin đầu tư</a>
									</li>
								</ul>
							</li>
							<?php } ?>
						</ul>	
					</li>
                    <li>
						<a href="<?=admin_url('slide')?>"><i class="fa fa-lg fa-fw fa-image"></i> <span class="menu-item-parent">Slide</span></a>
					</li>
                    <li>
						<a href="<?=admin_url('logo')?>"><i class="fa fa-lg fa-fw fa-image"></i> <span class="menu-item-parent">Logo</span></a>
					</li>
					<li>
						<a href="<?=admin_url('download')?>"><i class="fa fa-lg fa-fw fa-download"></i> <span class="menu-item-parent">Download</span></a>
					</li>
                    <li>
						<a href="<?=admin_url('hoidap')?>"><i class="fa fa-lg fa-fw fa-question"></i> <span class="menu-item-parent">Hỏi đáp</span></a>
					</li>
                    <li>
						<a href="<?=admin_url('daily')?>"><i class="fa fa-lg fa-fw fa-cube"></i> <span class="menu-item-parent">Đại lý</span></a>
					</li>
                    <li>
						<a href="<?=admin_url('city')?>"><i class="fa fa-lg fa-fw fa-map-marker"></i> <span class="menu-item-parent">Tỉnh thành</span></a>
					</li>
					<li>
						<a href="<?=admin_url('contact')?>"><i class="fa fa-lg fa-fw fa-envelope"></i> <span class="menu-item-parent">Liên hệ</span></a>
					</li>
                    <li>
						<a href="<?=admin_url('newsletter')?>"><i class="fa fa-lg fa-fw fa-envelope"></i> <span class="menu-item-parent">Newsletter</span></a>
					</li>
                    <li>
						<a href="<?=admin_url('dangkymua')?>"><i class="fa fa-lg fa-fw fa-envelope"></i> <span class="menu-item-parent">Khách hàng</span></a>
					</li>
                    <li>
						<a href="#"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Cài đặt</span></a>
                        <ul>
							<li>
								<a href="<?=admin_url('setting/website')?>">Cài đặt website</a>
							</li>
							<li>
								<a href="<?=admin_url('setting/email')?>">Cài đặt Email</a>
							</li>
						</ul>
					</li>
                    <li>
						<a href="<?=admin_url('user')?>"><i class="fa fa-lg fa-fw fa-users"></i> <span class="menu-item-parent">User</span></a>
					</li>
				</ul>
			</nav>