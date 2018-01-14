<?php namespace Model;

class Item extends \core\DB{
	public $table='item';

	public function format($dataArray){


   		foreach ($dataArray as $key => $Array) {

   			$dataArray[$key]['avatar'] = \core\Common::httpAvatar($Array['avatar'],$equipAvatar);
   		}

   		return $dataArray;
	}
}