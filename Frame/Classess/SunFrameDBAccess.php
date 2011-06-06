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
		
		// $id - database connection id
		// #res - last resource id
		var $id, $res = NULL;
		
		//constructor
		function SunFrameDBAccess($db) {
			$this->connect($db);
		}
		
		
		//connect with database
		function connect($db) {

			if ($this->id != NULL) $this->close();
			
			$this->id = @mysqli_connect($db['host'], $db['user'], $db['pass'], $db['name']);
			if(!$this->id) die("Database Connection Error on line " . __LINE__ . ", " . __FILE__);
			if (SUNFRAME_DEBUG) echo "DB Access OK!";
			
			$this->query("SET NAMES 'utf8'");
			//$this->query("SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
		}
		
		//close database connection
		function close() {
			@mysqli_close($this->id);
			$this->id = NULL;
		}
		
		function __destruct() {
			$this->close();
		}
		
		
		
		function query($query) {
			$this->res = @mysqli_query($this->id, $query);
			return $this->res;
			
		}
		
		
		function fetch_assoc($qid = NULL) {
		    if (!$qid) $qid = $this->res;
			return @mysqli_fetch_assoc($qid);
		}
		
		
		function fetch_array($qid = NULL) {
			if (!$qid) $qid = $this->res;
			return @mysqli_fetch_array($qid);
		}
		
		
		function num_rows($qid = NULL) {
			if (!$qid) $qid = $this->res;
			return @mysqli_num_rows($qid);
		}
		
		
		function affected_rows() {
			return @mysqli_affected_rows($this->id);
		}
		
		
		function errno()
		{
			if(!$this->id) {
				return @mysqli_errno();
			} else {
				return @mysqli_errno($this->id);
			}
		}
		
		function errmsg()
		{
			if(!$this->id) {
				return @mysqli_error();
			} else {
				return @mysqli_error($this->id);
			}
		}
		
		function escape_string($value) {
			return @mysqli_real_escape_string($this->id, $value);
		}
		
	}
		
?>