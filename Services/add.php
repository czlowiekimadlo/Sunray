<?PHP

	/***
	
	Project 'Sunray'
	
	Author: Wojciech 'Quak' Chojnacki
	E-mail: quak@tlen.pl
	Date:   14.02.2011
	File:   ./Services/add.php
	
	Description:
	
	create post service
	yep, it's 14/02 and I have nothing better to do
	
	
	
	***/
	
	define("SITE_ROOT", "./../");
	
	require_once(SITE_ROOT . "Frame/Sunframe.php");
	
	$frame->template->setTemplate("postform.html");
	$output = $frame->template->execute();
	
	$frame->finish(true, $output);
?>