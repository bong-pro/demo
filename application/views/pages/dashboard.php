<?php
defined( 'BASEPATH' ) or exit( 'No direct script access allowed' );

$this->document->add_js( 'gauge_basic', base_url( 'template/global_assets/js/plugins/visualization/echarts/echarts.min.js' ) );
?>

<div class="row">
	<div class="col-xl-6">
		<div class="card">
			<div class="card-body">
				<h1 class="mb-0 h1-clock" id="clock"><?php echo date("Y-m-d H:i:s", time()); ?></h1>
			</div>
		</div>

		<div class="card">
			<div class="card-body">
				<h1>Welcome!</h1>
				<p>The page you are looking at is being generated dynamically by System.</p>

				<p>If you would like to edit this page you'll find it located at:</p>
				<code>application/views/page/dashboard.php</code>

				<p>The corresponding controller for this page is found at:</p>
				<code>application/controllers/Dashboard.php</code>
				<div id='ci_info'>
					<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CI Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
				</div>
			</div>
		</div>
	</div>

	<div class="col-xl-6">
		<div class="card">
			<div class="card-body">
				<div class="form-group row">
					<label class="col-form-label col-lg-4">Server Name</label>
					<div class="col-lg-8">
						<span class="form-control"><?php echo $_SERVER['SERVER_NAME']; ?></span>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-4">Server Addr</label>
					<div class="col-lg-8">
						<span class="form-control"><?php echo $_SERVER['SERVER_ADDR']; ?></span>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-4">PHP Version</label>
					<div class="col-lg-8">
						<span class="form-control"><?php echo phpversion(); ?></span>
					</div>
				</div>

				<legend class="text-uppercase font-size-sm font-weight-bold"></legend>

				<div class="form-group row">
					<label class="col-form-label col-lg-4">CPU Usage percent</label>
					<div class="col-lg-8">
						<span class="form-control" id="cpu_usage_percent"><?php echo $cpu_usage_percent; ?></span>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-4">MEM Usage percent</label>
					<div class="col-lg-8">
						<span class="form-control" id="memory_usage_percent"><?php echo $memory_usage_percent; ?></span>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-4">DISK Usage percent</label>
					<div class="col-lg-8">
						<span class="form-control" id="disk_usage_percent"><?php echo $disk_usage_percent; ?></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
var data = function() {
	var _componentTime = function() {
		const clock = document.getElementById('clock');

		function getTime() {
			const time		= new Date();
			const year		= String(time.getFullYear()).padStart(2, "0");
			const month		= String((time.getMonth() + 1 )).padStart(2, "0");
			const today		= String(time.getDate()).padStart(2, "0");
			const hour		= String(time.getHours()).padStart(2, "0");
			const minutes	= String(time.getMinutes()).padStart(2, "0");
			const seconds	= String(time.getSeconds()).padStart(2, "0");

			clock.innerHTML = `${year}-${month}-${today} ${hour}:${minutes}:${seconds}`;
		}

		setInterval(getTime, 1000);
	};

	var _componentSystemInfo = function() {
		const cpu_usage_percent		= document.getElementById('cpu_usage_percent');
		const memory_usage_percent	= document.getElementById('memory_usage_percent');
		const disk_usage_percent	= document.getElementById('disk_usage_percent');

		function getSystemInfo() {
			$.ajax({
				url			: cp_params.base_url + '/dashboard/get_server_info/',
				error		: function(xhr, status, error) {
					console.log(xhr.responseText);
				},
				success		: function(data) {
					cpu_usage_percent.innerHTML		= data.cpu_usage_percent;
					memory_usage_percent.innerHTML	= data.memory_usage_percent;
					disk_usage_percent.innerHTML	= data.disk_usage_percent;
				}
			});
		}

		setInterval(getSystemInfo, 5000);
	};

	return {
		init: function() {
			_componentTime();
			_componentSystemInfo();
		}
	}
}();

document.addEventListener('DOMContentLoaded', function() {
	data.init();
});
</script>
