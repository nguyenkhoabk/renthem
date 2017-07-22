<html lang="en">
  <head>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
		<meta charset="utf-8" />
       
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="favicon.ico">
   
        <title>Booking system</title>
		<meta name="description" xml:lang="en" lang="en" content="" />
        <meta name="keywords"  xml:lang="en" lang="en" content="" />
		
		
	<style> 
    <!--
		#book-form {
			width:800px;
			height:300px;
			margin:auto;	
			font-family:Arial;		
			background-color:#5fb530;		
			border-radius:5px 5px 5px 5px ;			
		}
		.book-form-clear {
			clear:both;
		}
		#book-form #book-step-1 {
			width:800px;
			border-radius:5px 5px 5px 5px ;		
			border-bottom:1px dotted #81db4f;
		}
		#book-form #book-step-1 #book-step-green input[type=text], select {
			border:0px;
			padding:7px 5px 7px 5px;
			margin-top:3px;
		}
		#book-form #book-step-1 #book-step-green input[type=text] {
			width:60px;
			border-radius:5px 0px 0px 5px;
			padding:8px 5px 8px 5px;
			text-align:center;
		}
		#book-form #book-step-1 #book-step-green select {
			width:80px;
			border-radius:0px 5px 5px 0px;
			
			margin-left:-1px;
		}
		#book-form #book-step-1 #book-step-green #text {
			width:400px;
			font-size:13px;
			color:#ffffff;
			float:left;
			text-align:left;
			
		}
		#book-form #book-step-1 #book-step-green #text #text-title {
			font-size:16px;
			color:#ffffff;
			font-weight:bold;
			text-transform:uppercase;
		}
		#book-form #book-step-1 #book-step-green #input {
			width:230px;
			float:left;
		}
		#book-form #book-step-1 #book-step-green{ 
			background-color:#5fb530;
			width:630px;
			padding:10px;
			float:left;
			height:38px;
			border-radius:5px 0px 0px 5px ;		
		}
		#book-form #book-step-1 #book-step-orange{
			background-color:#fa6b03;
			width:130px;
			padding:10px;
			font-size:16px;
			font-weight:bold;
			color:#ffffff;
			text-transform:uppercase;
			text-align:center;
			line-height:38px;
			cursor:pointer;
			vertical-align:middle;
			float:left;
			border-radius:0px 5px 5px 0px ;		
		}
	-->
	</style>
  </head>
  <body>
  
  
	<div id="book-form">
		<div id="book-step-1">
			<div id="book-step-green">
				<div id="text">
				<div id="text-title">rakna ut din standkostnad</div>
				Ange antal rum exkl.kok oh hur stor bostdenar i kvm
				</div>
				<div id="input">
					<input type="text" value="" />
					<select name="">
						<option value="">mph</option>
						<option value="">window</option>
					</select>
				</div>
			</div>
			<div id="book-step-orange">se ditt pris</div>
			<div class="book-form-clear"></div>
		</div>
		<div id="book-step-2">
		</div>
		<div class="book-form-clear"></div>
	</div>
  </body>
 </html>