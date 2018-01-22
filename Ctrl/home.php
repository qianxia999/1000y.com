<?php namespace Ctrl;

class Home extends \core\base{

	public function home(){
		$Mcell=new \Model\Cell;

		$SourceList['Focus']=$Mcell->SourceList(160);
		$SourceList['Four']=$Mcell->SourceList(161);
		$SourceList['fuwuqi']=$Mcell->SourceList(163);

		$DocumentList['renwu']=$Mcell->DocumentList(54);
		$DocumentList['jingyan']=$Mcell->DocumentList(55);
		$DocumentList['qinggan']=$Mcell->DocumentList(57);

		$AlbumList['youxi']=$Mcell->AlbumList(151);
		$AlbumList['wanjia']=$Mcell->AlbumList(150);


		return compact('DocumentList','SourceList','AlbumList');
	}
}