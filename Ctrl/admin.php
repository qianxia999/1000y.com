<?php namespace Ctrl;

class Admin extends \core\base{

	public function admin(){

		#$Admin=$M->adminGet(USER);
		#$usermodArray=$M->key2value(USER,'mod');
		#dump($usermodArray);exit;

		$Online=new \Model\Online();

		$onlineCount=$Online->onlineCount();

		return compact('Admin','usermodArray','onlineCount');
	}

	public function login(){}

	public function loginSubmit(){
		global $M,$login;
		$user=get('user');
		$password=get('password');

		$md5password=$M->key2value($user,'password');

		if(!$md5password) show('此帐号不存在',$login);

		if(md5($password)==$md5password) {

			$success=$M->loginSuccess($user,$password);

			show('登录成功','/','1');

		} else show("密码不正确");
	}

	public function logout(){
		global $login;

		setcookie(AUTHKEY,false);

		Go($login);
	}

}
/*echo '操作系统'.PHP_OS;
echo '<BR>PHP版本'.PHP_VERSION;
exit;*/
