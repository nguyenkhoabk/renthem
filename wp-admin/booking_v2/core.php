<?php
	include ("config.php");
	
	include ("class/db.php");
	include ("class/client.php");
	include ("class/book.php");
	include ("class/service.php");
	include ("class/hour.php");
	include ("class/staff.php");
	include ("class/email.php");
	
	$work_hour = new work_hour();
	$workHourArr = $work_hour->getHour("*","",array('start_hour'=> 'ASC','start_minute'=> 'ASC'));

	$staff = new staff();
	$staffArr = $staff->getStaff("*", " mark_delete = 0  ", array('name'=> 'ASC'));
	
	$service = new service();
	$serviceArr = $service->getService("*", " mark_delete = 0 ",  array( 'position'=> 'ASC'));
	$priceArr = $service->getServicePrice("*", "",  array('service_id'=> 'ASC'));
	
	$client = new client();
	$book = new book();
	$emailCls = new email();
	$emailArr = $emailCls->getEmail("*", " id = 1",  array('id'=> 'ASC'));
		$emailStatus = $emailArr[0]['status'];
?>