<?php namespace Model;

class Category extends \core\DB{
	public $table='category';

	public function format($dataArray){

	    $avatarDir=config('avatar','category');

   		foreach ($dataArray as $key => $Array) {

   			$dataArray[$key]['avatar'] = \core\Common::httpAvatar($Array['avatar'],$avatarDir);
   		}

   		return $dataArray;
	}

	public function childCount($catid){

		return $this->count($this->table, ['parent'=>$catid]);#判断子分类条数
	}

	public function getParent($catid){ 

		return $this->Get($this->table,[
			'parent'
		],[
			'catid'=>$catid
		])
		['parent'];
	}

	public function getNode($catid){
		return $this->get($this->table,[
			'catid','parent','name','sort','state'
		],[
			$this->primary=>$catid
		]);
	}

	public function categoryRoute($catid){

		while($catid){

			$routeArray[]=$this->getNode($catid);

			$catid=$this->getParent($catid);
		}

		$routeHtml=$this->routeHtml($routeArray ?? []);

		return $routeHtml;
	}

	public function routeHtml($routeArray){

		$routeLink[]="<a href=?category>顶级</a>";

		$routeArray=array_reverse($routeArray);

		foreach($routeArray as $route){

			$catid=$route['catid'];

			$name=$route['name'];

			$routeLink[]="<a href=\"?category&catid=$catid\">$name</a>";
		}#dump($routeLink);exit;
		
		$routeHtml=implode(' ➢ ', $routeLink);

		return $routeHtml;
	}

	public function categoryList($catid,$state=false){

		$AND['parent']=$catid;
		if($state) $AND['state']=1;

		$dataArray=$this->select($this->table,[
			'catid','parent','name','avatar','style','seq','state'
		],[
			'AND'	=>$AND,
		    'ORDER'	=> ['seq'=>'DESC'],
		]);

		return $dataArray;
	}

	public function categoryActive(){

		$dataArray=$this->select($this->table,[
			'id','name','parent'
		],[
			'AND'=>['active'=>1],
			'ORDER'=>['sort'=>'DESC'],
		]);

		return $dataArray;
	}	

	public function photoUpdate($model,$photo){

		$result=$this->update($this->table,[
			'photo'=>$photo
		],[
			$this->primary=>$model
		]);

		if($result) return true;

		else return false;
	}

}


/*

	public function parentList($id){

		$parent=$this->parent($id);

		$Array=$this->select($this->table, [
			'id','name','parent','sort','active'
		], [
			'parent[=]' => $parent
		]);

		return $Array;
	}
	
	public function parentRoute($node){##递归返回所有目录
		$Route=[];

		while($node) {

			$Route[]=$this->getNode($node);

			$node=$this->getParent($node);

			$this->parentRoute($node);
		}

		return $Route;
	}
	public function categoryListR($id){##递归返回所有目录

		#$count=$this->count($this->table, ['parent'=>$id]);

		#if($count) {

			$childArray=$this->select($this->table,[
				'id','name','parent','sort','active'
			],[
				'parent'=>$id
			]);#print_r($childArray);exit;

			foreach ($childArray as $id => $Child) {

				$count=$this->count($this->table, ['parent'=>$id]);#判断子分类条数

				if($count) $Child['child'] = $this->categoryListR($id);#如果有子分类递归加入list

				$allArray[]=$Child;
			}
		#}

		return $allArray;
	}*/