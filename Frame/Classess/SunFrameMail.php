<?PHP

	/***
	
	Project 'Sunray'
	
	Author: Wojciech 'Quak' Chojnacki
	E-mail: quak@tlen.pl
	Date:   01.01.2011
	File:   ./Frame/Classess/SunFrameMail.php
	
	Description:
	
	mail class
	
	
	
	***/

	//check security constant
	if(!defined("SUNFRAME_SECURITY")) exit;

class SunFrameMail
{
	var $config;
	
	var $message, $subject, $addHeaders;
	var $adresses, $respond_to, $sender;
	var $useSMTP, $SMTP;
	var $template, $blocks;
	
	function SunFrameMail($config)
	{
		$this->reset();
		$this->config = $config;
		$this->useSMTP = $this->config->fields['smtp_use']->value;
		if ($this->useSMTP) $this->SMTP = new SunFrameMailSMTP($config);
		$this->respond_to = $this->sender = '';
	}
	
	function reset()
	{
		$this->adresses = array();
		$this->message = $this->addHeaders = '';
	}
	
	function check_email($email) {
		return ereg("^[a-z0-9_\\.-]+@([a-z0-9_-]+\\.)+[a-z]{2,}$", strtolower($email));	
	}
	
	function email($email)
	{
		$this->adresses['to'] = trim($email);
	}

	function cc($email)
	{
		$this->adresses['cc'][] = trim($email);
	}

	function bcc($email)
	{
		$this->adresses['bcc'][] = trim($email);
	}
	
	function respond($email)
	{
		$this->respond_to = trim($email);
	}

	function sender($email)
	{
		$this->sender = trim($email);
	}
	
	function set_subject($subject = '')
	{
		$this->subject = trim(preg_replace('#[\n\r]+#s', '', $subject));
	}
	
	function addHeaders($addHeaders)
	{
		$this->addHeaders .= trim($addHeaders) . "\n";
	}
	
	function load_template($file)
	{
		if(empty($this->template[$file]))
		{
			$templateFile = SITE_ROOT . "Templates/email_templates/" . $file;
						
			$fd = @fopen($templateFile, 'r');
			$this->template[$file] = fread($fd, filesize($templateFile));
			$this->template[$file] = htmlspecialchars(stripslashes($this->template[$file]));
			fclose($fd);
		}
		
		$this->message = $this->template[$file];

		return true;
		
	} // function load_template
	
	function assign_blocks($blocks)
	{
		if(is_array($blocks) && count($blocks) > 0)
		{
			unset($this->blocks);
			$this->blocks = $blocks;
		}
		
		return true;
		#$this->blocks = (empty($this->blocks)) ? $blocks : $this->blocks . $blocks;
	}
	
	function send()
	{
		
		$email = $this->config->fields['smtp_mail']->value;
		
		$this->message = str_replace ("'", "\'", $this->message);
		
		reset($this->blocks);
		
		while(list($block, $value) = each($this->blocks))
		{
			$formula = "#\{($block)\}#is";
			$this->message = preg_replace($formula, $value, $this->message);
		}
		
		$drop_header = '';
		$similarity = array();
		if (preg_match('#^(Subject:(.*?))$#m', $this->message, $drop_header))
		{
			$this->subject = (trim($similarity[2]) != '') ? trim($similarity[2]) : (($this->subject != '') ? $this->subject : "Unset");
			$drop_header .= '[\r\n]*?' . crash_preg_quote($similarity[1], '#');
		}
		else
		{
			$this->subject = (($this->subject != '') ? $this->subject : "Unset");
		}
		
		if (preg_match('#^(Charset:(.*?))$#m', $this->message, $similarity))
		{
			$this->encoding = (trim($similarity[2]) != '') ? trim($similarity[2]) : trim("UTF-8");
			$drop_header .= '[\r\n]*?' . crash_preg_quote($similarity[1], '#');
		}
		else
		{
			$this->encoding = trim("UTF-8");
		}
		
		if ($drop_header != '')
		{
			$this->message = trim(preg_replace('#' . $drop_header . '#s', '', $this->message));
		}
		
		$to = $this->adresses['to'];

		$cc = (count($this->adresses['cc'])) ? implode(', ', $this->adresses['cc']) : '';
		$bcc = (count($this->adresses['bcc'])) ? implode(', ', $this->adresses['bcc']) : '';
		
		$sender = (empty($this->sender)) ? $email : $this->sender;
		
		//$this->addHeaders = (($this->respond_to != '') ? "Reply-to: $this->respond_to\n" : '') . (($this->sender != '') ? "From: $this->sender\n" : "From: " . $sender . "\n") . "Return-Path: " . $email . "\nMessage-ID: <" . md5(uniqid(time())) . "@" . $email . ">\nMIME-Version: 1.0\nContent-type: text/plain; charset=" . $this->encoding . "\nContent-transfer-encoding: 8bit\nDate: " . date('r', time()) . "\nX-Priority: 3\nX-MSMail-Priority: Normal\nX-Mailer: PHP\nX-MimeOLE: Produced By Sunray\n" . $this->addHeaders . (($cc != '') ? "Cc: $cc\n" : '')  . (($bcc != '') ? "Bcc: $bcc\n" : ''); 
		$this->addHeaders = "From: $this->sender\nReturn-Path: " . $email; 
		
		if($this->useSMTP)
		{
			$result = $this->SMTP->send($to, $this->subject, $this->message, $this->sender, $this->addHeaders);
			//$result = $this->SMTP->send_old($to, $this->subject, $this->message, $this->sender, $this->addHeaders);
		}
		else
		{
			$empty_to = ($to == '') ? true : false;
			$to = ($to == '') ? 'Undisclosed-recipients:;' : $to;
			
			$result = mail($to, $this->subject, preg_replace("#(?<!\r)\n#s", "\n", $this->message), $this->addHeaders);
		}
		
		return $result;
	}

} // class poczta

?>