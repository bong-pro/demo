<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->document->add_js( 'moment', base_url( 'template/global_assets/js/plugins/ui/moment/moment.min.js' ) );
$this->document->add_js( 'select2', base_url( 'template/global_assets/js/plugins/forms/selects/select2.min.js' ) );
$this->document->add_js( 'datatables', base_url( 'template/global_assets/js/plugins/tables/datatables/datatables.min.js' ) );
$this->document->add_js( 'select', base_url( 'template/global_assets/js/plugins/tables/datatables/extensions/select.min.js' ) );
$this->document->add_js( 'buttons', base_url( 'template/global_assets/js/plugins/tables/datatables/extensions/buttons.min.js' ) );
$this->document->add_js( 'sweet_alert', base_url( 'template/global_assets/js/plugins/notifications/sweet_alert.min.js' ) );
?>

<!-- table list -->
<div class="card data-table">
	<div class="card-header bg-white header-elements-inline">
        <h6 class="card-title"><i class="icon-list2 mr-2"></i><?php echo $page_title; ?></h6>
        <div class="header-elements">
            <div class="list-icons">
                <ul class="list-inline list-inline-dotted mb-0">
                    <li class="list-inline-item">
                        <!--a class="list-icons-item sidebar-control sidebar-right-toggle" data-action="search"></a-->
                        <a class="list-icons-item" data-action="reload"></a>
                        <a class="list-icons-item" data-action="fullscreen"></a>
                        <!--a class="list-icons-item" data-action="remove"></a-->
                    </li>
                </ul>
            </div>
        </div>
    </div>

	<table class="table table-striped table-xs table-hover w-100 datatables" id="table"></table>
</div>
<!-- /table list -->

<!-- modal add -->
<div id="modal-add" class="modal fade" data-backdrop="static" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<form class="modal-content">
			<div class="modal-header py-2">
				<h5 class="modal-title"><i class="icon-upload7 mr-1"></i>신규 등록</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<div class="modal-body">
				<legend class="text-uppercase font-size-sm font-weight-bold">로그인정보</legend>

				<div class="form-group row">
					<label class="col-form-label col-lg-2">아이디<span class="text-danger ml-1">*</span></label>
					<div class="col-lg-10">
						<input type="text" name="user_login" class="form-control" placeholder="아이디&hellip;" required />
					</div>

					<label class="col-form-label col-lg-2"></label>
					<button type="button" class="btn btn-link btn-sm" id="btn_check_id" name="btn_check_id">중복검사</button>
					<span class="mt-1" id="msg_check_id"></span>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-2">비밀번호<span class="text-danger ml-1">*</span></label>
					<div class="col-lg-10">
						<input type="password" name="user_password" class="form-control" placeholder="비밀번호&hellip;" required />
					</div>
				</div>

				<legend class="text-uppercase font-size-sm font-weight-bold">기본정보</legend>

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
						<input type="text" name="mobile" class="form-control" placeholder="핸드폰 번호&hellip;" required />
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-2">그룹</label>
					<div class="col-lg-10">
						<select name="group_id" class="form-control select">
							<option value="">선택없음</option>
							<?php foreach ( $groups['list'] as $item ) : ?>
								<?php $item['group_id'] == '1' && $this->user->item( 'group_id' ) !== '1' ? $disabled = 'disabled' : $disabled = ''; ?>
								<option value="<?php echo $item['group_id']; ?>" <?php echo $disabled; ?>><?php echo $item['group_name']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i>닫기</button>
				<button type="submit" class="btn btn-primary"><i class="icon-checkmark3 font-size-base mr-1"></i>저장</button>
			</div>
		</form>
	</div>
</div>
<!-- /modal add -->

<!-- modal status -->
<div id="modal-status" class="modal fade" data-backdrop="static" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-sm modal-dialog-centered" role="document">
		<form class="modal-content">
			<div class="modal-header py-2">
				<h5 class="modal-title"><i class="icon-pencil7 mr-1"></i>상태 변경</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<div class="modal-body">

				<input type="hidden" name="user_id" />

				<div class="form-group row">
					<label class="col-form-label col-lg-2">상태</label>
					<div class="col-lg-10">
						<select name="is_used" class="form-control select">
							<option value="Y">활성화</option>
							<option value="N">비활성화</option>
						</select>
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i>닫기</button>
				<button type="submit" class="btn btn-primary"><i class="icon-checkmark3 font-size-base mr-1"></i>저장</button>
			</div>
		</form>
	</div>
