<?php namespace Ctrl;

class Category extends \core\base{

	public function category(){
		$L=new \core\Link;
		$this->Url=$L->URL();
		$COND=$L->COND();

		$catid=get('catid') ?? 0;
		
		$this->routeHtml = $this->M->categoryRoute($catid);

		$dataArray=$this->M->categoryList($catid);#当前目录
	    $dataArray=$this->M->format($dataArray);

	    return compact('dataArray','catid');
	}

	public function insert(){

		$insertid=$this->M->INS($_POST);

		if($insertid) Go(); else msg('失败');
	}

	public function del(){

		$catid=get('catid');

		if($this->M->childCount($catid)) show("此分类非空，请先删除子分类");

		$result=$this->M->DEL($_GET);

		if($result) Go(); else show('DELETE_FAILED');
	}

	public function avatarSubmit(){
		
	    $avatarDir=config('avatar','category');

		$mk=post($this->primary);
		
		$_POST['avatar']=\core\Common::avatarUpload($avatarDir,$mk);

		$result=$this->M->SAVE($_POST);

		if($result) Go(); else msg('UPDATE_FAILD');
	}

	public function photoSubmit(){

		$photo=new photo;

		$tmp_name=$_FILES['photo']['tmp_name'];

		#LIST($width,$height)=
		$getimagesize=getimagesize($tmp_name);#print_r($getimagesize);exit;

		$suffix=$photo->mine2suffix($getimagesize['mime']);

		$photoname=$id.'.'.$suffix;

		$entry=$modelPhoto.'/'.$photoname;

		$photo->compress($tmp_name,$entry);

		$update=$M->photoUpdate($id,$photoname);

		if($update) Go($referer);

		else show("更新失败了吗");


		$thename=strrchr($tmp_name,'.');

		echo $M->photoUpdate($id,$photo);

		exit;
		#$photo=bin2hex(file_get_contents($tmp_name));
	}
}