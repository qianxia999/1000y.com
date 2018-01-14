<?php namespace Model;

class Admin extends \core\DB{
	#public $table='admin';

	public function loginCheck(){

		if(!in_array($c,$this->ctrlConfig)) {

			if(isset($_COOKIE['ROOTAUTH'])) {

				$cookie=new cookie;

				$authcode = $cookie->authcode($_COOKIE['ROOTAUTH'], 'DECODE');

				$_LIST = LIST($_USER,$_TIME,$_PASSWORD) = explode("\t", $authcode);#DUMP($_LIST);EXIT;

				return $_USER;
			}

		}

	}


	public function loginSuccess($user,$password){

		$cookie=new \core\Cookie;

		$time=TIME;

		$authcode=$cookie->authcode("$user\t$time\t$password", 'ENCODE');

		$cookietime=31536000;

		$success = $cookie->set(AUTHKEY,$authcode,$cookietime);

		if($success) show('登录成功','/');#Go('/');

		else show('系统环境异常');
	}

	public function logout(){
		/*
		数据库记录注销操作
		$this->insert('user_record',[
			''
		]);
		 */

		$cookie=new cookie;

		$result=$cookie->unsetAUTH();
		#echo $result;exit;

		return $result;
	}

	public function adminGet($user){

		return $this->get($this->table,[
			'user','password(md5password)','username','nickname','mod','active'
		],[
			$this->primary=>$user
		]);
	}

}