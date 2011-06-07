<?PHP

	/***
	
	Project 'Sunray'
	
	Author: Wojciech 'Quak' Chojnacki
	E-mail: quak@tlen.pl
	Date:   21.07.2010
	File:   ./Frame/classes/SunFrameStructureQuery.php
	
	Description:
	
	table structure query class
	
	
	
	***/

	//check security constant
	if(!defined("SUNFRAME_SECURITY")) exit;
	
	
	
	class SunFrameStructureQuery extends SunFrameQuery {
		

		
		function SunFrameStructureQuery($dbaccess, $table)
		{
			parent::__construct($dbaccess, $table);
		}
		
		function generateQuery()
		{
			$query = "describe " . $this->table;
			return $query;
		}
		
		function commit()
		{
			$query = $this->generateQuery();
			$statement = $this->dbaccess->query($query);
			if (empty($statement)) {
				$this->error = new SunFrameDBError($this->dbaccess->errno(), $this->dbaccess->errmsg(), __LINE__, __FILE__);
				return NULL;
			}
			$structure = array();
			while ($row = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$structure[] = $row;
			}
			
			return $structure;
		}

		
	}
?>