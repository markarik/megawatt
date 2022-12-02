<!-- Main sidebar -->
<div class="sidebar sidebar-main">
	<div class="sidebar-content">
		<!-- Main navigation -->
		<div class="sidebar-category sidebar-category-visible">
			<div class="category-content no-padding">
				<ul class="navigation navigation-main navigation-accordion">
					<!-- Main -->
					<li class="{{ (isset($current_menu) && $current_menu == 'home')?'active':'' }}" >
						<a href="{{ route('home') }}" ><i class="fa fa-line-chart"></i> <span class="text-bold" >Home</span></a>
					</li>
					<li class="{{ (isset($current_menu) && $current_menu == 'tracker')?'active':'' }}" >
						<a href="{{ route('trackers') }}" ><i class="fa fa-map-marker"></i> <span class="text-bold" >Trackers</span></a>
					</li>
					<li class="{{ (isset($current_menu) && $current_menu == 'client')?'active':'' }}" >
						<a href="{{ route('clients') }}" ><i class="fa fa-briefcase"></i> <span class="text-bold" >Clients</span></a>
					</li>
					<li class="{{ (isset($current_menu) && $current_menu == 'agent')?'active':'' }}" >
						<a href="{{ route('agents') }}" ><i class="fa fa-users"></i> <span class="text-bold" >Agents</span></a>
					</li>
					<li class="{{ (isset($current_menu) && $current_menu == 'message')?'active':'' }}" >
						<a href="{{ route('messages') }}" ><i class="fa fa-bullhorn"></i> <span class="text-bold" >Broadcast Messages</span></a>
					</li>
					<li class="{{ (isset($current_menu) && $current_menu == 'users')?'active':'' }}" >
						<a href="{{ route('users') }}" ><i class="fa fa-users"></i> <span class="text-bold" >Users</span></a>
					</li>

				</ul>
			</div>
		</div>
	</div>
</div>

