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
					$values_array[] = ":v_" . $field->name;
					
				}
				$fields = implode(", ", $fields_array);
				$values = implode(", ", $values_array);
			} else {
				$fields = $this->fields->name;
				$values = ":v_" . $field->name;
			}
			
			
			$query = "insert into " . $this->table . "(" . $fields . ") values(" . $values . ")";
			
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
			
			if (!empty($this->fields))
			{
				if (is_array($this->fields))
				{
					foreach ($this->fields as $field) {
						$this->bindValue($statement, $field);
					}
				} 
				else 
				{
					$this->bindValue($statement, $this->fields);
				}
			}
			
			$statement->execute();
			
			
			
			return true;
		}
	}
	
?>