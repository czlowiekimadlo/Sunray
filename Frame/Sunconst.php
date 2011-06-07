<?PHP

	/***
	
	Project 'Sunray'
	
	Author: Wojciech 'Quak' Chojnacki
	E-mail: quak@tlen.pl
	Date:   05.01.2011
	File:   ./Frame/sunconst.php
	
	Description:
	
	sunframe constants declarations
	
	***/

	//set security constant
	define("SUNFRAME_SECURITY", true);
	
	
	
	/*
		CONFIGURATION
	*/
	define("SUNFRAME_DEBUG", 					false);
	define("SUNFRAME_DEBUG_LOG", 				SITE_ROOT . "debug.log");
	
	define("SUNFRAME_MAIN_CONFIG", 				0);
	define("SUNFRAME_DEFAULT_DB_SESSION", 		false);
	define("SUNFRAME_DEFAULT_TITLE_SEPARATOR", 	" - ");
	define("SUNFRAME_DEFAULT_TEMPLATE", 		"default");
	define("SUNFRAME_DEFAULT_LANG", 			"en");
	define("SUNFRAME_DEFAULT_REPOSITORY", 		"Templates/");
	define("SUNFRAME_TEMPLATE_TMP", 			"tmp/");
	
	
	/*
		USERS
	*/
	
	define("SUNFRAME_GUEST_USER", 0);
	
	
	
	/*
		DATABASE
	*/
	define("SUNFRAME_NUMBER", 0);
	define("SUNFRAME_TEXT", 1);
	
	define("SUNFRAME_ASC", 0);
	define("SUNFRAME_DESC", 1);
	
	define("SUNFRAME_COMPARE_EQUAL", 0);
	define("SUNFRAME_COMPARE_GREATER", 1);
	define("SUNFRAME_COMPARE_LESSER", 2);

	/*
		INPUT
	*/
	
	define("SUNFRAME_INPUT_ALL", 0);
	define("SUNFRAME_INPUT_GET", 1);
	define("SUNFRAME_INPUT_POST", 2);
	define("SUNFRAME_INPUT_COOKIE", 3);
	define("SUNFRAME_INPUT_SESSION", 4);
	


?>