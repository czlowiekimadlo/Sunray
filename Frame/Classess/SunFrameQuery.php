<?PHP

	/***
	
	Project 'Sunray'
	
	Author: Wojciech 'Quak' Chojnacki
	E-mail: quak@tlen.pl
	Date:   21.07.2010
	File:   ./Frame/classes/SunFrameQuery.php
	
	Description:
	
	base class for database queries
	
	
	
	***/

	//check security constant
	if(!defined("SUNFRAME_SECURITY")) exit;
	
	
	
	class SunFrameQuery {
		
		var $table = NULL;
		var $error = NULL;
		var $dbaccess = NULL;
		var $fields = NULL;
		var $rid = NULL;
		
		var $conditions = NULL;
		
		function SunFrameQuery($dbaccess, $table)
		{
			$this->dbaccess = $dbaccess;
			$this->table = $table;
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
		
		function setFields($fields)
		{
			$this->fields = $fields;
		}
		
		function generateQuery()
		{
			return "";
		}
		
		function commit()
		{
			return;
		}
		
		function setConditions($conditions)
		{
			$this->conditions = $conditions;
		}
		
		function parseCondition($field)
		{
			
			$condition = $field->name;
			switch ($field->compare)
			{
				
				case SUNFRAME_COMPARE_EQUAL:
					$condition .= '=';
					break;
						
				case SUNFRAME_COMPARE_GREATER:
					$condition .= '>';
					break;
							
				case SUNFRAME_COMPARE_LESSER:
					$condition .= '<';
					break;
							
				default:
					die("illegal query compare type");
			}
					
			switch ($field->type)
			{
				
				case SUNFRAME_NUMBER:
					$condition .= $this->dbaccess->escape_string($field->value);
					break;
					
				case SUNFRAME_TEXT:
					$condition .= "'" . $this->dbaccess->escape_string($field->value) . "'";
					break;
				
				default:
					die("illegal query field type");
			}
					
			return $condition;
		}
		
	}
?>