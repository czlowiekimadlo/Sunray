<?PHP

	/***
	
	Project 'Sunray'
	
	Author: Wojciech 'Quak' Chojnacki
	E-mail: quak@tlen.pl
	Date:   12.02.2011
	File:   ./Classess/PostHeader.php
	
	Description:
	
	post header information
	
	
	
	***/

	//check security constant
	if(!defined("SUNFRAME_SECURITY")) exit;
	
	
	class PostHeader
	{
		var $id = 0;
		var $title = NULL;
		
		function PostHeader()
		{
			
		}
		
		function parseRow($row)
		{
			$this->id = $row->id;
			$this->title = $row->title;
		}
	}
	
?>