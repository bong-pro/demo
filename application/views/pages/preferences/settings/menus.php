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
<!-- /tabel list -->

<!-- modal add -->
<div id="modal-add" class="modal fade" data-backdrop="static" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<form class="modal-content">
			<div class="modal-header py-2">
				<h5 class="modal-title"><i class="icon-upload7 mr-1"></i>신규 등록</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<div class="modal-body">
				<legend class="text-uppercase font-size-sm font-weight-bold">등록정보</legend>

				<div class="form-group row">
					<label class="col-form-label col-lg-3">상태</label>
					<div class="col-lg-9">
						<select name="is_used" class="form-control select">
							<option value="Y">활성화</option>
							<option value="N">비활성화</option>
						</select>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-3">메뉴명<span class="text-danger ml-1">*</span></label>
					<div class="col-lg-9">
						<input type="text" name="name" class="form-control" placeholder="메뉴명&hellip;" required />
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-3">일련번호<span class="text-danger ml-1">*</span></label>
					<div class="col-lg-9">
						<input type="text" name="menu_id" class="form-control" placeholder="메뉴 아이디&hellip;" required />
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-3">부모 일련번호<span class="text-danger ml-1">*</span></label>
					<div class="col-lg-9">
						<input type="text" name="parent_menu_id" class="form-control" placeholder="부모 일련번호&hellip;" required />
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-3">우선순위</label>
					<div class="col-lg-9">
						<input type="text" name="priority" class="form-control" placeholder="우선순위&hellip;" required />
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-3">링크</label>
					<div class="col-lg-9">
						<input type="text" name="link" class="form-control" placeholder="링크&hellip;" required />
						<small class="form-text text-muted">Base URL 이후부터 작성( /aaa/bbb/ccc )</small>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-3">링크 target</label>
					<div class="col-lg-9">
						<input type="text" name="link_target" class="form-control" placeholder="링크 target&hellip;" />
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-3">링크 class</label>
					<div class="col-lg-9">
						<input type="text" name="link_class" class="form-control" placeholder="링크 class&hellip;" />
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-3">메뉴 앞 HTML</label>
					<div class="col-lg-9">
						<input type="text" name="before_html" class="form-control" placeholder="HTML 입력&hellip;" />
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-3">메뉴 뒤 HTML</label>
					<div class="col-lg-9">
						<input type="text" name="after_html" class="form-control" placeholder="HTML 입력&hellip;" />
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

<!-- modal name -->
<div id="modal-name" class="modal fade" data-backdrop="static" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-sm modal-dialog-centered" role="document">
		<form class="modal-content">
			<div class="modal-header py-2">
				<h5 class="modal-title"><i class="icon-pencil7 mr-1"></i>메뉴명 수정</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<div class="modal-body">

				<input type="hidden" name="menu_id" />

				<div class="form-group row">
					<label class="col-form-label col-lg-2">메뉴명</label>
					<div class="col-lg-10">
						<input type="text" name="name" class="form-control" placeholder="메뉴명&hellip;" required />
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
<!-- /modal name -->

<!-- modal parent_menu_id -->
<div id="modal-parent-menu" class="modal fade" data-backdrop="static" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-sm modal-dialog-centered" role="document">
		<form class="modal-content">
			<div class="modal-header py-2">
				<h5 class="modal-title"><i class="icon-pencil7 mr-1"></i>부모 일련번호 수정</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<div class="modal-body">

				<input type="hidden" name="menu_id" />

				<div class="form-group row">
					<label class="col-form-label col-lg-4">부모 일련번호</label>
					<div class="col-lg-8">
						<input type="text" name="parent_menu_id" class="form-control" placeholder="부모 일련번호&hellip;" required />
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
<!-- /modal parent_menu_id -->

<!-- modal priority -->
<div id="modal-priority" class="modal fade" data-backdrop="static" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-sm modal-dialog-centered" role="document">
		<form class="modal-content">
			<div class="modal-header py-2">
				<h5 class="modal-title"><i class="icon-pencil7 mr-1"></i>우선순위 수정</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<div class="modal-body">

				<input type="hidden" name="menu_id" />

				<div class="form-group row">
					<label class="col-form-label col-lg-3">우선순위</label>
					<div class="col-lg-9">
						<input type="text" name="priority" class="form-control" placeholder="우선순위&hellip;" required />
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
<!-- /modal priority -->