</div>
<!-- /modal status -->

<!-- modal item -->
<div id="modal-item" class="modal fade" data-backdrop="static" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<form class="modal-content">
			<div class="modal-header py-2">
				<h5 class="modal-title"><i class="icon-pencil7 mr-1"></i>회원 정보</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<div class="modal-body">

				<input type="hidden" name="user_id" />

				<legend class="text-uppercase font-size-sm font-weight-bold">회원정보</legend>

				<div class="form-group row">
					<label class="col-form-label col-lg-2">상태</label>
					<div class="col-lg-10">
						<select name="is_used" class="form-control select">
							<option value="Y">활성화</option>
							<option value="N">비활성화</option>
						</select>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-2">아이디<span class="text-danger ml-1">*</span></label>
					<div class="col-lg-10">
						<input type="text" name="user_login" class="form-control" placeholder="아이디&hellip;" readonly />
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
						<select name="group_id" class="form-control select">
							<option value="">선택없음</option>
							<?php foreach ( $groups['list'] as $item ) : ?>
								<?php $item['group_id'] == '1' && $this->user->item( 'group_id' ) !== '1' ? $disabled = 'disabled' : $disabled = ''; ?>
								<option value="<?php echo $item['group_id']; ?>" <?php echo $disabled; ?>><?php echo $item['group_name']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-2">비밀번호<span class="text-danger ml-1">*</span></label>
					<div class="col-lg-10 d-none" id="user_password_box">
						<input type="text" name="user_password_modified" class="form-control" placeholder="변경할 비밀번호&hellip;"/>
					</div>
					<div class="col-lg-3">
						<a href="#" id="btn_modified_password" class="btn btn-outline-link"><i class="icon-pencil7 font-size-base mr-1"></i><span id="btn_modified_text">수정</span></a>
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i>닫기</button>
				<button type="submit" class="btn btn-primary"><i class="icon-checkmark3 font-size-base mr-1"></i>저장</button>
			</div>
		</form>
	</div>
</div>
<!-- /modal modified item -->

