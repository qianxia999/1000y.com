<?php namespace Model;

class Home extends \core\DB{

	public function Source($catid){

		$COND['AND']['catid']=$catid;
		$COND['AND']['state']=true;/*1*/
		$COND['ORDER']['seq']='DESC';

		$M=new Source;

		$dataArray=$M->ITEM($COND);

		return $dataArray;
	}
}