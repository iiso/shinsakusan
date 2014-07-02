<?php
class DB {
	var $hostname 	= 'localhost';
	var $username 	= '';
	var $password 	= '';
	var $db_name	= '';
	var $connection;
	var $errors		= array();
	var $queries	= array();
	var $query		= '';
	var $insert_id	= 0;
	var $debug		= 0;
	
	
	function DB($params=array()) {
		if(!empty($params)) {
			foreach($params as $k=>$v) {
				if(isset($this->{$k})) {
					$this->{$k} = $v;
				}
			}
		}
		
		if($this->hostname != '' && $this->username != '' && $this->password != '' && $this->db_name != '') {
			$this->connection = mysql_connect($this->hostname,$this->username,$this->password);
			if(!$this->connection) {
				$this->errors[] = 'Could not connect: '.mysql_error();
				return FALSE;
			}
			if(!mysql_select_db($this->db_name,$this->connection)) {
				$this->errors[] = 'Database error: '.mysql_error();
				return FALSE;
			}
		} else {
			$this->errors[] = 'Host/Username/Password/Database name is empty';
			return FALSE;
		}
		
		if($this->debug && !empty($this->errors)) {
			$this->pr($this->errors);
		}
		
	return TRUE;
	}
	
	
	function query($sql) {
		$this->queries[] = $sql;
		$result = @mysql_query($sql);
		if(!$result) {
			$this->errors[] = 'Invalid query: '.mysql_error();
		}
		if($result===TRUE) {
			$this->insert_id = mysql_insert_id();
		}
		
		if($this->debug && !empty($this->errors)) {
			$this->pr($this->errors);
			$this->pr($sql);
		}
		
	return $result;
	}
	
	
	function get_rows($sql) {
		$result = $this->query($sql);
		$rows = array();
		if($result !== FALSE) {
			while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
				$rows[] = $row;
			}
		}
	return $rows;
	}
	
	
	function get_row($sql) {
		$result = $this->query($sql);
		$row = array();
		if($result !== FALSE) {
			$row = mysql_fetch_array($result,MYSQL_ASSOC);
		}
	return $row;
	}


	function escape($str) {
		return mysql_escape_string($str);
	}
	
	
	function insert($table, $data) {
		// escape data
		foreach($data as $k=>$v) {
			$data[$k] = $this->escape($v);
		}

		// add created date
		if(!isset($data['created'])) {
			$data['created'] = date("Y-m-d H:i:s");
		}
		
		// check database fields exists
		$fields = $this->get_sql_field_names($table);
		foreach($data as $k=>$v) {
			if(!in_array($k,$fields)) {
				unset($data[$k]);
			}
		}

		// get keys & values
		$keys 	= array_keys($data);
		$values = array_values($data);

		// build insert query
		$sql = "INSERT INTO ".$this->escape($table)." (".implode(',',$keys).") VALUES('".implode("','",$values)."')";
		
	return $this->query($sql);
	}
	
	
	function update($table, $data, $id) {
		// add modified date
		if(!isset($data['modified'])) {
			$data['modified'] = date("Y-m-d H:i:s");
		}
		// check database fields exists
		$fields = $this->get_sql_field_names($table);
		$update = '';
		foreach($data as $k=>$v) {
			if(in_array($k,$fields)) {
				$update .= "`$k`='".$this->escape($v)."', ";
			}
		}
		// remove last comma
		$update = substr($update, 0, strrpos($update, ','));
		
		// build sql
		$sql = "UPDATE ".$this->escape($table)." SET ".$update." WHERE id=".$this->escape($id);

	return $this->query($sql);
	}


	function get_insert_id() {
		return $this->insert_id;
	}


	function get_sql_field_names($table) {
		$columns = array();
		$rows = $this->get_rows("SHOW COLUMNS FROM ".$table);
		foreach($rows as $k=>$v) {
			if(!in_array($v['Field'], $columns)) {
				$columns[] = $v['Field'];
			}
		}
	return $columns;
	}


	function pr($debug) {
		echo '<pre>';
		if(is_string($debug)) {
			echo $debug;
		} else {
			print_r($debug);
		}
		echo '</pre>';
	}
}