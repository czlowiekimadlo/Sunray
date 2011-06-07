<?PHP

	/***
	
	Project 'Sunray'
	
	Author: Wojciech 'Quak' Chojnacki
	E-mail: quak@tlen.pl
	Date:   20.07.2010
	File:   ./Frame/classes/SunFrameDBAccess.php
	
	Description:
	
	class for direct MySQL database access
	
	
	
	***/

	//check security constant
	if(!defined("SUNFRAME_SECURITY")) exit;
	
	
	
	//database access class
	class SunFrameDBAccess {
		
		var $db = NULL;
		var $statement = NULL;
		var $res = NULL;
		
		//constructor
		function SunFrameDBAccess($db) {
			$this->connect($db);
		}
		
		
		//connect with database
		function connect($db) {
			
			$this->db = NULL;
			
			try {
				$this->db = new PDO('mysql:host=' . $db['host'] . ';dbname=' . $db['name'], $db['user'], $db['pass']);
				$this->db->exec("SET CHARACTER SET utf8");
			} catch (PDOException $e) {
				die("Database Connection Error on line " . __LINE__ . ", " . __FILE__ . "<br/>" . $e->getMessage());
			}
		}
		
		function __destruct() {
			$this->db = NULL;
		}
		
		
		function query($query) {
			$this->res = $this->db->query($query);
			return $this->res;
			
		}
		
		function getStatement($query) {
			$this->statement = $this->db->query($query);
			return $this->statement;
		}
		
		function affectedRows() {
			if (empty($this->statement)) return 0;
			return $this->statement->rowCount();
		}
		
		
		
		function errno () {
			if (!empty($this->db)) return $this->db->errorCode();	
		}
		
		function errmsg () {
			if (!empty($this->db)) return $this->db->errorInfo();
		}
		
	}
		
?>