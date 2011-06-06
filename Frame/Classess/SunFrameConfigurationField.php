<?PHP

	/***
	
	Project 'Sunray'
	
	Author: Wojciech 'Quak' Chojnacki
	E-mail: quak@tlen.pl
	Date:   23.07.2010
	File:   ./Frame/classes/SunFrameConfigurationField.php
	
	Description:
	
	configuration field class
	
	
	
	***/

	//check security constant
	if(!defined("SUNFRAME_SECURITY")) exit;
	
	class SunFrameConfigurationField
	{

		var $id = NULL;
		var $name = NULL;
		var $value = NULL;
		var $module = NULL;
		var $table = NULL;
		
		function SunFrameConfigurationField($table, $fieldID, $name, $value, $module)
		{
			$this->table = $table;
			$this->id = $fieldID;
			$this->name = $name;
			$this->value = $value;
			$this->module = $module;
		}
		
		function updateValue($value)
		{
			$this->value = $value;
			
			$field = new SunFrameQueryField('value', SUNFRAME_TEXT, NULL, $this->value, NULL);
			$condition = new SunFrameQueryField('id', SUNFRAME_NUMBER, NULL, $this->id, SUNFRAME_COMPARE_EQUAL);
			
			$this->table->updateData($field, $condition);
		}
		
	}
	
?>