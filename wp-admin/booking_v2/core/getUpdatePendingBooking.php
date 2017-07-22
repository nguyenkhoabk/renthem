<?php
	include("../core.php");
?>

<H1>Pending Bookings</H1>
  						<table>
  							<thead>
  								<tr>
	  								<td>Name</td>
	  								<td>Address</td>
	  								<td>Phone</td>
	  								<td>Email</td>
	  								<td>Service</td>
	  								<td>Date</td>
	  								<td>Tools</td>
	  							</tr>
  							</thead>
  							<tbody>
							<?php
								$pending=$book->getPendingBook("*", "", "");
								
								foreach ($pending as $value) {
							?>
							<tr id="pedding_book_<?=$value['id']?>">
	  								<td><?=$value['first_name'].' '.$value['last_name']?></td>
	  								<td><?=$value['street']?></td>
	  								<td><?=$value['mobile']?></td>
	  								<td><?=$value['email']?></td>
	  								<td style="text-align:center !important;">
									
									<?php
										if ($value['clean_service_id'] != "") {
											echo $service->getServiceName($value['clean_service_id']);
										}
									?>
									&nbsp;
								<?php
										if ($value['window_service_id'] != "") {
											echo $service->getServiceName($value['window_service_id']);
										}
									?>
							
	  								<td style="text-align:center !important;"><?=date("Y-m-d",$value['up_date'])?></td>
	  								<td style="text-align:center !important;"><a href="javascript:;" onclick="displayPendingBookingEdit(<?=$value['id']?>);">view</a> &nbsp; &#9679; &nbsp;<a href="javascript:;" onclick="return deletePendingBook(<?=$value['id']?>);">delete</a></td>
	  							</tr>
							<?php
								}
							
							?>
  								
  							</tbody>
  							
  						</table>