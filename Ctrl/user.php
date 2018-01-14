<?php namespace Ctrl;

class User extends \core\base{

	public function user(){

		$userid=USER;

		$Array=$this->M->gets($userid);

		#checkBindMobile();

		if($Array['mobile']) return compact('Array');

		else {

			$url=config('url','bind');

			msg('MOBILE_BIND_FIRST',$url);
		}
	}


	public function Info(){
		$userid=get('userid') or msg('用户不存在');

		$Array=$this->M->gets($userid);

		return compact('Array');
	}

	public function userList(){#$COND=['AND'=>[],'ORDER'=>[],'LIMIT'=>[]];

		$L=new \core\Link;
		$COND['ORDER']=$L->order('time');
		$Link=$L->setlink('time','id','active','coin');#dump($Link);exit;
		$recommend=get('recommend');
		$agentid=get('agentid');
		$active=get('active');

		if($recommend) $COND['AND']['recommend']=$recommend;

		if($agentid) $COND['AND']['agentid']=$agentid;

		if(isset($active)) $COND['AND']['active']=$active;

		if($this->searchkeyword) {

			$field=searchField($this->searchkeyword);

			if($field=='cn') {
				$COND['AND']['OR']['username[~]']=$this->searchkeyword;
				$COND['AND']['OR']['fullname[~]']=$this->searchkeyword;
			} else $COND['AND'][$field]=$this->searchkeyword;
		}#dump($COND);EXIT;

	    LIST($dataArray,$paging)=$this->M->userList($COND);

		return compact('dataArray','paging','Link');#通过assign返回Link
	}


	public function userAddress(){

		$userid=USER;

		$Array=$this->M->userAddress($userid);#dump($Bank);exit;

		return compact('Array');
	}

	public function userAddressSubmit(){
		#正则过滤输入数据
		$Re=new \core\Regular;
		$phone=$Re->phone($this->phone) or show('联系人电话格式不正确');
		$citycode=get('citycode');
		$cityname=get('cityname');

		$modify=[
			'phone'		=>$phone,
			'contact'	=>$this->contact,
			'address'	=>$this->address,
			'time'		=>TIME,
		];
		if($citycode) {
			$modify['citycode']=$citycode;
			$modify['cityname']=$cityname;
		}

		$success=$this->M->userAddressSubmit(USER,$modify);

		if($success) show('收货地址保存成功','?user'); else show('收货地址保存失败');
	}

	public function Bank(){
		$bankConfig=Node('bank');

		$userid=USER;

		$Array=$this->M->userBank($userid);#dump($Bank);exit;

		return compact('Array','bankConfig');
	}

	public function BankSubmit(){
		#正则过滤输入数据
		$Re=new \core\Regular;
		$truename=$Re->fullname($this->truename) or show('姓名2-4个汉字');
		$citycode=get('citycode');
		$cityname=get('cityname');

		$modify=[
			'bank'		=>$this->bank,
			'bankcard'	=>$this->bankcard,
			'truename'	=>$truename,
			'branch'	=>$this->branch,
			'time'		=>TIME,
		];
		if($citycode) {
			$modify['citycode']=$citycode;
			$modify['cityname']=$cityname;
		}

		$success=$this->M->userBankSubmit(USER,$modify);

		if($success) show('银行卡信息保存成功','?user'); else show('银行卡信息保存失败');
	}

	public function Myqrcode(){

		$userid=USER;

		$httpQrcode=$this->M->makeQrcodeUser($userid);

		return compact('httpQrcode');
	}

	public function Recommend(){

		$L=new \core\Link();
		$this->Url=$L->URL();
		$COND=$L->COND();

		$count=$this->M->count($this->table,$COND['AND']);
		$this->Paging=$L->PAGING($count);

		$dataArray=$this->M->LIST($COND);
	    $dataArray=$this->M->format($dataArray);

		return compact('dataArray');
	}

###


	public function InfoAdmin(){

		$userid=get('userid') or msg('用户不存在');

		$this->User=$this->M->InfoAdmin($userid) or msg('用户不存在');

		#$this->bankConfig=\core\Wind::Node('bank');
		$this->bankConfig=config('bank');
	}

	public function Edit(){
		$userid=get('userid');

		$Array=$this->M->InfoAdmin($userid) or msg('用户不存在');

		return compact('Array','userid');
	}

	public function Admin(){
		$L=new \core\Link($this->primary);
		$this->Url=$L->URL('time','userid','state');
		$COND=$L->COND([
			'sj'=>['mobile'],
			'id'=>['userid','recommend'],
			'cn'=>['nickname[~]','username[~]'],
		]);

		$count=$this->M->count($this->table,$COND['AND']);
		$this->Paging=$L->PAGING($count);

		$this->dataArray=$this->M->LIST($COND);
		$this->dataArray=$this->M->format($this->dataArray);
	}
}