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
						success: {
							features: helpers.initFeatures,
							info: helpers.initInfo,
							prices: helpers.initPrices
						}
					} ) );
				});
			}
		};

		var helpers = {
			initDateTimePickers: function(){
				$('#start_datetimepicker').datetimepicker();
				$('#start_datetimepicker').data("DateTimePicker").setDate($('#dzangocart_subscription_plan_start').attr( 'value'));
				$('#start_datetimepicker').data("DateTimePicker").setMaxDate($('#dzangocart_subscription_plan_finish').attr( 'value'));

				$('#finish_datetimepicker').datetimepicker();
				$('#finish_datetimepicker').data("DateTimePicker").setDate($('#dzangocart_subscription_plan_finish').attr( 'value'));
				$('#finish_datetimepicker').data("DateTimePicker").setMinDate($('#dzangocart_subscription_plan_start').attr( 'value'));

				$("#start_datetimepicker").on("dp.change",function (e) {
					$('#dzangocart_subscription_plan_start').attr( 'value', $('#dzangocart_subscription_plan_startdatepicker').val() );
					$('#finish_datetimepicker').data("DateTimePicker").setMinDate(e.date);
				});
				$("#finish_datetimepicker").on("dp.change",function (e) {
					$('#dzangocart_subscription_plan_finish').attr( 'value', $('#dzangocart_subscription_plan_finishdatepicker').val() );
					$('#start_datetimepicker').data("DateTimePicker").setMaxDate(e.date);
				});
			},
			initFeatures: function() {
				$( "form", this ).ajaxForm({
					target: this,
					success: function() {
						helpers.initFeatures.apply( this );
					}
				});
			},
			initInfo: function() {
				helpers.initDateTimePickers();
				$( "form", this ).ajaxForm({
					target: this,
					success: function() {
						helpers.initInfo.apply( this );
						helpers.initDateTimePickers();
					}
				});
			},
			initPrices: function() {
				$( "form", this ).ajaxForm({
					target: this,
					success: function() {
						helpers.initInfo.apply( this );
					}
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
			cookie_name: "dzangocart_plan",
			tabs_class: "nav nav-tabs",
			tab_class: "",
			active_class: "active"
		}
	};
} ( window.jQuery );

$( document ).ready(function() {
	$( ".plan" ).plan( dzangocart_subscription_plan );
});
