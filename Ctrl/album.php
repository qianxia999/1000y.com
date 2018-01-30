<?php namespace Ctrl;

class Album extends \core\base{

	public function album(){

		$this->view='cat';

		$this->catArray=cat($this->table);
	}

	public function List(){
		$this->kindid=get('kindid');

		$L=new \core\Link();
		$this->Url=$L->URL();
		$COND=$L->COND();
		$COND['AND']['state']=1;

	    $dataArray=$this->M->LIST($COND);
	    $dataArray=$this->M->format($dataArray);
#dump($dataArray);exit;
	    return compact('dataArray');
	}

	public function Info(){

		$mk=get($this->primary) or msg('MK_NOT_EXIST');

		$Array=$this->M->ONE($mk);

		$Array['summary']=nl2br($Array['summary']);

	    $avatarDir=config('avatar','album');

		$photoList=\core\Common::photoList($avatarDir,$mk);#dump($photoList);exit;

		return compact('photoList','Array');
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
	    $avatarDir=config('avatar','album');

		$mk=post($this->primary);
		$_POST['avatar']=\core\Common::avatarUpload($avatarDir,$mk);

		$result=$this->M->SAVE($_POST);

		if($result) Go(); else msg('UPDATE_FAILD');
	}

	public function photoSubmit(){
	    $avatarDir=config('avatar','album');

		#获取上传目录ID
		$query=parse_url(REFERER,PHP_URL_QUERY);
		parse_str($query);
		$primary=$this->primary;
		$mk=$$primary;
		
		if(!$mk) msg('商品ID编号为空');

		$P=new \core\Photo;
		$uploadDIR=UPLOAD.'/'.$avatarDir.'/'.$mk.'/';

		$photo=$P->photoUpload($_FILES['file'],$uploadDIR);

		echo $photo;exit;
	}


	public function Edit(){

		$mk=get($this->primary) or msg('MK_NOT_EXIST');

		$this->Array=$this->M->ONE($mk);

	    $avatarDir=config('avatar','album');

		$photoList=\core\Common::photoList($avatarDir,$mk);#dump($photoList);exit;

		return compact('photoList');
	}

	public function insert(){

		$insertid=$this->M->INS($_POST);
		
		$url=$this->url([$this->ctrl=>'Edit',$this->primary=>$insertid]);

		if($insertid) Go($url); else msg('INSERT_FAILD');
	}

	public function update(){
		$_POST['time']=TIME;

		$catid=post('catid') or msg('CATEGORY_EMPTY',"?$this->ctrl");

		$result=$this->M->SAVE($_POST);

		$url=url([$this->ctrl=>'Admin','catid'=>$catid]);

		if($result) msg('UPDATE_SUCCESS',$url); else msg('UPDATE_FAILD');
	}

	public function delete(){

		$result=$this->M->DEL($_GET);

		if($result) Go(); else msg('DELETE_FAILED');
	}

	public function photoRemove(){
	    $avatarDir=config('avatar','album');

		$filename=get('filename');
		$mk=get($this->primary);

		$file=UPLOAD.'/'.$avatarDir.'/'.$mk.'/'.$filename;

		if(file_exists($file)) unlink($file);

		Go();
	}
}
