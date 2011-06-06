<?PHP

	/***
	
	Project 'Sunray'
	
	Author: Wojciech 'Quak' Chojnacki
	E-mail: quak@tlen.pl
	Date:   04.03.2011
	File:   ./Frame/classes/SunFrameClearLinesFilter.php
	
	Description:
	
	configuration for database connection
	
	
	
	***/

	//check security constant
	if(!defined("SUNFRAME_SECURITY")) exit;
	
	
	class SunFrameClearLinesFilter implements PHPTAL_Filter {
    	public function filter($xhtml){
        	return preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $xhtml);
		}
    }
	
?>