/**
 * Created by BABYMASTER on 30/07/2015.
 */
(function ( $ )
{
    $.fn.raty.defaults.path = WOR.imgUrl;
    $( '.mor-rating' ).raty(
        {
            starOff : 'star-off-big.png',
            starHalf : 'star-half-big.png',
            starOn : 'star-on-big.png',
            score: function() {
            return $(this).attr('data-score');
            },
            hints: ['1', '2', '3', '4', '5'],
            target: '#mor-rating-text',
            targetKeep : true,
            targetScore: '#mor-rating-value'
        }
    );
    $( '.mor-rating-item').raty(
        {
            starOff : 'star-off-big.png',
            starHalf : 'star-half-big.png',
            starOn : 'star-on-big.png',
            score: function() {
                return $(this).attr('data-score');
            },
            hints: ['1', '2', '3', '4', '5'],
            readOnly: true
        }
    );
    $( '.mor-tab-rating-item').raty(
        {
            starOff : 'star-off.png',
            starHalf : 'star-half.png',
            starOn : 'star-on.png',
            score: function() {
                return $(this).attr('data-score');
            },
            hints: ['1', '2', '3', '4', '5'],
            readOnly: true
        }
    );
    //Slide out Tab
    $( '#pollSlider-button' ).click( function()
    {
        if( $( this ).css( "margin-right" ) == "265px" )
        {
            $( '.pollSlider' ).animate( {"margin-right": '-=265'} );
            $( '#pollSlider-button' ).animate( { "margin-right": '-=265' } );
            // change arrow to text
            $( '.pollSldier-button-text').removeClass( 'wor-tab-hide' );
            $( '.wor-close-tab').addClass( 'wor-tab-hide' );
        }
        else
        {
            $( '.pollSlider' ).animate( {"margin-right": '+=265'} );
            $( '#pollSlider-button' ).animate( {"margin-right": '+=265'} );
            // change text to arrow
            $( '.pollSldier-button-text').addClass( 'wor-tab-hide' );
            $( '.wor-close-tab').removeClass( 'wor-tab-hide' );
        }
    });
    // Close slide out tab on mobile
    $( '.wor-close-tab-button').on( 'click', function()
    {
        $( '.pollSlider' ).animate( {"margin-right": '-=265'} );
        $( '#pollSlider-button' ).animate( { "margin-right": '-=265' } );
        // change arrow to text
        $( '.pollSldier-button-text').removeClass( 'wor-tab-hide' );
        $( '.wor-close-tab').addClass( 'wor-tab-hide' );
    } );
}
)( jQuery );