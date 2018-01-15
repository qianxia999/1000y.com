<?php namespace Ctrl;

class Cell extends \core\base{
	
	public function Guide(){

		$renwuArray=$this->M->documentArray(54);

		$xinshouArray=$this->M->documentArray(53);

		$dituAlbumList=$this->M->albumArray(155);

		return compact('renwuArray','xinshouArray','dituAlbumList');
	}



}