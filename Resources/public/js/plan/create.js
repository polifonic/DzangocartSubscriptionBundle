!function( $ ) {
	$.fn.plan = function( method ) {

		var settings,
			table;

		// Public methods
		var methods = {
			init: function( options ) {
				settings = $.extend( true, {}, $.fn.plan.defaults, options );

				return this.each( function() {
					var $this = $( this );

					moment.locale( dzangocart_subscription.locale );

					var start = $( "input.date.start", this ),
				    finish = $( "input.date.finish", this );

					start.datetimepicker( {
						pickTime: false,
						language: dzangocart_subscription.locale
					} );

					start.data( "DateTimePicker" ).setDate( start.attr( "value" ) );
					start.data( "DateTimePicker" ).setMaxDate( finish.attr( "value" ) );

					finish.datetimepicker( {
						pickTime: false,
						language: dzangocart_subscription.locale
					} );

					finish.data( "DateTimePicker" ).setDate( finish.attr( "value" ) );
					finish.data( "DateTimePicker" ).setMinDate( start.attr( "value" ) );

					start.on( "dp.change", function( e ) {
						finish.data( "DateTimePicker" ).setMinDate( e.date );
					} );

					finish.on( "dp.change", function( e ) {
						start.data( "DateTimePicker" ).setMaxDate( e.date );
					} );
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
			$.error( "Method " + method + " does not exist in $.plan." );
		}
	};

	$.fn.plan.defaults = {};
}( window.jQuery );

$( document ).ready( function() {
	$( ".plan_create" ).plan( dzangocart_subscription.plan );
} );
