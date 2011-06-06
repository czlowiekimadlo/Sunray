<?PHP

	/***
	
	Project 'Sunray'
	
	Author: Wojciech 'Quak' Chojnacki
	E-mail: quak@tlen.pl
	Date:   20.07.2010
	File:   ./Frame/sunframe.php
	
	Description:
	
	main framework file
	
	
	
	***/
	
	require_once(SITE_ROOT . "Frame/Sunconst.php");
	require_once(SITE_ROOT . "Frame/BasicFunctions.php");
	require_once(SITE_ROOT . "Frame/DBConfig.php");
	require_once(SITE_ROOT . "Frame/PHPTAL/PHPTAL.php");
	
	$frame = new SunFrame($dbinfo); unset($dbinfo);
	
	if (SUNFRAME_DEBUG) 
	{
		$frame->log->log("Frame initiated. Loading session...\r\n" . print_r($frame, true));
	}
	
	require_once(SITE_ROOT . "Frame/Session.php");
	require_once(SITE_ROOT . "Frame/Constants.php");
	
	$frame->initUser();
	
?>