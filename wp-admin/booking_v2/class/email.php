<?php
	class email extends database {		
		public $db_table = "email_status";
	
		function upEmail($data, $where = "") {
			return $this->update($this->db_table, $data, $where);
		}
		function getEmail($fields = "", $where = "", $order = "") {
			return $this->select($this->db_table, $fields, $where, $order);
		}
		
	}
