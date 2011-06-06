<?PHP

	/***
	
	Project 'Sunray'
	
	Author: Wojciech 'Quak' Chojnacki
	E-mail: quak@tlen.pl
	Date:   31.07.2010
	File:   ./Frame/classess/SunFrameQueryLimit.php
	
	Description:
	
	main page class
	
	
	
	***/

	//check security constant
	if(!defined("SUNFRAME_SECURITY")) exit;
	
	
	class SunFrameQueryLimit
	{
		var $limit = NULL;
		var $offset = NULL;
		
		function SunFrameQueryLimit($limit, $offset)
		{
			$this->limit = $limit;
			$this->offset = $offset;
		}
		
	}
	
?>