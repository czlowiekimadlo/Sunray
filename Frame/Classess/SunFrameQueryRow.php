<?PHP

	/***
	
	Project 'Sunray'
	
	Author: Wojciech 'Quak' Chojnacki
	E-mail: quak@tlen.pl
	Date:   22.07.2010
	File:   ./Frame/classes/SunFrameQueryRow.php
	
	Description:
	
	select query answer row
	
	
	***/

	//check security constant
	if(!defined("SUNFRAME_SECURITY")) exit;
	
	
	class SunFrameQueryRow {
		
		var $data = NULL;
		
		function SunFrameQueryRow($data)
		{
			$this->data = $data;
		}
	}
	
	
?>