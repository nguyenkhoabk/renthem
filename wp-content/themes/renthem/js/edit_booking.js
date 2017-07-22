(function($){
    $('#post-body-content').on('change', '.change', function() {
        calculate();
    });

    var standing_select = $('#standing');
    var ofta_select = $('#start');
    var ofta_col = $('#trweekly');
    var stort_select = $('#often1');
    var stort_col = stort_select.closest('tr');

    var ofta_def = ofta_select.val();
    var stort_def = stort_select.val();

    function render_hur_ofta( id ) {
        ofta_select.html('');
        var i;
        var r;

        if( $stand_ofta_storts[id] && $stand_ofta_storts[id]['oftas'] ) {
            ofta_col.show();
            r = true;

            for( i in $stand_ofta_storts[id]['oftas'] ) {
                if( $stand_ofta_storts[id]['oftas'].hasOwnProperty(i) ) {
                    var oid = $stand_ofta_storts[id]['oftas'][i];
                    ofta_select.append('<option data-id="' + $oftas[oid]['id'] + '" value="' + $oftas[oid]['description'] + '">' + $oftas[oid]['name'] + '</option>');
                }
            }
        }
        else {
            r = false;
            ofta_col.hide();
        }

        return r;
    }

    function render_hur_sort( id, s ) {
        var i, sid;

        if( $oftas[id] && $ofta_storts[id] ) {
            stort_col.show();
            $('.ofta_storts').remove();

            for( i in $ofta_storts[id] ) {
                if( $ofta_storts[id].hasOwnProperty(i) ) {
                    sid = $ofta_storts[id][i];
                    stort_select.append('<option data-id="' + $storts[sid]['id'] + '" class="ofta_storts" value="' + $storts[sid]['description'] + '">' + $storts[sid]['name'] + '</option>');
                }
            }
        }
        else if( $stand_ofta_storts[id] && $stand_ofta_storts[id]['storts'] ) {
            stort_col.show();
            stort_select.html('');

            for( i in $stand_ofta_storts[id]['storts'] ) {
                if( $stand_ofta_storts[id]['storts'].hasOwnProperty(i) ) {
                    sid = $stand_ofta_storts[id]['storts'][i];
                    stort_select.append('<option data-id="' + $storts[sid]['id'] + '" value="' + $storts[sid]['description'] + '">' + $storts[sid]['name'] + '</option>');
                }
            }
        }
        else if( s ) {
            stort_col.hide();
        }
    }

    standing_select.change(function() {
        var id = $(this).find('option:selected').data('id');
        var r = render_hur_ofta( id );
        render_hur_sort( id, true );
        if( r ) ofta_select.trigger('change');
    });

    ofta_select.change(function() {
        var id = $(this).find('option:selected').data('id');
        render_hur_sort( id, false );
    });

    standing_select.trigger('change');

    ofta_select.val(ofta_def);
    stort_select.val(stort_def);
})(jQuery);



function calculate()
{
    var hours, total, hours_text, standing_text, start_text, selectedTextStanding, selectedTextstart, selectedTexthours, standing, start, oft;

    standing=document.getElementById("standing").value;
    start=document.getElementById("start").value;
    oft = document.getElementById("often1");
    hours_text=document.getElementById("often1");
    hours=document.getElementById("often1").value;

    if(standing=="H")
    {

        if(start==135)
        {
            total=hours*start*4;
        }
        if(start==140)
        {
            total=hours*start*2;
        }
        if(start==155)
        {
            total=hours*start;
        }
    }
    else if(standing=="F")
    {
        total=hours;
    }
    else if(standing=="E")
    {
        total=185*hours;
    }
    else if(standing=="P")
    {
        total=99*hours;
    }
    else {
        hours = jQuery(oft).is(':visible') ? oft.value : 1;
        start = jQuery('#start').is(':visible') ? start : 1;
        total = start * hours;
    }


    standing_text = document.getElementById("standing");
    start_text = document.getElementById("start");

    selectedTextStanding = standing_text.options[standing_text.selectedIndex].text;
    selectedTextstart = jQuery(start_text).is(':visible') ? jQuery(start_text).find('option:selected').text() : '-';
    selectedTexthours = jQuery(hours_text).is(':visible') ? jQuery(hours_text).find('option:selected').text() : '-';

    document.getElementById("amount").value=total;
    document.getElementById("hdnstanding").value=selectedTextStanding;
    document.getElementById("hdnstart").value=selectedTextstart;
    document.getElementById("hdnoften").value=selectedTexthours;
}