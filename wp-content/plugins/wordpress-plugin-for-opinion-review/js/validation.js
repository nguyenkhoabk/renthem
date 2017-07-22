( function ($)
{
    $('.wro-submit').on( 'click', function()
    {
        // get objects
        var ratingObj = $( '#mor-rating-value' );
        var topicObj = $( 'input[name="wor-review-topic"]' );
        var firstNameObj = $( 'input[name="wor-review-first-name"]' );
        var lastNameObj = $( 'input[name="wor-review-last-name"]' );
        var cityObj = $( 'input[name="wor-review-city"]' );
        var commentObj = $( 'textarea[name="wro-review-review"]' );
        var canSubmit = true;
        //Display error notification if the require fields are empty
        // Checking rating field not empty
        if( ratingObj.val() == 0 )
        {
            var obj = ratingObj.parent( 'div' ).find( '.wor-error' ).removeClass( 'wor-hide' );
            canSubmit = false;
        }
        else
        {
            if( ! ratingObj.parent( 'div' ).find( '.wor-error' ).hasClass( 'wor-hide' ) )
            {
                ratingObj.parent( 'div' ).find( '.wor-error' ).addClass( 'wor-hide' )
            }
        }

        // Checking topic not empty
        if( $.trim( topicObj.val() ) == '' )
        {
            var obj = topicObj.parent( 'div' ).find( '.wor-error' ).removeClass( 'wor-hide' );
            canSubmit = false;
        }
        else
        {
            if( ! topicObj.parent( 'div' ).find( '.wor-error' ).hasClass( 'wor-hide' ) )
            {
                topicObj.parent( 'div' ).find( '.wor-error' ).addClass( 'wor-hide' )
            }
        }

        // Checking first name not empty
        if( $.trim( firstNameObj.val() ) == '' )
        {
            var obj = firstNameObj.parent( 'div' ).find( '.wor-error' ).removeClass( 'wor-hide' );
            canSubmit = false;
        }
        else
        {
            if( ! firstNameObj.parent( 'div' ).find( '.wor-error' ).hasClass( 'wor-hide' ) )
            {
                firstNameObj.parent( 'div' ).find( '.wor-error' ).addClass( 'wor-hide' )
            }
        }

        // Checking last name not empty
        if( $.trim( lastNameObj.val() ) == '' )
        {
            var obj = lastNameObj.parent( 'div' ).find( '.wor-error' ).removeClass( 'wor-hide' );
            canSubmit = false;
        }
        else
        {
            if( ! lastNameObj.parent( 'div' ).find( '.wor-error' ).hasClass( 'wor-hide' ) )
            {
                lastNameObj.parent( 'div' ).find( '.wor-error' ).addClass( 'wor-hide' )
            }
        }

        // Checking city name not empty
        if( $.trim( cityObj.val() ) == '' )
        {
            var obj = cityObj.parent( 'div' ).find( '.wor-error' ).removeClass( 'wor-hide' );
            canSubmit = false;
        }
        else
        {
            if( ! cityObj.parent( 'div' ).find( '.wor-error' ).hasClass( 'wor-hide' ) )
            {
                cityObj.parent( 'div' ).find( '.wor-error' ).addClass( 'wor-hide' )
            }
        }

        // Checking review not empty
        if( $.trim( commentObj.val() ) == '' )
        {
            var obj = commentObj.parent( 'div' ).find( '.wor-error' ).removeClass( 'wor-hide' );
            canSubmit = false;
        }
        else
        {
            if( ! commentObj.parent( 'div' ).find( '.wor-error' ).hasClass( 'wor-hide' ) )
            {
                commentObj.parent( 'div' ).find( '.wor-error' ).addClass( 'wor-hide' )
            }
        }
        return canSubmit;
    } );
}
)( jQuery );