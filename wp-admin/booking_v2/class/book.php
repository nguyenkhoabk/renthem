<?php
	class book extends database {		
		public $db_table = "book";
		public $db_table_book_details = "book_details";
		public $db_table_book_comment = "book_comment";
		public $db_table_book_pending = "book_pending";
		
		function setBook ($data) {
			return $this->insert($this->db_table, $data);
		}
		function  setBookPending($data) {
				return $this->insert($this->db_table_book_pending, $data);
		}
		function setBookDetails ($data) {
			return $this->insert($this->db_table_book_details, $data);
		}
		function setBookComment ($data) {
			return $this->insert($this->db_table_book_comment, $data);
		}
		function checkAvailableTime($start_time, $end_time, $staff_id, $date, $book_id = 0) {
			$count = $this->select($this->db_table," * ", "book_id != '".$book_id."' AND  staff_id = '".$staff_id."' AND date = '".$date."' AND ( time_id BETWEEN ".$start_time." AND ".$end_time." ) ", "");		
			return count($count);
		}
			function checkAvailableTimeV2($start_time, $end_time, $staff_id, $date, $book_id = 0) {
			$count = $this->select($this->db_table," * ", " staff_id = '".$staff_id."' AND date = '".$date."' AND ( time_id BETWEEN ".$start_time." AND ".$end_time." ) ", "");		
			return count($count);
		}
		function getBookDates($book_id) {
			$count = $this->select($this->db_table," * ", " book_id = '".$book_id."'  ", "");		
			return $count;
		}
		
		function delBookPeending($where = "") {
			return $this->delete($this->db_table_book_pending, $where);
		}
		function delBookCommentPeending($where = "") {
			return $this->delete($this->db_table_book_comment, $where);
		}
		function delBook($where = "") {
			return $this->delete($this->db_table, $where);
		}
		function delBookDetails($where = "") {
			return $this->delete($this->db_table_book_details, $where);
		}
		function upBook($data, $where = "") {
			return $this->update($this->db_table, $data, $where);
		}
		function upBookDetails($data, $where = "") {
			return $this->update($this->db_table_book_details, $data, $where);
		}
		function getBook($fields = "", $where = "", $order = "") {
			return $this->select($this->db_table, $fields, $where, $order);
		}
	
		function getPendingBook($fields = "", $where = "", $order = "") {
			return $this->select($this->db_table_book_pending, $fields, $where, $order);
		}
		
		
		function getBookDetails($fields = "", $where = "", $order = "") {
			return $this->select($this->db_table_book_details, $fields, $where, $order);
		}
		function getBookComment($fields = "", $where = "", $order = "") {
		return $this->select($this->db_table_book_comment, $fields, $where, $order);
		}
		function upBookComment($data, $where = "") {
			return $this->update($this->db_table_book_comment, $data, $where);
		}
		function getCommentTxt($book_id) {
			$service_vec =  $this->select($this->db_table_book_comment, " comment ", " book_id = '".$book_id."'", "");
				
			return $service_vec[0]['comment'];
		}
		function check_date($staff_id, $day_id, $date) {
			$rez_vec =  $this->select($this->db_table, " book_id ", " staff_id = '".$staff_id."' AND  date = '".$date."' AND time_id = '".$day_id."'", "");
		
			if (count($rez_vec) == 0) {
				return '<td></td>';
			} else {
				$book_id = $rez_vec[0]['book_id'];
				$service_vec =  $this->select($this->db_table_book_details, " service_id, service_window_id ", " id = '".$book_id."'", "");
			
					$service_id = $service_vec[0]['service_id'];
					
				if ($service_id == 0) {
				$service_id = $service_vec[0]['service_window_id'];
				}
			
				$service_details_vec =  $this->select("services", " background ", " id = '".$service_id."'", "");
				$background_color = $service_details_vec[0]['background'];
			
			
			
				return '<td style="background-color:'.$background_color.'; cursor:pointer;" onmouseover="showBookInfoPopupBottom(\''.$book_id.'\');" onmouseout="showBookInfoPopupBottomHide(\''.$book_id.'\');" onclick="showBookInfoPopup(\''.$book_id.'\');" >&nbsp;</td>';
			}
		}
	}
