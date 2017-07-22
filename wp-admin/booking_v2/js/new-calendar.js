var calendar_status = false;
				var calendar_default_date = "";
				var days = ["Mån","Tis","Ons","Tor","Fre","Lör","Sön"];
				var months = ["Januari", "Februari", "Mars", "April","Maj","Juni","Juli","Augusti","September","Oktober","November","December"];



			$( document ).ready(function() {
				
				
				
				
				$("#frmBookDate").click(function() {		
					calendar_default_date = $(this).val();	
					if (calendar_default_date == "") {
					var today = new Date();
					var dd = today.getDate();
					var mm = today.getMonth()+1; //January is 0!
					var yyyy = today.getFullYear();


						calendar_default_date = yyyy+"-"+("0"+mm).slice(-2)+"-"+("0"+dd).slice(-2);
						$("#frmBookDate").val(calendar_default_date);
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

				var month_name = "";
				switch(month) {
					case '01':
						month_name = "Januari";
						break;
					case '02':
						month_name = "Februari";
						break;
					case '03':
						month_name = "Mars";
						break;
					case '04':
						month_name = "April";
						break;
					case '05':
						month_name = "Maj";
						break;
					case '06':
						month_name = "Juni";
						break;
					case '07':
						month_name = "Juli";
						break;
					case '08':
						month_name = "Augusti";
						break;
					case '09':
						month_name = "September";
						break;
					case '10':
						month_name = "Oktober";
						break;
					case '11':
						month_name = "November";
						break;
					case '12':
						month_name = "December";
						break;
				}
				 	 	 	 	 	 	 	 	 	 	 	
				


				days_in_month = daysInMonth(month, year);
				running_day = getNoDay(day, month, year) -1 ;

				calendarTxt = '<div class="calendar_close" onclick="closeCalendar();">x</div><table>';
				calendarTxt += '<tr class="calendar-head">';
				calendarTxt += '<td class="previuos_month" onclick="previousMonth(\''+data+'\');">&#171;</td><td class="current_month" colspan="6" id="current_month">'+month_name+', '+year+'</td><td class="next_month" onclick="nextMonth(\''+data+'\')"> &#187;</td></tr>';
				calendarTxt += '<tr><td class="week_no">V</td>';
				$.each(days, function( index,value ) {
					calendarTxt += '<td class="day_name">'+value+'</td>';
				});
				calendarTxt += '</tr>';
				/*** add dates to calendar ***/

				calendarTxt += '<tr>';
				var week_text ="";
				/*** add blackdays  ***/
				for ( var i = 0; i < running_day; i++ ) {
					week_text += '<td></td>';
					days_in_this_week ++;
				}
				
				var week_number = getWeek(year,month,1);
				
				for ( var list_day = 1; list_day <= days_in_month; list_day++ ) {
				
					if ((running_day == 5) || (running_day ==6)) {
						 week_text  += '<td class="no_work_day">'+list_day+'</td>';
					} else {
					if (data == (year+'-'+month+'-'+('0'+list_day).slice(-2) )) {
							 week_text  += '<td class="selected_date" >'+list_day+'</td>';
					} else {
						if (checkPreviousDates(year, month, list_day)) {
							 week_text  += '<td class="work_day" onclick="setupNewDate(\''+year+'-'+month+'-'+('0'+list_day).slice(-2)+'\')">'+list_day+'</td>';
							} else {
							 week_text  += '<td class="work_day_past" >'+list_day+'</td>';
						}
						}
						
					}
						
					if (running_day == 6) {
					
					calendarTxt += '<td class="week_no">'+week_number+'</td>';
						calendarTxt +=  week_text +'</tr>';
						 week_text  ="";
						
						if (  day_counter+1 != days_in_month ) {
								calendarTxt +=  week_text +'<tr>';
								
							}
						running_day = -1;
						days_in_this_week = 0;
					}
					days_in_this_week ++;
					running_day ++;
					day_counter ++;
					week_number = getWeek(year,month,list_day);
				}
				
				if ((days_in_this_week < 8) && (days_in_this_week !=1)) {
				
						for ( var x = 1; x <= 8-days_in_this_week; x++ ) {	
							week_text += "<td></td>";
						}
						if (month == 12 ) {
							calendarTxt += '<td class="week_no">53</td>';
						} else {
							calendarTxt += '<td class="week_no">'+week_number+'</td>';
						}
						
					}
			
				calendarTxt += week_text+'</tr>';
				
				
				calendarTxt += '</table>';
				$("#calendar_box").html(calendarTxt);
				
				
			}
			
			function previousMonth(data) {
				//var data_vec = data.split("-");
			
				jQuery.ajax({
				type: "POST",
				data: "data="+data,
				url: "http://renthem.dev/wp-admin/booking_v2/getPreviousMonthFromdate.php",
					success:function( result ) {	
						
						$("#frmBookDate").val(result);
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
				$("#frmBookDate").val(date);
				$("#calendar_box").remove();
				calendar_status = false;
			}
			
			function closeCalendar() {
				$("#calendar_box").remove();
				calendar_status = false;
			}
			function getWeek(y, month, day) {
			
					
						 var date = new Date(y, month-1, day); 
						 date.setHours(0, 0, 0, 0); // Thursday in current week decides the year. 
						 date.setDate(date.getDate() + 3 - (date.getDay() + 6) % 7); 
						 // January 4 is always in week 1. 
						 var week1 = new Date(date.getFullYear(), 0, 4); // Adjust to Thursday in week 1 and count number of weeks from date to
						  return 1 + Math.round(((date.getTime() - week1.getTime()) / 86400000 - 3 + (week1.getDay() + 6) % 7) / 7);

			}
			function nextMonth(data) {
				var data_vec = data.split("-");
				jQuery.ajax({
					type: "POST",
					data: "data="+data,
					url: "http://renthem.dev/wp-admin/booking_v2/getNextMonthFromdate.php",
						success:function( result ) {	
								$("#frmBookDate").val(result);
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