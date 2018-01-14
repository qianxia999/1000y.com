<?php namespace Model;

class Equip extends \core\DB{
	public $table='item_equip';

	public function format($dataArray){
      $rankConfig=config('rank');
      $equipKind=cat('equipKind');
      $equipBrand=cat('equipBrand');
      $avatarDir=config('avatar','equip');

   	foreach ($dataArray as $key => $Array) {

         $dataArray[$key]['avatar']=\core\Common::httpAvatar($Array['avatar'],$avatarDir);

         $dataArray[$key]['kind']=\core\Common::catid2name($equipKind,$Array['kindid']);

         $dataArray[$key]['brand']=\core\Common::catid2name($equipBrand,$Array['brandid']);

         $dataArray[$key]['rank']=$rankConfig[$Array['rank']] ?? null;
   	}

   	return $dataArray;
	}
}