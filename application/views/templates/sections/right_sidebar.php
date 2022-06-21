<?php
defined( 'BASEPATH' ) or exit( 'No direct script access allowed' );
?>
<!-- Right sidebar -->
<div class="sidebar sidebar-light sidebar-right sidebar-expand-lg">

    <!-- Sidebar mobile toggler -->
    <div class="sidebar-mobile-toggler text-center">
        <a href="#" class="sidebar-mobile-expand"> <i class="icon-screen-full"></i>
            <i class="icon-screen-normal"></i>
        </a>
        <span class="font-weight-semibold"><?php echo !empty($title) ? $title : 'Right Sidebar'; ?></span>
        <a href="#" class="sidebar-mobile-right-toggle">
			<i class="icon-arrow-right8"></i>
        </a>
    </div>
    <!-- /sidebar mobile toggler -->


    <!-- Sidebar content -->
    <div class="sidebar-content">
		<?php if ( !empty($content) ) echo $content; ?>
    </div>
    <!-- /sidebar content -->

</div>
<!-- /right sidebar -->
