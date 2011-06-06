<?PHP

	/***
	
	Project 'Sunray'
	
	Author: Wojciech 'Quak' Chojnacki
	E-mail: quak@tlen.pl
	Date:   25.07.2010
	File:   ./Frame/classes/SunFrameUser.php
	
	Description:
	
	user information class
	
	
	
	***/

	//check security constant
	if(!defined("SUNFRAME_SECURITY")) exit;
	
	
	class SunFrameUser
	{
		var $id = NULL;
		var $data = NULL;
		var $groups = NULL;
		var $configuration = NULL;
		var $login = NULL;
		var $email = NULL;
		
		function SunFrameUser($userID = 0)
		{
			$this->id = $userID;
		}
		
		function initUser($database)
		{
			$condition = new SunFrameQueryField('id', SUNFRAME_NUMBER, NULL, $this->id, SUNFRAME_COMPARE_EQUAL);
			
			$database->registerTable('users');
			
			$userData = $database->tables['users']->getData(NULL, $condition);
			
			$this->data = $userData[0]->data;
			
			$this->configuration = new SunFrameUserConfiguration();
			
			$this->login = $userData[0]->data['login'];
			$this->email = $userData[0]->data['email'];
		}
		
		function getGroups()
		{
			
		}
		
	}
	
?>