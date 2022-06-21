<?php
defined( 'BASEPATH' ) or exit( 'No direct script access allowed' );
?>

<!-- info list -->
<div class="card data-table" id="card-info">
	<form action="#">
		<div class="card-header bg-white header-elements-inline">
			<h6 class="card-title"><i class="icon-list2 mr-2"></i><?php echo $page_title; ?></h6>
			<div class="header-elements">
				<button type="submit" class="btn btn-sm btn-primary"><i class="icon-checkmark3 font-size-base mr-1"></i>저장</button>
			</div>
		</div>

		<div class="card-body">
			<fieldset class="mb-3">
				<legend class="text-uppercase font-size-sm font-weight-bold">내정보</legend>

				<input type="hidden" id="user_id" name="user_id" value="1" />

				<div class="form-group row">
					<label class="col-form-label col-lg-2">아이디</label>
					<div class="col-lg-10">
						<input type="text" name="user_login" class="form-control" placeholder="아이디&hellip;" disabled />
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-2">이름<span class="text-danger ml-1">*</span></label>
					<div class="col-lg-10">
						<input type="text" name="user_name" class="form-control" placeholder="이름&hellip;" required />
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-2">이메일<span class="text-danger ml-1">*</span></label>
					<div class="col-lg-10">
						<input type="text" name="email" class="form-control" placeholder="이메일&hellip;" required />
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-2">핸드폰<span class="text-danger ml-1">*</span></label>
					<div class="col-lg-10">
						<input type="text" name="mobile" class="form-control" placeholder="핸드폰번호&hellip;" required />
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-2">그룹</label>
					<div class="col-lg-10">
						<input type="text" name="group_name" class="form-control" placeholder="그룹&hellip;" disabled />
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-2">비밀번호</label>
					<div class="col-lg-10 d-none" id="user_password_box">
						<input type="text" name="user_password_modified" class="form-control" placeholder="변경할 비밀번호&hellip;"/>
					</div>
					<div class="col-lg-3">
						<a href="#" id="btn_info_password" class="btn btn-outline-link"><i class="icon-pencil7 font-size-base mr-1"></i><span id="btn_info_text">수정</span></a>
					</div>
				</div>
			</fieldset>
		</div>
	</form>
</div>
<!-- /info list -->

<script type="text/javascript">
var data = function() {

	var _componentInfo = function() {
		const cardEl = $( '#card-info' );
		let target_id = <?php echo $this->user->item( 'user_id' ); ?>

		axios.get( cp_params.base_url + '/common/info/item_get/' + target_id, {
		} ).then( response => {
			$.each( response.data, function( i, v ) {
				var the_el = $( '[name="' + i + '"]' );
				if ( the_el.length > 0 ) {
					the_el.val( v );
					if ( the_el.is( "select" ) ) {
						the_el.change();
					}
				}
			} )
		} );

		cardEl.on( 'click', '#btn_info_password', function(e) {
			if ( document.getElementById( 'user_password_box' ).className === 'col-lg-10 d-none' ) {
				document.getElementById( 'user_password_box' ).classList.replace( 'col-lg-10', 'col-lg-7' );
				document.getElementById( 'user_password_box' ).classList.replace( 'd-none', 'd-block' );
				$( '#btn_info_text' ).text( '접기' );
			} else {
				document.getElementById( 'user_password_box' ).classList.replace( 'col-lg-7', 'col-lg-10' );
				document.getElementById( 'user_password_box' ).classList.replace( 'd-block', 'd-none' );
				$( '#btn_info_text' ).text( '수정' );
			}
		} );

		$( 'form', cardEl ).on( 'submit', function(e) {
			let target_id   = $( '#user_id' ).val();
			let form_data   = $( this ).serialize();

			$.ajax( {
				type        : 'POST',
				url         : cp_params.base_url + '/common/info/item_put/' + target_id,
				data        : form_data,
				dataType    : 'json',
				error       : function( xhr, status, error ) {
					alert( xhr.responseText );
				},
				success     : function( data ) {
					alert( data.message );
					location.reload();
				}
			} );
			return false;
		} );
	} 

	return {
		init: function() {
			_componentInfo();
		}
	}
}();

document.addEventListener( 'DOMContentLoaded', function() {
	data.init();
} );
</script>

