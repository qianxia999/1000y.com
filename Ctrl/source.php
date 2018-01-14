<?php namespace Ctrl;

class Source extends \core\base{

	public function source(){

		$this->catArray=cat($this->table);

		$this->view='cat';
	}

	public function Admin(){
		$L=new \core\Link;
		$this->Url=$L->URL('time','userid','state');
		$COND=$L->COND();

		$count=$this->M->count($this->table,$COND['AND']);
		$this->Paging=$L->PAGING($count);
		
		$dataArray=$this->M->LIST($COND);
		$dataArray=$this->M->format($dataArray);

		return compact('dataArray');
	}

	public function List(){
		$catid=get('catid') or msg('CATEGORY_EMPTY');
		$L=new \core\Link($this->primary);
		$this->Url=$L->URL('time','userid','state');
		$COND=$L->COND();
		$COND['AND']['state']=1;

		$count=$this->M->count($this->table,$COND['AND']);
		$this->Paging=$L->PAGING($count);

		$this->dataArray=$this->M->LIST($COND);
		$this->dataArray=$this->M->format($this->dataArray);
	}

	public function avatarSubmit(){
		$avatarDir=config('avatar','source');

		$mk=post($this->primary);
		$_POST['avatar']=\core\Common::avatarUpload($avatarDir,$mk);

		$result=$this->M->SAVE($_POST);

		if($result) Go(); else msg('UPDATE_FAILD');
	}

	public function insert(){
		$catid=post('catid') or msg('CATEGORY_EMPTY');

		$insertid=$this->M->INS($_POST);
		#$url=$this->url([$this->ctrl=>'Edit',$this->primary=>$insertid]);
		if($insertid) Go(); else msg('INSERT_FAILD');
	}

	public function delete(){

		$result=$this->M->DEL($_GET);
		
		if($result) Go(); else msg('DELETE_FAILED');
	}

}