!function( $ ) {
	$.fn.plan = function( method ) {

		var settings,
			table;

		// Public methods
		var methods = {
			init: function( options ) {
				settings = $.extend(true, {}, $.fn.plan.defaults, options);

				return this.each( function() {
					var $this = $( this );

					moment.locale( dzangocart_subscription.locale );

					$( ".tabs", this ).autotabs( $.extend( true, {}, settings.autotabs, {
						success: {
							features: helpers.initFeatures,
							info: helpers.initInfo,
							prices: helpers.initPrices
						}
					} ) );
				} );
			}
		};

		var helpers = {
			initDateTimePickers: function( reference ) {
				var start = $( ".date.start", reference ),
				    finish = $( ".date.finish", reference );

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
			},
			initPricesDateTimePicker: function( reference ) {
				$( "table tr.price", reference ).each( function () {
					var row = this;

					helpers.initDateTimePickers( row );
				} );
			},
			initFeatures: function() {
				$( "form", this ).ajaxForm( {
					target: this,
					success: function() {
						helpers.initFeatures.apply( this );
					}
				} );
			},
			initInfo: function() {
				var info = this;
				helpers.initDateTimePickers( info );
				$( "form", info ).ajaxForm( {
					target: this,
					success: function() {
						helpers.initInfo.apply( this );
						helpers.initDateTimePickers( info );
					}
				} );
			},
			initPrices: function() {
				var prices = this;
				helpers.initPricesDateTimePicker( prices );
				$( "form", prices ).ajaxForm( {
					target: this,
					success: function() {
						helpers.initPrices.apply( this );
						helpers.initPricesDateTimePicker( prices );
					}
				} );
			}
		};

		if (methods[ method ]) {
			return methods[ method ].apply(this, Array.prototype.slice.call(arguments, 1));
		}
		else if (typeof method === "object" || !method) {
			return methods.init.apply(this, arguments);
		}
		else {
			$.error( "Method " + method + " does not exist in $.plan." );
		}
	};

	$.fn.plan.defaults = {
		autotabs: {
			cookie_name: "dzangocart_plan",
			tabs_class: "nav nav-tabs",
			tab_class: "",
			active_class: "active"
		}
	};
}(window.jQuery);

$(document).ready(function() {
	$( ".plan" ).plan(dzangocart_subscription.plan);
});
