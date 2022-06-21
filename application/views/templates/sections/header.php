<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Main navbar -->
<div class="navbar navbar-expand-lg navbar-dark navbar-static">

	<!-- Mobile logo, controller -->
	<div class="d-flex flex-1 d-lg-none">
		<?php if ( $use__left_sidebar ) : ?>
		<button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
			<i class="icon-transmission"></i>
		</button>
		<?php endif; ?>

		<?php if ( $use__right_sidebar ) : ?>
		<button class="navbar-toggler sidebar-mobile-right-toggle" type="button">
			<i class="icon-arrow-right8"></i>
		</button>
		<?php endif; ?>
	</div>
	<!-- /Mobile logo, controller -->

	<!-- Logo -->
	<div class="navbar-brand text-center text-lg-left pt-1 pb-1">
		<a href="/" class="d-inline-block">
			<span class="font-weight-bold text-white d-none d-sm-block" style="font-size:1.5rem">DEMO corp.</span>
			<span class="font-weight-bold text-white d-sm-none" style="font-size:1.6rem">DEMO</span>
		</a>
	</div>
	<!-- /Logo -->

	<!-- Header right nav -->

	<span class="ml-lg-3 mr-lg-auto"></span>

	<ul class="navbar-nav flex-row order-1 order-lg-2 flex-1 flex-lg-0 justify-content-end align-items-center">
		<li class="nav-item nav-item-dropdown-lg dropdown dropdown-user h-100">
			<a href="#" class="navbar-nav-link navbar-nav-link-toggler dropdown-toggle d-inline-flex align-items-center h-100" data-toggle="dropdown">
				<?php echo $this->user->get_avatar(array(
					'class'	=> 'rounded-pill mr-lg-2 border',
					'width'	=> 30,
				)); ?>
				<span class="d-none d-lg-inline-block"><?php echo $this->user->item('name'); ?></span>
			</a>

			<div class="dropdown-menu dropdown-menu-right">
				<a href="<?php echo base_url('/admin/profile'); ?>" class="dropdown-item"><i class="icon-user-plus"></i>My profile</a>
				<div class="dropdown-divider"></div>
				<a href="#" class="dropdown-item"><i class="icon-cog5"></i>Account settings</a>
				<a href="<?php echo base_url('/auth/logout'); ?>" class="dropdown-item"><i class="icon-switch2"></i>Logout</a>
			</div>
		</li>
	</ul>
	<!-- /Header right nav -->

</div>
<!-- /Main naver -->
