<?PHP

	/***
	
	Project 'Sunray'
	
	Author: Wojciech 'Quak' Chojnacki
	E-mail: quak@tlen.pl
	Date:   21.07.2010
	File:   ./Frame/classes/SunFrameDBTable.php
	
	Description:
	
	class for accessing abstract table
	
	
	
	***/

	//check security constant
	if(!defined("SUNFRAME_SECURITY")) exit;
	
	
	
	class SunFrameDBTable {
		
		var $name = NULL;
		var $error = NULL;
		var $dbaccess = NULL;
		var $prefix = NULL;
		var $structure = NULL;
		
		function SunFrameDBTable($name)
		{
			$this->name = $name;
		}
		
		function initTable()
		{
			$structureQuery = new SunFrameStructureQuery($this->dbaccess, $this->prefix . $this->name);
			$this->structure = $structureQuery->commit();
			if ($this->structure == NULL || $structureQuery->isError())
			{
				$this->error = new SunFrameDBError(NULL, NULL, __LINE__, __FILE__, $structureQuery->getError());
				return false;
			}
			
			return true;
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
		
		function getData($fields, $conditions = NULL, $sort = NULL, $limit = NULL)
		{
			$this->error = NULL;
			
			$selectQuery = new SunFrameSelectQuery($this->dbaccess, $this->prefix . $this->name);
			$selectQuery->setFields($fields);
			$selectQuery->setConditions($conditions);
			$selectQuery->setSort($sort);
			$selectQuery->setLimit($limit);
			
			$data = $selectQuery->commit();
			
			if (empty($data) || $selectQuery->isError())
			{
				$this->error = new SunFrameDBError(NULL, $selectQuery->getError() . "\r\n" . $selectQuery->generateQuery(), __LINE__, __FILE__);
				return false;
			}
			
			return $data;
		}
		
		function insertData($fields)
		{
			$this->error = NULL;
			
			$insertQuery = new SunFrameInsertQuery($this->dbaccess, $this->prefix . $this->name);
			$insertQuery->setFields($fields);
			
			if ($insertQuery->commit())
			{
				return true;
			} else {
				$this->error = new SunFrameDBError(NULL, NULL, __LINE__, __FILE__, $insertQuery->getError());
				return false;
			}
		}
		
		function updateData($fields, $conditions = NULL)
		{
			$this->error = NULL;
			
			if (empty($fields))
			{
				$this->error = new SunFrameDBError(NULL, "Empty update fields", __LINE__, __FILE__, $deleteQuery->getError());
				return false;
			}
			
			$updateQuery = new SunFrameUpdateQuery($this->dbaccess, $this->prefix . $this->name);
			$updateQuery->setFields($fields);
			$updateQuery->setConditions($conditions);
			
			if ($updateQuery->commit())
			{
				return true;
			} else {
				$this->error = new SunFrameDBError(NULL, $updateQuery->generateQuery(), __LINE__, __FILE__, $updateQuery->getError());
				return false;
			}
		}
		
		function deleteData($conditions = NULL, $flush = false)
		{
			$this->error = NULL;
			
			if (empty($conditions) && $flush == false)
			{
				$this->error = new SunFrameDBError(NULL, "Table flush warning: empty delete conditions", __LINE__, __FILE__, $deleteQuery->getError());
				return false;
			}
			
			$deleteQuery = new SunFrameDeleteQuery($this->dbaccess, $this->prefix . $this->name);
			$deleteQuery->setConditions($conditions);
			
			
			if ($deleteQuery->commit())
			{
				return true;
			} else {
				$this->error = new SunFrameDBError(NULL, NULL, __LINE__, __FILE__, $deleteQuery->getError());
				return false;
			}
		}
		
		function flushTable($flush = false)
		{
			$this->deleteData(NULL, $flush);
		}
	}
?>