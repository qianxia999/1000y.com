<?php namespace Model;

class Document extends \core\DB{
	public $table='document';

	public function format($dataArray){
		$catArray=cat($this->table);

		foreach ($dataArray as $key => $Array) {

            $dataArray[$key]['time']=date("m/d",$Array['updateTime']);
            $dataArray[$key]['cat']=$catArray[$Array['catid']]['name'] ?? null;

		}

   		return $dataArray;
	}

	public function ITEM($COND){

		$dataArray=$this->select($this->table,[
			'did','catid','title','style','updateTime'
		],$COND);

		$dataArray=$this->format($dataArray);

		return $dataArray;
	}

}