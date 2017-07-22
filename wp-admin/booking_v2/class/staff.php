<?php
	class staff extends database {		
		public $db_table = "staff";
		function setStaff ($data) {
			return $this->insert($this->db_table, $data);
		}
		
		function delStaff($where = "") {
			return $this->delete($this->db_table, $where);
		}
		function upStaff($data, $where = "") {
			return $this->update($this->db_table, $data, $where);
		}
		function getStaff($fields = "", $where = "", $order = "") {
			return $this->select($this->db_table, $fields, $where, $order);
		}
		function getStaffName($id) {
			$serv = $this->getStaff("name", " id = '".$id."' ", "");
			if (count($serv) == 1) {
				return $serv[0]['name'];
			}
			return "";
			
		}
	}
