<?php
	include("../core.php");
	
	$book_vec = $book->getBookDetails("*", "", array(" service_id "=> "DESC", "frequency" => "ASC", "service_window_id" => "ASC", "id" => "DESC"));
?>
	<H1>Bookings</H1>
  						<table>
  							<thead>
  								<tr>
	  								<td>Name</td>
	  								<td>Address</td>
	  								<td>Phone</td>
	  								<td>Staff</td>
	  								
									<td>Comment</td>
	  								<td>Date & Time</td>
	  								<td>Tools</td>
	  							</tr>
  							</thead>
  							<tbody>
  								<?php
				$service_aux = "";				
  									foreach($book_vec as $value) {
  										$service_id = $value['service_id'];
										$book_id =  $value['id'];
										
										$book_details = $book->getBook("*", "book_id = '".$book_id."'","");
									
										$client_id = $book_details[0]['client_id'];
										$staff_id = $book_details[0]['staff_id'];
										$client_arr = $client->getClient("*", " id = '".$client_id."'","");
										
										
	$service_id = $value['service_id'];
	$service_window_id = $value['service_window_id'];
	$frequency = $value['frequency'];
	
	$service_name = $service->getServiceName($service_id);
	if (	$service_id != 0) {
		switch ($frequency) {
			case '1':
					$service_name .= " en g&aring;ng i m&aring;naden ";
				break;
			case '2':
					$service_name .= " varannan vecka ";
				break;
			case '4':
					$service_name .= " varje vecka ";
				break;
			
		}
	}
	if ($service_window_id != 0) {
			if ($service_name == "") {
				$service_name .= $service->getServiceName($service_window_id);
			} else {
				$service_name .= ', '.$service->getServiceName($service_window_id);
			}
		 }	
				if ($service_aux != $service_name)	 {
		?>
			<tr>
				<td colspan="7" style="background-color:#555555; color:#ffffff; padding-top:10px; padding-bottom:10px; font-weight:bold;"><b><?=$service_name?></b></td>
			</tr>
		<?php
				$service_aux = $service_name;
				}				
  								?>
  								<tr id="book_id_delete_<?=$book_id?>">
	  								<td><?=$client_arr[0]['first_name']?> <?=$client_arr[0]['last_name']?></td>
	  								<td><?=$client_arr[0]['address']?></td>
	  								<td><?=$client_arr[0]['phone']?></td>
	  								<td><?=$staff->getStaffName($staff_id)?></td>
	  						
									<td><?=$book->getCommentTxt($book_id)?></td>
	  								<td style="text-align:center!important;"><?=$value['date']?></td>
	  								<td  width="100" style="text-align:center!important;"><a href="javascript:;" onclick="showBookEdit(<?=$book_id?>);loadCalendar('<?=$value['date']?>');">view</a>&nbsp;	&#9679;	&nbsp;
									<a href="javascript:;" onclick="deleteBook('<?=$book_id?>','<?=$value['date']?>');">delete</a>
									</td>
	  							</tr>
  								<?php
  									}
  								?>
  								
  							</tbody>
  							
  						</table>
  					