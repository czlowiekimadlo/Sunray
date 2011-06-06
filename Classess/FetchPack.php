<?PHP

	/***
	
	Project 'Sunray'
	
	Author: Wojciech 'Quak' Chojnacki
	E-mail: quak@tlen.pl
	Date:   12.02.2011
	File:   ./Classess/FetchPack.php
	
	Description:
	
	posts package
	
	
	
	***/

	//check security constant
	if(!defined("SUNFRAME_SECURITY")) exit;
	
	
	class FetchPack
	{
		var $posts = NULL;
		var $id = 0;
		var $limit = 0;
		var $amount = 0;
		var $last = 0;
		
		function FetchPack()
		{
			global $frame;
			$this->limit = POSTS_PER_FETCH;
			
		}
		
		function fetch()
		{
			global $frame;
			
			$fields = NULL;
			$condition = NULL;
			$sort = NULL;
			$limit = NULL;
			
			$frame->database->registerTable('posts');
			
			$fields[] = new SunFrameQueryField('id');
			$fields[] = new SunFrameQueryField('title');
			
			if ($this->id > 0) $condition = new SunFrameQueryField('id', SUNFRAME_NUMBER, NULL, $this->id, SUNFRAME_COMPARE_LESSER);
			
			$sort = new SunFrameQueryField('id', SUNFRAME_NUMBER, SUNFRAME_DESC);
			
			$limit = new SunFrameQueryLimit($this->limit, 0);
			
			$data = $frame->database->tables['posts']->getData($fields, $condition, $sort, $limit);
			
			if (!empty($data))
			{
				foreach ($data as $row)
				{
					$post = new PostHeader();
					$post->parseRow($row);
					
					$this->posts[] = $post;
				}
			}
			
			$this->amount = count($this->posts);
			if (!empty($this->posts[$this->amount - 1])) $this->last = $this->posts[$this->amount - 1]->id;
			
		}
	}
	
?>