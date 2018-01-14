<?php namespace Model;

class Npc extends \core\DB{
	public $table='npc';

	public function format($dataArray){
		$npcKind=cat('npcKind');
		$mapList=cat('map');

	    $avatarDir=config('avatar','npc');

		foreach ($dataArray as $key => $Array) {

			$dataArray[$key]['avatar']=\core\Common::httpAvatar($Array['avatar'],$avatarDir);

			$dataArray[$key]['kind']=\core\Common::catid2name($npcKind,$Array['kindid']);

			$dataArray[$key]['map']=\core\Common::catid2name($mapList,$Array['mapid']);

			$dataArray[$key]['tabOfferList']=$this->npcTabOfferList($key);
		}

  		return $dataArray;
	}

	public function npcTabOfferList($npcid){
		$tabConfig=config('tabConfig');

		foreach($tabConfig as $tab => $text) {

			$List[$tab]=$this->select('npc_offer',[
		    	"[>]$tab" => ['itemid'=>'itemid'],
			],[
				'id','qty','fqcy','style',
				$tab.'.itemid','name','avatar',
			],[
				'AND'=>['npcid'=>$npcid,'tab'=>$tab,'npc_offer.state'=>true,$tab.'.state'=>true],
				'ORDER'=>['npc_offer.seq'=>'DESC'],
			]);
		}

		return $List;
	}

}