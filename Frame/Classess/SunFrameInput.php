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
			$this->inputChain[SUNFRAME_INPUT_SESSION] = new SunFrameInputSource(SUNFRAME_INPUT_SESSION);
		}
		
		function getData($field, $input = SUNFRAME_INPUT_ALL, $sanitize = true)
		{
			if ($input == SUNFRAME_INPUT_ALL)
			{
				foreach ($this->inputChain as $source)
				{
					$output = $source->getData($field, $sanitize);
					if (!empty($output)) return $output;
				}
				return NULL;
			} else {
				if (!empty($this->inputChain[$input])) return $this->inputChain[$input]->getData($field, $sanitize);
				else return NULL;
			}
		}
		
	}
	
?>