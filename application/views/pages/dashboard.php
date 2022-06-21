<?php
defined( 'BASEPATH' ) or exit( 'No direct script access allowed' );

$this->document->add_js( 'gauge_basic', base_url( 'template/global_assets/js/plugins/visualization/echarts/echarts.min.js' ) );
?>

<div class="row">
	<div class="col-xl-6">
		<div class="card">
			<div class="card-body">
				<h1 class="mb-0 h1-clock"><?php echo date("Y-m-d H:i:s", time()); ?></h1>
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

		<div class="col-sm-4 pl-0">
			<div class="card" style="height: 300px;">
				<div class="card-body">
					<div class="chart-container">
						<div class="chart has-fixed-height" id="gauge_basic"></div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-xl-6">
		<div class="card">
			<div class="card-body">
				<div class="form-group row">
					<label class="col-form-label col-lg-4">RAM Usage</label>
					<div class="col-lg-8">
						<input type="text" name="memusage" class="form-control" disabled>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-4">CPU Usage(%)</label>
					<div class="col-lg-8">
						<input type="text" name="cpuload" id="cpuload" class="form-control" disabled>
					</div>
				</div>

				<hr>

				<div class="form-group row">
					<label class="col-form-label col-lg-4">Hard Disk Usage(%)</label>
					<div class="col-lg-8">
						<input type="text" name="diskusage" class="form-control" disabled>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-4">Hard Disk Usage(%)</label>
					<div class="col-lg-8">
						<input type="text" name="diskusage" class="form-control" disabled>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-4">Established Connections</label>
					<div class="col-lg-8">
						<input type="text" name="connections" class="form-control" disabled>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-4">Total Connections</label>
					<div class="col-lg-8">
						<input type="text" name="totalconnections" class="form-control" disabled>
					</div>
				</div>

				<hr>

				<div class="form-group row">
					<label class="col-form-label col-lg-4">CPU Threads</label>
					<div class="col-lg-8">
						<input type="text" name="cpu_count" class="form-control" disabled>
					</div>
				</div>

				<hr>

				<div class="form-group row">
					<label class="col-form-label col-lg-4">RAM Total</label>
					<div class="col-lg-8">
						<input type="text" name="memtotal" class="form-control" disabled>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-4">RAM Used(GB)</label>
					<div class="col-lg-8">
						<input type="text" name="memused" class="form-control" disabled>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-4">RAM Available(GB)</label>
					<div class="col-lg-8">
						<input type="text" name="memavailable" class="form-control" disabled>
					</div>
				</div>

				<hr>

				<div class="form-group row">
					<label class="col-form-label col-lg-4">Hard Disk Free(GB)</label>
					<div class="col-lg-8">
						<input type="text" name="diskfree" class="form-control" disabled>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-4">Hard Disk Used(GB)</label>
					<div class="col-lg-8">
						<input type="text" name="diskused" class="form-control" disabled>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-4">Hard Disk Total(GB)</label>
					<div class="col-lg-8">
						<input type="text" name="disktotal" class="form-control" disabled>
					</div>
				</div>

				<hr>

				<div class="form-group row">
					<label class="col-form-label col-lg-4">Server Name</label>
					<div class="col-lg-8">
						<input type="text" name="server_name" value="<?php echo $_SERVER['SERVER_NAME']; ?>" class="form-control" disabled>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-4">Server Addr</label>
					<div class="col-lg-8">
						<input type="text" name="server_addr" value="<?php echo $_SERVER['SERVER_ADDR']; ?>" class="form-control" disabled>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-4">PHP Version</label>
					<div class="col-lg-8">
						<input type="text" name="php_version" value="<?php echo phpversion(); ?>" class="form-control" disabled>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-4">PHP Load(GB)</label>
					<div class="col-lg-8">
						<input type="text" name="phpload" class="form-control" disabled>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-4">Load Time(sec)</label>
					<div class="col-lg-8">
						<input type="text" name="total_time" class="form-control" disabled>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
var data = function() {
	var _gaugeBasicLightExample = function() {
		if (typeof echarts == 'undefined') {
			console.warn('Warning - echarts.min.js is not loaded.');
			return;
		}

		var gauge_basic_element = document.getElementById('gauge_basic');

		if (gauge_basic_element) {
			var gauge_basic = echarts.init(gauge_basic_element);
			var gauge_basic_options = {
				textStyle: {
					fontFamily: 'Roboto, Arial, Verdana, sans-serif',
					fontSize: 13
				},
				title: {
					text: 'Server CPU usage',
					subtext: false,
					left: 'center',
					textStyle: {
						fontSize: 17,
						fontWeight: 500,
						color: '#008acd'
					}
				},
				tooltip: {
					trigger: 'item',
					backgroundColor: 'rgba(0,0,0,0.75)',
					padding: [10, 15],
					textStyle: {
						fontSize: 13,
						fontFamily: 'Roboto, sans-serif'
					},
					formatter: '{a} <br/>{b}: {c}%'
				},
				series: [
					{
						name: 'CPU usage',
						type: 'gauge',
						center: ['50%', '36%'],
						radius: '90%',
						detail: {formatter:'{value}%'},
						axisLine: {
							lineStyle: {
								color: [[0.2, '#2ec7c9'], [0.8, '#5ab1ef'], [1, '#d87a80']],
								width: 15
							}
						},
						axisTick: {
							splitNumber: 10,
							length: 20,
							lineStyle: {
								color: 'auto'
							}
						},
						splitLine: {
							length: 22,
							lineStyle: {
								color: 'auto'
							}
						},
						title: {
							offsetCenter: [0, '60%'],
							textStyle: {
								fontSize: 13
							}
						},
						detail: {
							offsetCenter: [0, '45%'],
							formatter: '{value}%',
							textStyle: {
								fontSize: 20,
								fontWeight: 500
							}
						},
						pointer: {
							width: 5
						},
						data: [{value: 0, name: 'CPU usage'}]
					}
				]
			};

			gauge_basic.setOption(gauge_basic_options);

			clearInterval(timeTicket);
			var timeTicket = setInterval(function () {
				axios.get(cp_params.base_url + '/dashboard/system_info', {
				}).then(response => {
					$.each(response.data, function(i, v) {
						console.log(v);
						gauge_basic_options.series[0].data[0].value = parseFloat(v).toFixed(2);
						gauge_basic.setOption(gauge_basic_options, true);
					})
				});
			}, 2000);
		}

		var triggerChartResize = function() {
			gauge_basic_element && gauge_basic.resize();
		};

		var sidebarToggle = document.querySelectorAll('.sidebar-control');
		if (sidebarToggle) {
			sidebarToggle.forEach(function(togglers) {
				togglers.addEventListener('click', triggerChartResize);
			});
		}

		var resizeCharts;
		window.addEventListener('resize', function() {
			clearTimeout(resizeCharts);
			resizeCharts = setTimeout(function () {
				triggerChartResize();
			}, 200);
		});
	};

	var _componentTime = function() {
		const clock = document.querySelector('.h1-clock');

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

	return {
		init: function() {
			_gaugeBasicLightExample();
			_componentTime();
		}
	}
}();

document.addEventListener('DOMContentLoaded', function() {
	data.init();
});
</script>
