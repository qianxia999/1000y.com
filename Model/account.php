<?php namespace Model;

class Account extends \core\DB {
	public $table='user2';

	public function field2userid($key,$value){
		return $this->get($this->table,'userid',[
			$key=>$value
		]);
	}

	public function recommendMobile(){

		$recommend=get('recommend');

		if($recommend) return $this->K2V('mobile',$recommend);

		/*if($recommend) {
			$cookie=new \core\Cookie;
			$cookie->set('recommend',$recommend);
			if($IP) $this->M->recommend2mysql($recommend);
		} else {
			$recommend=$this->M->recommendGet($IP);
		}*/
	}

	public function passwordModifyVerfity($verify,$password,$repassword){
		$Re=new \core\Regular;
		$verify=$Re->verify($verify) or msg('VERIFY_NOT_MATCH');
		$password=$Re->password($password) or msg('PASSWORD_FORMAT_ERROR');
		$repassword=$Re->repassword($password,$repassword) or msg('PASSWORD_NOT_MATCH');
	}

	public function forgetVerfity($mobile,$verify,$password,$repassword){
		$Re=new \core\Regular;
		$mobile=$Re->mobile($mobile) or msg('ACCOUNT_FORMAT_ERROR');
		$vmobile=$Re->vmobile($mobile) or msg('MOBILE_NOT_MATCH');
		$verify=$Re->verify($verify) or msg('VERIFY_NOT_MATCH');
		$password=$Re->password($password) or msg('PASSWORD_FORMAT_ERROR');
		$repassword=$Re->repassword($password,$repassword) or msg('PASSWORD_NOT_MATCH');
	}

	public function mobileBindVerfity($userid,$password,$verify,$mobile){
		$Re=new \core\Regular;
		$mobile=$Re->mobile($mobile) or msg('MOBILE_FORMAT_ERROR');
		$vmobile=$Re->vmobile($mobile) or msg('MOBILE_NOT_MATCH');
		$verify=$Re->verify($verify) or msg('VERIFY_NOT_MATCH');
		$password=$Re->password($password) or msg('PASSWORD_FORMAT_ERROR');

		$md5password=$this->K2V('password',$userid);

		if(md5($password)===$md5password) return true;
		else msg('PASSWORD_ERROR');
	}

	
	public function registerVerfity($account,$password,$repassword,$recommendmobile){

		$Re=new \core\Regular;
		#$mobile=$Re->mobile($mobile) or msg('MOBILE_FORMAT_ERROR');
		#$vmobile=$Re->vmobile($mobile) or msg('MOBILE_NOT_MATCH');
		#$verify=$Re->verify($verify) or msg('VERIFY_NOT_MATCH');

		$account=$Re->account($account) or msg('ACCOUNT_FORMAT_ERROR');
		#$has=$this->field2userid('account',$account);
		if( $this->has($this->table,['account'=>$account]) ) msg('ACCOUNT_IS_EXIST');

		$password=$Re->password($password) or msg('PASSWORD_FORMAT_ERROR');
		$repassword=$Re->repassword($password,$repassword) or msg('PASSWORD_NOT_MATCH');

		$fields = [
			'account'	=>$account,
			'password'	=>md5($password),
			'time'		=>TIME,
			'state'		=>1,
		];

		if($recommendmobile) $fields['recommend']=$this->field2userid('mobile',$recommendmobile);# or msg('RECOMMEND_NOT_EXIST');

		$fields['ip']=\core\Common::IP();

		return $fields;

		#$userid=!$this->M->phone2userid($mobile) or msg('MOBILE_IS_EXIST');
		#$agentid=$this->M->K2V('agentid',$recommend);
	}

	public function loginVerfity($account,$password){
		$Re=new \core\Regular;
		#$mobile=$Re->mobile($mobile) or msg('MOBILE_FORMAT_ERROR');
		$account=$Re->account($account) or msg('ACCOUNT_FORMAT_ERROR');
		$password=$Re->password($password) or msg('PASSWORD_FORMAT_ERROR');

		$userid=$this->field2userid('account',$account) or msg('ACCOUNT_NOT_EXIST');
		
		$User=$this->ONE($userid);

		if(md5($password)===$User['password']) {

			$state=$User['state'];
			if($state==1) {

				return $userid;

			} else {

				$stateConfig=config('userState');

				msg($stateConfig[$state] ?? 'UNKNOWN_STATE');
			}

		} else msg("PASSWORD_ERROR");#密码错误
	}


	public function loginSuccess($userid,$password){
		$time=TIME;

		$cookie=new \core\Cookie;

		$authcode=$cookie->authcode("$userid\t$time\t$password",'ENCODE');

		$success=$cookie->set(AUTHKEY,$authcode) or msg('设置COOKIE失败');

		return $success;
	}



	public function Welcome($account,$url){

		$msg="<p>连线名称：$account<p>";
		$msg.="<p>您的帐号已经注册成功，<p>";
		$msg.="<p><a href='$url'>进入个人中心</a></p>";

		return $msg;
	}



	public function avatarRemove($userid){
		$avatarDir=config('avatar','user');
		$filename=$this->K2V('avatar',$userid);
		\core\Common::avatarRemove($avatarDir,$filename);

		$success=$this->SAVE([
			'userid'=>$userid,
			'avatar'=>''
		]);

		return $success;
	}

	public function sign(){#dump($this);exit;

		#$Query=$this->query("SELECT * FROM dbo.account1000y")->fetchAll();

		$Query=$this->select("account1000y",'*',[
			'account'=>'fcsnow'
		]);

		dump($Query);exit;

		dump($Get);exit;
	}

	public function mssqlAccount($account,$password){
		$mssql=new \core\SqlServer;

		$query=$mssql->insert('account1000y',[
			'account'=>$account,
			'password'=>$password,
		]);

		$SQLSTATE=current($query->errorInfo());

		if($SQLSTATE == '00000') return true;
	}

}
