<?php namespace Model;

class User extends \core\DB{
	public $table='user2';

	public function recommender($userid){

		$User=$this->ONE($userid);

		if($User['nickname']) return $User['nickname'];

		else if($User['username']) return $User['username'];

		else if($User['mobile']) return $User['mobile'];

		else return $userid;
	}

	public function gets($userid){
	    $avatarDir=config('avatar','user');
		$adminList=config('admin');

		$Array=$this->ONE($userid);

   		$Array['avatar'] = \core\Common::httpAvatar($Array['avatar'],$avatarDir);

		$Array['isAdmin']=in_array($Array['userid'],$adminList);

		$Array['recommender']=$this->recommender($Array['recommend']);

		#if($Array['isAdmin']) define('ADMIN',true);
		#$this->isAgent=\core\Common::isAgent(USER);

		return $Array;
	}


	public function format($dataArray){
		$userState=config('userState');
	    $avatarDir=config('avatar','user');
	    $Default=config('avatar','userDefault');

		foreach($dataArray as $key => $Array) {

			$dataArray[$key]['count']=$this->count($this->table,[
				'recommend'=>$Array['userid']
			]);

			$dataArray[$key]['recommender']=$this->recommender($Array['recommend']);

			$dataArray[$key]['avatar'] = \core\Common::httpAvatar($Array['avatar'],$avatarDir,$Default);

			$dataArray[$key]['state']=$userState[$Array['state']] ?? $Array['state'];


			#$agentname=$this->get('agent','name',['agentid'=>$Array['agentid']]);
			#$dataArray[$id]['agentname']=$agentname ? $agentname : $Array['agentid'];

		}

		return $dataArray;
	}

	public function InfoAdmin($userid){
	    $avatarDir=config('avatar','user');
	    $Default=config('avatar','userDefault');

		$Array = $this->ONE($userid);

		$Array['recommender']=$this->recommender($Array['recommend']);

		$Array['avatar'] = \core\Common::httpAvatar($Array['avatar'],$avatarDir,$Default);

		#$userAddress=$this->userAddressGet($userid);
		#$userBank=$this->userBankGet($userid);
		#if($userBank['bank']) $userBank['bankname']=\Ctrl\Pool::bankname($userBank['bank']);

		return $Array;
	}

	public function phone2userid($mobile){
		return $this->get($this->table,'userid',[
			'mobile'=>$mobile
		]);
	}


	public function loginMod($username){

		$Array=$this->get($this->table,[
			'mod'
		],[
			'username'=>$username
		]);#print_r($Array);exit;

		return $Array['mod'];
	}




	public function userAddressGet($userid){
		return $this->get('user_address',[
			'phone','contact','address','cityname'
		],[
			'userid'=>$userid
		]);
	}

	public function userBankGet($userid){
		return $this->get('user_bank',[
			'bank','bankcard','truename','cityname','branch',
		],[
			'userid'=>$userid
		]);
	}


	public function avatarUpdate($userid,$avatar){

		$result=$this->update($this->table,[
			'avatar'=>$avatar
		],[
			$this->primary=>$userid
		]);

		if($result) return true;

		else return false;
	}

###



	public function userAddress($userid){
		return $this->get('user_address','*',[
			'userid'=>$userid
		]);
	}

	public function userAddressSubmit($userid,$modify){
		$table='user_address';

		$has=$this->get($table,'userid',[
			'userid'=>$userid
		]);

		if($has) {
			$success=$this->update($table,$modify,[
				'userid'=>$userid
			]);
		} else {
			$modify['userid']=$userid;
			$success=$this->insert($table,$modify);
		}

		return $success;
	}

	public function userBank($userid){
		return $this->get('user_bank','*',[
			'userid'=>$userid
		]);
	}

	public function userBankSubmit($userid,$modify){
		$table='user_bank';

		$has=$this->get($table,'userid',[
			'userid'=>$userid
		]);

		if($has) {
			$success=$this->update($table,$modify,[
				'userid'=>$userid
			]);
		} else {
			$modify['userid']=$userid;
			$success=$this->insert($table,$modify);
		}

		return $success;
	}

	public function makeQrcodeUser($userid){
		$REGISTER=config('url','register');
	    $QRCODE=config('avatar','qrcode');
	    $LOGO=config('avatar','logo');

		$qrcodeFile=UPLOAD.'/'.$QRCODE.'/'.$userid.'.png';#二维码文件保存地址
		$qrcodeValue='http://'.HOST.'/'.$REGISTER.'&recommend='.$userid;

		$avatar=$this->K2V('avatar',$userid);
	    $avatarDir=config('avatar','user');
   		$userAvatar = \core\Common::localAvatar($avatar,$avatarDir);

		$qrcodeLogo=file_exists($userAvatar) ? $userAvatar : UPLOAD.'/'.$LOGO;#二维码中间LOGO

		$QR=new \core\myQrcode;
		$QR->makeQrcode($qrcodeFile,$qrcodeValue,$qrcodeLogo);#if(!is_file($qrcodeLogo)) #如果不存在,生成二维码

		return ATTACH.'/'.$QRCODE.'/'.$userid.'.png';#返回HTTP访问的二维码地址
	}

	public function userRecommend($COND){

		$count=$this->count($this->table,@$COND['AND']);

		$paging=paging($count);

		$COND['LIMIT']=[$paging['keystart'],$paging['pagesize']];

		$dataArray=$this->select($this->table, [
			'id(userid)','avatar','phone','nickname','recommend','fullname','time','active'
		],
			$COND
		);

		foreach ($dataArray as $key => $Array) {

			$httpUserAvatar=$this->httpUserAvatar($Array['avatar']);

			$dataArray[$key]['avatar']=$httpUserAvatar;
		}

		return [$dataArray,$paging];
	}
}

/*
	public function recommendDelete($index){

		return $this->delete('personal',[
			'index'=>$index
		]);
	}

	public function recommendGet($index){

		if($_COOKIE['recommend']) $recommend=$_COOKIE['recommend'];
		#else if($_SESSION['recommend']) $recommend=$_SESSION['recommend'];
		else if($index){
			$Get=$this->get('personal',[
				'string'
			],[
				'AND'=>['index'=>$index,'type'=>'recommend'],
			]);

			$string=$Get['string'];#取序列号字段

			$Array=unserialize($string);#反向序列号

			$recommend=$Array['recommend'];#获取推荐人
		}

		return $recommend;
	}

	public function recommend2mysql($recommend){
		$time,$IP;

		$Array['recommend']=$recommend;

		$Array['time']=$time;

		$string=serialize($Array);

		$has=$this->has('personal',[
			'index'=>$IP,
		]);#echo $has;exit;

		if($has){
			$result=$this->update('personal', [
				'type'=>'recommend','string'=>$string
			], [
				'index[=]'=>$IP,
			]);
		}else{
			$result=$this->insert('personal', [
				'index'=>$IP,'type'=>'recommend','string'=>$string
			]);
		}

		if($result) return true;
	}*/
