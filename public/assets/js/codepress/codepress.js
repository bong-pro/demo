/*********************
 * # Custom JS code
 *********************/

var CodePress = function () {

	const _componentDropzone = function() {
		if ( typeof Dropzone == 'undefined' ) {
			return;
		}

		//Dropzone.autoDiscover = false;
		$.extend( true, Dropzone.prototype.defaultOptions, {
			dictDefaultMessage           : "파일을 드래그 하거나<span>여기를 클릭 하세요</span>",
			dictFallbackMessage          : "브라우저에서 드래그 앤 드롭을 지원하지 않습니다.",
			dictFallbackText             : "Please use the fallback form below to upload your files like in the olden days.",
			dictFileTooBig               : "파일 크기가 초과되었습니다.({{filesize}}MiB). 최대 용량: {{maxFilesize}}MiB.",
			dictInvalidFileType          : "이 형식의 파일은 업로드할 수 없습니다.",
			dictResponseError            : "서버가 {{statusCode}} 코드를 응답하였습니다.",
			dictCancelUpload             : "업로드 취소",
			dictCancelUploadConfirmation : "해당 업로드를 취소하시겠습니까?",
			dictUploadCanceled           : '업로드가 취소되었습니다.',
			dictRemoveFile               : "파일 삭제",
			dictMaxFilesExceeded         : "더 이상 파일을 업로드할 수 없습니다.",

			addRemoveLinks               : true,
			data                         : null,
			init                         : function() {
				const dz = this;
				const multiple = dz.options.maxFiles > 1;
				const inputEl = $( this.element ).find( ':input' );

				// drop, dragstart, dragend, dragenter, dragover, dragleave,
				// addedfile, removedfile, thumbnail, error, errormultiple,
				// processing, processingmultiple, uploadprogress, totaluploadprogress,
				// sending, sendingmultiple, success, successmultiple,
				// canceled, canceledmultiple, complete, completemultiple,
				// reset, maxfilesexceeded, maxfilesreached

				dz.on( 'maxfilesexceeded', function (file) {
					this.removeAllFiles();
					this.addFile(file);
					console.log( '교체함' );
				} );

				dz.on( 'addedfile', function(file) {
					console.log( '추가됨' );
				} );

				dz.on( 'sending', function(file, xhr, formData) {
					console.log( '전송' );
				} );

				dz.on( 'success', function(file, response) {
					console.log(dz.getAcceptedFiles());
					const value = is_json(inputEl.val()) ? JSON.parse(inputEl.val()) : [inputEl.val()];
					response.forEach(function(v) {
						value.push(v.dataURL);
					} );

					inputEl.val(JSON.stringify(value));
				} );

				dz.on( 'removedfile', function(file) {
					const value = dz.files.map(v => {
						return v['dataURL'];
					} );

					inputEl.val(value.length > 0 ? JSON.stringify(value) : '' );
				} );

				$.each( dz.options.data, function( index, mock ) {
					if (dz.options.maxFiles <= index + 1) {
						dz.files.push( $.extend( mock, {
							accepted : true,
						} ) );

						dz.displayExistingFile(mock, mock.path);
					}
				} );
			}
		} );
	};
    
	// Select2
	const _componentSelect2 = function() {
		if ( !$().select2 ) {
			return;
		}

		// Default initialization
		$( '.select' ).select2( {
			minimumResultsForSearch: Infinity
		} );

		// Select with search
		$('.select-search').select2();

		// Fixed width. Single select
		$( '.select-fixed-single' ).select2( {
			minimumResultsForSearch: Infinity,
			width: 250
		} );

		$.fn.select2.defaults.set( 'language', 'ko' );

		$( 'select.select2:not(.select2-hidden-accessible)' ).select2( {
			minimumResultsForSearch: Infinity,
			dropdownAutoWidth: true,
			//width: 'auto',
			//allowClear:true,
		} );

		$( 'select.select2-search:not(.select2-hidden-accessible)' ).select2( {
			placeholder: function() {
				return $( this ).data( 'placeholder' );
			},
		} );
	};

	// BlockUI
	const _componentBlockUI = function() {
		if ( !$().block ) {
			return;
		}

		$.extend( $.blockUI.defaults, {
			overlayCSS: {
				backgroundColor: '#fff',
				opacity: 0.8,
				cursor: 'wait',
				'box-shadow': '0 0 0 1px #ddd'
			},
			css: {
				border: 0,
				padding: 0,
				backgroundColor: 'none'
			}
		} );
	};

	// Loading Button
	const _componentLoadingButton = function() {
		$( '.btn-loading' ).on( 'click', function () {
			var btn = $( this ),
				initialText = btn.html(),
				loadingText = btn.data( 'loading-text' );
			btn.html( loadingText ).addClass( 'disabled' );
			setTimeout( function () {
				btn.html( initialText ).removeClass( 'disabled' );
			}, 3000 )
		} );
	};

	// Ladda Button
	const _componentLaddaButton = function() {
		if ( typeof Ladda == 'undefined' ) {
			return;
		}

		// Button with spinner
		Ladda.bind( '.btn-ladda-spinner', {
			dataSpinnerSize: 16,
			timeout: 2000
		} );

		Ladda.bind( '.btn-ladda-progress', {
			callback: function( instance ) {
				var progress = 0;
				var interval = setInterval( function() {
					progress = Math.min( progress + Math.random() * 0.1, 1);
					instance.setProgress( progress );

					if( progress === 1 ) {
						instance.stop();
						clearInterval( interval );
					}
				}, 200 );
			}
		} );
	};

	// Color Picker
	const _componentColorPicker = function() {
		if ( !$().spectrum ) {
			return;
		}

		const palette = [
			[ "#000", "#444", "#666", "#999", "#ccc", "#eee", "#f3f3f3", "#fff" ],
			[ "#f00", "#f90", "#ff0", "#0f0", "#0ff", "#00f", "#90f", "#f0f" ],
			[ "#f4cccc", "#fce5cd", "#fff2cc", "#d9ead3", "#d0e0e3", "#cfe2f3", "#d9d2e9", "#ead1dc" ],
			[ "#ea9999", "#f9cb9c", "#ffe599", "#b6d7a8", "#a2c4c9", "#9fc5e8", "#b4a7d6", "#d5a6bd" ],
			[ "#e06666", "#f6b26b", "#ffd966", "#93c47d", "#76a5af", "#6fa8dc", "#8e7cc3", "#c27ba0" ],
			[ "#c00", "#e69138", "#f1c232", "#6aa84f", "#45818e", "#3d85c6", "#674ea7", "#a64d79" ],
			[ "#900", "#b45f06", "#bf9000", "#38761d", "#134f5c", "#0b5394", "#351c75", "#741b47" ],
			[ "#600", "#783f04", "#7f6000", "#274e13", "#0c343d", "#073763", "#20124d", "#4c1130" ]
		];

		$( '.colorpicker' ).spectrum( {
			showInput: true,
			showPalette: true,
			palette: palette
		} );
	};

	// Date Picker
	const _componentDatePicker = function() {
		if ( !$().datepicker ) {
			return;
		}

		$.extend( $.datepicker._defaults, {
			altField            : '',
			altFormat           : '',
			showOn              : 'focus', // focus, button, both
			autoSize            : true,
			duration            : 'normal', //slow, normal, fast
			//showOptions			: {direction: 'up'},
			dateFormat          : 'yy-mm-dd',
			maxDate             : null, // +1m +1w +1d
			minDate             : null,
			changeYear          : true,
			yearRange           : 'c-10:c+10',
			yearSuffix          : '',
			changeMonth         : true,
			stepMonths          : 1,
			showOtherMonths     : true,
			//selectOtherMonths	: true,
			showMonthAfterYear  : true,
			monthNamesShort     : ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
			prevText            : '이전달',
			nextText            : '다음달',
			//defaultDate			: null,
			dayNamesMin         : ['일', '월', '화', '수', '목', '금', '토'],
			firstDay            : 0,
			buttonText          : '선택',
			//showButtonPanel		: true,
			closeText           : '닫기',
			currentText         : '오늘',
			beforeShow          : function( input, inst ) {
				alert( 'datepicker.beforeShow' );
				if ( $().select2 ) {
					$(inst).find( 'select' ).select2();
				}
			},
			beforeShowDay       : function(date) {
				switch (date.getDay()) {
					case 0 :
						return [ true,'ui-datepicker-sunday', '일요일' ];
					case 6 :
						return [ true,'ui-datepicker-saturday', '토요일' ];
					default :
						return [ true,'' ];
				}
			},
			onChangeMonthYear   : function( year, month, inst ) {},
			onClose             : function( date, inst ) {},
			onSelect            : function( date, inst ) {},
		} );
	};

	// Picka Date
	const _componentPickadate = function() {
		if ( !$().pickadate ) {
			return;
		}

		$.extend($.fn.pickadate.defaults, {
			// Strings and translations
			monthsFull: [ 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' ],
			monthsShort: [ 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' ],
			weekdaysFull: [ 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday' ],
			weekdaysShort: [ 'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat' ],
			showMonthsShort: undefined,
			showWeekdaysFull: undefined,

			// Buttons
			today: '오늘',
			clear: '지우기',
			close: '닫기',

			// Accessibility labels
			labelMonthNext: '다음달',
			labelMonthPrev: '이전달',
			labelMonthSelect: 'Select a month',
			labelYearSelect: 'Select a year',

			// Formats
			format: 'yyyy-mm-dd',
			formatSubmit: undefined,
			hiddenPrefix: undefined,
			hiddenSuffix: '_submit',
			hiddenName: undefined,

			// Dropdown selectors
			selectYears: undefined,
			selectMonths: undefined,

			// First day of the week
			firstDay: undefined,

			// Date limits
			min: undefined,
			max: undefined,
		} );
	};

	// PickaTime
	const _componentPickatime = function() {
		if ( !$().pickatime ) {
			return;
		}
	};

	// Validation
	const _componentVailidation = function() {
		if ( !$().validate ) {
			return;
		}

		$.validator.setDefaults( {
			ignore          : 'input[type=hidden], .select2-search__field',
			errorClass      : 'validation-invalid-label',
			successClass    : 'validation-valid-label',
			validClass      : 'validation-valid-label',
			highlight       : function( element, errorClass ) {
				$( element ).removeClass( errorClass );
			},
			unhighlight     : function( element, errorClass ) {
				$( element ).removeClass( errorClass );
			},
			success         : function( label ) {
				label.remove();
				//label.addClass('validation-valid-label').text('Success.');
			},
			errorPlacement  : function( error, element ) {
				if ( element.parents().hasClass( 'form-check' ) ) {
					error.appendTo( element.parents( '.form-check' ).parent() );
				}
				else if ( element.parents().hasClass( 'form-group-feedback' ) || element.hasClass( 'select2-hidden-accessible' ) ) {
					error.appendTo( element.parent() );
				}
				else if ( element.parent().is( '.uniform-uploader, .uniform-select' ) || element.parents().hasClass( 'input-group' ) ) {
					error.appendTo( element.parent().parent() );
				}
				else {
					error.insertAfter( element );
				}
			},
		} );
	};

	// Datatables
	const _componentDatatable = function() {
		if ( !$().DataTable ) {
			return;
		}

		const displayLength = sessionStorage.getItem( 'ui_datatable_length' ) !== null ? parseInt( sessionStorage.getItem( 'ui_datatable_length' ) ) : 10;
		$.extend( true, $.fn.dataTable.defaults, {
			dom             : '<"datatable-spinner"r><"datatable-header"flB><"datatable-scroll datatable-scroll-wrap"t><"datatable-footer"ip>',
			retrieve        : true,
			processing      : true,
			serverSide      : true,
			responsive      : true,
			columnDefs		: [
				{
					width: 10,
					targets: [ 0 ]
				}
			],
			fixedColumns:   {
				leftColumns: 1,
				rightColumns: 0
			},
			select          : {
				style       : 'multi',
				selector    : 'td:first-child'
			},
			iDisplayLength  : displayLength,
			lengthMenu      : [ [10,15,20,50,75,100],[10,15,20,50,75,100] ],
			createdRow      : function( row, data, dataIndex ) {},
			initComplete    : function( settings, json ) {
				const wrapperEl = $(settings.nTableWrapper);

				wrapperEl.find( '.dataTables_length select' ).addClass( 'select2' );
				wrapperEl.find( '.dataTables_filter input' ).unbind().bind( 'keyup', function(e) {
					const pattern = /^[가-힣0-9a-zA-Z\s~!@#$%^&*()_+|<>?:{}]+$/;
					const keyword = this.value;

					if ( keyword.length < 1 || ( keyword.length > 1 && pattern.test( keyword ) ) || e.keyCode == 13 ) {
						settings.oInstance.api().search(keyword).draw();
					}
				} );

				// 데이터테이블 limit 변경시 저장
				$( '.datatable-header .dataTables_length' ).on( 'change', 'select', function() {
					window.sessionStorage.setItem( 'ui_datatable_length', $( this ).val());
				} );
			},
			fnPreDrawCallback : function( settings ) {},
			drawCallback    : function( settings ) {
				// 렌더링 할때마다 실행하므로 trigger 이동 필요
				_componentSelect2();
			},
			language        : {
				decimal             : '',
				emptyTable          : '데이터가 존재하지 않습니다.',
				info                : '총 <strong>_TOTAL_</strong>건의 데이터를 찾았습니다.<span class="text-muted"> &mdash; _START_에서 _END_번째 아이템</span>',
				infoEmpty           : '검색된 데이터가 없습니다.',
				infoFiltered        : '(전체 _MAX_건에서 필터링)',
				infoPostFix         : '',
				thousands           : ',',
				lengthMenu          : '_MENU_',
				loadingRecords      : '로딩중...',
				processing          : '잠시만 기다려 주세요...',
				search              : '_INPUT_',
				searchPlaceholder   : '검색 키워드...',
				zeroRecords         : '일치하는 데이터가 존재하지 않습니다.',
				paginate            : {
					first       : '처음',
					last        : '마지막',
					next        : '&rarr;',
					previous    : '&larr;',
				},
				aria                : {
					sortAscending     : ': activate to sort column ascending',
					sortDescending    : ': activate to sort column descending',
				},
				select              : {
					rows  : {
						'0' : '',
						'_' : '<span class="text-blue">아이템 %d건 선택</span>',
					},
				},
			},
		} );

		$.fn.dataTable.ext.errMode = 'throw';
	};

	// Noty
	const _componentNoty = function() {
		if ( typeof Noty == 'undefined' ) {
			return;
		}

		// Override Noty defaults
		Noty.overrideDefaults( {
			theme: 'limitless',
			layout: 'topRight',
			type: 'alert',
			timeout: 2500,
			closeWidth: ['click', 'button'],
			animation: {
				open: 'animated fadeInRight',
				close: 'animated fadeOutRight',
			}
		} );
	};

	// Dual listbox
	var _componentDualListbox = function() {
		if ( !$().bootstrapDualListbox ) {
			return;
		}

		// Basic example
		$( '.listbox' ).bootstrapDualListbox( {
			showFilterInputs: false,
			preserveSelectionOnMove: 'moved',
			moveOnSelect: false
		} );
	};

	var _componentFancytree = function() {
		if ( !$().fancytree ) {
			return;
		}

		// Hierarchical select
		$( '.tree-checkbox-hierarchical' ).fancytree( {
			checkbox	: true,
			selectMode	: 3,
			icons       : false,
		} );

		// Define element
		var selectAllSwitch = document.querySelector( '#select_all' );

		// Change checkbox states
		selectAllSwitch.addEventListener( 'change', function() {
			if ( selectAllSwitch.checked ) {
				$.ui.fancytree.getTree( '.tree-checkbox-toggle' ).visit( function( node ){
					node.setSelected( true );
				} );
				return false;
			} else {
				$.ui.fancytree.getTree( '.tree-checkbox-toggle' ).visit( function( node ){
					node.setSelected( false );
				} );
				return false;
			}
		} );
	};

	var _componentMultiselect = function() {
		if ( !$().multiselect ) {
			return;
		}

		// Basic initialization
		$( '.multiselect' ).multiselect();

		// Select All option
		$( '.multiselect-select-all' ).multiselect( {
			includeSelectAllOption : true
		} );

		// Select All and Filtering features
		$( '.multiselect-select-all-filtering' ).multiselect( {
			includeSelectAllOption : true,
			enableFiltering : true,
			enableCaseInsensitiveFiltering : true
		} );
	};

	var _componentTrumbowyg = function() {
		if ( !$().trumbowyg ) {
			return;
		}

		// Set custom icons path
		$.trumbowyg.svgPath = cp_params.base_url + '/template/global_assets/js/plugins/editors/trumbowyg/ui/icons.svg';

		// Default initialization
		$( '.trumbowyg_default' ).trumbowyg( {
			_dir: "rtl"
		} );

		$( '.trumbowyg_custom' ).trumbowyg( {
			btns: [
				//['formatting'],
				['strong', 'em'],
				['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
				['unorderedList', 'orderedList'],
				['undo', 'redo'], // Only supported in Blink browsers
				//['insertImage', 'link'],
				['viewHTML'],
				['fullscreen']
			]
		} );

		$( '.trumbowyg_menu_none' ).trumbowyg( {
			disabled: true,
			btns: [
				['viewHTML'],
			]
		} );
	};

	var _componentFileUpload = function() {
		if ( !$().fileinput ) {
			return;
		}

		//
		// Define variables
		//

		// Modal template
		var modalTemplate = '<div class="modal-dialog modal-lg" role="document">\n' +
			'  <div class="modal-content">\n' +
			'    <div class="modal-header align-items-center">\n' +
			'      <h6 class="modal-title">{heading} <small><span class="kv-zoom-title"></span></small></h6>\n' +
			'      <div class="kv-zoom-actions btn-group">{toggleheader}{fullscreen}{borderless}{close}</div>\n' +
			'    </div>\n' +
			'    <div class="modal-body">\n' +
			'      <div class="floating-buttons btn-group"></div>\n' +
			'      <div class="kv-zoom-body file-zoom-content"></div>\n' + '{prev} {next}\n' +
			'    </div>\n' +
			'  </div>\n' +
			'</div>\n';

		// Buttons inside zoom modal
		var previewZoomButtonClasses = {
			toggleheader: 'btn btn-light btn-icon btn-header-toggle btn-sm',
			fullscreen: 'btn btn-light btn-icon btn-sm',
			borderless: 'btn btn-light btn-icon btn-sm',
			close: 'btn btn-light btn-icon btn-sm'
		};

		// Icons inside zoom modal classes
		var previewZoomButtonIcons = {
			prev: $('html').attr('dir') == 'rtl' ? '<i class="icon-arrow-right32"></i>' : '<i class="icon-arrow-left32"></i>',
			next: $('html').attr('dir') == 'rtl' ? '<i class="icon-arrow-left32"></i>' : '<i class="icon-arrow-right32"></i>',
			toggleheader: '<i class="icon-menu-open"></i>',
			fullscreen: '<i class="icon-screen-full"></i>',
			borderless: '<i class="icon-alignment-unalign"></i>',
			close: '<i class="icon-cross2 font-size-base"></i>'
		};

		// File actions
		var fileActionSettings = {
			zoomClass: '',
			//zoomIcon: '<i class="icon-zoomin3"></i>',
			dragClass: 'p-2',
			dragIcon: '<i class="icon-three-bars"></i>',
			rfemoveClass: '',
			removeErrorClass: 'text-danger',
			removeIcon: '<i class="icon-bin"></i>',
			indicatorNew: '<i class="icon-file-plus text-success"></i>',
			indicatorSuccess: '<i class="icon-checkmark3 file-icon-large text-success"></i>',
			indicatorError: '<i class="icon-cross2 text-danger"></i>',
			indicatorLoading: '<i class="icon-spinner2 spinner text-muted"></i>'
		};

		//
		// Basic example
		//

		$( '.file-input' ).fileinput( {
			browseLabel: 'Browse',
			browseIcon: '<i class="icon-file-plus mr-2"></i>',
			uploadIcon: '<i class="icon-file-upload2 mr-2"></i>',
			removeIcon: '<i class="icon-cross2 font-size-base mr-2"></i>',
			layoutTemplates: {
				icon: '<i class="icon-file-check"></i>',
				modal: modalTemplate
			},
			initialCaption: "No file selected",
			previewZoomButtonClasses: previewZoomButtonClasses,
			previewZoomButtonIcons: previewZoomButtonIcons,
			fileActionSettings: fileActionSettings
		} );

		//
		// Misc
		//

		// Disable/enable button
		$( '#btn-modify' ).on( 'click', function() {
			$btn = $(this);
			if ( $btn.text() == 'Disable file input' ) {
				$( '#file-input-methods' ).fileinput( 'disable' );
				$btn.html( 'Enable file input' );
				alert( 'Hurray! I have disabled the input and hidden the upload button.' );
			} else {
				$( '#file-input-methods' ).fileinput( 'enable' );
				$btn.html('Disable file input');
				alert( 'Hurray! I have reverted back the input to enabled with the upload button.' );
			}
		} );
	};

	var _componentTouchspin = function() {
		if ( !$().TouchSpin ) {
			return;
		}

		// Basic example
		$( '.touchspin-basic' ).TouchSpin( {
			postfix: '<i class="icon-paragraph-justify3"></i>'
		} );

		// Postfix
		$( '.touchspin-postfix' ).TouchSpin( {
			min: 0,
			max: 100,
			step: 0.1,
			decimals: 2,
			postfix: '%'
		} );

		// Init with empty values
		$( '.touchspin-empty' ).TouchSpin();

		// Incremental/decremental steps
		$( '.touchspin-step' ).TouchSpin( {
			min: 0,
			max: 10000000,
			stepinterval: 50,
			maxboostedstep: 10000000,
			step: 10
		} );

		// Vertical spinners
		$( '.touchspin-vertical' ).TouchSpin( {
			verticalbuttons: true,
			verticalup: '<i class="icon-arrow-up12"></i>',
			verticaldown: '<i class="icon-arrow-down12"></i>'
		} );

		// krw
		$( '.touchspin-krw' ).TouchSpin( {
			min: 0,
			max: 10000000,
			stepinterval: 50,
			maxboostedstep: 10000000,
			step: 10,
			postfix: '원'
		} );

		// kg
		$( '.touchspin-kg' ).TouchSpin( {
			min: 0,
			max: 1000,
			step: 0.1,
			decimals: 2,
			postfix: 'kg'
		} );
	};

    return {
		initBeforeLoad: function() {
			_componentDropzone();
		},

		// Initialize all components
        initComponent : function() {
			_componentDropzone();
            _componentSelect2();
			_componentBlockUI();
			_componentLoadingButton();
			_componentLaddaButton();
			_componentColorPicker();
			_componentDatePicker()
			_componentPickadate();
			_componentPickatime();
			_componentVailidation();
			_componentDatatable();
			_componentNoty();
			_componentDualListbox();
			_componentFancytree();
			_componentMultiselect();
			_componentTrumbowyg();
			_componentFileUpload();
			_componentTouchspin();
        },

		// Enable transitions when page is fully loaded
		initAfterLoad: function() {
			//_searchFormValidation();
			//_displayCopyrightOnConsole();
			//setTimeout(function() {window.scrollTo(0, 1)}, 100);
        }
    };
    
}();

/*********************
 * Initialize module
 *********************/
CodePress.initBeforeLoad();

// When content is loaded
document.addEventListener( 'DOMContentLoaded', () => {
	CodePress.initComponent();
} );

// When page is fully loaded
window.addEventListener( 'load', () => {
	CodePress.initAfterLoad();
} );
