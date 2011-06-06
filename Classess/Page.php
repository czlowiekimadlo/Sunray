<?PHP

	/***
	
	Project 'Sunray'
	
	Author: Wojciech 'Quak' Chojnacki
	E-mail: quak@tlen.pl
	Date:   27.07.2010
	File:   ./Classess/Page.php
	
	Description:
	
	base page class
	
	
	
	***/

	//check security constant
	if(!defined("SUNFRAME_SECURITY")) exit;
	
	
	class Page
	{
		var $title = NULL;
		var $titleBase = NULL;
		var $description = NULL;
		var $keywords = NULL;
		
		function Page()
		{
			global $frame;
			$this->title = $this->titleBase = $frame->configuration->fields['title']->value;
			
			$this->description = $frame->configuration->fields['description']->value;
			$this->keywords = $frame->configuration->fields['keywords']->value;
						
		}
		
		function setTitle($title)
		{
			global $frame;
			
			if (isset($frame->configuration->fields['title_separator']->value) && strlen($frame->configuration->fields['title_separator']->value) > 0)
			{
				$separator = $frame->configuration->fields['title_separator']->value;
			}
			else
			{
				$separator = SUNFRAME_TITLE_SEPARATOR;
			}
			
			$this->title = $title . $separator . $this->title;
		}
		
	}
	
?>