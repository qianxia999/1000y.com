<?php namespace Model;

class Cell extends \core\DB{
	
	public function Source($catid){

		$COND['AND']['catid']=$catid;
		$COND['AND']['state']=true;/*1*/
		$COND['ORDER']['seq']='DESC';

		$M=new Source;

		$dataArray=$M->ITEM($COND);

		return $dataArray;
	}

	public function documentArray($catid){

		$COND['AND']['catid']=$catid;
		$COND['AND']['state']=true;/*1*/
		$COND['ORDER']['seq']='DESC';

		$M=new Document;

		$dataArray=$M->ITEM($COND);

		return $dataArray;
	}

	public function albumArray($catid){

		$COND['AND']['catid']=$catid;
		$COND['AND']['state']=true;/*1*/

		$M=new Album;

		$dataArray=$M->ITEM($COND);

		return $dataArray;

	}




}