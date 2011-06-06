<?PHP

	/***
	
	Project 'Sunray'
	
	Author: Wojciech 'Quak' Chojnacki
	E-mail: quak@tlen.pl
	Date:   27.07.2010
	File:   ./Frame/classes/SunFrameInput.php
	
	Description:
	
	abstract data input class
	
	
	
	***/

	//check security constant
	if(!defined("SUNFRAME_SECURITY")) exit;
	
	
	class SunFrameInput
	{
		var $inputChain = NULL;
		
		function SunFrameInput()
		{
			$this->inputChain[SUNFRAME_INPUT_GET] = new SunFrameInputSource(SUNFRAME_INPUT_GET);
			$this->inputChain[SUNFRAME_INPUT_POST] = new SunFrameInputSource(SUNFRAME_INPUT_POST);
			$this->inputChain[SUNFRAME_INPUT_COOKIE] = new SunFrameInputSource(SUNFRAME_INPUT_COOKIE);
		}
		
		function getData($field, $input = SUNFRAME_INPUT_ALL)
		{
			if ($input == SUNFRAME_INPUT_ALL)
			{
				$output = $this->inputChain[SUNFRAME_INPUT_GET]->getData($field);
				if (empty($output)) $output = $this->inputChain[SUNFRAME_INPUT_POST]->getData($field);
				if (empty($output)) $output = $this->inputChain[SUNFRAME_INPUT_COOKIE]->getData($field);
				return $output;
			} else {
				if (!empty($this->inputChain[$input])) return $this->inputChain[$input]->getData($field);
				else return NULL;
			}
		}
		
	}
	
?>