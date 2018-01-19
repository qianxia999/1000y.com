<?php namespace Model;

class Source extends \core\DB{
	public $table='source';

	public function format($dataArray){
		$avatarDir=config('avatar','source');

   		foreach ($dataArray as $key => $Array) {

   			$dataArray[$key]['avatar'] = \core\Common::httpAvatar($Array['avatar'],$avatarDir);
   		}

   		return $dataArray;
	}

	public function ITEM($COND){

		$dataArray=$this->select($this->table,[
			'sid','catid','word','url','avatar','style',
		],$COND);

		$dataArray=$this->format($dataArray);

		return $dataArray;
	}

}