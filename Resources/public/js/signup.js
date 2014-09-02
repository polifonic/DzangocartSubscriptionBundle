!function( $ ) {
	$.fn.signup = function( method ) {

		var settings;

		// Public methods
		var methods = {
			init: function( options ) {
				settings = $.extend( true, {}, $.fn.signup.defaults, options );

				return this.each(function() {
					var $this = $( this );

					$( "form", $this ).ajaxForm({
						success: function( data ) {

							if ( data.hasOwnProperty( "redirectUrl" ) ) {
								window.location.href = data.redirectUrl;
							}

							$this.replaceWith( data );
							$( ".dzangocart_subscription_signup" ).signup( subscription_signup );
						}
					});
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
			$.error( "Method " +  method + " does not exist in $.signup." );
		}
	};

    $.fn.signup.defaults = {
		type_a_head: false
	};
} ( window.jQuery );

$( document ).ready(function() {
	$( ".dzangocart_subscription_signup" ).signup( subscription_signup );
});
