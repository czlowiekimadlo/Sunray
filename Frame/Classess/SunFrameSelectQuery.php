<?PHP

	/***
	
	Project 'Sunray'
	
	Author: Wojciech 'Quak' Chojnacki
	E-mail: quak@tlen.pl
	Date:   21.07.2010
	File:   ./Frame/classes/SunFrameSelectQuery.php
	
	Description:
	
	class for fetching data from tables
	
	
	
	***/

	//check security constant
	if(!defined("SUNFRAME_SECURITY")) exit;
	
	class SunFrameSelectQuery extends SunFrameQuery{
		
		
		
		
		function SunFrameSelectQuery($dbaccess, $table)
		{
			parent::__construct($dbaccess, $table);
		}
		
		function generateQuery()
		{
			$fields = NULL;
			$conditions = NULL;
			$sort = NULL;
			$limit = NULL;
			
			if (empty($this->fields))
			{
				$fields = '*';
			} else if (is_array($this->fields)){
				foreach ($this->fields as $field)
				{
					$fields_array[] = $field->name;
				}
				$fields = implode(", ", $fields_array);
			} else {
				$fields = $this->fields->name;
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
			
			if (!empty($this->sort_c))
			{
				$sort = " order by ";
				
				if (is_array($this->sort_c)) {
				$sort_array = array();
					
					foreach ($this->sort_c as $sort_f)
					{
						$sort_array[] = $this->parseSort($sort_f);
					}
					$sort .= implode(", ", $sort_array);
					
				} else {
					$sort .= $this->parseSort($this->sort_c);
				}
			}
			
			if (!empty($this->limit))
			{
				$limit = " limit ";
				
				if ($this->limit->offset > 0)
				{
					$limit .= (int)$this->limit->offset . ", " . (int)$this->limit->limit;
				} else {
					$limit .= (int)$this->limit->limit;
				}
				
			} else {
				$limit = "";
			}
			
			
			$query = "select " . $fields . " from " . $this->table . $conditions . $sort . $limit;
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
			
			$data = array();
			
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
			
			while ($row = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$data[] = new SunFrameQueryRow($row);
			}
			
			return $data;
		}
		
		
	}
	
?>