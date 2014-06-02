!function( $ ) {
	$.fn.features = function( method ) {

		var settings,
			table;

		var methods = {
			init: function( options ) {
				settings = $.extend( true, {}, $.fn.features.defaults, options );

				return this.each(function() {
					var $this = $( this );

					table = $( "table.table", this ).dataTable( $.extend( true, {}, settings.dataTables, {
						fnInitComplete: function( oSettings, json ) {
							$( oSettings.nTable ).show();
						}, 
					} ) );
				} );
			}
		};

		if ( methods[ method ] ) {
			return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ) );
		}
		else if ( typeof method === "object" || !method ) {
			return methods.init.apply( this, arguments );
		}
		else {
			$.error( "Method " +  method + " does not exist in $.features." );
		}
	};

	$.fn.features.defaults = {
		dataTables: {
			aoColumnDefs: [
				{ bSortable: false, aTargets: [ 0, 1, 2, 4 ] },
				{ bVisible: false, aTargets: [ 0 ] },
				{ sClass: "actions", aTargets: [ 4 ] }
			],
			asStripeClasses: [],
			bAutoWidth: false,
			bDestroy: true,
			bFilter: false,
			bPaginate: true,
			bProcessing: true,
			bServerSide: true,
			bSortable: true,
			oLanguage: {
				sUrl: "/bundles/uamdatatables/lang/en.txt"
			}
		}
	};
} ( window.jQuery );

$( document ).ready(function() {
	$( ".features" ).features( dzangocart_subscription.features );
});