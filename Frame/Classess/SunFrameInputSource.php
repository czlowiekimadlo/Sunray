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
		
		function getData($field, $sanitize = true)
		{
			$filter =  $sanitize ? FILTER_SANITIZE_SPECIAL_CHARS : FILTER_UNSAFE_RAW;
			switch ($this->source)
			{
				case SUNFRAME_INPUT_GET:
					return filter_input(INPUT_GET, $field, $filter);
					break;
					
				case SUNFRAME_INPUT_POST:
					return filter_input(INPUT_POST, $field, $filter);
					break;
					
				case SUNFRAME_INPUT_COOKIE:
					return filter_input(INPUT_COOKIE, $field, $filter);
					break;
					
				case SUNFRAME_INPUT_SESSION:
					return $_SESSION[$field];
					break;
					
				default:
					return NULL;
			}
			
		}
		
	}
	
?>