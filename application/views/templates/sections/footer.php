<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Footer -->
<div class="navbar navbar-expand-lg navbar-light border-bottom-0 border-top">
	<div class="text-center d-lg-none w-100">
		<button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target="#navbar-footer">
			<i class="icon-unfold mr-2"></i>Footer</button>
	</div>

	<div class="navbar-collapse collapse" id="navbar-footer">
		<span class="navbar-text">&copy; 2022. Copyright: <a href="#">DEMO CO,.LTD.</a></span>
		<span class="ml-lg-auto">
			<code data-popup="tooltip"><?php echo  (ENVIRONMENT === 'development') ?  'CI Version: <strong>' . CI_VERSION . '</strong>' : '' ?></code>
		</span>
	</div>
</div>
<!-- /Footer -->
