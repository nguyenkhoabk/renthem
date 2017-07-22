/**
 * Created by BABYMASTER on 30/07/2015.
 */
(function ( $ )
{
    $.fn.raty.defaults.path = WOR.imgUrl;
    $( '.admin-mor-rating' ).raty(
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
            readOnly: true
        }
    );
}
)( jQuery );