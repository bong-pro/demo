<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="breadcrumb-line breadcrumb-line-light header-elements-lg-inline border-top-0">

	<!-- Top nav -->
	<div class="d-flex">
		<div class="breadcrumb">
			<a href="<?php echo site_url(); ?>" class="breadcrumb-item"><i class="icon-home2 mr-2"></i>Home</a>
			<?php if ( !empty($current_menu) ) echo doc_generate_breadcrumb($current_menu); ?>
		</div>
		<?php if ( !empty($nav_data) ) : ?>
		<a href="#" class="header-elements-toggle text-default d-lg-none"><i class="icon-more"></i></a>
		<?php endif; ?>
	</div>
	<!-- /Top nav -->

	<!-- Breadcrumb nav -->
	<?php if ( !empty($nav_data) ) : ?>
	<div class="header-elements d-none">
		<div class="breadcrumb justify-content-center">
			<?php foreach ( $nav_data AS $group ) : ?>
			<?php if ( is_array($group['_children']) && sizeof($group['_children']) > 0 ) : ?>
			<div class="breadcrumb-elements-item dropdown p-0">
				<a href="#" class="breadcrumb-elements-item dropdown-toggle <?php echo html_escape($group['link_class']); ?>" data-toggle="dropdown">
					<?php $group['before_html']; ?>
					<?php $group['name']; ?>
				</a>
				<div class="dropdown-menu dropdown-menu-right">
					<?php foreach ( $group['children'] as $item ) : ?>
					<a href="#" class="dropdown-item <?php echo html_escape($item['link_class']); ?>">
						<?php echo $item['before_html']; ?>
						<?php echo $item['name']; ?>
					</a>
					<div class="dropdown-divider"></div>
					<?php endforeach; ?>
				</div>
			</div>
			<?php else : ?>
			<a href="#" class="breadcrumb-elements-item">
				<?php echo $group['before_html']; ?>
				<?php echo $group['name']; ?>
			</a>
			<?php endif; ?>
			<?php endforeach; ?>
		</div>
	</div>
	<?php endif; ?>
	<!-- /Breadcrumb nav -->

</div>
