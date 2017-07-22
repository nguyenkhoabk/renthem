(function ( $ )
{
	$( '#delivery-date' ).datetimepicker(
		{
			lang: 'se',
			dayOfWeekStart: 1,
			inline:true,
			timepicker:false,
			minDate: 0,
            scrollMonth: false,
			id: 'mw-datepicker',
			defaultSelect: false,
			//theme:'dark',
			format:'m/d/Y'
		});
} )(jQuery);
