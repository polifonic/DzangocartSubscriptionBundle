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
