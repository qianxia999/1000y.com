<?php namespace Ctrl;

class Home extends \core\base{

	public function home(){

		$FocusArray=$this->M->Source(160);
		$FourArray=$this->M->Source(161);

		return compact('FocusArray','FourArray');
	}
}