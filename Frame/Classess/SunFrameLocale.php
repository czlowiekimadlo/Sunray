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
		
		function SunFrameLocale($locale = SUNFRAME_DEFAULT_LANG)
		{
			$this->loadLocale($locale);
		}
		
		function loadLocale($localeTag = SUNFRAME_DEFAULT_LANG)
		{
			if (!empty($localeTag)) $path = SITE_ROOT . "Locale/" . $locale . "/locale.php";
			else $path = SITE_ROOT . "Locale/" . SUNFRAME_DEFAULT_LANG . "/locale.php";
			if (!file_exists($path)) include_once($path);
			else die("Couldn't load locale file: " . $path . " " . SUNFRAME_DEFAULT_LANG);
			
			$this->parseLocale($locale);
			unset($locale);
			$this->localeTag = $localeTag;
		}
		
		function parseLocale($localeArray)
		{
			if (is_array($localeArray))
			{
				foreach($localeArray as $key => $value)
				{
					$this->$key = $value;
				}
			} else die("Locale array corrupted.");
		}
		
	}
	
?>