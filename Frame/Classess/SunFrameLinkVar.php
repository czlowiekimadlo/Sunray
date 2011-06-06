<?PHP

	/***
	
	Project 'Sunray'
	
	Author: Wojciech 'Quak' Chojnacki
	E-mail: quak@tlen.pl
	Date:   28.07.2010
	File:   ./Frame/classess/SunFrameLinkVar.php
	
	Description:
	
	hyperlink variable class
	
	
	
	***/

	//check security constant
	if(!defined("SUNFRAME_SECURITY")) exit;
	
	
	class SunFrameLinkVar
	{
		var $name = NULL;
		var $value = NULL;
		
		function SunFrameLinkVar($name, $value)
		{
			$this->name = $name;
			$this->value = $value;
		}
		
	}
	
?>