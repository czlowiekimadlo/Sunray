<?PHP

	/***
	
	Project 'Sunray'
	
	Author: Wojciech 'Quak' Chojnacki
	E-mail: quak@tlen.pl
	Date:   20.07.2010
	File:   ./Frame/classes/SunFrame.php
	
	Description:
	
	session handling functions
	
	
	
	***/

	//check security constant
	if(!defined("SUNFRAME_SECURITY")) exit;
		
	function open_session() {
		return true;
	}
	
	function close_session() {
		return true;
	}
	
	function read_session($sid) {
		global $frame;
		
		$frame->database->registerTable('session');
		
		$field = new SunFrameQueryField('data');
		$condition = new SunFrameQueryField('id', SUNFRAME_TEXT, NULL, $sid, SUNFRAME_COMPARE_EQUAL);
		
		$data = $frame->database->tables['session']->getData($field, $condition);
		
		if ($data == NULL || $data == false)
		{
			return "";
		}
		else
		{
			$array[0] = $data[0]->data['data'];
			list($session) = $array;
			return $session;
		}

		
	}
	
	
	function write_session($sid, $data) {
		global $frame;
		
		$frame->database->registerTable('session');
		
		
		$field = new SunFrameQueryField('data');
		$condition = new SunFrameQueryField('id', SUNFRAME_TEXT, NULL, $sid, SUNFRAME_COMPARE_EQUAL);
		
		$result = $frame->database->tables['session']->getData($field, $condition);
		if (!$result)
		{
			$fields[] = new SunFrameQueryField('data', SUNFRAME_TEXT, NULL, $data);
			$fields[] = new SunFrameQueryField('id', SUNFRAME_TEXT, NULL, $sid);
			
			$frame->database->tables['session']->insertData($fields);
		}
		else
		{
			$field = new SunFrameQueryField('data', SUNFRAME_TEXT, NULL, $data);
			$condition = new SunFrameQueryField('id', SUNFRAME_TEXT, NULL, $sid, SUNFRAME_COMPARE_EQUAL);
			
			$frame->database->tables['session']->updateData($field, $condition);
		} 
		
		return $frame->database->tables['session']->dbaccess->affected_rows();
	}
	
	function destroy_session($sid) {
		global $frame;
		
		$frame->database->registerTable('session');
		
		$condition = new SunFrameQueryField('id', SUNFRAME_TEXT, NULL, $sid, SUNFRAME_COMPARE_EQUAL);
		
		$frame->database->tables['session']->deleteData($condition);
		
		$_SESSION = array();
		return $frame->database->tables['session']->dbaccess->affected_rows();
	}
	
	function clean_session($exp) {
		global $frame;
		
		$query = sprintf('delete from ' . $frame->database->prefix . 'session where date_add(access interval %d seconds) < now()', (int)$exp);
		$resource = $frame->database->query($query);
		
		return $frame->database->dbaccess->affectedRows();
	}
	
	if (SUNFRAME_DEFAULT_DB_SESSION && !SUNFRAME_DEBUG) session_set_save_handler('open_session', 'close_session', 'read_session', 'write_session', 'destroy_session', 'clean_session');
	
	
	session_start();
	$frame->session = true;

	if( !isset($_SESSION['last_access']) || (time() - $_SESSION['last_access']) > 60 ) $_SESSION['last_access'] = time(); 
	
?>