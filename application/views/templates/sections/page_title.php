<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="page-header page-header-light">
	<div class="page-header-content header-elements-lg-inline">

		<!-- Page title nav -->
		<div class="page-title d-flex">
			<h4>
				<i class="icon-arrow-left52 mr-2"></i>
				<span class="font-weight-semibold">
					<?php echo !empty($page_link) ? $page_link : 'Home'; ?>
				</span>
				<span class="font-weight-nomal"> - <?php echo !empty($page_title) ? $page_title : 'Dashboard'; ?></span>
			</h4>
			<?php if ( !empty($nav_data) ) : ?>
				<a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
			<?php endif; ?>
		</div>

		<?php if ( !empty($nav_data) ) : ?>
		<div class="header-elements d-none">
			<div class="d-flex justify-content-center">
			<?php foreach ( $nav_data AS $item ) : ?>
				<a href="<?php echo $item['link']; ?>" class="btn btn-link btn-float text-body <?php echo html_escape($item['link_class']); ?>">
					<?php echo $item['before_html'] . '<span>HOME</span> - ' . $item['name'] . $item['after_html']; ?>
				</a>
			<?php endforeach; ?>
			</div>
		</div>
		<?php endif; ?>
		<!-- /Page title nav -->

	</div>
</div>
