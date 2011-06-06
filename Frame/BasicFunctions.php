<?PHP

	/***
	
	Project 'Sunray'
	
	Author: Wojciech 'Quak' Chojnacki
	E-mail: quak@tlen.pl
	Date:   20.07.2010
	File:   ./Frame/basic_functions.php
	
	Description:
	
	basic functions
	
	
	
	***/
	
	//check security constant
	if(!defined("SUNFRAME_SECURITY")) exit;
	
	
	
	//class autoload
	function __autoload($class)
	{
		$path = SITE_ROOT . "Frame/Classess/" . $class . ".php";
		if(file_exists($path)) {
			require_once($path);
			return;
		}
		
		$path = SITE_ROOT . "Classess/" . $class . ".php";
		if(file_exists($path)) {
			require_once($path);
			return;
		}
		
		$path = SITE_ROOT . "Modules/" . $class . ".php";
		if(file_exists($path)) {
			require_once($path);
			return;
		}
		
		
	}
	

	
	
?>