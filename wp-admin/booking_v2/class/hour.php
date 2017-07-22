<?php
	class work_hour extends database {		
		public $db_table = "work_hour";
		
		function getHour($fields = "", $where = "", $order = "") {
			return $this->select($this->db_table, $fields, $where, $order);
		}
		
	}
