<?php namespace Ctrl;

class Mould extends \core\base{

	public function mould(){

		$tpl='mouldList';

		LIST($dataArray,$paging)=$this->M->mouldList();

		return compact('dataArray','paging');
	}

	public function mouldGet(){
		
		$id=get('id');

		$Array=$M->mouldGet($id);

		$attributeArray = $this->M->mouldAttribute($id);

		return compact('attributeArray','Array','id');
	}

	public function insert(){#插入模型

		$result=$this->M->insertMould($mould);

		if($result) Go(); else show('失败');
	}

	public function delete(){#删除模型

		$result=$this->M->deleteModel($$primary);

		if($result) Go(); else show('失败');

	}

	public function insertAttribute(){#插入属性

		$result=$this->M->insertAttribute($mouldid,$name);

		if($result) Go(); else show('失败');

	}
	public function deleteAttribute(){#删除属性

		$result=$this->M->deleteAttribute($id);

		if($result) Go(); else show('失败');

	}
	public function insertAttributeValue(){#插入属性

		$result=$this->M->insertAttributeValue($id,$value);

		if($result) Go(); else show('失败');

	}

	public function deleteAttributeValue(){#删除属性

		$result=$this->M->deleteAttributeValue($id,$value);

		if($result) Go(); else show('失败');

	}

	public function photoSubmit(){

		$photo=new photo;

		$tmp_name=$_FILES['photo']['tmp_name'];

		#LIST($width,$height)=
		$getimagesize=getimagesize($tmp_name);#print_r($getimagesize);exit;

		$suffix=$photo->mine2suffix($getimagesize['mime']);

		$photoname=$id.'.'.$suffix;

		$entry=$mouldPhoto.'/'.$photoname;

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