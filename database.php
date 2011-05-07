<?php

//	phpdb.php
//
//	Database class for PHP 5
//
//	Requires: mysql module
//
//

class phpDB {
	private $dblink = NULL;
	
	public function connect($server = DB_SERVER, $username = DB_SERVER_USERNAME, $password = DB_SERVER_PASSWORD, $database = DB_DATABASE) {
		$this->dblink = mysql_connect($server, $username, $password);
		
		if($this->dblink) {
			mysql_select_db($database);
		}
		
		return $this->dblink;
	}

	public function close() {
		if($this->dblink) {
			$result =  mysql_close($this->dblink);
			$this->dblink = NULL;
			return $result;
		}
	}
	
	public function error() {}
	
	public function query($query) {
		$result = mysql_query($query, $this->dblink);
		
		return $result;
	}
	
	public function insert($table, $data) {
		$query = "INSERT INTO `$table` (";
		while(list($columns, ) = each($data)) {
			$query .= $columns . ", ";
		}
		$query = substr($query, 0, -2) . ") VALUES (";
		reset($data);
		while (list(, $value) = each($data)) {
			switch ((string)$value) {
				case "now()":
					$query .= "now(), ";
					break;
				case "null":
					$query .= "null, ";
					break;
				default:
					$query .= "'$value', ";
					break;
			}
		}
		$query = substr($query, 0, -2) .");";
		return $this->query($query);
	}
	
	public function update($table, $data) {
		$query = "UPDATE `$table` SET (";
		
	}
	
	public function num_rows($result) {
		return mysql_num_rows($result);
	}
	
	public function fetch_array($result) {
		return mysql_fetch_array($result, MYSQL_ASSOC);
	}
	
	public function get_link() {
		return $this->dblink;
	}
}
?>