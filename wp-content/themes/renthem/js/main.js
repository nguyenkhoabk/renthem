(function($)
{
	var standing_select = $('#standing');
	var ofta_select = $('#often');
	var ofta_col = $('#trweekly');
	var stort_select = $('#size');
	var stort_col = stort_select.closest('tr');

	function render_hur_ofta(id) 
	{
		ofta_select.html('');
		var i;
		var r;

		if( $stand_ofta_storts[id] && $stand_ofta_storts[id]['oftas'] ) 
		{
			ofta_col.show();
			r = true;

			for( i in $stand_ofta_storts[id]['oftas'] ) 
			{
				if( $stand_ofta_storts[id]['oftas'].hasOwnProperty(i) ) 
				{
					var oid = $stand_ofta_storts[id]['oftas'][i];
					ofta_select.append('<option data-id="' + $oftas[oid]['id'] + '" value="' + $oftas[oid]['description'] + '">' + $oftas[oid]['name'] + '</option>');
				}
			}
		}
		else 
		{
			r = false;
			ofta_col.hide();
		}

		return r;
	}

	function render_hur_sort( id, s ) 
	{
		var i, sid;

		if( $oftas[id] && $ofta_storts[id] ) 
		{
			stort_col.show();
			$('.ofta_storts').remove();

			for( i in $ofta_storts[id] ) 
			{
				if( $ofta_storts[id].hasOwnProperty(i) ) 
				{
					sid = $ofta_storts[id][i];
					stort_select.append('<option data-id="' + $storts[sid]['id'] + '" class="ofta_storts" value="' + $storts[sid]['description'] + '">' + $storts[sid]['name'] + '</option>');
				}
			}
			stort_select.val(stort_select.find("option:first").val());
			stort_select.trigger('change');
		}
		else if( $stand_ofta_storts[id] && $stand_ofta_storts[id]['storts'] ) 
		{
			stort_col.show();
			stort_select.html('');

			for( i in $stand_ofta_storts[id]['storts'] ) 
			{
				sid = $stand_ofta_storts[id]['storts'][i];
				if( $storts.hasOwnProperty(sid)) 
				{
					stort_select.append('<option data-id="' + $storts[sid]['id'] + '" value="' + $storts[sid]['description'] + '">' + $storts[sid]['name'] + '</option>');
				}
			}
			stort_select.val(stort_select.find("option:first").val());
			stort_select.trigger('change');
		}
		else if( s ) 
		{
			stort_col.hide();
		}
	}

	standing_select.change(function() 
	{
		var id = $(this).find('option:selected').data('id');
		var r = render_hur_ofta( id );
		render_hur_sort( id, true );
		if( r ) ofta_select.trigger('change');
	});

	ofta_select.change(function() 
	{
		var id = $(this).find('option:selected').data('id');
		render_hur_sort( id, false );
	});

	standing_select.trigger('change');
})(jQuery);