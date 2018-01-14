<?php namespace Model;

class Album extends \core\DB{
	public $table='album';

	public function format($dataArray){
		$avatarDir=config('avatar','album');

   		foreach ($dataArray as $key => $Array) {

   			$dataArray[$key]['avatar'] = \core\Common::httpAvatar($Array['avatar'],$avatarDir);
   		}

   		return $dataArray;
	}
	
}