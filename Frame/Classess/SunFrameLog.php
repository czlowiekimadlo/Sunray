<?PHP

	/***
	
	Project 'Sunray'
	
	Author: Wojciech 'Quak' Chojnacki
	E-mail: quak@tlen.pl
	Date:   20.01.2011
	File:   ./Frame/classess/SunFrameLog.php
	
	Description:
	
	hyperlink variable class
	
	
	
	***/

	//check security constant
	if(!defined("SUNFRAME_SECURITY")) exit;
	
	
	class SunFrameLog
	{
		var $path = NULL;
		var $fp = NULL;
		
		function SunFrameLog($path)
		{
			$this->path = $path;
			$this->fp = @fopen($this->path, "a+");
			if (!$this->fp) die("Couldnt open log file in: " . $this->path);
		}
		
		function log($entry)
		{
			if (!$this->fp) return;
			fwrite($this->fp, date("[Y/m/d G:i:s]") . " " . $entry . "\r\n");
		}
		
		function close()
		{
			fclose($this->fp);
		}
		
		function __destruct ()
		{
			$this->close();
		}
		
	}
	
?>