<?PHP

	/***
	
	Project 'Sunray'
	
	Author: Wojciech 'Quak' Chojnacki
	E-mail: quak@tlen.pl
	Date:   01.01.2011
	File:   ./Frame/Classess/SunFrameMailSMTP.php
	
	Description:
	
	smtp class
	
	
	
	***/

	//check security constant
	if(!defined("SUNFRAME_SECURITY")) exit;

	@include_once("Mail.php");


	class SunFrameMailSMTP
	{
		var $config = NULL;
		
		function SunFrameMailSMTP ($config)
		{
			$this->config = $config;
		}
		
		function parse_server($socket, $return, $line = __LINE__) 
		{ 
			global $lang;
			
			while (substr($server_response, 3, 1) != ' ') 
			{
				if (!($server_response = fgets($socket, 256))) 
				{ 
					die("Fatal error parsing smtp server.");
					exit;
				} 
			} 
		
			if (!(substr($server_response, 0, 3) == $return) && SUNFRAME_DEBUG) 
			{ 
				die("Fatal error parsing smtp server. Answer: " . $server_response . " Expected: " . $odpowiedz . " Line: " . $linia);
				//exit;
			} 
		}
		
		
		
		
		function send($to, $subject, $message, $from = NULL, $addHeaders = NULL) {
			
			$headers["From"] = empty($from) ? $this->config->fields['smtp_mail']->value : $from;
			$headers["To"] = $to;
			$headers["Subject"] = $subject;
			
			$smtpinfo["host"] = $this->config->fields['smtp_host']->value;
			$smtpinfo["port"] = empty($this->config->fields['smtp_port']->value) ? 25 : $this->config->fields['smtp_port']->value;
			$smtpinfo["auth"] = true;
			$smtpinfo["username"] = $this->config->fields['smtp_user']->value;
			$smtpinfo["password"] = $this->config->fields['smtp_pass']->value;
			
			$mail_object =& Mail::factory("smtp", $smtpinfo);
			$mail_object->send($to, $headers, $message);
			
			return true;
		}
		
		
		function send_old($to, $subject, $message, $from = NULL, $addHeaders = NULL)
		{
			
			$email = (empty($from)) ? $this->config->fields['smtp_mail']->value : $from;
			$smtp_host = $this->config->fields['smtp_host']->value;
			$smtp_user = $this->config->fields['smtp_user']->value;
			$smtp_pass = $this->config->fields['smtp_pass']->value;
			
			$message = preg_replace("#(?<!\r)\n#si", "\r\n", $message);
			
			if ($addHeaders != '')
			{
				if (is_array($addHeaders))
				{
					if (sizeof($addHeaders) > 1)
					{
						$addHeaders = join("\n", $addHeaders);
					}
					else
					{
						$addHeaders = $addHeaders[0];
					}
				}
				$addHeaders = chop($addHeaders);
		
				$addHeaders = preg_replace('#(?<!\r)\n#si', "\r\n", $addHeaders);
		
				$header_array = explode("\r\n", $addHeaders);
				@reset($header_array);
		
				$addHeaders = '';
				while(list(, $header) = each($header_array))
				{
					if (preg_match('#^cc:#si', $header))
					{
						$cc = preg_replace('#^cc:(.*)#si', '\1', $header);
					}
					else if (preg_match('#^bcc:#si', $header))
					{
						$bcc = preg_replace('#^bcc:(.*)#si', '\1', $header);
						$header = '';
					}
					$addHeaders .= ($header != '') ? $header . "\r\n" : '';
				}
				
				$addHeaders = chop($addHeaders);
				$cc = explode(', ', $cc);
				$bcc = explode(', ', $bcc);
			}
			
			if (trim($subject) == '')
			{
			}
		
			if (trim($message) == '')
			{
			}
			
			$smtpPort = empty($this->config->fields['smtp_port']->value) ? 25 : $this->config->fields['smtp_port']->value;
			if( !$socket = @fsockopen($smtp_host, $smtpPort, $errno, $errstr, 20) )
			{
				die("Fatal error connecting smtp server.<br>" . $errno . " " . $errstr);
				exit;
			}
			
			$this->parse_server($socket, "220", __LINE__);
			
			if( !empty($smtp_user) && !empty($smtp_pass))
			{ 
				fputs($socket, "EHLO " . $smtp_host . "\r\n");
				$this->parse_server($socket, "250", __LINE__);
		
				fputs($gniazdo, "AUTH LOGIN\r\n");
				$this->parse_server($socket, "334", __LINE__);
		
				fputs($gniazdo, base64_encode($smtp_user) . "\r\n");
				$this->parse_server($socket, "334", __LINE__);
		
				fputs($gniazdo, base64_encode($smtp_pass) . "\r\n");
				$this->parse_server($socket, "235", __LINE__);
			}
			else
			{
				fputs($gniazdo, "HELO " . $smtp_host . "\r\n");
				$this->parse_server($socket, "250", __LINE__);
			}
			
			fputs($socket, "MAIL FROM: <" . $email . ">\r\n");
			$this->parse_server($socket, "250", __LINE__);
			
			$to_header = '';
			
			$do = (trim($do) == '') ? 'Undisclosed-recipients:;' : trim($to);
			if (preg_match('#[^ ]+\@[^ ]+#', $do))
			{
				fputs($socket, "RCPT TO: <$to>\r\n");
				$this->parse_server($socket, "250", __LINE__);
			}
			
			@reset($bcc);
			while(list(, $addresses_bcc) = each($bcc))
			{
				$addresses_bcc = trim($addresses_bcc);
				if (preg_match('#[^ ]+\@[^ ]+#', $addresses_bcc))
				{
					fputs($socket, "RCPT TO: <$addresses_bcc>\r\n");
					$this->parse_server($socket, "250", __LINE__);
				}
			}
		
			@reset($cc);
			while(list(, $addresses_cc) = each($cc))
			{
				$addresses_cc = trim($addresses_cc);
				if (preg_match('#[^ ]+\@[^ ]+#', $addresses_cc))
				{
					fputs($socket, "RCPT TO: <$addresses_cc>\r\n");
					$this->parse_server($socket, "250", __LINE__);
				}
			}
			
			fputs($socket, "DATA\r\n");
			$this->parse_server($socket, "354", __LINE__);
			
			fputs($socket, "Subject: $subject\r\n");
		
			fputs($socket, "To: $do\r\n");
		
			fputs($socket, "$addHeaders\r\n\r\n");
		
			fputs($socket, "$message\r\n");
		
			fputs($socket, ".\r\n");
			$this->parse_server($socket, "250", __LINE__);
			
			fputs($socket, "QUIT\r\n");
			fclose($socket);
		
			return TRUE;
		
		
		}
		
		
	}




?>