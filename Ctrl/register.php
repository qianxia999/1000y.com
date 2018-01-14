<?php namespace Ctrl;

class Register extends \core\base{

	public function register(){

		$success=$this->M->insertSqlServer();

	}
	
}