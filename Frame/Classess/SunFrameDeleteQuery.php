<?PHP

	/***
	
	Project 'Sunray'
	
	Author: Wojciech 'Quak' Chojnacki
	E-mail: quak@tlen.pl
	Date:   23.07.2010
	File:   ./Frame/classes/SunFrameDeleteQuery.php
	
	Description:
	
	class for removing data from tables
	
	
	
	***/

	//check security constant
	if(!defined("SUNFRAME_SECURITY")) exit;
	
	class SunFrameDeleteQuery extends SunFrameQuery{
		
		function SunFrameDeleteQuery($dbaccess, $table)
		{
			parent::__construct($dbaccess, $table);
		}
		
		function generateQuery()
		{
			$conditions = NULL;
			
			
			if (!empty($this->conditions))
			{
				$conditions = " where ";
				
				if (is_array($this->conditions)) {
				$conditions_array = array();
					
					foreach ($this->conditions as $condition)
					{
						$conditions_array[] = $this->parseCondition($condition);
					}
					$conditions .= implode(" and ", $conditions_array);
					
				} else {
					$conditions .= $this->parseCondition($this->conditions);
				}
			}
			
			
			
			
			$query = "delete from " . $this->table . $conditions;
			return $query;
		}
		
		function commit()
		{
			$query = $this->generateQuery();
			$resource = $this->dbaccess->query($query);
			if (!$resource)
			{
				return false;
			}
			return true;
		}
	}
	
?>