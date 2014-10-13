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
			initPlanDateTimePickers: function() {
				var start = $( ".date.start" ),
				    finish = $( ".date.finish" );

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
			initPricesDateTimePicker: function() {
				var start_date_picker = [],
				    finish_date_picker = [],
				    start = [],
				    finish = [],
				    start_dummy = [],
				    finish_dummy = [];

				for ( var i = 0; i < dzangocart_subscription_plan_prices.count; i++ ) {
					start_date_picker[i] = $( "#start_datetimepicker_" + i );
					finish_date_picker[i] = $( "#finish_datetimepicker_" + i );
					start[i] = $( "#prices_" + i + "_start" );
					finish[i] = $( "#prices_" + i + "_finish" );
					start_dummy[i] = $( "#prices_" + i + "_startdatepicker" );
					finish_dummy[i] = $( "#prices_" + i + "_finishdatepicker" );

					start_date_picker[i].datetimepicker( {
						pickTime: false
					} );
					start_date_picker[i].data( "DateTimePicker" ).setDate(start[i].attr( "value" ) );
					start_date_picker[i].data( "DateTimePicker" ).setMaxDate(finish[i].attr( "value" ) );

					finish_date_picker[i].datetimepicker( {
						pickTime: false
					} );
					finish_date_picker[i].data( "DateTimePicker" ).setDate(finish[i].attr( "value" ) );
					finish_date_picker[i].data( "DateTimePicker" ).setMinDate(start[i].attr( "value" ) );
				}

				$( ".start_datetimepicker" ).on( "dp.change", function( e ) {
					var i = $(this).attr( "id" ).substring($(this).attr( "id" ).length - 1 );
					$( "#prices_" + i + "_start" ).attr( "value", $( "#prices_" + i + "_startdatepicker" ).val() );
					$( "#finish_datetimepicker_" + i).data( "DateTimePicker" ).setMinDate( e.date );
				} );

				$( ".finish_datetimepicker" ).on( "dp.change", function( e ) {
					var i = $( this ).attr( "id" ).substring( $( this ).attr( "id" ).length - 1 );
					$( "#prices_" + i + "_finish" ).attr( "value", $( "#prices_" + i + "_finishdatepicker" ).val() );
					$( "#start_datetimepicker_" + i ).data( "DateTimePicker" ).setMaxDate( e.date );
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
				helpers.initPlanDateTimePickers();
				$( "form", this ).ajaxForm( {
					target: this,
					success: function() {
						helpers.initInfo.apply( this );
						helpers.initPlanDateTimePickers();
					}
				} );
			},
			initPrices: function() {
				helpers.initPricesDateTimePicker();
				$( "form", this ).ajaxForm( {
					target: this,
					success: function() {
						helpers.initPrices.apply( this );
						helpers.initPricesDateTimePicker();
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
