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

	public function DocumentList($catid=null,$max=null,$order=null){

		if($catid) $COND['AND']['catid']=$catid;

		$COND['AND']['state']=true;/*1*/

		$order = $order ?? 'seq';

		$COND['ORDER'][$order]='DESC';

		if($max) $COND['LIMIT'] = [0,$max];

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