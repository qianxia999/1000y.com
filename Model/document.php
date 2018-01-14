<?php namespace Model;

class Document extends \core\DB{
	public $table='document';

	public function format($dataArray){
		$catArray=cat($this->table);

		foreach ($dataArray as $key => $Array) {

            $dataArray[$key]['cat']=$catArray[$Array['catid']]['name'] ?? null;

		}

   		return $dataArray;
	}

	public function ITEM($COND){

		$dataArray=$this->select($this->table,[
			'did','catid','title(name)','style'
		],$COND);

		return $dataArray;
	}

}