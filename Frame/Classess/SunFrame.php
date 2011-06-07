<?PHP

	/***
	
	Project 'Sunray'
	
	Author: Wojciech 'Quak' Chojnacki
	E-mail: quak@tlen.pl
	Date:   20.07.2010
	File:   ./Frame/classes/SunFrame.php
	
	Description:
	
	configuration for database connection
	
	
	
	***/

	//check security constant
	if(!defined("SUNFRAME_SECURITY")) exit;
	
	
	
	class SunFrame {
		
		var $database = NULL;
		var $configuration = NULL;
		var $user = NULL;
		var $input = NULL;
		var $template = NULL;
		var $session = false;
		var $mail = NULL;
		var $closed = false;
		var $log = NULL;
		var $locale = NULL;
		
		function SunFrame($dbinfo = NULL)
		{
			if (!empty($dbinfo)) $this->initFrame($dbinfo);
		}
		
		
		
		function connectDatabase($dbinfo)
		{
			$this->database = new SunFrameDatabase($dbinfo);
		}
		
		function initConfiguration()
		{
			$this->configuration = new SunFrameConfiguration($this->database);
			
			
		}
		
		//must be initiated after initFrame()
		function initUser($userID = SUNFRAME_GUEST_USER)
		{
			if (!empty($_SESSION['user']))
			{
				$this->user = $_SESSION['user'];
			} else {
				$this->user = new SunFrameUser($userID);
			}
			
			if (!empty($this->user->configuration->locale) && $this->user->configuration->locale != $this->locale->localeTag && !$this->locale->switched) 
			{
				if (SUNFRAME_DEBUG) 
				{
					echo $this->user->configuration->locale . " != " . $this->locale->localeTag;
					$this->log->log($this->user->configuration->locale . " != " . $this->locale->localeTag);
				}
				$this->locale->loadLocale($this->user->configuration->locale);
				echo "switching";
			}
		}
		
		function initInput()
		{
			$this->input = new SunFrameInput();
		}
		
		function initTemplate()
		{
			$this->template = new PHPTAL();
			$this->template->setOutputMode(PHPTAL::HTML5);
			$this->template->setPhpCodeDestination(SITE_ROOT . SUNFRAME_TEMPLATE_TMP);
			
			$templateName = (empty($this->configuration->fields['template']->value)) ? SUNFRAME_DEFAULT_TEMPLATE : $this->configuration->fields['template']->value;
			$this->template->setTemplateRepository(SITE_ROOT . SUNFRAME_DEFAULT_REPOSITORY . $templateName);
			$this->template->setPostFilter(new SunFrameClearLinesFilter());
		}
		
		//mail must be initiated after configuration
		function initMail()
		{
			$this->mail = new SunFrameMail($this->configuration);
		}
		
		function initLog()
		{
			if (SUNFRAME_DEBUG) $this->log = new SunFrameLog(SUNFRAME_DEBUG_LOG);
		}
		
		// locale must be initiated after input and configuration
		function initLocale()
		{
			$locale = $this->input->getData("locale");
			$switched = true;
			if (empty($locale)) 
			{
				$locale = $this->configuration->fields['locale']->value;
				$switched = false;
			}
			
			$this->locale = new SunFrameLocale($locale);
			$this->locale->switched = $switched;
			//$_SESSION["locale"] = $this->locale->localeTag;
			setcookie("locale", $this->locale->localeTag);
		}
		
		function initFrame($dbinfo)
		{
			$this->initLog();
			$this->connectDatabase($dbinfo);
			$this->initConfiguration();
			$this->initInput();
			$this->initLocale();
			$this->initMail();
			$this->initTemplate();
		}
		
		function finish($exit = true, $output = NULL)
		{
			if ($this->closed) return;
			$this->closed = true;
			
			if ($this->session)
			{
				$_SESSION['user'] = $this->user;
				session_write_close();
			}
			
			if (!empty($this->log))$this->log->close();
			
			if (!empty($output)) echo $output;
			if ($exit) exit();
		}
		
		function __destruct ()
		{
			$this->finish();	
		}
		
		function redirect($link = NULL)
		{
			if (empty($link)) $link = new SunFrameLink(SITE_ROOT);
			$url = $link->generateURL();
			$this->finish(false);
			header("Location: " . $url);
			exit();
		}
		
		
	}
?>