<?php
	include("../core.php");
	
	if (isset($_POST['action']) && !empty($_POST['action'])) {
		switch ($_POST['action']) {
			case 'update':
					$data = array();
						$data['service_id'] = $_POST['service_id'];
						$data['amount'] = $_POST['amount'];
						$data['start_value'] = $_POST['min_value'];
						$data['end_value'] = $_POST['max_value'];
						$data['frequency'] = $_POST['frequency'];
						$id = $_POST['id'];
						
						$service->upServicePrice($data, " id = '".$id."' ");
						
				break;
		}
	}

?>
	<table>
  						<thead>
  							<tr>
	  							<td>Service</td>
								<td>Amount</td>
								<td>Value</td>
								<td>Frequency</td>
	  							<td>Tools</td>
	  						</tr>
  						</thead>
  						<tbody >
<?php
	$priceArr = $service->getServicePrice("*", "",  array('service_id'=> 'ASC'));
	
  								foreach ($priceArr as $value) {
							?>	
								<tr id="price_row_<?=$value['id']?>">
									<td><?=$service->getServiceName($value['service_id'])?></td>
									<td style="text-align: center !important;"><?=$value['amount']?></td>
									<td style="text-align: center !important;"><?=$value['start_value']?> - <?=$value['end_value']?></td>
									<td style="text-align: center !important;">
									<?php
										switch ($value['frequency']) {
											case '0':
													echo 'One time';
												break;
											case '1':
													echo 'One time a month';
												break;
											case '2':
													echo 'Every second week';
												break;
											case '4':
													echo 'Every week';
												break;
										}
									?>
									</td>
									<td style="text-align: center !important;">
										<a href="javascript:;" onclick="editPrice('<?=$value['id']?>');">edit</a>  &nbsp; &#9679; &nbsp;
										<a href="javascript:;" onclick="deletePrice('<?=$value['id']?>');">delete</a> 
									</td>
								</tr>	  
							<?php
								  }
  								
  							?>
						</tbody>
  					</table>