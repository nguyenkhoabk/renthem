<?php
	include("core.php");
?>
<div class="stang"><a href="#">Stäng <img alt="" src="stang.png"></a> </div>
<?php
	$size = intval ($_POST['book_value']);
	
	$serviceFront = $service->getService("*", " (show_on = 1 OR show_on = 2)   ",  array('position'=> 'ASC'));
	
//	print_r($serviceFront);
	
	foreach($serviceFront as $value) {
		//freq 0
		$service_id = $value['id'];
		
		if ($value['type'] == 2) {
		$servicePrice = $service->getServicePrice("*", " ( service_id = '".$service_id."')  AND (frequency = 0)", "" );
	
		if (count($servicePrice) != 0) {
?>
<div class="bookOffer-row">
		<div class="service-icon"><img alt="" src="http://renthem.se/wp-admin/booking_v2/ico4.png"></div>
		<div class="service-name">Fönsterputsning <span>&bull;&bull;</span><input type="text" name="windows_no" id="window_no" value="0" onkeyup="updateWindowPrice(this.value, '<?=$service_id?>' );" name="book_value" id="book_value"></div>
		<div class="service-no">&nbsp;</div>
		<div class="service-price" id="window_price_<?=$service_id?>">0<span>:-</span> </div>
		<div class="service-choose">Välj <input type="checkbox"  id="window_id_0_<?=$service_id?>" name="window_service"  value="<?=$service_id?>"><label for="window_id_0_<?=$service_id?>"></label></div>
		<div class="service-tool"><a href="<?=$value[0]['url']?>" target="_blank">Läs mer</a></div>
		<div class="clearBookForm"></div>
	</div>


<?php
			}
		} else {



	//freq 1
$servicePrice = $service->getServicePrice("*", " (".$size." BETWEEN start_value AND end_value ) AND ( service_id = '".$service_id."')  AND (frequency = 1)", "" );
		if (count($servicePrice) == 1) {
?>
	<div class="bookOffer-row">
		<div class="service-icon"><img src="http://renthem.se/wp-admin/booking_v2/images/cal_0.png" alt="" /><img src="http://renthem.se/wp-admin/booking_v2/images/cal_1.png" alt="" /></div>
		<div class="service-name"><?=$value['name']?> <?php if ($service_id == 1) { echo 'en gång i månaden';}?> </div>
		<div class="service-no">&nbsp;</div>
		<div class="service-price"><?=(int)$servicePrice[0]['amount'] *1 ?> <span>Kr</span> </div>
		<div class="service-choose">Välj <input type="checkbox" value="1::<?=$service_id?>" onclick="Checkbox_to_RadioButton(this);" name="clean_service"  id="clean_id_1_<?=$service_id?>" /><label for="clean_id_1_<?=$service_id?>"></label></div>
		<div class="service-tool"><a target="_blank" href="<?=$value['url']?>">Läs mer</a></div>
		<div class="clearBookForm"></div>
	</div>
<?php
}
		//freq 2
$servicePrice = $service->getServicePrice("*", " (".$size." BETWEEN start_value AND end_value ) AND ( service_id = '".$service_id."')  AND (frequency = 2)", "" );

		if (count($servicePrice) == 1) {
?>
	<div class="bookOffer-row">
		<div class="service-icon"><img src="http://renthem.se/wp-admin/booking_v2/images/cal_0.png" alt="" />
		<img src="http://renthem.se/wp-admin/booking_v2/images/cal_2.png" alt="" /></div>
		<div class="service-name"><?=$value['name']?> <?php if ($service_id == 1) { echo 'varannan vecka';}?></div>
		<div class="service-no">&nbsp;</div>
		<div class="service-price" ><?=(int)$servicePrice[0]['amount']*2?> <span>Kr</span> </div>
		<div class="service-choose">Välj <input type="checkbox"  value="2::<?=$service_id?>"  onclick="Checkbox_to_RadioButton(this);" name="clean_service"  id="clean_id_2_<?=$service_id?>" class="regular-checkbox big-checkbox" /><label for="clean_id_2_<?=$service_id?>"></label></div>
		<div class="service-tool"><a target="_blank" href="<?=$value['url']?>">Läs mer</a></div>
		<div class="clearBookForm"></div>
	</div>
<?php
}
		//freq 4
$servicePrice = $service->getServicePrice("*", " (".$size." BETWEEN start_value AND end_value ) AND ( service_id = '".$service_id."')  AND (frequency = 4)", "" );
		if (count($servicePrice) == 1) {
?>
	<div class="bookOffer-row">
		<div class="service-icon"><img src="http://renthem.se/wp-admin/booking_v2/images/cal_0.png" alt="" />
		<img src="http://renthem.se/wp-admin/booking_v2/images/cal_4.png" alt="" /></div>
		<div class="service-name"><?=$value['name']?> <?php if ($service_id == 1) { echo 'varje vecka';}?></div>
		<div class="service-no">&nbsp;</div>
		<div class="service-price"><?=(int)$servicePrice[0]['amount']*4?> <span>Kr</span> </div>
		<div class="service-choose">Välj <input type="checkbox" value="4::<?=$service_id?>" onclick="Checkbox_to_RadioButton(this);" name="clean_service"  id="clean_id_4_<?=$service_id?>" class="regular-checkbox big-checkbox" /><label for="clean_id_4_<?=$service_id?>"></label></div>
		<div class="service-tool"><a target="_blank" href="<?=$value['url']?>">Läs mer</a></div>
		<div class="clearBookForm"></div>
	</div>
<?php
}


		$servicePrice = $service->getServicePrice("*", " (".$size." BETWEEN start_value AND end_value ) AND ( service_id = '".$service_id."')  AND (frequency = 0)", "" );
		
		if (count($servicePrice) == 1) {
?>
	<div class="bookOffer-row">
		<div class="service-icon"><img src="http://renthem.se/wp-admin/booking_v2/images/cal_0.png" alt="" /></div>
		<div class="service-name"><?=$value['name']?> </div>
		<div class="service-no">&nbsp;</div>
		<div class="service-price"><?=(int)$servicePrice[0]['amount']?> <span>Kr</span> </div>
		<div class="service-choose">Välj <input type="checkbox"  value="0::<?=$service_id?>"  onclick="Checkbox_to_RadioButton(this);" name="clean_service"  id="clean_id_0_<?=$service_id?>" class="regular-checkbox big-checkbox" /><label for="clean_id_0_<?=$service_id?>"></label></div>
		<div class="service-tool"><a target="_blank" href="<?=$value['url']?>">Läs mer</a></div>
		<div class="clearBookForm"></div>
	</div>
<?php
}
	


		} // if type
	}
?>

	<div class="bookOffer-row-footer">
		Priserna ovanför är 50% efter skattereduktion och det som faktureras kunden &#9679; Priset för fönster gäller normalt 2-sidigt fönster utan spröjs, vid spröjs tillkommer det 3kr/spröjs
	</div>
	
	<div id="bookForm-book">
		<input type="button" value="Boka!" onclick="showBookPopUp();" />
	</div>
	<div class="clearBookForm"></div>