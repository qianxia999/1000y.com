<?php namespace Ctrl;

class Cell extends \core\base{
	
	public function Guide(){

		$renwuArray=$this->M->documentArray(54);

		$xinshouArray=$this->M->documentArray(53);

		return compact('renwuArray','xinshouArray');
	}



}