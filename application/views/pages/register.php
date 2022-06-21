<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->document->add_js('validate', base_url('template/global_assets/js/plugins/forms/validation/validate.min.js'));
//$this->document->add_js('messages-ko', base_url('template/global_assets/js/plugins/forms/validation/localization/messages_ko.js'));

$this->document->add_inline_style("
.login-cover {
	background: url(" . base_url( 'assets/images/login_cover.jpg' ) . ");
	background-size: cover;
	background-repeat: no-repeat;
}
");

// error message
if( $this->session->flashdata('message') ) echo $this->session->flashdata('message');
?>

<!-- register form -->
<form id="register-form" class="login-form form-validate-jquery" method="post" novalidate="novalidate">
    <div class="card mb-0">
        <div class="card-body">
            <div class="text-center mb-3">
                <!--img src="<?php echo base_url( 'template/global_assets/images/logo/logo.svg' ); ?>" width="200" class="mb-1" /-->
				<h1 class="font-weight-bold">DEMO corp.</h1>
				<h5 class="mb-0">Create account</h5>
				<span class="d-block text-muted">All fields are required</span>
            </div>

			<div class="form-group text-center text-muted content-divider">
				<span class="px-2">Login information</span>
			</div>

			<div class="form-group">
				<div class="input-group">
					<span class="input-group-prepend">
						<span class="input-group-text"><i class="icon-user-check text-muted"></i></span>
					</span>
					<input type="text" class="form-control" name="login" id="login" placeholder="Login ID&hellip;" />
				</div>
			</div>

			<div class="form-group mb-1">
				<div class="input-group">
					<span class="input-group-prepend">
						<span class="input-group-text"><i class="icon-user-lock text-muted"></i></span>
					</span>
					<input type="password" class="form-control" name="password" id="password" placeholder="Password&hellip;" />
				</div>
			</div>

			<div class="form-group">
				<div class="input-group">
					<span class="input-group-prepend">
						<span class="input-group-text"><i class="icon-user-lock text-muted"></i></span>
					</span>
					<input type="password" class="form-control" name="password_cp" id="password_cp" placeholder="Confirm Password&hellip;" />
				</div>
			</div>
            
			<div class="form-group text-center text-muted content-divider">
				<span class="px-2">Basic information</span>
			</div>

			<div class="form-group mb-1">
				<div class="input-group">
					<span class="input-group-prepend">
						<span class="input-group-text"><i class="icon-user text-muted"></i></span>
					</span>
					<input type="text" class="form-control" name="name" id="name" placeholder="Name&hellip;" />
				</div>
			</div>

			<div class="form-group mb-1">
				<div class="input-group">
					<span class="input-group-prepend">
						<span class="input-group-text"><i class="icon-mention text-muted"></i></span>
					</span>
					<input type="text" class="form-control" name="email" id="email" placeholder="E-Mail&hellip;" />
				</div>
			</div>

			<div class="form-group">
				<div class="input-group">
					<span class="input-group-prepend">
						<span class="input-group-text"><i class="icon-mobile text-muted"></i></span>
					</span>
					<input type="text" class="form-control" name="mobile" id="mobile" placeholder="Mobile number&hellip;" />
				</div>
			</div>

            <div class="form-group">
                <button type="submit" name="submit_btn" class="btn btn-primary btn-block">Register</button>
            </div>

			<div class="form-group text-center text-muted content-divider">
				<span class="px-2">Are you a member?</span>
			</div>

			<div class="form-group">
				<a href="<?php echo base_url(); ?>" class="btn btn-dark btn-block">Login</a>
			</div>
			
			<span class="form-text text-center text-muted">&copy; 2022. Copyright: <a href="#">DEMO CO,.LTD.</a></span>
        </div>
    </div>
</form>
<!-- /register form -->

<script type="text/javascript">
var data = function() {
	var _componentValidation = function() {
		if (!$().validate) {
			console.warn('Warning - validate.min.js is not loaded.');
			return;
		}

		var validator = $('.form-validate-jquery').validate({
			rules : {
				login : {
					required	: true,
					minlength	: 3,
					maxlength	: 30,
					remote: {
						url		: cp_params.base_url + '/auth/data_check/',
						type	: 'post',
						data	: {
							login : function() {
								return $('input[name="login"]').val();
							}
						},
					}
				},
				password : {
					required	: true,
					minlength	: 4,
					maxlength	: 20,
				},
				password_cp : {
					required	: true,
					minlength	: 4,
					maxlength	: 20,
					equalTo		: "input[name='password']",
				},
				name : {
					required	: true,
					minlength	: 3,
					maxlength	: 50,
				},
				email : {
					required	: true,
					email		: true,
					minlength	: 8,
					maxlength	: 50,
				},
				mobile : {
					required	: true,
					digits		: true,
					minlength	: 10,
					maxlength	: 30,
				},
			},
			messages : {
				login : {
					remote : 'There are duplicate values.',
				}
			}
		});
	};

	return {
		init: function() {
			_componentValidation();
		}
	}
}();

document.addEventListener('DOMContentLoaded', function() {
	data.init();
});
</script>
