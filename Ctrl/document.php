<?php namespace Ctrl;

class Document extends \core\base{

	public function document(){
		
		$this->catArray=cat($this->table);

		$this->view='cat';
	}

	public function List(){
		$this->catid=get('catid');
		$L=new \core\Link($this->primary);
		$COND=$L->COND();
		$COND['AND']['state']=1;

		$count=$this->M->count($this->table,$COND['AND']);
		$this->Paging=$L->PAGING($count);
		$this->dataArray=$this->M->LIST($COND);
		$this->dataArray=$this->M->format($this->dataArray);
		#dump($this->dataArray);exit;
	}

	public function Info(){

		$mk=get($this->primary) or msg('MK_NOT_EXIST');

		$this->Array=$this->M->ONE($mk);
	}

	public function Admin(){
		$L=new \core\Link;
		$this->Url=$L->URL('time','userid','state');
		$COND=$L->COND();

		$count=$this->M->count($this->table,$COND['AND']);
		$this->Paging=$L->PAGING($count);

		$this->dataArray=$this->M->LIST($COND);
	}

	public function Add(){

		$this->catArray=cat($this->table);
	}

	public function insert(){
		$title=post('title') or msg('TITLE_EMPTY');
		$catid=post('catid') or msg('CATEGORY_EMPTY');

		$insertid=$this->M->INS($_POST);
		
		$url=$this->url([$this->ctrl=>'Edit',$this->primary=>$insertid]);

		if($insertid) msg('INSERT_SUCCESS',$url); else msg('INSERT_FAILD');
	}

	public function Edit(){

		$this->catArray=cat($this->table);

		$mk=get($this->primary) or msg('MK_NOT_EXIST');

		$this->Array=$this->M->ONE($mk);
	}

	public function update(){

		$result=$this->M->SAVE($_POST);

		if($result) msg('UPDATE_SUCCESS','?document'); else msg('UPDATE_FAILD');
	}

	public function delete(){

		$result=$this->M->DEL($_GET);
		
		if($result) Go(); else msg('DELETE_FAILED');
	}
}