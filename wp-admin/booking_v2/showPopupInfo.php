<?php
	include("../core.php");
	
	$id = $_POST['book_id'];
	$book_vec = $book->getBookDetails("*", " id = '".$id."' ", "");

	$service_id = $book_vec[0]['service_id'];
	$service_window_id = $book_vec[0]['service_window_id'];
	$frequency = $book_vec[0]['frequency'];
	
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
		 
										$book_id =  $book_vec[0]['id'];
										
										$book_details = $book->getBook("*", "book_id = '".$book_id."'","");
							
										$client_id = $book_details[0]['client_id'];
										$staff_id = $book_details[0]['staff_id'];
										$client_arr = $client->getClient("*", " id = '".$client_id."'","");
									
  								?>
						<table style="width:80%; margin:auto !Important;">
						<thead>
  								<tr>
	  								<td>Name</td>
	  								<td>Address</td>
	  								<td>Phone</td>
	  								<td>Staff</td>
	  								<td>Service</td>
									<td>Comment</td>
	  								<td>Date & Time</td>
	  								
	  							</tr>
  							</thead>
  							<tbody>
  								<tr >
	  								<td><?=$client_arr[0]['name']?></td>
	  								<td><?=$client_arr[0]['address']?></td>
	  								<td><?=$client_arr[0]['phone']?></td>
	  								<td><?=$staff->getStaffName($staff_id)?></td>
	  								<td style="text-align:center!important;"><?=$service_name?></td>
									<td><?=$book->getCommentTxt($book_id)?></td>
	  								<td style="text-align:center!important;"><?=$book_vec[0]['date']?></td>
	  							</tr>
								</tbody>
						</table>
  								<?php
?>