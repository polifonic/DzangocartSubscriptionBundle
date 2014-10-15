!function( $ ) {
	$.fn.plans = function( method ) {

		var settings,
			table;

		// Public methods
		var methods = {
			init: function( options ) {
				settings = $.extend( true, {}, $.fn.plans.defaults, options );

				return this.each( function() {
					var $this = $( this );

					helpers.initTableDnD( this );
					
				} );
			}
		};

		var helpers = {
			initTableDnD: function( plans ) {
				var plans = plans;
				table = $( "table.plans", plans );
				table.tableDnD( {
					onDrop: function( table, row ) {
						var new_rank = $( table.tBodies[ 0 ].rows ).index( row ) + 1,
							plan_id = ( row.id ).slice( -1 );

						if ( String(new_rank) !== $( "td.number", row ).html() ) {
							$( "tbody.loading", table ).html( settings.tablednd.ajax.loading );
							$.ajax( {
								url: settings.tablednd.ajax.url,
								data: { plan_id : plan_id, new_rank : new_rank },
								success: function ( data ) {
									$( "tbody.plans", table ).replaceWith( data );
									$( "tbody.loading", table ).html( '' );
									$( ".flash-message", plans ).html( "<div class='alert alert-success'>" + settings.tablednd.ajax.success + "</div>" );
									helpers.initTableDnD( plans );
								}
							} );
						}
					}
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
			$.error( "Method " + method + " does not exist in $.plans." );
		}
	};

	$.fn.plans.defaults = {};
}( window.jQuery );

$( document ).ready( function() {
	$( ".plans" ).plans( dzangocart_subscription.plans );
} );
