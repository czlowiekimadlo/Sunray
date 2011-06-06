<?PHP

	/***
	
	Project 'Sunray'
	
	Author: Wojciech 'Quak' Chojnacki
	E-mail: quak@tlen.pl
	Date:   20.07.2010
	File:   ./Frame/DBConfig.php
	
	Description:
	
	configuration for database connection
	
	
	
	***/

	//check security constant
	if(!defined("SUNFRAME_SECURITY")) exit;
	
	$dbinfo['host'] = "localhost";
	$dbinfo['name'] = "quak";
	$dbinfo['user'] = "quak";
	$dbinfo['pass'] = "zawidz64";
	$dbinfo['prefix'] = "phs_";
	
?>