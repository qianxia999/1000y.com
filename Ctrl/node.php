<?php namespace Ctrl;

class Node extends \core\base{

	public function node(){
		global $M;

		$key=get('key');##?如何解决VIEW中未定义的情况

		$childArray=$M->getChild($key ? $key : '');

		$Node=$M->getNode($key);

		$parentArray=$M->getChild($Node['parent']);#print_r($parentArray);

		return compact('childArray','parentArray','Node','key');

	}

	public function del(){
		global $M;

		$result=$M->DEL($this->key);

		if($result) Go(); else show('失败');

	}

	public function add(){
		global $M;

		$result=$M->ADD($this->key,$this->parent);

		if($result) Go(); else show('失败');

	}
}