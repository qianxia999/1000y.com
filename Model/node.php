<?php namespace Model;

class Node extends \core\DB{
	public $table='node';

	public function getChild($key) {

		$dataArray=$this->select($this->table, [
			'key','mean','parent','sort','active',
		], [
		    'parent[=]'=>$key,
		    'ORDER' => ['sort'=>'DESC'],
		]);

		return $dataArray;
	}

	public function getNode($key) {

		return $this->get($this->table, [
			'key','mean','parent','active'
		], [
			'key[=]' => $key
		]);
	}


	public function ADD($key,$parent){

		$result=$this->insert($this->table, [
			'key'=>$key,'parent'=>$parent
		]);

		return $result;
	}


	public function DEL($key){

		$count=$this->count($this->table, ['parent'=>$key]);#判断子分类条数

		if($count) show("此节点非空，请先删除子节点");

		return $this->delete($this->table, [
			'key[=]' => $key
		]);
	}

	#设计为动态调用 __Call?
	public function activeNode($key) {

		$dataArray=$this->select($this->table,[
			'key','mean','parent','sort'
		],[
			'AND'=>['parent'=>$key,'active'=>1],
			'ORDER'=>['sort'=>'DESC'],
		]);

		return $dataArray;
	}
}

/*	#设计为动态调用 考虑__Call  __autoload
	public function nodeArrays($key) {
		global $db;
		$sql="SELECT * FROM `key` WHERE `parent`='$key' AND active ORDER BY active DESC,weight DESC;";
		$dataArray=$Fetch2Array($sql);#print_r($dataArray);exit;
		return $dataArray;
	}

	public function nodeInsert($key,$parent){

		$sql="INSERT INTO `$table`(`$primary`,`parent`) VALUES('{$$primary}','$parent')";

		$result=$this->debug()->insert($this->table, [
			$this->primary=>${$this->primary},'parent'=>$parent,
		]);#echo $result;exit;

		$this->query("INSERT INTO `$this->table`(`$this->primary`,`parent`) VALUES('$key','$parent');")->fetchColumn();
		$result=$this->query("mysqli_affected_rows($this->db)")->fetchAll();
		print_r($result);exit;
		return $result;
	}*/