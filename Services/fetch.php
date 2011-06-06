<?PHP

	/***
	
	Project 'Sunray'
	
	Author: Wojciech 'Quak' Chojnacki
	E-mail: quak@tlen.pl
	Date:   12.02.2011
	File:   ./Services/fetch.php
	
	Description:
	
	posts fetch service
	
	
	
	***/
	
	define("SITE_ROOT", "./../");
	
	require_once(SITE_ROOT . "Frame/Sunframe.php");
	
	$pack = new FetchPack();
	
	$pack->id = (int)$frame->input->getData('id');
	
	$pack->fetch();
	
	$frame->template->setTemplate("fetch.html");
	$frame->template->pack = $pack;
	$frame->template->user = $frame->user;
	$output = $frame->template->execute();
	
	$frame->finish(true, $output);
?>