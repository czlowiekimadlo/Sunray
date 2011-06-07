<?PHP

	/***
	
	Project 'Sunray'
	
	Author: Wojciech 'Quak' Chojnacki
	E-mail: quak@tlen.pl
	Date:   13.03.2011
	File:   ./Frame/classess/SunFrameLocale.php
	
	Description:
	
	locale class
	
	
	
	***/

	//check security constant
	if(!defined("SUNFRAME_SECURITY")) exit;
	
	
	class SunFrameLocale
	{
		var $localeTag = NULL;
		var $switched = false;
		
		function SunFrameLocale($locale = SUNFRAME_DEFAULT_LANG)
		{
			$this->loadLocale($locale);
		}
		
		function loadLocale($localeTag = SUNFRAME_DEFAULT_LANG)
		{
			$path = SITE_ROOT . "Locale/" . $localeTag . "/locale.php";
			$this->localeTag = $localeTag;
			
			if (empty($localeTag) || !file_exists($path)) 
			{
				$path = SITE_ROOT . "Locale/" . SUNFRAME_DEFAULT_LANG . "/locale.php";
				$this->localeTag = SUNFRAME_DEFAULT_LANG;
			}
			
			include_once($path);
			
			$this->parseLocale($locale);
			
		}
		
		function parseLocale($localeArray)
		{
			if (SUNFRAME_DEBUG)
			{
				print_r($localeArray); 
				echo "loading locale\r\n";
			}
			
			if (is_array($localeArray))
			{
				foreach($localeArray as $key => $value)
				{
					$this->$key = $value;
				}
			}
			else
			{
				print_r($localeArray);
				die("Locale array corrupted");
			}
		}
		
	}
	
?>