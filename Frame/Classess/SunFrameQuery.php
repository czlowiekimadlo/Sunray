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
		var $sort_c = NULL;
		var $limit = NULL;
		
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
					$condition .= ' = ';
					break;
						
				case SUNFRAME_COMPARE_GREATER:
					$condition .= ' > ';
					break;
							
				case SUNFRAME_COMPARE_LESSER:
					$condition .= ' < ';
					break;
							
				default:
					die("illegal query compare type");
			}
			
			$condition .= ":c_" . $field->name;
					
			return $condition;
		}
		
		function setSort($sort)
		{
			$this->sort_c = $sort;
		}
		
		function parseSort($field)
		{
			$sort = $field->name;
			
			switch ($field->order)
			{
				case SUNFRAME_ASC:
					$sort .= " asc";
					break;
					
				case SUNFRAME_DESC:
					$sort .= " desc";
					break;
				
				default:
					die("illegal query sort type");
			}
			
			return $sort;
		}
		
		function setLimit($limit)
		{
			$this->limit = $limit;
		}
		
		function bindValue($statement, $param) 
		{
			$type = NULL;
			
			switch ($param->type)
			{
				case SUNFRAME_NUMBER:
					$type = PDO::PARAM_INT;
					break;
					
				case SUNFRAME_TEXT:
					$type = PDO::PARAM_STR;
					break;
					
				default:
					die("Illegal param type.");
			}
			
			$statement->bindValue(":c_" . $param->name, $param->value, $type);
		}
		
	}
?>