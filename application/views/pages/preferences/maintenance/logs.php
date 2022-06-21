<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->document->add_inline_style ("
.language-javascript { white-space: nowrap; overflow: auto; width: 500px; height: 500px; }
");
?>

<!-- data log -->
<div class="card">
	<div class="card-header bg-white header-elements-inline">
        <h6 class="card-title"><i class="icon-list2 mr-2"></i><?php echo $page_title; ?></h6>
    </div>

	<div class="card-body" id="logs-form">
		<fieldset class="mb-3">
			<pre class="language-javascript overflow-auto w-100"><code><?php echo $logs; ?></code></pre>
		</fieldset>

		<div class="text-right">
			<button type="submit" class="btn btn-danger btn-delete"><i class="icon-trash font-size-base mr-1"></i>Delete</button>
			<button type="submit" class="btn btn-primary btn-download"><i class="icon-file-download font-size-base mr-1"></i>Download</button>
		</div>
	</div>
</div>
<!-- /data log -->

<script type="text/javascript">
var data = function() {

	var _componentDownload = function() {
		const modalEl = $('#logs-form');

		modalEl.on('click', '.btn-download', function(e) {
			document.location.href = cp_params.base_url + '/preferences/maintenance/logs/data_download';
		});
	}

	var _componentDelete = function() {
		const modalEl = $('#logs-form');

		modalEl.on('click', '.btn-delete', function(e) {

			if ( confirm('Are you sure you want to delete it?') == true ) {
				$.ajax( {
					dataType	: 'json',
					url			: cp_params.base_url + '/preferences/maintenance/logs/data_delete',
					error		: function(xhr, status, error) {
						alert(xhr.responseText);
					},
					success     : function(data) {
						alert(data.message);
						location.reload();
					}
				} );
				return false;
			} else {
				return false;
			}
		} );
	}

	return {
		init: function() {
			_componentDownload();
			_componentDelete();
		}
	}
}();

document.addEventListener('DOMContentLoaded', function() {
	data.init();
} );
</script>
