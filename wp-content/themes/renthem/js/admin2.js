jQuery.fn.clearForm=function(){return this.each(function(){var type=this.type;var tag=this.tagName.toLowerCase();if(tag=='form'){return jQuery(':input',this).clearForm()}if(type=='text'||type=='password'||tag=='textarea'||type=='file'){this.value=''}else if(type=='checkbox'||type=='radio'){this.checked=false}else if(tag=='select'){this.selectedIndex=0}})};

(function($){
    var configuration = $('#configuration');
    var cats_table = $('#cats_table tbody');
    var items_table = $('#items_table tbody');
    var stadning_options = $('.stadning_options');
    var ofta_options = $('.ofta_options');

    $('.positive-integer').numeric({ decimal: false, negative: false });

    $(".hour-col input[type='submit']").click(function(e) {
        e.preventDefault();
        var el = $(this);
        var form = el.closest('form');
        var data = form.serialize();
        var loading = form.find('.loading');

        var name = form.find('input[name="cat_name"]').val();
        var cat_val = form.find('input[name="cat_val"]');

        if( name == '' || ( cat_val.length && cat_val.val() == '' ) )
            return false;

        if( form.find('#cat3').length ) {
            if( configuration.find('li').length < 1 )
                return false;

            var conds = [];
            configuration.find('li').each(function(i, el){
                conds.push($(el).attr('data-id'));
            });

            data += '&conds=' + conds.join(',');
        }


        $.ajax({
            method: 'POST',
            url: ajaxurl,
            data: data + '&action=rm_save_cat',
            beforeSend: function() {
                el.attr( 'disabled', 'disabled' );
                loading.removeClass('hide');
            },
            success: function( r ) {
                var m = $.parseJSON(r);

                cats_table.html(m.cats_table);
                items_table.html(m.items_table);
                stadning_options.html(m.new_stadning_options);
                ofta_options.html(m.new_ofta_options);
                configuration.append(
                    '<li data-id="' + m.id + '"><span class="pitem">' + name + '</span><a href="#">Remove</a></li>'
                );

                if( form.find('#cat3').length )
                    configuration.html('');
            },
            complete: function() {
                el.removeAttr( 'disabled' );
                form.clearForm();
                loading.addClass('hide');
            }
        });
    });

    $('.hour-col input[type="button"]').click(function(e) {
        e.preventDefault();
        var el = $(this);
        var select = el.next().next();

        if( configuration.find('li[data-id="' + select.val() + '"]').length )
            return false;

        configuration.append(
            '<li data-id="' + select.val() + '"><span class="pitem">' + select.find(":selected").text() + '</span><a href="#">Remove</a></li>'
        );
    });

    configuration.on('click', 'li a', function(e) {
        e.preventDefault();
        $(this).parent().remove();
    });

    $('table').on('click', '.delete-hour', function(e) {
        e.preventDefault();
        el = $(this);

        if( ! window.confirm('Are you sure? Deleting will effect children of this element. You may have to configure them.') )
            return false;

        $.ajax({
            method: 'POST',
            url: ajaxurl,
            data: 'id=' + el.attr('data-id') + '&action=rm_delete_cat&rm_delete_cat_nonce=' + $('#rm_delete_cat_nonce').val(),
            success: function( r ) {
                var m = $.parseJSON(r);

                cats_table.html(m.cats_table);
                items_table.html(m.items_table);
                stadning_options.html(m.new_stadning_options);
                ofta_options.html(m.new_ofta_options);
            }
        });
    });


})(jQuery);