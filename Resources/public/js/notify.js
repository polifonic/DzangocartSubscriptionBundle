$( document ).ajaxSuccess(function( event, xhr, settings ) {
	var flash = $( xhr.responseText )
		.find( "template.flash" )
		.html();

	$( "#notify" ).html( flash );

	setTimeout(
		function() {
			$( "#notify" ).fadeOut( 5000 );
		},
		10000
	 );
} );

$( document ).ready(function() {
	$( "#notify" ).html( $( "template.flash" ).html() );
} );
