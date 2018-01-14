<?php namespace Model;

class Offer extends \core\DB{
	public $table='npc_offer';

	public function getItemidByName($tab,$name){
		return $this->get($tab,'itemid',[
			'name'=>$name
		]);
	}

	public function tabOfferListAdmin($npcid){
		$tabConfig=config('tabConfig');

		foreach($tabConfig as $tab => $text) {

			$tabOfferList[$tab]=$this->select('npc_offer',[
			    "[>]$tab" => ['itemid'=>'itemid'],
			],[
				'id','npcid','tab','qty','fqcy','style','npc_offer.seq','npc_offer.state',
				$tab.'.itemid','name','avatar',
			],[
				'AND'=>['npcid'=>$npcid,'tab'=>$tab],
				'ORDER'=>['npc_offer.seq'=>'DESC'],
			]);
		}

		return $tabOfferList;
	}

	public function OfferListTab($mapid){#区分tab
		$avatarDir=config('avatar','npc');

		$npcList = $this->select('npc',[
			'npcid','name','avatar',
		],[
			'AND'=>['mapid'=>$mapid,'state'=>true],
			'ORDER'=>['seq'=>'DESC'],
		]);

		foreach ($npcList as $npcid => $Array) {

			$npcList[$npcid]['avatar']=\core\Common::httpAvatar($Array['avatar'],$avatarDir);

			$npcList[$npcid]['tabOfferList']=$this->npcTabOfferList($npcid);
		}

		return $npcList;
	}

	public function npcTabOfferList($npcid){
		$tabConfig=config('tabConfig');

		foreach($tabConfig as $tab => $text) {

			$List[$tab]=$this->select($this->table,[
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

	public function OfferListAll($mapid){#不区分tab
		$avatarDir=config('avatar','npc');

		$npcList = $this->select('npc',[
			'npcid','name','avatar',
		],[
			'AND'=>['mapid'=>$mapid,'state'=>true],
			'ORDER'=>['seq'=>'DESC'],
		]);

		foreach ($npcList as $npcid => $Array) {

			$npcList[$npcid]['avatar']=\core\Common::httpAvatar($Array['avatar'],$avatarDir);

			$OfferList=$this->select($this->table,[
				'id','npcid','tab','itemid','qty','fqcy','style',
			],[
				'AND'=>['npcid'=>$npcid,'state'=>true],
				'ORDER'=>['seq'=>'DESC'],
			]);

			foreach ($OfferList as $id => $List) {
				$OfferList[$id]['itemName']=$this->get($List['tab'],'name',[
					'itemid'=>$List['itemid']
				]);
			}

			$npcList[$npcid]['OfferList']=$OfferList;
		}

		return $npcList;
	}
}