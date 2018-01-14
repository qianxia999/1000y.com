<?php namespace Ctrl;

class Offer extends \core\base{

	public function offer(){
		$mapList=cat('map');

		foreach ($mapList as $mapid => $List) {
			$Offer[$mapid]=$this->M->OfferListTab($mapid);
		}

		return compact('Offer');
	}

	public function List(){
		$mapid=get('mapid');

		$OfferList=$this->M->OfferListTab($mapid);
		#dump($OfferList);exit;
		return compact('OfferList');
	}

	public function insert(){
		$itemname=post('itemname');
		$tab=post('tab');

		$itemid=$this->M->getItemidByName($tab,$itemname) or msg('ITEM_NOT_EXIST');

		$array=[
			'npcid'=>post('npcid'),
			'tab'=>$tab,
			'itemid'=>$itemid,
			'state'=>post('state'),
		];

		$insertid=$this->M->INS($array);

		if($insertid) $this->Go(); else msg('INSERT_FAILD');
	}

	public function Edit(){

		$npcid=get('npcid');

		$tabOfferList=$this->M->tabOfferListAdmin($npcid);#dump($tabOfferList);exit;
		
		return compact('tabOfferList');
	}

	public function delete(){

		$result=$this->M->DEL($_GET);

		if($result) Go(); else msg('DELETE_FAILED');
	}
}
