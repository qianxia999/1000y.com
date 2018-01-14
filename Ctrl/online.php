<?php namespace Ctrl;

class Online extends \core\base{

	public function online(){
		global $M;

		$L=new \core\Link;
		$COND['ORDER']=$L->order('lasttime');
		$Link=$L->setlink();

	    LIST($dataArray,$paging)=$M->userList($COND);

	    $AllCount=$M->onlineCount();

		return compact('dataArray','paging','Link','AllCount');
	}
}