<script type="text/javascript">
var data = function() {

	var _componentDatatable = function() {
		if (!$().DataTable) {
			console.warn('Warning - datatables.min.js is not loaded.');
			return;
		}

		const tableEl = $( 'table.datatables' );

		var datatable = tableEl.DataTable( {
			ajax		: {
				url			: cp_params.base_url + '/preferences/management/user/users/list',
				type		: 'GET',
				data		: function(d) {
					// ajax 요청항목 재정의
					var data = {
						limit			: d.length,
						offset			: d.start,
						keyword			: d.search.value,
						orderby			: d.columns[d.order[0].column].data,
						order			: d.order[0].dir
					};

					// 필터 항목 추가
					$( ':input.search-filter-item' ).each( function() {
						let key = $( this ).attr( 'name' ).replace( /^filter__/, '' );
						let value = $( this ).val();

						if ( value == '' || ( $( this ).is( ':checkbox, :radio' ) && ! $( this ).is( ':checked' ) ) ) {
							return;
						}

						if ( $( this ).data( 'ionRangeSlider' ) ) {
							let ionRangeSlider = $( this ).data( 'ionRangeSlider' );

							if ( 'single' == ionRangeSlider.options.type ) {
								if ( ionRangeSlider.result.from < ionRangeSlider.result.max ) {
									data[key] = ionRangeSlider.result.from;
								}
							} else {
								data[key] = {};
								if ( ionRangeSlider.result.from > ionRangeSlider.result.min ) {
									data[key]['min'] = ionRangeSlider.result.from;
								}
								if ( ionRangeSlider.result.to < ionRangeSlider.result.max ) {
									data[key]['max'] = ionRangeSlider.result.to;
								}
							}
						} else if( $.isArray( value ) ) {
							data[key] = value.join();
						} else {
							data[key] = value;
						}
					} );

					return data;
				},
				dataSrc        : function( response ){
					response.recordsTotal		= response.total_rows;
					response.recordsFiltered	= response.total_rows;
					response.draw++;

					return response.list;
				},
			},
			buttons			: [
				{
					className   : 'btn btn-primary btn-add-new',
					text        : '<i class="icon-upload7 font-size-base mr-1"></i>신규등록'
				},
				{
					className   : 'btn btn-danger btn-delete-selected',
					text        : '<i class="icon-trash font-size-base mr-1"></i>선택삭제'
				},
				{
					extend      : 'collection',
					text        : '<i class="icon-three-bars"></i>',
					className   : 'btn btn-teal btn-icon dropdown-toggle dropdown-icon-none',
					buttons     : [
						{
							extend      : 'copy',
							className   : 'btn btn-light',
							text        : '<i class="icon-copy3 font-size-base mr-1"></i>선택항목 복사'
						},
						{
							extend      : 'print',
							className   : 'btn btn-light',
							text        : '<i class="icon-printer font-size-base mr-1"></i>선택항목 프린트'
						},
						{
							extend		: 'excel',
							className   : 'btn btn-light',
							text        : '<i class="icon-file-download font-size-base mr-1"></i>선택항목 다운로드',
							customize: function ( xlsx ) {
								var sheet = xlsx.xl.worksheets["sheet1.xml"];
								$( "c[r^=J] t", sheet ).text( "" );
							}
						},
					]
				},
			],
			order			: [ [ 1,'desc' ] ],
			createdRow		: function( row, data, dataIndex ) {
				$( row ).data( 'target-id', data.user_id );
			},
			columns		: [
				{
					data		: 'user_id',
					class		: 'select-checkbox',
					sortable	: false,
					render      : function( data, type, row, meta ) {
						return null;
					}
				},
				{
					title		: '<center>일련번호</center>',
					data        : 'user_id',
					class		: 'text-nowrap',
				},
				{
					title		: '<center>아이디</center>',
					data        : 'user_login',
					class		: 'text-nowrap text-left',
				},
				{
					title		: '<center>이름</center>',
					data        : 'user_name',
					class		: 'text-nowrap text-left',
				},
				{
					title		: '<center>이메일</center>',
					data        : 'email',
					class		: 'text-nowrap text-left',
				},
				{
					title		: '<center>전화번호</center>',
					data        : 'mobile',
					class		: 'text-nowrap text-left',
					render		: function( data, type, row, meta ) {
						var html = '<i class="icon-phone-outgoing font-size-sm mr-1"></i>'
							+ data.replace( /(^02.{0}|^01.{1}|[0-9]{3})([0-9]+)([0-9]{4})/, "$1-$2-$3" );

						return html;
					}
				},
				{
					title		: '<center>그룹</center>',
					data        : 'group_name',
					class		: 'text-nowrap text-center',
					render		: function( data, type, row, meta ) {
						let html = data ? data : '&mdash;';

						return html;
					}
				},
				{
					title		: '<center>상태</center>',
					data        : 'is_used',
					class		: 'text-nowrap text-center',
					sortable    : false,
					render		: function( data, type, row, meta ) {
						if ( row.is_used === 'Y' ) {
							var html = '<a href="#" class="badge badge-flat border-primary text-primary" data-toggle="modal" data-target="#modal-status">활성화</a>';
						} else {
							var html = '<a href="#" class="badge badge-flat text-muted" data-toggle="modal" data-target="#modal-status">비활성화</a>';
						}

						return html;
					}
				},
				{
					title		: '<center>등록일</center>',
					data        : 'created_at',
					class		: 'text-nowrap text-center',
					render		: function( data, type, row, meta ) {
						let momentDt = moment( data );
						let html = momentDt.isSame( moment(), 'day' ) ? moment.duration( momentDt.diff() ).humanize() + ' ago' : momentDt.format( 'YYYY-MM-DD' );

						return html;
					}
				},
				{
					title		: '<center><i class="icon-menu-open2"></i></center>',
					data        : 'user_id',
					class		: 'text-nowrap text-center',
					sortable    : false,
					render		: function( data, type, row, meta ) {
						let html = '<div class="list-icons">\n' +
							'	<div class="dropdown">\n' +
							'		<a href="#" class="list-icons-item dropdown-toggle" data-toggle="dropdown"><i class="icon-cog6"></i></a>\n' +
							'		<div class="dropdown-menu dropdown-menu-right dropdown-menu-xs">\n' +
							'			<div class="dropdown-header">옵션 선택</div>\n' +
							'			<a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal-item"><i class="icon-pencil7 text-primary"></i>데이터 수정</a>\n' +
							'			<a href="#" class="dropdown-item btn-delete-item"><i class="icon-trash text-danger"></i>데이터 삭제</a>\n' +
							'		</div>\n' +
							'	</div>\n' +
							'</div>';

						return html;
					}
				}
			],
		} );

		$( ':input.search-filter-item' ).on( 'change', function() {
			datatable.ajax.reload();
		} );

		$( '.btn-add-new' ).attr( 'data-toggle', 'modal' ).attr( 'data-target', '#modal-add' );

		$( 'thead .select-checkbox' ).on( 'click', function(e) {
			if ( $( 'thead tr' ).hasClass( 'selected') ) {
				$( 'thead tr' ).removeClass( 'selected' );
				$( 'tbody tr' ).removeClass( 'selected' );
				datatable.rows().deselect();
			} else {
				$( 'thead tr' ).addClass( 'selected' );
				$( 'tbody tr' ).addClass( 'selected' );
				datatable.rows().select();
			}
		} );

	}

	var _componentAdd = function() {
		const modalEl = $( '#modal-add' );

		modalEl.on( 'show.bs.modal', function(e) {
			$( this ).find( 'form' )[0].reset();

			$( 'select[name="is_used"]' ).val( 'Y' ).trigger( 'change' );
			$( 'select[name="group_id"]' ).val( '' ).trigger( 'change' );
		} );

		modalEl.on( 'hidden.bs.modal', function(e) {
			$( this ).find( 'form' )[0].reset();

			$( 'select[name="is_used"]' ).val( 'Y' ).trigger( 'change' );
			$( 'select[name="group_id"]' ).val( '' ).trigger( 'change' );
		} );

		modalEl.on( 'click', '#btn_check_id', function(e) {
			var user_login      = modalEl.find( "input[name='add_user_login']" );
			var checkBool       = false;
			var msg_check_id	= modalEl.find( "#msg_check_id" );

			if ( user_login.val() == "" ) {
				$( "#msg_check_id" ).html( '<small class="text-muted"><i class="icon-notification2 mr-1"></i>아이디를 입력해주세요.</small>' );
				return false;
			}

			$.ajax( {
				type		: "POST",
				url			: cp_params.base_url + "/auth/id_finder",
				data		: {
					"user_login" : user_login.val()
				},
				dataType	: 'json',
				error		: function( request, status, error ) {
					alert( "code:" + request.status + "\n" + "message:" + request.responseText + "\n" + "error:" + error );
					return;
				},
				success		: function( data ) {
					if ( data.responseText == "check_no" ) {
						$( "#msg_check_id" ).html( '<small class="text-danger"><i class="icon-cancel-circle2 mr-1"></i>중복되는 아이디가 있습니다.</small>' );
						checkBool = false;
					} else if ( data.responseText == "check_strlen" ) {
						$( "#msg_check_id" ).html( '<small class="text-warning"><i class="icon-notification2 mr-1"></i>아이디 길이는 [3]자 이상입니다.</small>' );
						checkBool = false;
					} else {
						$( "#msg_check_id" ).html( '<small class="text-primary"><i class="icon-checkmark-circle mr-1"></i>사용 가능한 아이디입니다.</small>' );
						checkBool = true;
					}
				}
			} );
		} );

		$( 'form', modalEl ).on( 'submit', function(e) {
			var form_data    = $( this ).serialize();

			$.ajax( {
				type        : 'POST',
				url         : cp_params.base_url + '/preferences/management/user/users/item_insert/',
				data        : form_data,
				dataType    : 'json',
				error       : function( xhr, status, error ) {
					alert( xhr.responseText );
				},
				success     : function( data ) {
					$( '#table' ).DataTable().ajax.reload( null, false );
					$( '#modal-add' ).modal( 'hide' );
					alert( data.message );
				}
			} );
			return false;
		} );
	}

	var _componentStatus = function() {
		const modalEl = $( '#modal-status' );

		modalEl.on( 'show.bs.modal', function(e) {
			let target_id = $( e.relatedTarget ).closest( 'tr' ).data( 'target-id' );

			axios.get( cp_params.base_url + '/preferences/management/user/users/item_get/' + target_id, {
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
		} );

		modalEl.on( 'hidden.bs.modal', function(e) {
			$( this ).find( 'form' )[0].reset();

			$( 'select[name="is_used"]' ).val( 'Y' ).trigger( 'change' );
		} );

		$( 'form', modalEl ).on( 'submit', function(e) {
			let target_id = $( '[name="user_id"]' ).val();
			let form_data   = $( this ).serialize();

			$.ajax( {
				type        : 'POST',
				url         : cp_params.base_url + '/preferences/management/user/users/status_put/' + target_id,
				data        : form_data,
				dataType    : 'json',
				error       : function( xhr, status, error ) {
					alert( xhr.responseText );
				},
				success     : function( data ) {
					$( '#table' ).DataTable().ajax.reload( null, false );
					$( '#modal-status' ).modal( 'hide' );
					alert( data.message );
				}
			} );
			return false;
		} );
	}

	var _componentItem = function() {
		const modalEl = $( '#modal-item' );

		modalEl.on( 'click', '#btn_modified_password', function(e) {
			if ( document.getElementById( 'user_password_box' ).className === 'col-lg-10 d-none' ) {
				document.getElementById( 'user_password_box' ).classList.replace( 'col-lg-10', 'col-lg-7' );
				document.getElementById( 'user_password_box' ).classList.replace( 'd-none', 'd-block' );
				$( '#btn_modified_text' ).text( '접기' );
			} else {
				document.getElementById( 'user_password_box' ).classList.replace( 'col-lg-7', 'col-lg-10' );
				document.getElementById( 'user_password_box' ).classList.replace( 'd-block', 'd-none' );
				$( '#btn_modified_text' ).text( '수정' );
			}
		} );

		modalEl.on( 'show.bs.modal', function(e) {
			$( this ).find( 'form' )[0].reset();
			let target_id = $( e.relatedTarget ).closest( 'tr' ).data( 'target-id' );

			axios.get( cp_params.base_url + '/preferences/management/user/users/item_get/' + target_id, {
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
		} );

		modalEl.on( 'hidden.bs.modal', function(e) {
			$( this ).find( 'form' )[0].reset();

			$( 'select[name="is_used"]' ).val( 'Y' ).trigger( 'change' );
			$( 'select[name="group_id"]' ).val( '' ).trigger( 'change' );
		} );

		$( 'form', modalEl ).on( 'submit', function(e) {
			let target_id = $( '[name="user_id"]' ).val();
			let form_data   = $( this ).serialize();

			$.ajax( {
				type        : 'POST',
				url         : cp_params.base_url + '/preferences/management/user/users/item_put/' + target_id,
				data        : form_data,
				dataType    : 'json',
				error       : function( xhr, status, error ) {
					alert( xhr.responseText );
				},
				success     : function( data ) {
					$( '#table' ).DataTable().ajax.reload( null, false );
					$( '#modal-item' ).modal( 'hide' );
					alert( data.message );
				}
			} );
			return false;
		} );
	}

	var _componentDeleteItem = function() {
		const modalEl = $( 'table.datatables' );

		modalEl.on( 'click', '.btn-delete-item', function(e) {
			let target_id = $( this ).closest( 'tr' ).data( 'target-id' );

			if ( confirm( '삭제를 하면 복구가 불가능합니다.\n삭제를 진행하시겠습니까?' ) == true ) {
				$.ajax( {
					url         : cp_params.base_url + '/preferences/management/user/users/item_delete/' + target_id,
					dataType    : 'json',
					error       : function( xhr, status, error ) {
						alert( xhr.responseText );
					},
					success     : function( data ) {
						$( '#table' ).DataTable().ajax.reload( null, false );
						alert( '삭제가 완료되었습니다.' );
					}
				} );
				return false;
			} else {
				return false;
			}
		} );
	}

	var _componentDeleteSelected = function() {
		const modalEl = $( '.data-table' );

		modalEl.on( 'click', '.btn-delete-selected', function(e) {
			var i = 0;
			var target_ids = '';
			$( 'tr.selected' ).each( function() {
				target_ids += '&' + i + '=' + $( this ).data( 'targetId' );
				i++;
			} );

			if ( target_ids.length > 0 ) {
				if ( confirm( '삭제를 하면 복구가 불가능합니다.\n선택된 아이템을 삭제하시겠습니까?' ) == true ) {
					$.ajax( {
						type        : 'POST',
						url         : cp_params.base_url + '/preferences/management/user/users/selected_delete/',
						data        : target_ids,
						dataType    : 'json',
						error       : function( xhr, status, error ) {
							alert( xhr.responseText );
						},
						success     : function( data ) {
							$( '#table' ).DataTable().ajax.reload( null, false );
							alert( '삭제가 완료되었습니다.' );
						}
					} );
					return false;
				} else {
					return false;
				}
			} else {
				alert( '선택값이 없습니다.' );
			}
		} );
	}

	return {
		init: function() {
			_componentDatatable();
			_componentAdd();
			_componentStatus();
			_componentItem();
			_componentDeleteItem();
			_componentDeleteSelected();
		}
	}
}();

document.addEventListener( 'DOMContentLoaded', function() {
	data.init();
} );
</script>
