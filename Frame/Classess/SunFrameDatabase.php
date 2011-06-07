<?PHP

	/***
	
	Project 'Sunray'
	
	Author: Wojciech 'Quak' Chojnacki
	E-mail: quak@tlen.pl
	Date:   20.07.2010
	File:   ./Frame/classes/SunFrameDatabase.php
	
	Description:
	
	database class for accessing data
	
	
	
	***/

	//check security constant
	if(!defined("SUNFRAME_SECURITY")) exit;
	
	
	//database class
	class SunFrameDatabase {
		
		var $dbaccess = NULL;
		var $tables = array();
		var $prefix = NULL;
		var $error = NULL;
		
		function SunFrameDatabase($dbinfo)
		{
			$this->dbaccess = new SunFrameDBAccess($dbinfo);
			$this->prefix = $dbinfo['prefix'];
		}
		
		function registerTable($name, $table = NULL)
		{
			if ($this->tables[$name] != NULL) return;
			
			if ($table != NULL) {
				$this->tables[$name] = $table;
			} else {
				$this->tables[$name] = new SunFrameDBTable($name);
			}
			
			$this->tables[$name]->dbaccess = $this->dbaccess;
			$this->tables[$name]->prefix = $this->prefix;
			$init = $this->tables[$name]->initTable();
			if (!$init)
			{
				$this->error = new SunFrameDBError(NULL, NULL, __LINE__, __FILE__, $this->tables[$name]->getError());
				return false;
			}
		}
		
		function isError()
		{
			if ($this->error != NULL) return true;
			else return false;
		}
		
		function getError()
		{
			return $this->error;
		}
				
	}
	
?>