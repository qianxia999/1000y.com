<?php namespace Model;

class Daoju extends \core\DB{
	public $table='item_daoju';

	public function gets($mk){
	    $avatarDir=config('avatar','daoju');

		$Array=$this->ONE($mk);

   		$Array['avatar'] = \core\Common::httpAvatar($Array['avatar'],$avatarDir);

   		return $Array;
	}

	public function format($dataArray){
		$mapList=cat('map');
	    $avatarDir=config('avatar','daoju');
		#$daojuKind=cat('daojuKind');

   		foreach ($dataArray as $key => $Array) {

   			$dataArray[$key]['worth'] = $Array['worth'] ? $Array['worth'] : '';

   			$dataArray[$key]['avatar'] = \core\Common::httpAvatar($Array['avatar'],$avatarDir);

   			#$dataArray[$key]['cat']=\core\Common::catid2name($daojuKind,$Array['catid']);
   		}

   		return $dataArray;
	}
}