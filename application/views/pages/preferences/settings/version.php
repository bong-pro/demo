<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php if ( ! empty( $version_info ) ) :?>
	<div id="accordion-group">
		<?php foreach ( $version_info AS $item ) : ?>
			<div class="card mb-0 rounded-bottom-0">
				<div class="card-header header-elements-inline">
					<h6 class="card-title">
						<a data-toggle="collapse" class="text-default collapsed" href="#accordion-item-0001" aria-expanded="false">
							<span class="badge badge-primary mr-1">#0001</span>
							<span class="font-size-base text-muted ml-2"><?php echo $item['name']; ?></span>
						</a>
					</h6>
					<div class="header-elements">
						<?php echo $item['created']; ?>
					</div>
				</div>
				<div id="accordion-item-0001" class="collapse" data-parent="#accordion-group" style="">
					<div class="card-body">
						<div class="progress mb-3" style="height: 0.625rem;">
							<div class="progress-bar progress-bar-striped bg-secondary" style="width: <?php echo $item['percent']; ?>%">
								<span class="sr-only"><?php echo $item['percent']; ?>% Complete</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
<?php else : ?>
	<div class="alert alert-danger alert-styled-left alert-dismissible">
		<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
		<span class="font-weight-semibold">Sorry.</span> There is currently no registered version information.</div>
<?php endif; ?>
