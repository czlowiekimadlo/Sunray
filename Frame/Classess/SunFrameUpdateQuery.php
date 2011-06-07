<?PHP

	/***
	
	Project 'Sunray'
	
	Author: Wojciech 'Quak' Chojnacki
	E-mail: quak@tlen.pl
	Date:   23.07.2010
	File:   ./Frame/classes/SunFrameUpdateQuery.php
	
	Description:
	
	class for updating data in tables
	
	
	
	***/

	//check security constant
	if(!defined("SUNFRAME_SECURITY")) exit;
	
	class SunFrameUpdateQuery extends SunFrameQuery{
		
		function SunFrameUpdateQuery($dbaccess, $table)
		{
			parent::__construct($dbaccess, $table);
		}
		
		function parseField($field)
		{
			$set = NULL;
			
			$set = $field->name . "=";
			
			switch ($field->type)
			{
				case SUNFRAME_NUMBER:
					$set .= $this->dbaccess->escape_string($field->value);
					break;
							
				case SUNFRAME_TEXT:
					$set .= "'" . $this->dbaccess->escape_string($field->value) . "'";
					break;
				
				default:
					die("illegal query field type");
			}
			
			return $set;
		}
		
		function generateQuery()
		{
			$fields = NULL;
			
			if (empty($this->fields))
			{
				$this->error = new SunFrameDBError(NULL, "Update error: empty fields list", __LINE__, __FILE__, NULL);
				return false;
			} else if (is_array($this->fields)){
				foreach ($this->fields as $field)
				{
					$fields_array[] = $this->parseField($field);
				}
				$fields = implode(", ", $fields_array);
			} else {
				$fields = $this->parseField($this->fields);
			}
			
			
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
			
			
			$query = "update " . $this->table . " set " . $fields . $conditions;
			
			return $query;
		}
		
		function commit()
		{
			$query = $this->generateQuery();
			$statement = $this->dbaccess->getStatement($query);
			if (empty($statement))
			{
				return false;
			}
			
			if (!empty($this->conditions))
			{
				if (is_array($this->conditions))
				{
					foreach ($this->conditions as $condition) {
						$this->bindValue($statement, $condition);
					}
				} 
				else 
				{
					$this->bindValue($statement, $this->conditions);
				}
			}
			
			$statement->execute();
			
			
			return true;
		}
	}
	
?>