<html>
	<head>

		<link rel="stylesheet" href="css/book-form.css" type="text/css" />

	<link rel="stylesheet" type="text/css" href="ustawienia.css" media="screen" />
    	<link rel="stylesheet" href="css/new_calendar.css" type="text/css" />




		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
		
<script src="js/new-calendar.js"></script>
<script src="js/book-script-form.js"></script>

	</head>
	<body>
		<div id="book-lightbox">
			<div id="popup">
				<div id="popup-close" onclick="closePopUp();">x</div>
				<div id="popup-title"> Vi har reserverat en tid for städning hemma hos er den</div>
				<div id="popup-description">For att slutföra bokningen behöver vi bara dina personuppgifter/adress,se nedan. En bekräftelse
				kommer därefter att skickas till din mail. Har du nágra frágor gár det bra att ringa vár kundtjänst pá
				08-82 44 77. Provstädningen ar inte bindande for fortsatt städning, utan bara for det bokade tillfället. </div>
			<form action="" method="post" id="frmBook" onsubmit="return validateBookForm();">	
				<input type="hidden" name="clean_service" value="" id="clean_service" />
				<input type="hidden" name="window_service" value="" id="window_service" />
				<input type="hidden" name="window_no_book" value="" id="window_no_book" />
				<table width="100%">
					<tr>
						<td width="50%"><b>Förnamn *</b><br/>
							<input type="text" class="class-input" name="frmBookFirstName" id="frmBookFirstName" />
						</td>
						<td  width="50%"><b>Efternamn *</b><br/>
							<input type="text" class="class-input" name="frmBookLastName" id="frmBookLastName" />
						</td>
					</tr>
					<tr>
						<td><b>Gatuadress *</b><br/>
							<input type="text" class="class-input" name="frmBookStreet" id="frmBookStreet" />
						</td>
						<td><b>Postnummer *</b><br/>
							<input type="text" class="class-input" name="frmBookZip" id="frmBookZip" />
							</td>
					</tr>
					<tr>
						<td>	<b>Ort *</b><br/>
							<input type="text" class="class-input" name="frmBookCity" id="frmBookCity" />
						</td>
						<td><b>Mobilnr. *</b><br/>
							<input type="text" class="class-input" name="frmBookMobile" id="frmBookMobile" />
							</td>
					</tr>
					<tr>
						<td><b>E-post *</b><br/>
							<input type="text" class="class-input" name="frmBookEmail" id="frmBookEmail" />
						</td>
						<td><b>Date *</b><br/>
							<input  type="text" class="class-input" name="frmBookDate" autocomplete="off" id="frmBookDate"/>
							</td>
					</tr>
					<tr>
						<td><b>Meddelande</b> <br/>
							<textarea class="class-input" style="resize:none;" id="frmBookComment" name="frmBookComment"></textarea>
						</td>
						<td>
							<input type="radio" name="frmBookHour" value="8-12" /> Förmiddag 8:00-12:00 <br/>
							<input type="radio" name="frmBookHour" value="13-17" /> Eftermiddag 13:00-17:00
						</td>
					</tr>
					<tr>
						<td><input type="checkbox" value="1" name="frmBookTerms" /> Jag har läst <A target="_blank" href="//renthem.se/bokningsvillkor/">Bokningsvillkoren</a></td>
						<td align="center"><input type="submit" value="Boka !" /></td>
					</tr>
					
				</table>
		</form>
			</div>
		</div>
		<div id="calendar-cont"></div>
	


	</body>
</html>