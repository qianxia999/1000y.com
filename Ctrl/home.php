<?php namespace Ctrl;

class Home extends \core\base{

	public function home(){

		$Mcell=new \Model\Cell;

		$FocusArray=$Mcell->Source(160);
		$FourArray=$Mcell->Source(161);
		$SourceArray['fuwuqi']=$Mcell->Source(163);

		$renwuArray=$Mcell->documentArray(54);
		$jingyanArray=$Mcell->documentArray(55);
		$qingganArray=$Mcell->documentArray(57);

		$AlbumArray['youxi']=$Mcell->albumArray(151);
		$AlbumArray['wanjia']=$Mcell->albumArray(150);


		return compact('FocusArray','FourArray','renwuArray','jingyanArray','qingganArray','SourceArray','AlbumArray');
	}
}