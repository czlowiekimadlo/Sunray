<?PHP

	/***
	
	Project 'Sunray'
	
	Author: Wojciech 'Quak' Chojnacki
	E-mail: quak@tlen.pl
	Date:   23.07.2010
	File:   ./Frame/classes/SunFrameModuleConfiguration.php
	
	Description:
	
	module configuration class
	
	
	
	***/

	//check security constant
	if(!defined("SUNFRAME_SECURITY")) exit;
	
	class SunFrameModuleConfiguration
	{

		var $fields = NULL;
		
		function SunFrameModuleConfiguration($fields)
		{
			$this->fields = $fields;
		}
		
	}
	
?>