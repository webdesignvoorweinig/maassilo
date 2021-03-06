<?php
class DB {
	private static $_instance = null;
	private $_pdo,
	$_query, 
	$_error = false, 
	$_results, 
	$_count = 0,
	$_lastid;
	private function __construct() {
		try {
			$this->_pdo = new PDO('mysql:host=' . Config::get('mysql/host') . ';dbname='. Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public static function getInstance() {
		if(!isset(self::$_instance)) {
			self::$_instance = new DB();
		}
		return self::$_instance;
	}
	
	public function query($sql, $params=array()) {
		$this->_error = false;
		if($this->_query = $this->_pdo->prepare($sql)) {
			
			if(count($params)) {
				$x = 1;
				foreach($params as $param) {
					
					$this->_query->bindValue($x, $param);
					$x++;
				} 
			}
			if($this->_query->execute()) {
            
				$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
				$this->_count = $this->_query->rowCount();
			} 
            else {
				$this->_error = true;
			}
		}
		return $this;	
	}
	
	public function query_assoc($sql, $params=array()) {
		$this->_error = false;
		if($this->_query = $this->_pdo->prepare($sql)) {
			if(count($params)) {
				$x = 1;
				foreach($params as $param) {
					$this->_query->bindValue($x, $param);
					$x++;
				} 
			}
			if($this->_query->execute()) {
            
				$this->_results = $this->_query->fetchAll(PDO::FETCH_ASSOC);
				$this->_count = $this->_query->rowCount();
			} 
            else {
				$this->_error = true;
			}
		}
		return $this;	
	}



	public function action($action, $table, $where = array()) {
		if(count($where) === 3) {
			$operators = array('=', '>', '<', '>=', '<=');
			
			$field 		= $where[0];
			$operator 	= $where[1];
			$value 		= $where[2];
			if(in_array($operator, $operators)) {
				$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
				if(!$this->query($sql, array($value))->error()) {
					return $this;
				}					
			}
		} 
			/* deze code testen of je een gewone alle records query kan draaien */	
		else {
			$sql = "{$action} FROM {$table}";
			if(!$this->query($sql)->error()) {
				return $this;
			}
		}
		/* beneden staande enablen en bovenstaand else blok verwijderen als het niet werkt */
		/* return false;	*/
	}
	
	public function get($table, $where = array()) {
		return $this->action('SELECT *', $table, $where);
	}
	
	public function delete($table, $where) {
		return $this->action('DELETE', $table, $where);
	}
	
	public function insert($table, $fields = array()) {
		
			$keys = array_keys($fields);
			$values = null;
			$x = 1;
			
			foreach($fields as $field) {
				$values .= '?';
				
				if($x < count($fields)){
					$values .= ', ';
				}
				$x++;
			}
			
			$sql = "INSERT INTO {$table} (`" . implode('`, `', $keys) . "`) VALUES ({$values})";
			
    		if(!$this->query($sql, $fields)->error()) {
				return true;
			}
			
		return false;
	}

	public function results() {
		return $this->_results;
	}
	
	public function first() {
		return $this->results()[0];
	}
	
	public function lastid() {
    	return $this->_lastid;
    }

	public function error() {
		return $this->_error;
	}
	
	public function rows() {
		return $this->_count;
	}

} 