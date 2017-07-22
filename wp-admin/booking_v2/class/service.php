<?php
	class service extends database {		
		public $db_table = "services";
		public $db_table_price = "service_price";
		function setService ($data) {
			return $this->insert($this->db_table, $data);
		}
		function setServicePrice ($data) {
			return $this->insert($this->db_table_price, $data);
		}
		
		function delService($where = "") {
			return $this->delete($this->db_table, $where);
		}
		
		function delServicePrice($where = "") {
			return $this->delete($this->db_table_price, $where);
		}
		function upService($data, $where = "") {
			return $this->update($this->db_table, $data, $where);
		}
		function upServicePrice($data, $where = "") {
			return $this->update($this->db_table_price, $data, $where);
		}
		function getService($fields = "", $where = "", $order = "") {
			return $this->select($this->db_table, $fields, $where, $order);
		}
		function getServicePrice($fields = "", $where = "", $order = "") {
			return $this->select($this->db_table_price, $fields, $where, $order);
		}
		function getServiceName($id) {
			$serv = $this->getService("name", " id = '".$id."' ", "");
			if (count($serv) == 1) {
				return $serv[0]['name'];
			}
			return "";
			
		}
	}
