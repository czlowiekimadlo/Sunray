<?PHP

	/***
	
	Project 'Sunray'
	
	Author: Wojciech 'Quak' Chojnacki
	E-mail: quak@tlen.pl
	Date:   23.07.2010
	File:   ./Frame/classes/SunFrameConfiguration.php
	
	Description:
	
	main configuration class
	
	
	
	***/

	//check security constant
	if(!defined("SUNFRAME_SECURITY")) exit;
	
	class SunFrameConfiguration
	{
		
		var $database = NULL;
		var $fields = NULL;
		var $modules = NULL;
		var $user = NULL;
		
		
		function SunFrameConfiguration($database)
		{
			$this->database = $database;
			
			$this->database->registerTable('config');
			
			$condition = new SunFrameQueryField('module', SUNFRAME_NUMBER, NULL, SUNFRAME_MAIN_CONFIG, SUNFRAME_COMPARE_EQUAL);
			
			$data = $this->database->tables['config']->getData(NULL, $condition);
			
			if (!$data) {
				$error = $this->database->getError();
				print_r($error);
				die("couldn't fetch configuration data");
			}
			
			foreach ($data as $field)
			{
				$this->fields[$field->data['attribute']] = new SunFrameConfigurationField($this->database->tables['config'], $field->data['id'], $field->data['attribute'], $field->data['value'], $field->data['module']);
			}
		}
		
		
		function fetchModuleConfiguration($moduleID)
		{
			$moduleFields = NULL;
			
			$condition = new SunFrameQueryField('module', SUNFRAME_NUMBER, NULL, $moduleID, SUNFRAME_COMPARE_EQUAL);
			
			$data = $this->database->tables['config']->getData(NULL, $condition);
			
			if (!$data || empty($data)) {
				return false;
			}
			
			foreach ($data as $moduleField)
			{
				$moduleFields[$moduleField->attribute] = new SunFrameConfigurationField($this->database->config, $moduleField->id, $moduleField->attribute, $moduleField->value, $moduleField->module);
			}
			
			$this->modules[moduleID] = new SunFrameModuleConfiguration($moduleFields);
			
			return true;
		}
	}
	
?>