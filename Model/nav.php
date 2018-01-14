<?php namespace Model;

class Nav extends \core\DB{
	public $table='nav';

	public function classArray($ctrlDir){

		if(is_dir($ctrlDir)) {

			foreach (new \DirectoryIterator($ctrlDir) as $fileInfo) {
			    #echo $fileInfo->getFilename() . "<br>\n";
			    if($fileInfo->isDot()) continue;
			    $array=pathinfo($fileInfo->getFilename());
			    $dataArray[]=$array['filename'];
			}
		}#dump($dataArray);exit;

		return $dataArray;
	}

	public function getCtrlMethods($ctrl){

		$MethodsAll=$this->getMethods($ctrl);

		$COND['AND']=['ctrl'=>$ctrl,'method'=>$MethodsAll];

		$dataList=$this->LIST($COND);

		$methodArray=array_column($dataList,'method');

		$Methods=array_diff($MethodsAll, $methodArray);

		return [$Methods,$dataList];
	}

	public function getMethods($ctrl){

		$ctrlclass='\\Ctrl\\'.ucfirst($ctrl);#控制器类名首字母大写

		$C=new $ctrlclass();#dump($C);exit;

		$Methods=get_class_methods($C);#unset($method['']#dump($Methods);exit;

		foreach($Methods as $i => $method){

			if( in_array($method,['__call','__construct','__get']) )

				unset($Methods[$i]);
		}#dump($Methods);exit;

		return $Methods;
	}
	

/*	public function getMethod($ctrl,$method){

		return $this->get($this->table,[
			'title'
		],[
			'ctrl'=>$ctrl,'method'=>$method
		]);
	}*/
}