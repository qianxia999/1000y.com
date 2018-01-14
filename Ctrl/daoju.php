<?php namespace Ctrl;

class Daoju extends \core\base{

	public function daoju(){

		$this->view='cat';

		$this->catArray=cat($this->table);
	}

	public function List(){
		$this->kindid=get('kindid');
		$this->mapid=get('mapid');

		$L=new \core\Link();
		$this->Url=$L->URL('sudu','gongji');
		$COND=$L->COND();

	    $dataArray=$this->M->LIST($COND);
	    $dataArray=$this->M->format($dataArray);

	    return compact('dataArray');
	}

	public function Admin(){
		$this->mapid=get('mapid');

		$L=new \core\Link();
		$this->Url=$L->URL();
		$COND=$L->COND();

		$count=$this->M->count($this->table,$COND['AND']);
		$this->Paging=$L->PAGING($count);

		$dataArray=$this->M->LIST($COND);
	    $dataArray=$this->M->format($dataArray);

	    return compact('dataArray');
	}

	public function avatarSubmit(){

	    $avatarDir=config('avatar','daoju');

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

		if(isset($_FILES['avatar']['size'])){

			global $daojuAvatar;

			$mk=post($this->primary);

			$_POST['avatar']=\core\Common::avatarUpload($daojuAvatar,$mk);
		}

		$result=$this->M->SAVE($_POST);

		#$url=$this->url([$this->ctrl=>'Admin']);

		if($result) msg('UPDATE_SUCCESS'); else msg('UPDATE_FAILD');
	}

	public function delete(){

		$result=$this->M->DEL($_GET);
		
		if($result) Go(); else msg('DELETE_FAILED');
	}
}