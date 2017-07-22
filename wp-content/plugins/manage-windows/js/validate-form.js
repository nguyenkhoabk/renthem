( function ( $ )
{
	$( ' #mw-button-place-order ' ).on( 'click', function( e )
	{
		// check if customer still does not select a window so cannot make order
		var totalAmount = 0;
		$( 'input[name^=mw-number-]' ).each( function( i )
		{
			totalAmount += parseInt( $( this ).val() );
		}
		);
		if ( totalAmount < 1 )
		{
			alert( 'Please select a window' );
			return false;
		}
		// Validate form information
		var listFieldRequired = [ 'second-name', 'first-name', 'mobile-phone', 'email', 'address', 'zip-code', 'city', 'delivery-date', 'organisation' ];
		var flag = true;
		$.each( listFieldRequired, function( key, value )
		{
			var requireElement = $( '#' + value );
			if ( ! displayRequireMessage( requireElement ) )
			{
				flag = false;
				//return false;
			}
		}
		)
		return flag;
	}
	)

	function displayRequireMessage( requireElement )
	{
		var value = requireElement.val();
		if( value == '' )
		{
			// display text message
			requireElement.parent().find( '.require-field' ).text( 'Required field!' );
			// change border color
			requireElement.addClass( 'require-element' );
			return false;
		}
		else
		{
			requireElement.parent().find( '.require-field' ).text( '' );
			requireElement.removeClass( 'require-element' );
			return true;
		}
	}

} )( jQuery );
