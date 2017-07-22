/**
 * Created by BABYMASTER on 11/10/2015.
 */
( function ( $ )
{
    // Load fancy box
    $( 'body' ).on( 'change', '#window_id_0_4', function( b )
    {
        if ( $( this ).is( ':checked' ) )
        {
            $( '.rm-modal' ).addClass('rm-display-model');
        }
        else
        {
            var windowSelectedWindowIds = $( '#hidden-selected-windows-id' );
            var windowSelectedWindowNames = $( '#hidden-selected-windows-name' );
            var displaySelectedWindow = $( '#display-selected-windows' );

            displaySelectedWindow.html('');
            windowSelectedWindowIds.val('');
            windowSelectedWindowNames.val('')
        }
    } );

    // displays windows are selected
    // display name and save id of windows selected
    var windowContainer = $( '.rm-windows-container' );
    var windowChk = windowContainer.find( "input[id^='rm-window-id']" );
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
            var parentContainer = currentChk.parents( '.rm-window-title' );
            var windowNameObj = parentContainer.children( 'input[name="window-title"]' );
            listNames.push( windowNameObj.val() );
            listId.push( parentContainer.find( 'input[id^="rm-window-id"]').val() );
        } );
        windowNameInput.val( listNames.join() );
        windowIdInput.val( listId.join() );
    } );

    // close fancybox
    $( 'body').on( 'click', '.rm-closebtn', function( e )
    {
        $( '.rm-modal' ).removeClass('rm-display-model');
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

    // submit windows are selected
    $( 'body').on( 'click', '.rm-submitbtn', function( e )
    {
        var windowSelectedWindowIds = $( '#hidden-selected-windows-id' );
        var windowSelectedWindowNames = $( '#hidden-selected-windows-name' );
        var displaySelectedWindow = $( '#display-selected-windows' );

        displaySelectedWindow.html( windowNameInput.val() );
        windowSelectedWindowIds.val( windowIdInput.val() );
        windowSelectedWindowNames.val( windowNameInput.val() );
        $( '.rm-modal' ).removeClass('rm-display-model');
    });

    //  Slide down all service options
    $( '.rm-bookoffer-container').on( 'slideDown' );
} )( jQuery );
