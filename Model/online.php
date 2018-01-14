<?php namespace Model;

class Online extends \core\DB{
	public $table='online';

	public function onlineCount(){

		$onlineTime=\core\Conf::get('onlineTime','common');

		$count=$this->count($this->table,[
			'lasttime[>]'=>TIME-$onlineTime
		]);

		return $count;
	}

	public function userList($COND){
		$onlineTime=\core\Conf::get('onlineTime','common');

		$COND['AND']['lasttime[>]']=TIME-$onlineTime;

		$count=$this->count($this->table,@$COND['AND']);

		$paging=paging($count);

		$COND['LIMIT']=[$paging['keystart'],$paging['pagesize']];

		$dataArray=$this->select($this->table,[
			'userid','lasttime','page'
		],
			$COND
		);

		return [$dataArray,$paging];
	}
}