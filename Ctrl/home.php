<?php namespace Ctrl;

class Home extends \core\base{

	public function home(){
		$Mcell=new \Model\Cell;

		$SourceList['Slide']=$Mcell->SourceList(160);
		$SourceList['Focus']=$Mcell->SourceList(160);
		$SourceList['Four']=$Mcell->SourceList(161);
		$SourceList['fuwuqi']=$Mcell->SourceList(163);

		$max=7;
		$DocumentList['xinshou']=$Mcell->DocumentList(53,$max);
		$DocumentList['renwu']=$Mcell->DocumentList(54,$max);
		$DocumentList['jingyan']=$Mcell->DocumentList(55,$max);
		$DocumentList['qinggan']=$Mcell->DocumentList(57,$max);

		$AlbumList['youxi']=$Mcell->AlbumList(151);
		$AlbumList['wanjia']=$Mcell->AlbumList(150);
		$AlbumList['ditu']=$Mcell->AlbumList(155);


		return compact('DocumentList','SourceList','AlbumList');
	}
}