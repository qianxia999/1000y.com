<?php namespace Ctrl;

class Equip extends \core\base{

	public function equip(){

		$this->view='cat';

		$this->catArray=cat($this->table);
	}

	public function List(){
		$this->kindid=get('kindid');
		$this->brandid=get('brandid');

		$L=new \core\Link('rank','ASC');
		$this->Url=$L->URL('rank','gongji');
		$COND=$L->COND();
		$COND['AND']['state']=1;
		unset($COND['LIMIT']);

	    $dataArray=$this->M->LIST($COND);
	    $dataArray=$this->M->format($dataArray);

	    return compact('dataArray');
	}

	public function Admin(){
		$this->kindid=get('kindid');
		$this->brandid=get('brandid');

		$L=new \core\Link();
		$this->Url=$L->URL('eid','sudu','gongji');
		$COND=$L->COND();

		$count=$this->M->count($this->table,$COND['AND']);
		$this->Paging=$L->PAGING($count);

		$dataArray=$this->M->LIST($COND);
	    $dataArray=$this->M->format($dataArray);

		return compact('dataArray');
	}

	public function avatarSubmit(){
		
	    $avatarDir=config('avatar','equip');

		$mk=post($this->primary);
		
		$_POST['avatar']=\core\Common::avatarUpload($avatarDir,$mk);

		$result=$this->M->SAVE($_POST);

		if($result) Go(); else msg('UPDATE_FAILD');
	}

	public function Edit(){

		$mk=get($this->primary) or msg('MK_NOT_EXIST');

		$this->Array=$this->M->ONE($mk);
	}

	public function insert(){
		#$catid=post('catid') or msg('CATEGORY_EMPTY',$url);

		$insertid=$this->M->INS($_POST);

		$url=url([$this->ctrl=>'Edit',$this->primary=>$insertid]);

		if($insertid) $this->Go($url); else msg('INSERT_FAILD');
	}

	public function update(){

		$result=$this->M->SAVE($_POST);

		if($result) msg('UPDATE_SUCCESS'); else msg('UPDATE_FAILD');
	}

	public function delete(){

		$result=$this->M->DEL($_GET);

		if($result) Go(); else msg('DELETE_FAILED');
	}
	/*	public function Add(){
		$this->catArray=cat($this->table);
	}*/
}
