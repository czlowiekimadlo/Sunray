<?PHP

	/***
	
	Project 'Sunray'
	
	Author: Wojciech 'Quak' Chojnacki
	E-mail: quak@tlen.pl
	Date:   23.07.2010
	File:   ./Frame/classes/SunFrameInsertQuery.php
	
	Description:
	
	class for inserting data into tables
	
	
	
	***/

	//check security constant
	if(!defined("SUNFRAME_SECURITY")) exit;
	
	class SunFrameInsertQuery extends SunFrameQuery{
		
		function SunFrameInsertQuery($dbaccess, $table)
		{
			parent::__construct($dbaccess, $table);
		}
		
		function generateQuery()
		{
			$fields = NULL;
			$values = NULL;
			
			if (empty($this->fields))
			{
				$this->error = new SunFrameDatabaseError(NULL, "Insert error: empty fields list", __LINE__, __FILE__, NULL);
				return false;
			} else if (is_array($this->fields)){
				foreach ($this->fields as $field)
				{
					$fields_array[] = $field->name;
					
					switch ($field->type)
					{
						case SUNFRAME_NUMBER:
							$values_array[] = $this->dbaccess->escape_string($field->value);
							break;
							
						case SUNFRAME_TEXT:
							$values_array[] = "'" . $this->dbaccess->escape_string($field->value) . "'";
							break;
						
						default:
							die("illegal query field type");
					}
				}
				$fields = implode(", ", $fields_array);
				$values = implode(", ", $values_array);
			} else {
				$fields = $this->fields->name;
				
				switch ($field->type)
				{
					case SUNFRAME_NUMBER:
						$values = $this->dbaccess->escape_string($field->value);
						break;
							
					case SUNFRAME_TEXT:
						$values = "'" . $this->dbaccess->escape_string($field->value) . "'";
						break;
						
					default:
						die("illegal query field type");
				}
			}
			
			
			
			
			$query = "insert into " . $this->table . "(" . $fields . ") values(" . $values . ")";
			
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