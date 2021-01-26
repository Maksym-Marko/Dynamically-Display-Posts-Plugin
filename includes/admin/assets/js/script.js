jQuery( document ).ready( function( $ ) {

	$( '#mxddp_form_update' ).on( 'submit', function( e ){

		e.preventDefault();

		var nonce = $( this ).find( '#mxddp_wpnonce' ).val();

		var someString = $( '#mxddp_some_string' ).val();

		var data = {

			'action': 'mxddp_update',
			'nonce': nonce,
			'mxddp_some_string': someString

		};

		jQuery.post( mxddp_admin_localize.ajaxurl, data, function( response ){

			// console.log( response );
			alert( 'Value updated.' );

		} );

	} );

} );