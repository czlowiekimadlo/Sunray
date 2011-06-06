<?PHP

	/***
	
	Project 'Sunray'
	
	Author: Wojciech 'Quak' Chojnacki
	E-mail: quak@tlen.pl
	Date:   28.07.2010
	File:   ./Frame/classess/SunFrameLink.php
	
	Description:
	
	base hyperlink class
	
	
	
	***/

	//check security constant
	if(!defined("SUNFRAME_SECURITY")) exit;
	
	
	class SunFrameLink
	{
		var $path = NULL;
		var $file = NULL;
		var $variables = NULL;
		
		function SunFrameLink($path, $file = NULL)
		{
			$this->path = $path;
			$this->file = $file;
		}
		
		function addVariable($variable)
		{
			$this->variables[] = $variable;
		}
		
		function generateURL()
		{
			$link = $this->path . $this->file;
			
			if (!empty($this->variables))
			{
				if (is_array($this->variables))
				{
					foreach($this->variables as $variable)
					{
						$variables_array[] = $variable->name . "=" . $variable->value;
					}
					$variables = implode("&", $variables_array);
				}
				else
				{
					$variables = $this->variables->name . "=" . $this->variables->value;
				}
			}
			
			if (!empty($variables)) $link .= "?" . $variables;
			
			return $link;
		}
		
	}
	
?>