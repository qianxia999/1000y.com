<?php namespace Ctrl;

class Item extends \core\base{

	public function item(){

		$this->view='cat';

		$this->catArray=cat($this->table);
	}

	public function List(){
		#$this->kindid=get('kindid') ?? current(array_keys($this->wugongKind));
		$this->kindid=get('kindid');

		$L=new \core\Link('sudu');
		$this->Url=$L->URL('sudu','huifu','shanduo','gongji','fangyu');
		$COND=$L->COND();

	    $dataArray=$this->M->LIST($COND);
	    $dataArray=$this->M->format($dataArray);
	    return compact('dataArray');
	}

	public function Admin(){
		$L=new \core\Link();
		$this->Url=$L->URL();
		$COND=$L->COND();

		$count=$this->M->count($this->table,$COND['AND']);
		$this->Paging=$L->PAGING($count);

		$dataArray=$this->M->LIST($COND);
	    $dataArray=$this->M->format($dataArray);

		$this->catid=get('catid');

		return compact('dataArray');
	}

	public function avatarSubmit(){

		if($_FILES['avatar']['size']){

			global $equipAvatar;

			$mk=post($this->primary);

			$_POST['avatar']=\core\Common::avatarUpload($equipAvatar,$mk);
		}

		$result=$this->M->SAVE($_POST);

		if($result) Go(); else msg('UPDATE_FAILD');
	}

	public function Edit(){

		$this->kindArray=cat('kind');

		$this->catArray=cat($this->table);

		$mk=get($this->primary) or msg('MK_NOT_EXIST');

		$this->Array=$this->M->ONE($mk);
	}

	public function insert(){

		$url=url([$this->ctrl=>'Edit',$this->primary=>$insertid]);

		$catid=post('catid') or msg('CATEGORY_EMPTY',$url);

		$insertid=$this->M->INS($_POST);

		if($insertid) Go(); else $this->msg('INSERT_FAILD');
	}

	public function update(){

		$catid=post('catid') or msg('CATEGORY_EMPTY',"?$this->ctrl");

		$result=$this->M->SAVE($_POST);

		$url=url([$this->ctrl=>'Admin','catid'=>$catid]);

		if($result) msg('UPDATE_SUCCESS',$url); else msg('UPDATE_FAILD');
	}

	public function delete(){

		$result=$this->M->DEL($_GET);

		if($result) Go(); else msg('DELETE_FAILED');
	}
/*	public function Add(){

		$this->catArray=cat($this->table);
	}*/
}
