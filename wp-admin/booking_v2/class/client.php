<?php
	class client extends database {		
		public $db_table = "client";
		function setClient ($data) {
			return $this->insert($this->db_table, $data);
		}
		
		function delClient($where = "") {
			return $this->delete($this->db_table, $where);
		}
		function upClient($data, $where = "") {
			return $this->update($this->db_table, $data, $where);
		}
		function getClient($fields = "", $where = "", $order = "") {
			return $this->select($this->db_table, $fields, $where, $order);
		}
		
	}
