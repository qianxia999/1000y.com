<?php namespace Ctrl;

class Npc extends \core\base{

	public function npc(){

		$this->view='cat';

		$this->catArray=cat($this->table);
	}

	public function List(){
		$this->kindid=get('kindid');
		$this->mapid=get('mapid');

		$L=new \core\Link();
		$this->Url=$L->URL($this->primary,'name');
		$COND=$L->COND();unset($COND['LIMIT']);

		$count=$this->M->count($this->table,$COND['AND']);
		$this->Paging=$L->PAGING($count);

		$dataArray=$this->M->LIST($COND);
	    $dataArray=$this->M->format($dataArray);

		return compact('dataArray');
	}

	public function Admin(){
		$this->kindid=get('kindid');
		$this->mapid=get('mapid');

		$L=new \core\Link();
		$this->Url=$L->URL($this->primary,'name','mapid','kindid','seq');
		$COND=$L->COND();

		$count=$this->M->count($this->table,$COND['AND']);
		$this->Paging=$L->PAGING($count);

		$dataArray=$this->M->LIST($COND);
	    $dataArray=$this->M->format($dataArray);

		return compact('dataArray');
	}

	public function avatarSubmit(){

	    $avatarDir=config('avatar','npc');

		$mk=post($this->primary);
		
		$_POST['avatar']=\core\Common::avatarUpload($avatarDir,$mk);

		$result=$this->M->SAVE($_POST);

		if($result) Go(); else msg('UPDATE_FAILD');
	}

	public function Edit(){
		$this->kindid=get('kindid');
		$this->mapid=get('mapid');

		$mk=get($this->primary) or msg('MK_NOT_EXIST');

		$this->Array=$this->M->ONE($mk);
	}

	public function insert(){
		
		$insertid=$this->M->INS($_POST);

		$url=url([$this->ctrl=>'Edit',$this->primary=>$insertid]);

		if($insertid) $this->Go($url); else msg('INSERT_FAILD');
	}

	public function update(){

		$mapid=post('mapid') or msg('CATEGORY_EMPTY',"?$this->ctrl");

		$result=$this->M->SAVE($_POST);

		$url=url([$this->ctrl=>'Admin','mapid'=>$mapid]);

		if($result) msg('UPDATE_SUCCESS',$url); else msg('UPDATE_FAILD');
	}

	public function delete(){

		$result=$this->M->DEL($_GET);

		if($result) Go(); else msg('DELETE_FAILED');
	}
}
