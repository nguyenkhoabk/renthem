<?php
include("../core.php");
$date = $_POST['date'];



	$vec = explode("-", $date);
	
	$next_day= date('Y-m-d', strtotime('+1 day', strtotime($vec[2].'-'.$vec[1].'-'.$vec[0])));
	$previous_day= date('Y-m-d', strtotime('-1 day', strtotime($vec[2].'-'.$vec[1].'-'.$vec[0])));

?>
<div id="book-head">
  					<div class="book-title">Booking</div>
  					<div class="book-date"><a href="javascript:;" onclick="loadCalendar('<?=$previous_day?>');" >&#171;</a> <input type="text"  name="default_date" id="default_date"  style="text-align: center;" value="<?=$date ?>" /> <a href="javascript:;" onclick="loadCalendar('<?=$next_day?>');" >&#187;</a></div>
  					<div class="book-button">
  						<button class="btn b-add"  onclick="showAddNewBooking()">Add New Booking</button>
					
  					</div>
  				</div>
  			<div class="clear"></div>
  				<div id="book-calendar">
  					<div class="book-content">
  						<table>
  							<thead>
  								<tr>
	  								<td class="staff-box">Staff</td>
	  								<?php
	  									foreach($workHourArr as $value) {
	  										if ($value['start_minute'] == 0) {
	  											echo '<td>'.$value['start_hour'].'<sup>'.$value['start_minute'].'0</sup></td>';
	  										} else {
	  											echo '<td>'.$value['start_hour'].'<sup>'.$value['start_minute'].'</sup></td>';
	  										}
	  										
	  									}
	  								?>	  								
	  							</tr>
  							</thead>
  							<tbody>
  								
  								<?php
  									foreach ($staffArr as $values) {
  										echo '<tr>';
	  										echo '<td class="staff-box-name" style="cursor:pointer;" onclick="showWeekStaffWork(\''.$date.'\', \''.$values['id'].'\')">'.$values['name'].'</td>'; 
	  										foreach($workHourArr as $value) {
	  											echo $checkdatebackground = $book->check_date($values['id'],$value['id'], $date);
		  										//echo '<td></td>';
		  									}
										echo '</tr>';
  									}
  								
  								?>
  								
  							</tbody>
  							
  						</table>
  						
  					</div>
  				</div>