<?php
	class database {
		var $oConn;
		var $oDB;
		
		function openConnection() {
			$this->oConn = mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die ("No connection!");
			$this->oDB = mysql_select_db(DB_DATABASE) or die ("No database");
			return true;
		}
		function closeConnection() {
			mysql_close($this->oConn);
			return true;
		}
		function select($table,$field = "*", $where = "", $order = "") {
		$this->openConnection();
		mysql_query("set names 'utf8'");
			$order_query = "";
			if ($order != "")
			foreach ($order as $key => $value) {
				if ($order_query != "") {
					$order_query .= ',';
				}
				$order_query .= $key." ".mysql_real_escape_string($value)." ";
			}
			if ($order_query != "") {
				$order_query = " ORDER BY ".$order_query;
			}
			
			$fields = array();
			
			if ($where!= "") {
				$where = " WHERE ".$where;
			}
			
		 	$sql = "SELECT ".$field." FROM ".$table.$where.$order_query." ;";
			$result = mysql_query($sql) or die(mysql_error());
			$this->closeConnection();
			if ($result) {
					$no = mysql_num_rows($result);
					for ($i = 0; $i < $no; $i ++ ) {
						$row = mysql_fetch_assoc($result);
						foreach ($row as $key => $value) {
							$fields[$i][$key] = $value;
						}
					}
					
				}	
			return $fields;
			
		}
		function insert($table, $data) {
		$this->openConnection();
		mysql_query("set names 'utf8'");
			$query = "";
			foreach ($data as $key => $value) {
				if ($query != "") {
					$query .= ',';
				}
				$query .= " $key = '".mysql_real_escape_string($value)."' ";
			}
			if ($query != "") {
				
				$sql = "INSERT INTO ".$table." SET ".$query." ;";
				$result = mysql_query($sql) or die(mysql_error());
				$last_id = mysql_insert_id();
				$this->closeConnection();
				if ($result) {					
					return $last_id;
				}
			}
			return 0;
		}
		function delete($table, $where = "") {
			if ($where != "" ) {
				$this->openConnection();
				$sql = "DELETE FROM ".$table." WHERE ".$where." ;";
				$result = mysql_query($sql) or die(mysql_error());
				$this->closeConnection();
				if ($result) {
					return 1;
				}				
			}
 			return 0;
		}
		function update($table, $data, $where = "") {
		$this->openConnection();
		mysql_query("set names 'utf8'");
			$query = "";
			foreach ($data as $key => $value) {
				if ($query != "") {
					$query .= ',';
				}
					$query .= " $key = '".mysql_real_escape_string($value)."' ";
			}
			
			$sql = "UPDATE ".$table." SET ".$query." WHERE ".$where." ;";
			$result = mysql_query($sql) or die(mysql_error());
			$this->closeConnection();
			if ($result) {
					return 1;
				}	
			return 0;
		}
	}