<!-- modal link -->
<div id="modal-link" class="modal fade" data-backdrop="static" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-md modal-dialog-centered" role="document">
		<form class="modal-content">
			<div class="modal-header py-2">
				<h5 class="modal-title"><i class="icon-pencil7 mr-1"></i>링크 수정</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<div class="modal-body">

				<input type="hidden" name="menu_id" />

				<div class="form-group row">
					<label class="col-form-label col-lg-2">링크</label>
					<div class="col-lg-10">
						<input type="text" name="link" class="form-control" placeholder="링크&hellip;" required />
						<small class="form-text text-muted">Base URL 이후부터 작성( /aaa/bbb/ccc )</small>
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
<!-- /modal link -->

<!-- modal status -->
<div id="modal-status" class="modal fade" data-backdrop="static" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-sm modal-dialog-centered" role="document">
		<form class="modal-content">
			<div class="modal-header py-2">
				<h5 class="modal-title"><i class="icon-pencil7 mr-1"></i>상태 변경</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<div class="modal-body">

				<input type="hidden" name="menu_id" />

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
				<h5 class="modal-title"><i class="icon-pencil7 mr-1"></i>정보 수정</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<div class="modal-body">

				<input type="hidden" name="menu_id" />

				<legend class="text-uppercase font-size-sm font-weight-bold">등록정보</legend>

				<div class="form-group row">
					<label class="col-form-label col-lg-3">상태</label>
					<div class="col-lg-9">
						<select name="is_used" class="form-control select">
							<option value="Y">활성화</option>
							<option value="N">비활성화</option>
						</select>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-3">메뉴명<span class="text-danger ml-1">*</span></label>
					<div class="col-lg-9">
						<input type="text" name="name" class="form-control" placeholder="메뉴명&hellip;" required />
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-3">일련번호<span class="text-danger ml-1">*</span></label>
					<div class="col-lg-9">
						<input type="text" name="menu_id" class="form-control" placeholder="메뉴 아이디&hellip;" disabled />
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-3">부모 일련번호<span class="text-danger ml-1">*</span></label>
					<div class="col-lg-9">
						<input type="text" name="parent_menu_id" class="form-control" placeholder="부모 일련번호&hellip;" required />
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-3">우선순위</label>
					<div class="col-lg-9">
						<input type="text" name="priority" class="form-control" placeholder="우선순위&hellip;" />
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-3">링크</label>
					<div class="col-lg-9">
						<input type="text" name="link" class="form-control" placeholder="링크&hellip;" />
						<small class="form-text text-muted">Base URL 이후부터 작성( /aaa/bbb/ccc )</small>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-3">링크 target</label>
					<div class="col-lg-9">
						<input type="text" name="link_target" class="form-control" placeholder="링크 target&hellip;" />
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-3">링크 class</label>
					<div class="col-lg-9">
						<input type="text" name="link_class" class="form-control" placeholder="링크 class&hellip;" />
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-3">메뉴 앞 HTML</label>
					<div class="col-lg-9">
						<input type="text" name="before_html" class="form-control" placeholder="HTML 입력&hellip;" />
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-3">메뉴 뒤 HTML</label>
					<div class="col-lg-9">
						<input type="text" name="after_html" class="form-control" placeholder="HTML 입력&hellip;" />
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
<!-- /modal item -->

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
				url			: cp_params.base_url + '/preferences/management/menus/list',
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
									data[ key ] = ionRangeSlider.result.from;
								}
							} else {
								data[ key ] = {};

								if ( ionRangeSlider.result.from > ionRangeSlider.result.min ) {
									data[ key ]['min'] = ionRangeSlider.result.from;
								}
								if ( ionRangeSlider.result.to < ionRangeSlider.result.max ) {
									data[ key ]['max'] = ionRangeSlider.result.to;
								}
							}
						} else if( $.isArray( value ) ) {
							data[ key ] = value.join();
						} else {
							data[ key ] = value;
						}
					} );

					return data;
				},
				dataSrc        : function(response){
					response.recordsTotal = response.total_rows;
					response.recordsFiltered = response.total_rows;
					response.draw++;

					return response.list;
				},
			},
			buttons : [
				{
					className	: 'btn btn-primary btn-add-new',
					text		: '<i class="icon-upload7 font-size-base mr-1"></i>신규등록'
				},
				{
					className	: 'btn btn-danger btn-delete-selected',
					text		: '<i class="icon-trash font-size-base mr-1"></i>선택삭제'
				},
				{
					extend		: 'collection',
					text		: '<i class="icon-three-bars"></i>',
					className	: 'btn btn-teal btn-icon dropdown-toggle dropdown-icon-none',
					buttons		: [
						{
							extend		: 'copy',
							text		: '<i class="icon-copy3 font-size-base mr-1"></i>선택항목 복사'
						},
						{
							extend		: 'print',
							text		: '<i class="icon-printer font-size-base mr-1"></i>선택항목 프린트'
						},
						{
							extend		: 'excel',
							text		: '<i class="icon-file-download font-size-base mr-1"></i>선택항목 다운로드',
							customize	: function (xlsx) {
								var sheet = xlsx.xl.worksheets["sheet1.xml"];
								$( "c[r^=I] t", sheet ).text( "" );
							}
						},
					]
				},
			],
			order			: [ [ 2,'desc' ] ],
			createdRow		: function( row, data, dataIndex ) {
				$( row ).data( 'target-id', data.menu_id );
			},
			columns		: [
				{
					data		: 'menu_id',
					class		: 'select-checkbox',
					sortable    : false,
					render		: function( data, type, row, meta ) {
						return null;
					}
				},
				{
					title		: '<center>메뉴명</center>',
					data        : 'name',
					class		: 'text-nowrap text-left',
					render		: function( data, type, row, meta ) {
						return '<a href="#" class="text-dark text-nowrap" data-toggle="modal" data-target="#modal-name">' + data + '</a>';
					}
				},
				{
					title		: '<center>일련번호</center>',
					data        : 'menu_id',
					class		: 'text-nowrap text-right',
				},
				{
					title		: '<center>부모 일련번호</center>',
					data        : 'parent_menu_id',
					class		: 'text-nowrap text-right',
					render		: function( data, type, row, meta ) {
						return '<a href="#" class="text-dark text-nowrap" data-toggle="modal" data-target="#modal-parent-menu">' + data + '</a>';
					}
				},
				{
					title		: '<center>우선순위</center>',
					data        : 'priority',
					class		: 'text-nowrap text-right',
					sortable    : false,
					render		: function( data, type, row, meta ) {
						return '<a href="#" class="text-dark text-nowrap" data-toggle="modal" data-target="#modal-priority">' + data + '</a>';
					}
				},
				{
					title		: '<center>링크</center>',
					data        : 'link',
					class		: 'text-nowrap text-left',
					render		: function( data, type, row, meta ) {
						return '<a href="#" class="text-dark text-nowrap" data-toggle="modal" data-target="#modal-link">' + data + '</a>';
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
							'</div>\n';

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

	var _componentAddNew = function() {
		const modalEl = $( '#modal-add' );

		modalEl.on( 'show.bs.modal', function(e) {
			$( this ).find( 'form' )[0].reset();

			$( 'select[name="is_used"]' ).val( 'Y' ).trigger( 'change' );
		} );

		modalEl.on( 'hidden.bs.modal', function(e) {
			$( this ).find( 'form' )[0].reset();

			$( 'select[name="is_used"]' ).val( 'Y' ).trigger( 'change' );
		} );

		$( 'form', modalEl ).on( 'submit', function(e) {
			var form_data    = $( this ).serialize();

			$.ajax( {
				type        : 'POST',
				url         : cp_params.base_url + '/preferences/management/menus/item_insert/',
				data        : form_data,
				dataType    : 'json',
				error       : function( xhr, status, error ) {
					alert( xhr.responseText );
				},
				success     : function( data ) {
					if ( data.confirm === 'Y' ) {
						alert( data.message );
						location.reload();
					} else {
						$( '#table' ).DataTable().ajax.reload( null, false );
						$( '#modal-add' ).modal( 'hide' );
						alert( data.message );
					}
				}
			} );
			return false;
		} );
	}

	var _componentName = function() {
		const modalEl = $( '#modal-name' );

		modalEl.on( 'show.bs.modal', function(e) {
			let target_id = $( e.relatedTarget ).closest( 'tr' ).data( 'target-id' );

			axios.get( cp_params.base_url + '/preferences/management/menus/item_get/' + target_id, {
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
		} );

		$( 'form', modalEl ).on( 'submit', function(e) {
			let target_id = $( '[name="menu_id"]' ).val();
			let form_data = $( this ).serialize();

			$.ajax( {
				type        : 'POST',
				url         : cp_params.base_url + '/preferences/management/menus/name_put/' + target_id,
				data        : form_data,
				dataType    : 'json',
				error       : function( xhr, status, error ) {
					alert( xhr.responseText );
				},
				success     : function( data ) {
					$( '#table' ).DataTable().ajax.reload( null, false );
					$( '#modal-name' ).modal( 'hide' );
					alert( data.message );
				}
			} );
			return false;
		} );
	}

	var _componentParentMenu = function() {
		const modalEl = $( '#modal-parent-menu' );

		modalEl.on( 'show.bs.modal', function(e) {
			let target_id = $( e.relatedTarget ).closest( 'tr' ).data( 'target-id' );

			axios.get( cp_params.base_url + '/preferences/management/menus/item_get/' + target_id, {
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
		} );

		$( 'form', modalEl ).on( 'submit', function(e) {
			let target_id = $( '[name="menu_id"]' ).val();
			let form_data = $( this ).serialize();

			$.ajax( {
				type        : 'POST',
				url         : cp_params.base_url + '/preferences/management/menus/paren_menu_put/' + target_id,
				data        : form_data,
				dataType    : 'json',
				error       : function( xhr, status, error ) {
					alert( xhr.responseText );
				},
				success     : function( data ) {
					$( '#table' ).DataTable().ajax.reload( null, false );
					$( '#modal-parent-menu').modal( 'hide' );
					alert( data.message );
				}
			} );
			return false;
		} );
	}

	var _componentPriority = function() {
		const modalEl = $( '#modal-priority' );

		modalEl.on( 'show.bs.modal', function(e) {
			let target_id = $( e.relatedTarget ).closest( 'tr' ).data( 'target-id' );

			axios.get( cp_params.base_url + '/preferences/management/menus/item_get/' + target_id, {
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
		} );

		$( 'form', modalEl ).on( 'submit', function(e) {
			let target_id = $( '[name="menu_id"]' ).val();
			let form_data = $( this ).serialize();

			$.ajax( {
				type        : 'POST',
				url         : cp_params.base_url + '/preferences/management/menus/priority_put/' + target_id,
				data        : form_data,
				dataType    : 'json',
				error       : function( xhr, status, error ) {
					alert( xhr.responseText );
				},
				success     : function( data ) {
					$( '#table' ).DataTable().ajax.reload( null, false );
					$( '#modal-priority' ).modal( 'hide' );
					alert( data.message );
				}
			} );
			return false;
		} );
	}

	var _componentLink = function() {
		const modalEl = $( '#modal-link' );

		modalEl.on( 'show.bs.modal', function(e) {
			let target_id = $( e.relatedTarget ).closest( 'tr' ).data( 'target-id' );

			axios.get( cp_params.base_url + '/preferences/management/menus/item_get/' + target_id, {
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
		} );

		$( 'form', modalEl ).on( 'submit', function(e) {
			let target_id = $( '[name="menu_id"]' ).val();
			let form_data = $( this ).serialize();

			$.ajax( {
				type        : 'POST',
				url         : cp_params.base_url + '/preferences/management/menus/link_put/' + target_id,
				data        : form_data,
				dataType    : 'json',
				error       : function( xhr, status, error ) {
					alert( xhr.responseText );
				},
				success     : function( data ) {
					$( '#table' ).DataTable().ajax.reload( null, false );
					$( '#modal-link' ).modal( 'hide' );
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

			axios.get( cp_params.base_url + '/preferences/management/menus/item_get/' + target_id, {
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
			let target_id = $( '[name="menu_id"]' ).val();
			let form_data = $( this ).serialize();

			$.ajax( {
				type        : 'POST',
				url         : cp_params.base_url + '/preferences/management/menus/status_put/' + target_id,
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

		modalEl.on( 'show.bs.modal', function(e) {
			let target_id = $( e.relatedTarget ).closest( 'tr' ).data( 'target-id' );

			axios.get( cp_params.base_url + '/preferences/management/menus/item_get/' + target_id, {
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
			let target_id = $( '[name="menu_id"]' ).val();
			let form_data   = $( this ).serialize();

			$.ajax( {
				type        : 'POST',
				url         : cp_params.base_url + '/preferences/management/menus/item_put/' + target_id,
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
					url         : cp_params.base_url + '/preferences/management/menus/item_delete/' + target_id,
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
			var target_ids = [];
			$( 'tr.selected' ).each( function() {
				target_ids += '&' + i + '=' + $( this ).data( 'targetId' );
				i++;
			} );

			if ( target_ids.length > 0 ) {
				if ( confirm( '삭제를 하면 복구가 불가능합니다.\n선택된 아이템을 삭제하시겠습니까?' ) == true ) {
					$.ajax( {
						type        : 'POST',
						url         : cp_params.base_url + '/preferences/management/menus/selected_delete/',
						data		: target_ids,
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
			_componentAddNew();
			_componentName();
			_componentParentMenu();
			_componentPriority();
			_componentLink();
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
