<?php
include("../core.php");
$date = $_POST['date'];
$staff_id = $_POST['staff_id'];

$vec = explode("-", $date);

$time_sec =  strtotime($vec[2].'-'.$vec[1].'-'.$vec[0]);
 $day_no = date('N', $time_sec);
$first_day_no = $day_no - 1; 
$first_day_of_week = date('Y-m-d', strtotime('-'.$first_day_no.' day', $time_sec));

$staffVec = $staff->getStaff(" name ", " id = '".$staff_id."' ", "");
$staff_name = "";

if (count($staffVec) == 1) {
	$staff_name = $staffVec[0]['name'];
}
?>

<div class="book-content">
  						<table>
  							<thead>
  								<tr>
	  								<td class="staff-box"><?=$staff_name?></td>
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
  									for ($i=0; $i<7; $i++) {
									
  										echo '<tr>';
	  										echo '<td class="staff-box-name" style="text-align:center !important;">'.$first_day_of_week.'</td>'; 
	  										foreach($workHourArr as $value) {
	  											echo $checkdatebackground = $book->check_date($staff_id,$value['id'], $first_day_of_week);
		  										//echo '<td></td>';
		  									}
										echo '</tr>';
										$vec = explode("-", $first_day_of_week);
										$time_sec =  strtotime($vec[2].'-'.$vec[1].'-'.$vec[0]);
										$first_day_of_week = date('Y-m-d', strtotime('+1 day', strtotime($vec[2].'-'.$vec[1].'-'.$vec[0])));
  									}
  								
  								?>
  								
  							</tbody>
  							
  						</table>
  						
  					</div>