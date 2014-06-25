!function($) {
	$.fn.plan = function(method) {

		var settings,
				table;

		// Public methods
		var methods = {
			init: function(options) {
				settings = $.extend(true, {}, $.fn.plan.defaults, options);

				return this.each(function() {
					var $this = $(this);

					$(".tabs", this).autotabs($.extend(true, {}, settings.autotabs, {
						success: {
							features: helpers.initFeatures,
							info: helpers.initInfo,
							prices: helpers.initPrices
						}
					}));
				});
			}
		};

		var helpers = {
			initPlanDateTimePickers: function() {
				var start_date_picker = $('#start_datetimepicker');
				var finish_date_picker = $('#finish_datetimepicker');
				var start = $('#dzangocart_subscription_plan_start');
				var finish = $('#dzangocart_subscription_plan_finish');
				var start_dummy = $('#dzangocart_subscription_plan_startdatepicker');
				var finish_dummy = $('#dzangocart_subscription_plan_finishdatepicker');

				start_date_picker.datetimepicker({
					pickTime: false
				});
				start_date_picker.data("DateTimePicker").setDate(start.attr('value'));
				start_date_picker.data("DateTimePicker").setMaxDate(finish.attr('value'));

				finish_date_picker.datetimepicker({
					pickTime: false
				});
				finish_date_picker.data("DateTimePicker").setDate(finish.attr('value'));
				finish_date_picker.data("DateTimePicker").setMinDate(start.attr('value'));

				start_date_picker.on("dp.change", function(e) {
					start.attr('value', start_dummy.val());
					finish_date_picker.data("DateTimePicker").setMinDate(e.date);
				});
				finish_date_picker.on("dp.change", function(e) {
					finish.attr('value', finish_dummy.val());
					start_date_picker.data("DateTimePicker").setMaxDate(e.date);
				});
			},
			initPricesDateTimePicker: function() {
				var start_date_picker = [];
				var finish_date_picker = [];
				var start = [];
				var finish = [];
				var start_dummy = [];
				var finish_dummy = [];

				for (var i = 0; i < dzangocart_subscription_plan_prices.count; i++) {
					start_date_picker[i] = $('#start_datetimepicker_' + i);
					finish_date_picker[i] = $('#finish_datetimepicker_' + i);
					start[i] = $('#prices_' + i + '_start');
					finish[i] = $('#prices_' + i + '_finish');
					start_dummy[i] = $('#prices_' + i + '_startdatepicker');
					finish_dummy[i] = $('#prices_' + i + '_finishdatepicker');

					start_date_picker[i].datetimepicker({
						pickTime: false
					});
					start_date_picker[i].data("DateTimePicker").setDate(start[i].attr('value'));
					start_date_picker[i].data("DateTimePicker").setMaxDate(finish[i].attr('value'));

					finish_date_picker[i].datetimepicker({
						pickTime: false
					});
					finish_date_picker[i].data("DateTimePicker").setDate(finish[i].attr('value'));
					finish_date_picker[i].data("DateTimePicker").setMinDate(start[i].attr('value'));

					start_date_picker[i].on("dp.change", function(e) {
						var i = $(this).attr('id').substring($(this).attr('id').length - 1)
						start[i].attr('value', start_dummy[i].val());
						finish_date_picker[i].data("DateTimePicker").setMinDate(e.date);
					});
					finish_date_picker[i].on("dp.change", function(e) {
						var i = $(this).attr('id').substring($(this).attr('id').length - 1)
						finish[i].attr('value', finish_dummy[i].val());
						start_date_picker[i].data("DateTimePicker").setMaxDate(e.date);
					});
				}
			},
			initFeatures: function() {
				$("form", this).ajaxForm({
					target: this,
					success: function() {
						helpers.initFeatures.apply(this);
					}
				});
			},
			initInfo: function() {
				helpers.initPlanDateTimePickers();
				$("form", this).ajaxForm({
					target: this,
					success: function() {
						helpers.initInfo.apply(this);
						helpers.initPlanDateTimePickers();
					}
				});
			},
			initPrices: function() {
				helpers.initPricesDateTimePicker();
				$("form", this).ajaxForm({
					target: this,
					success: function() {
						helpers.initInfo.apply(this);
						helpers.initPricesDateTimePicker();
					}
				});
			}
		};

		if (methods[ method ]) {
			return methods[ method ].apply(this, Array.prototype.slice.call(arguments, 1));
		}
		else if (typeof method === "object" || !method) {
			return methods.init.apply(this, arguments);
		}
		else {
			$.error("Method " + method + " does not exist in $.plan.");
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
	$(".plan").plan(dzangocart_subscription_plan);
});
