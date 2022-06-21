<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Main sidebar -->
<div class="sidebar sidebar-dark sidebar-main sidebar-expand-lg sidebar-main-resized">

	<!-- Sidebar content -->
	<div class="sidebar-content">

		<!-- User menu -->
		<div class="sidebar-section sidebar-user my-1">
			<div class="sidebar-section-body">
				<div class="media">
					<a href="#" class="mr-3">
					<?php echo $this->user->get_avatar(array(
						'width'	=> 34,
						'class'	=> 'rounded-circle border',
					)); ?>
					</a>

					<div class="media-body">
						<div class="font-weight-semibold"><?php echo $this->user->item('name'); ?></div>
						<div class="font-size-sm line-height-sm opacity-50"><?php echo $this->user->item('email'); ?></div>
					</div>

					<div class="ml-3 align-self-center">
						<button type="button" class="btn btn-outline-light-100 text-white border-transparent btn-icon rounded-pill btn-sm sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
							<i class="icon-transmission"></i>
						</button>

						<button type="button" class="btn btn-outline-light-100 text-white border-transparent btn-icon rounded-pill btn-sm sidebar-mobile-main-toggle d-lg-none">
							<i class="icon-cross2"></i>
						</button>
					</div>
				</div>
			</div>
		</div>
		<!-- /User menu -->

		<!-- Main navigation -->
		<?php if ( ! empty( $nav_data ) ) : ?>
		<div class="sidebar-section">
			<ul class="nav nav-sidebar" data-nav-type="accordion">
				<?php foreach ( $nav_data as $item ) : ?> 
				<li class="nav-item-header" <?php echo html_escape($item['link_class']); ?>>
					<div class="text-uppercase font-size-xs line-height-xs">
						<?php echo $item['before_html'] . '<span>' . $item['name'] . '</span>' . $item['after_html']; ?>
					</div>
					<i class="icon-menu" title="<?php echo html_escape($item['name']); ?>"></i>
				</li>
				<?php echo doc_generate_nav($item['_children'], $document_ID); ?>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php endif; ?>
		<!-- /Main navigation -->

	</div>
	<!-- /Sidebar content -->

</div>
<!-- /Main sidebar -->
