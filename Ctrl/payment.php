<?php namespace Ctrl;

class Payment extends \core\base{
	
	public function payment(){}

	public function paymentList(){
		global $M;
		$L=new \core\Link;
		$COND['ORDER']=$L->order('time');
		$Link=$L->setlink('time');

		$state=get('state');

		$COND['AND']['state']=isset($state) ? $state : 1;

		$COND['AND']['userid']=USER;

		LIST($dataArray,$paging)=$M->paymentList($COND);

		$paymentSum=$M->paymentSum(USER);

		return compact('dataArray','paging','Link','paymentSum');
	}

	public function paymentCreate(){
		global $M;
		$Re=new \core\Regular;
		$rmb=$Re->money($this->rmb) or show('充值金额输入有误','?payment');
		if($rmb <100 ) show('最低100元起','?payment');

		$orderid=$M->paymentCreate(USER,$rmb);

		show("订单创建成功,<br>现在进入支付,编号{$orderid}","/?payment=paymentSelect&orderid=$orderid","1");
	}

	public function paymentSelect(){
		global $M;
		$orderid=get('orderid') or show('订单编号为空,请返回重新创建',"?payment");

		$Payment=$M->get('payment',[
			'userid','orderid','rmb','state'
		],[
			'orderid'=>$orderid
		]);

		if(!$Payment) show('此订单编号不存在');

		if($Payment['state']==1) show('此订单已经支付');

		#支付宝
		$WID['WIDout_trade_no']=$orderid;
		$WID['WIDsubject']='积分充值';
		$WID['WIDtotal_amount']=$Payment['rmb'];

		#微信
		$microtime=microtime();
		$array['rmb']=$Payment['rmb'];
		$array['USERID']=USER;
		$array['microtime']=$microtime;#print_r($array);
		$json=json_encode($array);
		$jsonurl=urlencode($json);

		return compact('orderid','WID','Payment','jsonurl');
	}

	public function paymentOk(){

		show('支付成功！等待服务器端返回信息',"?coin","3000");
	}

	public function paymentNo(){

		show('支付失败，请重试',"?payment");
	}




	public function paymentListAdmin(){
		global $M;
		$L=new \core\Link;
		$COND['ORDER']=$L->order('time');
		$Link=$L->setlink('time');

		$state=get('state');
		$way=get('way');
		$userid=get('userid');

		if($state) $COND['AND']['state']=$state;#$COND['AND']['state']=isset($state) ? $state : 1;
		if($userid) $COND['AND']['userid']=$userid;
		if($way) $COND['AND']['way']=$way;

		LIST($dataArray,$paging)=$M->paymentListAdmin($COND);

		return compact('dataArray','paging','Link','way');
	}

	public function paymentManual(){
		global $M;

		$orderid=get('orderid');

		$Array=$M->paymentManual($orderid);

		return compact('Array');
	}

	public function paymentManualSubmit(){
		global $M;

		$orderid=get('orderid');

		$success=$M->paymentManualSubmit($orderid);

		if($success) show('充值成功','?payment=paymentList'); else show('充值失败');		
	}

	public function paymentInfo(){
		global $M;
		$orderid=get('orderid');

		$Array=$M->paymentAlipay($orderid);
		if(!$Array) show('不存在的编号ID');

		$jsonArray=json_decode($Array['json'],true);
		#dump($jsonArray);exit;

		return compact('jsonArray');
	}

}

/*	public function coinBuySelect(){
		#支付宝
		#$body['userid']=$USERID;
		#$body['ticket']=$ticket;
		#$body['total_fee']=$ticket*10;
		#$WID['body']=urlencode(json_encode($body));
		$WID['subject']='商家推广券';
		$WID['body']=$USERID;
		$WID['total_fee']=$ticket*10;
		$WID['show_url']="index.php?shop&m=ticketBuy";
		$WID['out_trade_no']=date("YmdHis").millisecond();

		#微信
		$ticketPrice=$ticket*10;
		$array['ticketPrice']=$ticket*10;
		$array['USERID']=$USERID;
		$array['microtime']=$microtime;#print_r($array);
		$json=json_encode($array);
		$jsonurl=urlencode($json);
		#$_SESSION['jsontoken']=md5($json);
	}*/