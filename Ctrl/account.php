<?php namespace Ctrl;

class Account extends \core\base{

	public function Term(){}
	public function about(){}

	public function account(){

		$this->recommendMobile=$this->M->recommendMobile();
	}

	public function registerSubmit(){
		#$mobile=post('mobile');
		$account=post('account');
		$password=post('password');
		$repassword=post('repassword');
		$recommendmobile=post('recommendmobile');

		$fields=$this->M->registerVerfity($account,$password,$repassword,$recommendmobile);

		$insertid=$this->M->INS($fields);

		if($insertid) {#$this->M->recommendDelete($IP);##删除本IP的推荐人信息

			$mssqlSuccess=$this->M->mssqlAccount($account,$password);
			if(!$mssqlSuccess) msg('MSSQL_INSERT_FAILD');

			$this->M->loginSuccess($insertid,$password);

			$url=config('url','loginSuccess');
			$text=$this->M->Welcome($account,$url);
			msg($text,$url);

		} else msg('INSERT_FAILD');
	}

	public function Login(){}

	public function loginSubmit(){
		#$mobile=post('mobile');
		$account=post('account');
		$password=post('password');

		$userid=$this->M->loginVerfity($account,$password);

		$this->M->loginSuccess($userid,$password);

		$url=config('url','loginSuccess');

		msg('LOGIN_SUCCESS',$url,'1');
	}


	public function logout(){
		#数据库记录注销操作
		#$this->insert('user_record',[

		setcookie(AUTHKEY,false);

		$url=config('url','login');

		msg('LOGOUT_SUCCESS',$url);
	}


	public function cookie(){#清空COOKIE

		foreach(array_keys($_COOKIE) as $key) setcookie($key,false);

		msg("已清空COOKIE");
	}

	public function session(){#清空SESSION $_SESSION['USERID']=NULL;

		session_destroy();

		msg("已清空SESSION");
	}

	public function MobileBind(){

		$userid=USER;

		$User=$this->M->ONE($userid);

		$mobile=$User['mobile'];

		if($mobile) {
			$url=config('url','modify');

			msg('MOBILE_BIND_ALREADY',$url);
		}

		$this->account=$User['account'];
	}

	public function MobileBindSubmit(){
		$userid=USER;
		$mobile=post('mobile');
		$password=post('password');
		$verify=post('verify');
		$this->M->mobileBindVerfity($userid,$password,$verify,$mobile);

		$success=$this->M->SAVE([
			'userid'=>$userid,
			'mobile'=>$mobile
		]);

		if($success) {

			$url=config('url','user');

			msg('MOBILE_BIND_SUCCESS',$url);

		} else msg('MOBILE_BIND_FAILED');
	}

	public function Modify(){

		$userid=USER;

		$User=new \Model\User;

		$Array=$User->gets($userid);

		return compact('Array');
	}

	public function modifySubmit(){#dump($_POST);EXIT;
		$nickname=post('nickname');
		$Re=new \core\Regular;
		$nickname=$Re->string($nickname) or show('昵称超过长度限制');

		$fields=[
			'userid'=>USER,
			'nickname'=>$nickname,
		];

		$success=$this->M->SAVE($fields);

		if($success) msg('保存成功'); else msg('失败');
	}

	public function avatarSubmit(){
	    $avatarDir=config('avatar','user');

		$mk=post($this->primary);
		
		$_POST['avatar']=\core\Common::avatarUpload($avatarDir,$mk);

		$result=$this->M->SAVE($_POST);

		if($result) Go(); else msg('UPDATE_FAILD');
	}

	public function avatarRemove(){
		$userid=USER;

		$success=$this->M->avatarRemove($userid);

		if($success) Go();
	}

	public function Forget(){}

	public function forgetSubmit(){
		$mobile=post('mobile');
		$verify=post('verify');
		$password=post('password');
		$repassword=post('repassword');

		$this->M->forgetVerfity($mobile,$verify,$password,$repassword);

		$userid=$this->M->field2userid('mobile',$mobile);

		$success=$this->M->SAVE([
			'userid'=>$userid,
			'password'=>md5($password),
		]);

		if($success) {

			$url=config('url','loginSuccess');

			msg('PASSWORD_SAVE_SUCCESS',$url);

		} else msg('PASSWORD_SAVE_FAILED');

	}

	public function PasswordMofify(){

		$userid=USER;

		$this->mobile=$this->M->K2V('mobile',$userid);
	}

	public function passwordMofifySubmit(){
		$userid=USER;
		$verify=post('verify');
		$password=post('password');
		$repassword=post('repassword');

		$this->M->passwordModifyVerfity($verify,$password,$repassword);

		$success=$this->M->SAVE([
			'userid'=>$userid,
			'password'=>md5($password),
		]);

		if($success) {

			$url=config('url','loginSuccess');

			msg('PASSWORD_SAVE_SUCCESS',$url);

		} else msg('PASSWORD_SAVE_FAILED');
	}
}