<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="ko">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover, shrink-to-fit=no">
	<meta name="HandheldFriendly" content="true">
	<meta name="theme-color" content="<?php echo html_escape($theme_color); ?>">
	<meta name="robots" content="noindex">
	<meta name="googlebot" content="noindex">

	<title><?php echo $page_title; ?></title>

	<!-- Stylesheets -->
	<link rel="shortcut icon" href="<?php echo base_url('assets/images/logo/favicon.ico'); ?>" />
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link rel="stylesheet" id="icomoon-css" href="<?php echo base_url('template/global_assets/css/icons/icomoon/styles.min.css'); ?>" type="text/css" media="all">
	<link rel="stylesheet" id="all-css" href="<?php echo base_url('template/' . $layout_num . $direction . $theme . 'full/assets/css/all.min.css'); ?>" type="text/css" media="all">
	<link rel="stylesheet" id="core-css" href="<?php echo base_url('assets/css/codepress/codepress.css'); ?>" type="text/css" media="all">
	<?php $this->document->output_css(); ?>
	<!-- /Stylesheets -->

	<!-- Core JS files -->
	<script type="text/javascript" src="<?php echo base_url('template/global_assets/js/main/jquery.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('template/global_assets/js/main/bootstrap.bundle.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('template/global_assets/js/plugins/loaders/blockui.min.js'); ?>"></script>
	<!-- /Core JS files -->

	<!-- Theme JS files -->
	<script type="text/javascript" src="<?php echo base_url('template/' . $layout_num . $direction . $theme . 'full/assets/js/app.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/axios/axios.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/codepress/codepress.js'); ?>"></script>
	<?php $this->document->output_js(); ?>
	<!-- /Theme JS files -->
</head>

<body class="<?php echo html_escape($body_class); ?>">

	<?php echo $section__header; ?>

	<div class="page-content <?php echo html_escape($page_class);?>">

		<?php echo $section__left_sidebar; ?>

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Inner content -->
			<div class="content-inner">
				<?php if ( !empty($section__page_title) || !empty($section__breadcrumb) ) : ?>
				<div class="page-header page-header-light">
					<?php if ( strpos($_SERVER['REQUEST_URI'], 'auth') ) : ?>
					<?php else : ?>
						<?php echo $section__page_title; ?>
					<?php endif; ?>
					<?php echo $section__breadcrumb; ?>
				</div>
				<?php endif; ?>
				<div id="content" class="content <?php echo html_escape($content_class); ?>">
					<?php echo $section__content; ?>
				</div>
				<?php echo $section__footer; ?>
			</div>
			<!-- /Inner content -->

		</div>
		<!-- /Main content -->

		<?php echo $section__right_sidebar; ?>

	</div><!-- .page-content -->

	<?php $this->document->output_js(true); ?>

</body>
</html>
