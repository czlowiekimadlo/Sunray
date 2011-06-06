<?PHP

	/***
	
	Project 'Sunray'
	
	Author: Wojciech 'Quak' Chojnacki
	E-mail: quak@tlen.pl
	Date:   21.07.2010
	File:   ./Frame/classes/SunFrameDBError.php
	
	Description:
	
	database error
	
	
	
	***/

	//check security constant
	if(!defined("SUNFRAME_SECURITY")) exit;
	
	
	
	class SunFrameDBError {
		
		var $number = NULL;
		var $message = NULL;
		var $line = NULL;
		var $filename = NULL;
		var $parent = NULL;
		
		function SunFrameDBError($number, $message, $line, $filename, $parent = NULL)
		{
			$this->number = $number;
			$this->message = $message;
			$this->line = $line;
			$this->filename = $filename;
			$this->parent = $parent;
		}
		
		function getString()
		{
			return "DBError message: Error in file " . $this->filename . " on line " . $this->line . ": (" . $this->number . ") " . $this->message;	
		}
		
		
	}
?>