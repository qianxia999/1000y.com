<?php namespace Ctrl;

class Nav extends \core\base{

	public function nav(){
		
		$ctrlDir=APP.'/Ctrl';

		$this->classArray=$this->M->classArray($ctrlDir);
	}

	public function Class(){

		$class=get('class');

		LIST($this->Methods,$this->dataList)=$this->M->getCtrlMethods($class);

		return compact('class');
	}


	public function delete(){

		$result=$this->M->DEL($_GET);
		
		if($result) Go(); else msg('DELETE_FAILED');
	}

	public function insert(){

		$class=get('class');
		$method=get('method');

		$result=$this->M->INS(['ctrl'=>$class,'method'=>$method]);

		if($result) Go(); else show('失败','?nav');
	}

/*	public function Modify(){
		#if($_SERVER['REQUEST_METHOD']=='POST') $this->POST();进入一个非POST页面 设置一个退回链接

		$class=get('class');
		$method=get('method');

		$Array=$this->M->getMethod($class,$method);

		return compact('Array');
	}*/
}