!function( $ ) {
	$.fn.plan = function( method ) {

		var settings,
			table;

		// Public methods
		var methods = {
			init: function( options ) {
				settings = $.extend( true, {}, $.fn.plan.defaults, options );

				return this.each(function() {
					var $this = $( this );

					$( ".tabs", this ).autotabs( $.extend( true, {}, settings.autotabs, {

					} ) );
				});
			}
		};

		if ( methods[ method ] ) {
			return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
		}
		else if  (typeof method === "object" || !method ) {
			return methods.init.apply( this, arguments );
		}
		else {
			$.error( "Method " +  method + " does not exist in $.plan." );
		}
	};

	$.fn.plan.defaults = {
		autotabs: {
			tabs_class: "nav nav-tabs",
			tab_class: "",
			active_class: "active"
		}
	};
} ( window.jQuery );

$( document ).ready(function() {
	$( ".plan" ).plan( dzangocart_subscription_plan );
});
