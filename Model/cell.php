<?php namespace Model;

class Cell extends \core\DB{
	
	public function SourceList($catid){

		$COND['AND']['catid']=$catid;
		$COND['AND']['state']=true;/*1*/
		$COND['ORDER']['seq']='DESC';

		$M=new Source;

		$dataArray=$M->ITEM($COND);

		return $dataArray;
	}

	public function DocumentList($catid){

		$COND['AND']['catid']=$catid;
		$COND['AND']['state']=true;/*1*/
		$COND['ORDER']['seq']='DESC';

		$M=new Document;

		$dataArray=$M->ITEM($COND);

		return $dataArray;
	}

	public function AlbumList($catid){

		$COND['AND']['catid']=$catid;
		$COND['AND']['state']=true;/*1*/

		$M=new Album;

		$dataArray=$M->ITEM($COND);

		return $dataArray;
	}
}