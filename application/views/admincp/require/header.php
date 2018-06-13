<!-- #HEADER -->
		<header id="header">
			<div id="logo-group">

				<!-- PLACE YOUR LOGO HERE -->
				<span id="logo"> <img src="<?=base_url()?>public/<?=ADMIN_FOLDER?>/img/logo.png" alt="SmartAdmin"> </span>
				<!-- END LOGO PLACEHOLDER -->

				<!-- Note: The activity badge color changes when clicked and resets the number to 0
					 Suggestion: You may want to set a flag when this happens to tick off all checked messages / notifications -->
				
				<span id="activity" class="activity-dropdown" style="display: none;"> <i class="fa fa-user"></i> <b class="badge bg-color-red bounceIn animated"> <?=$total_contact_unview?> </b> </span>
                <div class="ajax-dropdown" style="display: none;">

					<!-- the ID links are fetched via AJAX to the ajax container "ajax-notifications" -->
					<div class="btn-group btn-group-justified" data-toggle="buttons">
						<label class="btn btn-default">
							<input type="radio" name="activity" id="<?=admin_url('contact/unview')?>">
							Liên hệ (<?=$total_contact_unview?>) </label>
						
						
					</div>

					<!-- notification content -->
					<div class="ajax-notifications custom-scroll">

						<div class="alert alert-transparent">
							<h4>Click vào menu liên hệ để xem những tin nhắn mới nhất</h4>
							
						</div>

						<i class="fa fa-lock fa-4x fa-border"></i>

					</div>
					<!-- end notification content -->

					<!-- footer: refresh area -->
					<span> 
						<button type="button" data-loading-text="<i class='fa fa-refresh fa-spin'></i> Loading..." class="btn btn-xs btn-default pull-right">
							<i class="fa fa-refresh"></i>
						</button> </span>
					<!-- end footer -->

				</div>
			</div>

			
			<!-- #TOGGLE LAYOUT BUTTONS -->
			<!-- pulled right: nav area -->
			<div class="pull-right">
				
				<!-- collapse menu button -->
				<div id="hide-menu" class="btn-header pull-right">
					<span> <a href="javascript:void(0);" data-action="toggleMenu" title="Collapse Menu"><i class="fa fa-reorder"></i></a> </span>
				</div>
				<!-- end collapse menu -->
				
                <!-- fullscreen button -->
				<div id="fullscreen" class="btn-header transparent pull-right">
					<span> <a href="javascript:void(0);" data-action="launchFullscreen" title="Full Screen"><i class="fa fa-arrows-alt"></i></a> </span>
				</div>
				<!-- end fullscreen button -->
                
				<!-- #MOBILE -->
				<!-- Top menu profile link : this shows only when top menu is active -->
				<ul id="mobile-profile-img" class="header-dropdown-list hidden-xs padding-5">
					<li class="">
						<a href="#" class="dropdown-toggle no-margin userdropdown" data-toggle="dropdown"> 
							<label>Xin chào: <?=$username?></label>&nbsp;(<?=$group?>)<img src="<?=base_url()?>public/uploads/users/<?=$avatar?>" alt="<?=$username?>" class="online" />  
						</a>
						<ul class="dropdown-menu pull-right">
							<li>
								<a href="<?=admin_url('user/change')?>" class="padding-10 padding-top-0 padding-bottom-0"> <i class="fa fa-user"></i> <u>P</u>rofile</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="<?=admin_url('user/logout')?>" class="padding-10 padding-top-5 padding-bottom-5" data-action="userLogout"><i class="fa fa-sign-out fa-lg"></i> <strong><u>L</u>ogout</strong></a>
							</li>
						</ul>
					</li>
				</ul>

				<!-- logout button -->
				<div id="logout" class="btn-header transparent pull-right">
					<span> <a href="<?=admin_url('logout')?>" title="Sign Out" data-action="userLogout" data-logout-msg="You can improve your security further after logging out by closing this opened browser"><i class="fa fa-sign-out"></i></a> </span>
				</div>
				<!-- end logout button -->

				<!-- search mobile button (this is hidden till mobile view port) -->
				<div id="search-mobile" class="btn-header transparent pull-right">
					<span> <a href="javascript:void(0)" title="Search"><i class="fa fa-search"></i></a> </span>
				</div>
				<!-- end search mobile button -->
				
				<!-- end input: search field -->

				


			</div>
			<!-- end pulled right: nav area -->

		</header>
		<!-- END HEADER -->