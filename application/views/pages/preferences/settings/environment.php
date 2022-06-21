<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style type="text/css">
.content pre {margin: 0; font-family: monospace;}
.content a:link {color: #009; text-decoration: none; background-color: #fff;}
.content a:hover {text-decoration: underline;}
.content table {border-collapse: collapse; border: 0; width: 100%; box-shadow: 1px 2px 3px #ccc;}
.content .center {text-align: center;}
.content .center table {margin: 1em auto; text-align: left;}
.content .center th {text-align: center !important;}
.content td, th {border: 1px solid #666; font-size: 75%; vertical-align: baseline; padding: 4px 5px;}
.content h1 {font-size: 150%;}
.content h2 {font-size: 125%;}
.content .p {text-align: left;}
.content .e {background-color: #ccf; width: 300px; font-weight: bold;}
.content .h {background-color: #99c; font-weight: bold;}
.content .v {background-color: #ddd; max-width: 300px; overflow-x: auto; word-wrap: break-word;}
.content .v i {color: #999;}
.content img {float: right; border: 0;}
.content hr {width: 934px; background-color: #ccc; border: 0; height: 1px;}
</style>

<div class="card">
	<div class="card-body"><?php echo $phpinfo_html; ?></div>
</div>
