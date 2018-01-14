<?php namespace Model;

class Cell extends \core\DB{

	public function documentArray($catid){

		$COND['AND']['catid']=$catid;
		$COND['AND']['state']=true;/*1*/

		$M=new Document;

		$dataArray=$M->ITEM($COND);

		return $dataArray;
	}




}