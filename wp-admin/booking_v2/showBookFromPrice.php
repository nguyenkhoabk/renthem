<?php
	include("core.php");
?>
<div class="stang"><a href="javascript:;" onclick='$("#bookOffer").html("");$("#book_value").val("kvm");'>Stäng <img alt="" src="//renthem.se/wp-admin/booking_v2/stang.png"></a> </div>
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
		<div class="service-icon"><img alt="" src="//renthem.se/wp-admin/booking_v2/ico4.png"></div>
		<div class="service-name">Fönsterputsning <span>&bull;&bull;</span>
	
		<input type="text" name="window_no" id="window_no " value="0" onkeyup="updateWindowPrice(this.value, '<?=$service_id?>' );"  class="book_value"></div>
		<div class="service-no">&nbsp;</div>
		<div class="service-price" id="window_price_<?=$service_id?>">0<span>:-</span> </div>
		<div class="service-choose"><span>Välj</span> <input type="checkbox"  id="window_id_0_<?=$service_id?>"  class="regular-checkbox big-checkbox"  name="window_service"  value="<?=$service_id?>"><label for="window_id_0_<?=$service_id?>"></label></div>
		<div class="service-tool"><a href="<?=$value[0]['url']?>" target="_blank">Läs mer</a></div>
		<div class="clearBookForm"></div>
			<input type="hidden" name="window_no_tmp" id="window_no_tmp" value="" />
	</div>
<?php
			}
		} else {



	//freq 1
$servicePrice = $service->getServicePrice("*", " (".$size." BETWEEN start_value AND end_value ) AND ( service_id = '".$service_id."')  AND (frequency = 1)", "" );
		if (count($servicePrice) == 1) {
?>
	<div class="bookOffer-row">
		<div class="service-icon"><img src="//renthem.se/wp-admin/booking_v2/ico1.png" /></div>
		<div class="service-name"><?=$value['name']?> <?php if ($service_id == 1) { echo 'en gång i månaden';}?> <span>&bull;</span></div>
		<div class="service-no">&nbsp;</div>
		<div class="service-price"><?=(int)$servicePrice[0]['amount'] *1 ?><span>:-</span> </div>
		<div class="service-choose"><span>Välj</span>  <input type="checkbox" value="1::<?=$service_id?>"  class="regular-checkbox big-checkbox"  onclick="Checkbox_to_RadioButton(this);" name="clean_service"  id="clean_id_1_<?=$service_id?>" /><label for="clean_id_1_<?=$service_id?>"></label></div>
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
		<div class="service-icon"><img src="//renthem.se/wp-admin/booking_v2/ico2.png" /></div>
		<div class="service-name"><?=$value['name']?> <?php if ($service_id == 1) { echo 'varannan vecka';}?> <span>&bull;</span></div>
		<div class="service-no">&nbsp;</div>
		<div class="service-price" ><?=(int)$servicePrice[0]['amount']*2?><span>:-</span> </div>
		<div class="service-choose"><span>Välj</span>  <input type="checkbox"  value="2::<?=$service_id?>"  class="regular-checkbox big-checkbox"  onclick="Checkbox_to_RadioButton(this);" name="clean_service"  id="clean_id_2_<?=$service_id?>" class="regular-checkbox big-checkbox" /><label for="clean_id_2_<?=$service_id?>"></label></div>
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
		<div class="service-icon"><img src="//renthem.se/wp-admin/booking_v2/ico3.png" /></div>
		<div class="service-name"><?=$value['name']?> <?php if ($service_id == 1) { echo 'varje vecka';}?> <span>&bull;</span></div>
		<div class="service-no">&nbsp;</div>
		<div class="service-price"><?=(int)$servicePrice[0]['amount']*4?><span>:-</span> </div>
		<div class="service-choose"><span>Välj</span>  <input type="checkbox" value="4::<?=$service_id?>"  class="regular-checkbox big-checkbox"  onclick="Checkbox_to_RadioButton(this);" name="clean_service"  id="clean_id_4_<?=$service_id?>" class="regular-checkbox big-checkbox" /><label for="clean_id_4_<?=$service_id?>"></label></div>
		<div class="service-tool"><a target="_blank" href="<?=$value['url']?>">Läs mer</a></div>
		<div class="clearBookForm"></div>
	</div>
<?php
}


		$servicePrice = $service->getServicePrice("*", " (".$size." BETWEEN start_value AND end_value ) AND ( service_id = '".$service_id."')  AND (frequency = 0)", "" );
		
		if (count($servicePrice) == 1) {
?>
	<div class="bookOffer-row">
		<div class="service-icon">
		<?php		
		$bullet = "";
			switch ($value['id']) {
				case '15':
						echo '<img src="//renthem.se/wp-admin/booking_v2/ico6.png" alt="" />';
						$bullet = "<span>&bull;</span>";
					break;
				case '2':
				echo '<img src="//renthem.se/wp-admin/booking_v2/ico5.png" alt="" />';
				$bullet = "<span>&bull;&bull;&bull;</span>";
					break;
				case '5':
				echo '<img src="//renthem.se/wp-admin/booking_v2/icon1.png" alt="" />';
					break;
			}
		?>
		</div>
		<div class="service-name"><?=$value['name'].' '.$bullet?> </div>
		<div class="service-no">&nbsp;</div>
		<div class="service-price"><?=(int)$servicePrice[0]['amount']?><span>:-</span> </div>
		<div class="service-choose"><span>Välj</span> <input type="checkbox"  value="0::<?=$service_id?>"   class="regular-checkbox big-checkbox"  onclick="Checkbox_to_RadioButton(this);" name="clean_service"  id="clean_id_0_<?=$service_id?>" class="regular-checkbox big-checkbox" /><label for="clean_id_0_<?=$service_id?>"></label></div>
		<div class="service-tool"><a target="_blank" href="<?=$value['url']?>">Läs mer</a></div>
		<div class="clearBookForm"></div>
	</div>
<?php
}
	


		} // if type
	}
?>

	<div class="bookOffer-row-footer">
        &#9679; Hemstädning (varannan vecka) Mån-Tis 160kr/tim, Ons-Fre 175kr/tim <br>
        &#9679; Hemstädning (varje vecka) Mån-Tis 150kr/tim, Ons-Tor 165kr/tim <br>
        &#9679; Fönsterputsning bokas via vår <a href="//renthem.se/tjanster-priser/fonsterputsning-stockholm/">priskalkylator</a><br>
        &#9679; Priserna ovanför är 50% efter skattereduktion och det som faktureras kunden
	</div>
	
	<div id="bookForm-book">
		<input type="button" value="Boka!" onclick="showBookPopUp();" />
	</div>
	<div class="clearBookForm"></div>