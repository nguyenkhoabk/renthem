(function ( $ )
{
    // display name and save id of windows selected
    var windowContainer = $( '.bs-windows-container' );
    var windowChk = windowContainer.find( "input[id^='window-id']" );
    var windowNameInput = windowContainer.find( '#window-selected-titles' );
    var windowIdInput = windowContainer.find( '#window-selected-ids' );

    // when change check checkbox
    windowChk.change(function ( e )
    {
        var listNames = [];
        var listId = [];
        windowChk.filter(':checked').each( function ()
        {
            var currentChk = $( this );
            var parentContainer = currentChk.parents( '.window-name' );
            var windowNameObj = parentContainer.children( 'input[name="window-title"]' );
            listNames.push( windowNameObj.val() );
            listId.push( parentContainer.find( 'input[id^="window-id"]').val() );
        } );
        windowNameInput.val( listNames.join() );
        windowIdInput.val( listId.join() );
    } );
    // display fancybox
    $( '#window_id_0_4' ).change( function( b )
    {
        if ( $( this ).is( ':checked' ) )
        {
            $( '.modal' ).addClass('display-model');
        }
    } );
    // close fancybox
    $( '.closebtn' ).click( function( e )
    {
        $( '.modal' ).removeClass('display-model');
        // uncheck checkbox
        $( '#window_id_0_4' ).attr( 'checked', false );

        // reset value

        var windowSelectedWindowIds = $( '#hidden-selected-windows-id' );
        var windowSelectedWindowNames = $( '#hidden-selected-windows-name' );
        var displaySelectedWindow = $( '#display-selected-windows' );

        displaySelectedWindow.html('');
        windowSelectedWindowNames.val('');
        windowSelectedWindowIds.text('');
    });
    // select windows
    $( '.submitbtn').click( function( e )
    {
        var windowSelectedWindowIds = $( '#hidden-selected-windows-id' );
        var windowSelectedWindowNames = $( '#hidden-selected-windows-name' );
        var displaySelectedWindow = $( '#display-selected-windows' );

        displaySelectedWindow.html( windowNameInput.val() );
        windowSelectedWindowIds.val( windowIdInput.val() );
        windowSelectedWindowNames.val( windowNameInput.val() );
        $( '.modal' ).removeClass('display-model');
    } )
} )( jQuery )
