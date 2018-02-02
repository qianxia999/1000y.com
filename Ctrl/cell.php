<?php namespace Ctrl;

class Cell extends \core\base{
	
	public function Guide(){
		$Mcell=new \Model\Cell;

		$DocumentList['renwu']=$Mcell->DocumentList(54);
		
		$DocumentList['xinshou']=$Mcell->DocumentList(53);

		$AlbumList['ditu']=$Mcell->AlbumList(155);

		return compact('AlbumList','DocumentList');
	}

	public function Download(){
	}
	
}