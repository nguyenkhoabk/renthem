var calendar_status = false;
				var calendar_default_date = "";
				var days = ["Mon","Tue","Wed","Thu","Fri","Sat","Sun"];
				var months = ["January", "February", "March", "April","May","June","July","August","September","October","November","December"];



			$( document ).ready(function() {
				
				
				
				
				$("#default_date").click(function() {		
					calendar_default_date = $(this).val();	
					if (calendar_default_date == "") {
					var today = new Date();
					var dd = today.getDate();
					var mm = today.getMonth()+1; //January is 0!
					var yyyy = today.getFullYear();


						calendar_default_date = yyyy+"-"+("0"+mm).slice(-2)+"-"+("0"+dd).slice(-2);
						$("#default_date").val(calendar_default_date);
					}
					if (calendar_status == false) {
						$(this).after('<div id="calendar_box"></div>');
						
						calendarInitiate(calendar_default_date)
						calendar_status = true;
					}
				});
				
			});
			
			
			function calendarInitiate(data) {
				var calendarTxt = "";
				var running_day = 0;
				var days_in_month = 30;
				var days_in_this_week = 1;
				var day_counter = 0 ;
				
				var year = 0;
				var month = 0;
				var day = 0 ;
				
				var data_vec = data.split("-");
				
				year = data_vec[0];
				month = data_vec[1];
				day = data_vec[2];
				
				days_in_month = daysInMonth(month, year);
				running_day = getNoDay(day, month, year) -1 ;

				calendarTxt = '<div class="calendar_close" onclick="closeCalendar();">x</div><table class="calendar_table">';
				calendarTxt += '<tr>';
				calendarTxt += '<td class="previuos_month" onclick="previousMonth(\''+data+'\');">&#171;</td><td class="current_month" colspan="6" id="current_month">July, 2014</td><td class="next_month" onclick="nextMonth(\''+data+'\')"> &#187;</td></tr>';
				calendarTxt += '<tr>';
				$.each(days, function( index,value ) {
					calendarTxt += '<td class="day_name">'+value+'</td>';
				});
				calendarTxt += '</tr>';
				/*** add dates to calendar ***/

				calendarTxt += '<tr>';
				/*** add blackdays  ***/
				for ( var i = 0; i < running_day; i++ ) {
					calendarTxt += '<td></td>';
					days_in_this_week ++;
				}
		
				for ( var list_day = 1; list_day <= days_in_month; list_day++ ) {
					if ((running_day == 5) || (running_day ==6)) {
						calendarTxt += '<td class="no_work_day">'+list_day+'</td>';
					} else {
					if (data == (year+'-'+month+'-'+('0'+list_day).slice(-2) )) {
							calendarTxt += '<td class="selected_date" >'+list_day+'</td>';
					} else {
						if (checkPreviousDates(year, month, list_day)) {
							calendarTxt += '<td class="work_day" onclick="setupNewDate(\''+year+'-'+month+'-'+('0'+list_day).slice(-2)+'\')">'+list_day+'</td>';
							} else {
							calendarTxt += '<td class="work_day_past" >'+list_day+'</td>';
						}
						}
						
					}
						calendarTxt += '<td>0</td>';
					if (running_day == 6) {
						calendarTxt += '</tr>';
						
						if (  day_counter+1 != days_in_month ) {
								calendarTxt += '<tr>';
							}
						running_day = -1;
						days_in_this_week = 0;
					}
					days_in_this_week ++;
					running_day ++;
					day_counter ++;
				}
				
				if (days_in_this_week < 8) {
						for ( var x = 1; x <= 8-days_in_this_week; x++ ) {	
							calendarTxt += "<td></td>";
						}
					}
			
				calendarTxt += '</tr>';
				
				
				calendarTxt += '</table>';
				$("#calendar_box").html(calendarTxt);
				
				
			}
			
			function previousMonth(data) {
				//var data_vec = data.split("-");
				
				jQuery.ajax({
				type: "POST",
				data: "data="+data,
				url: "getPreviousMonthFromdate.php",
					success:function( result ) {	
						
						$("#default_date").val(result);
						calendarInitiate(result);
						
						var data_vec = result.split("-");
						
						var mmt = data_vec[1] -1;
						var yyt = data_vec[0];
						
						var new_copy = yyt+", "+showMonthName(months[mmt]);
						
						$("#current_month").html(new_copy);
						
					}
				});
			
			
				
			}
			function setupNewDate(date) {
				$("#default_date").val(date);
				$("#calendar_box").remove();
				calendar_status = false;
			}
			
			function closeCalendar() {
				$("#calendar_box").remove();
				calendar_status = false;
			}
			function nextMonth(data) {
				var data_vec = data.split("-");
				
				jQuery.ajax({
				type: "POST",
				data: "data="+data,
				url: "getNextMonthFromdate.php",
					success:function( result ) {	
							$("#default_date").val(result);
						calendarInitiate(result);
						
							var data_vec = result.split("-");
						
						var mmt = data_vec[1] -1;
						var yyt = data_vec[0];
						
						var new_copy = months[mmt]+", "+yyt;
						
						$("#current_month").html(new_copy);
						
						
							}
				});
				
				
			
			}
			function checkPreviousDates(year, month, day) {
			
				var date = new Date(year,month-1,day);
				var today = new Date();
		
				if ( date < today ) {
					return false;
				}
				return true;
			}
			function daysInMonth(month,year) {
				return new Date(year, month, 0).getDate();
			}
			
			function getNoDay(day, month, year) {
				var day_no =0 ;
				day_no = new Date(year, month-1, 1).getDay();
		
				switch (day_no) {
					case 0: return 7;	break;
					case 1: return 1;	break;
					case 2: return 2;	break;
					case 3: return 3;	break;
					case 4: return 4;	break;
					case 5: return 5;	break;
					case 6: return 6;	break;
				}
			}