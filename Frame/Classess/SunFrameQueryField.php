<?PHP

	/***
	
	Project 'Sunray'
	
	Author: Wojciech 'Quak' Chojnacki
	E-mail: quak@tlen.pl
	Date:   21.07.2010
	File:   ./Frame/classes/SunFrameQueryField.php
	
	Description:
	
	table field class for selecting, setting conditions and
	ordering
	
	
	***/

	//check security constant
	if(!defined("SUNFRAME_SECURITY")) exit;
	
	
	class SunFrameQueryField {
		
		var $name = NULL;
		var $type = NULL;
		var $order = NULL;
		var $value = NULL;
		var $compare = NULL;
		
		function SunFrameQueryField($name, $type = NULL, $order = NULL, $value = NULL, $compare = NULL)
		{
			$this->name = $name;
			$this->type = $type;
			$this->order = $order;
			$this->value = $value;
			$this->compare = $compare;
		}
	}
	
	
?>