<?php namespace Model;

class Magic extends \core\DB{
	public $table='item_magic';

	public function gets($mk){
	    $avatarDir=config('avatar','magic');

		$Array=$this->ONE($mk);

   		$Array['avatar'] = \core\Common::httpAvatar($Array['avatar'],$avatarDir);

   		return $Array;
	}

	public function format($dataArray){
		$magicKind=cat('magicKind');
		$magicCeng=cat('magicCeng');

	    $avatarDir=config('avatar','magic');

   		foreach ($dataArray as $key => $Array) {

   			if(!$Array['avatar']) {

	   			$categoryDir=config('avatar','category');

	   			$Cat=new \Model\Category;

	   			$CatAvatarField=$Cat->K2V('avatar',$Array['kindid']);

	   			$CatAvatarDefault = \core\Common::httpAvatar($CatAvatarField,$categoryDir);
	   		}

   			$dataArray[$key]['avatar'] = \core\Common::httpAvatar($Array['avatar'],$avatarDir,$CatAvatarDefault);

   			$dataArray[$key]['kind']=\core\Common::catid2name($magicKind,$Array['kindid']);

   			$dataArray[$key]['ceng']=\core\Common::catid2name($magicCeng,$Array['cengid']);
   		}

   		return $dataArray;
	}

/*	public function httpWugongAvatar($dataArray){
	    $wugongAvatar,$wugongDefault;

		foreach ($dataArray as $key => $Array) {

			if($Array['avatar']) $httpAvatar=ATTACH.'/'.$wugongAvatar.'/'. $Array['avatar'];
			
			else $httpAvatar=ATTACH.'/'.$wugongDefault;

			$dataArray[$key]['avatar']=$httpAvatar;
		}
		return $dataArray;
	}*/

}