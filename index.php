<?PHP

	/***
	
	Project 'Sunray'
	
	Author: Wojciech 'Quak' Chojnacki
	E-mail: quak@tlen.pl
	Date:   20.07.2010
	File:   ./index.php
	
	Description:
	
	home page file
	
	
	
	***/
	
	define("SITE_ROOT", "./");
	
	require_once(SITE_ROOT . "Frame/Sunframe.php");
	
	$page = new Page();
	
	$frame->template->setTemplate("index.html");
	$frame->template->page = $page;
	$frame->template->user = $frame->user;
	$frame->template->locale = $frame->locale;
	
	$frame->finish(true, $frame->template->execute());
?>