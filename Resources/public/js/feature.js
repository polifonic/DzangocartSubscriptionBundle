!function( $ ) {
	$.fn.feature = function( method ) {

		var settings,
			table;

		// Public methods
		var methods = {
			init: function( options ) {
				settings = $.extend( true, {}, $.fn.feature.defaults, options );

				return this.each(function() {
					var $this = $( this );

					$( ".tabs", this ).autotabs( $.extend( true, {}, settings.autotabs, {
						success: {
							info: helpers.initInfo,
							plans: helpers.initPlans
						}
					} ) );
				});
			}
		};

		var helpers = {
			initInfo: function() {
				$( "form", this ).ajaxForm({
					target: this,
					success: function() {
						helpers.initInfo.apply( this );
					}
				});
			},
			initPlans: function() {
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
			$.error( "Method " +  method + " does not exist in $.feature." );
		}
	};

	$.fn.feature.defaults = {
		autotabs: {
			cookie_name: "dzangocart_feature",
			tabs_class: "nav nav-tabs",
			tab_class: "",
			active_class: "active"
		}
	};
} ( window.jQuery );

$( document ).ready(function() {
	$( ".feature" ).feature( dzangocart_subscription_feature );
});
