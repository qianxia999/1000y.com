<?php namespace Model;

class Mould extends \core\DB{
	public $table = 'mould';

	public function mouldList(){

        $count=$this->count($this->table);

        #$paging=paging($count);

		$dataArray=$this->select($this->table,[
			'id','key','name','sort','active'
		],[
		    'ORDER' => ['sort'=>'DESC'],
		    #'LIMIT'=>[$paging['keystart'],$paging['pagesize']]
		]);

        return [$dataArray,$paging];
	}


	public function getAttribute($id){

		$Get=$this->get('mall_attribute',[
			'attribute'
		],[
			'id'=>$id
		]);

		$json=$Get['attribute'];

		return $json;
	}

	public function mouldAttribute($mouldid){

		$dataArray=$this->select('attribute',[
			'id','name','attribute','unit','sort','active'
		],[
			'AND'=>['mouldid'=>$mouldid],
		    'ORDER' => ['sort'=>'DESC'],
		]);

        return $dataArray;
	}
	public function mouldGet($id){

		return $this->get($this->table,[
			'id','mould','name','photo','parameter','sort','active'
		],[
			$this->primary=>$id
		]);

	}

	public function photoUpdate($mould,$photo){

		$result=$this->update($this->table,[
			'photo'=>$photo
		],[
			$this->primary=>$mould
		]);

		if($result) return true;

		else return false;
	}

	public function insertModel($mould){

		return $this->insert($this->table,[
			'mould'=>$mould,'active'=>'1'
		]);
	}

	public function deleteModel($id){

		$count=$this->count('mall_attribute', ['mouldid'=>$id]);

		if($count) show("此模型属性非空，请先删除属性");

		return $this->delete($this->table, [
			'id[=]' => $id
		]);
	}


	public function deleteAttribute($id){

		return $this->delete('mall_attribute', [
			'id' => $id
		]);
	}

	public function insertAttribute($mouldid,$name){

		 return $this->insert('mall_attribute',[
			'mouldid'=>$mouldid,'name'=>$name,'active'=>'1'
		]);
	}

	public function deleteAttributeValue($id,$value){

		$json=$this->getAttribute($id);

		$Array=json_decode($json,true);

		$result=array_flip($Array);
		
		$key=$result[$value];

		unset($Array[$key]);

		$json=json_encode($Array);

		$result=$this->update('mall_attribute',[
			'attribute'=>$json
		],[
			'id'=>$id
		]);

		return $result;
	}

	public function insertAttributeValue($id,$value){

		$json=$this->getAttribute($id);

		$Array=json_decode($json,true);

		if(is_array($Array)) array_push($Array,$value);

		else $Array[]=$value;

		$json=json_encode($Array);

		$result=$this->update('mall_attribute',[
			'attribute'=>$json
		],[
			'id'=>$id
		]);

		return $result;
	}

/*
	public function attributeList(){

        $count=$this->count($this->table);

        $paging=Padings($count);

		$dataArray=$this->select($this->table,[
			'id','name','sort','active'
		],[
		    'ORDER' => ['sort'=>'DESC'],
		    'LIMIT'=>[$paging['keystart'],$paging['pagesize']]
		]);

        return [$dataArray,$paging];
	}

*/
}