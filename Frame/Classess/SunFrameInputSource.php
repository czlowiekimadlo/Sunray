<?PHP

	/***
	
	Project 'Sunray'
	
	Author: Wojciech 'Quak' Chojnacki
	E-mail: quak@tlen.pl
	Date:   27.07.2010
	File:   ./Frame/classes/SunFrameInputSource.php
	
	Description:
	
	input class
	
	
	
	***/

	//check security constant
	if(!defined("SUNFRAME_SECURITY")) exit;
	
	
	class SunFrameInputSource
	{
		var $source = NULL;
		
		function SunFrameInputSource($source)
		{
			$this->source = $source;
		}
		
		function getData($field)
		{
			switch ($this->source)
			{
				case SUNFRAME_INPUT_GET:
					return $_GET[$field];
					break;
					
				case SUNFRAME_INPUT_POST:
					return $_POST[$field];
					break;
					
				case SUNFRAME_INPUT_COOKIE:
					return $_COOKIE[$field];
					break;
					
				default:
					return NULL;
			}
			
		}
		
	}
	
?>