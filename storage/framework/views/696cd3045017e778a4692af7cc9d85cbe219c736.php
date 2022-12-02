<div class="navbar navbar-inverse">
	<div class="navbar-header">
		<a href="/" class="navbar-brand text-bold">
			<img src="<?php echo e(url('assets/imgs/logo/megawatt-logo-transparent-sm.png')); ?>" title="MegaWatt" class="img-responsive" />
			MegaWatt
		</a>
		<ul class="nav navbar-nav visible-xs-block">
			<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="fa fa-chevron-down"></i></a></li>
			<li><a class="sidebar-mobile-main-toggle"><i class="fa fa-align-justify"></i></a></li>

			<!-- <li><a class="sidebar-mobile-secondary-toggle"><i class="fa fa-ellipsis-v"></i></a></li> -->
		</ul>
	</div>
	<div class="navbar-collapse collapse" id="navbar-mobile">
		<ul class="nav navbar-nav navbar-right">
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown">
					<i class="fa fa-user" ></i>
					<span class="text-bold" ><?php echo e($user->name); ?></span>
					<i class="caret"></i>
				</a>

				<ul class="dropdown-menu dropdown-menu-right">
					<!--
					<li><a href="#"><i class="fa fa-user-plus"></i> My profile</a></li>
					<li class="divider"></li>
					-->
					<li><a href="<?php echo e(route('auth.logout')); ?>"><i class="fa fa-power-off"></i> Logout</a></li>
				</ul>
			</li>
		</ul>
	</div>
</div>
<?php /**PATH /var/www/work/app/resources/views/includes/topnav.blade.php ENDPATH**/ ?>