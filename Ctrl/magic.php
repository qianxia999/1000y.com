<?php namespace Ctrl;

class Magic extends \core\base{

	public function magic(){

		$this->catArray=cat('magicKind');

		$this->view='cat';
	}

	public function Admin(){
		$this->kindid=get('kindid');
		$this->cengid=get('cengid');

		$L=new \core\Link();
		$this->Url=$L->URL($this->primary,'sudu','gongji');
		$COND=$L->COND();

		$count=$this->M->count($this->table,$COND['AND']);
		$this->Paging=$L->PAGING($count);

		$dataArray=$this->M->LIST($COND);
	    $dataArray=$this->M->format($dataArray);

	    return compact('dataArray');
	}

	public function List(){
		#$this->kindid=get('kindid') ?? current(array_keys($this->wugongKind));
		$this->kindid=get('kindid');

		$L=new \core\Link('sudu');
		$this->Url=$L->URL('sudu','huifu','shanduo','gongji','fangyu');
		$COND=$L->COND();
		$COND['AND']['state']=1;

	    $dataArray=$this->M->LIST($COND);
	    $dataArray=$this->M->format($dataArray);

	    return compact('dataArray');
	}

	public function avatarSubmit(){
	    $avatarDir=config('avatar','magic');

		$mk=post($this->primary);
		
		$_POST['avatar']=\core\Common::avatarUpload($avatarDir,$mk);

		$result=$this->M->SAVE($_POST);

		if($result) Go(); else msg('UPDATE_FAILD');
	}

	public function insert(){

		$insertid=$this->M->INS($_POST);
		
		$url=$this->url([$this->ctrl=>'Edit',$this->primary=>$insertid]);

		if($insertid) Go($url); else msg('INSERT_FAILD');
	}

	public function Edit(){

		$mk=get($this->primary) or msg('MK_NOT_EXIST');

		$this->Array=$this->M->gets($mk);
	}

	public function update(){
	    $avatarDir=config('avatar','magic');

		$mk=post($this->primary);
		$_POST['avatar']=\core\Common::avatarUpload($avatarDir,$mk);

		$result=$this->M->SAVE($_POST);

		$url=$this->url([$this->ctrl=>'Admin']);

		if($result) msg('UPDATE_SUCCESS',$url); else msg('UPDATE_FAILD');
	}

	public function delete(){

		$result=$this->M->DEL($_GET);
		
		if($result) Go(); else msg('DELETE_FAILED');
	}
}