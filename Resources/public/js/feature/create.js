!function( $ ) {
	$.fn.suggest = function( method ) {

		// Public methods
		var methods = {
			init: function( options ) {
				var $form = $( "form", this );

				$( "input[name='name']", $form ).keyup( function( event ) {
					var name = $.trim($( this ).val().toLowerCase());
					var propertyName = name.replace(/[^a-zA-Z0-9]/g,'_');
					propertyName = propertyName.replace(/_{2,}/g,'_');

					$( "input[name='property_name']", $form ).val( propertyName );
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
			$.error( "Method " +  method + " does not exist in $.suggest." );
		}
	};
} ( window.jQuery );

$( document ).ready(function() {
	$( ".create_feature" ).suggest();
});
