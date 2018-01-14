<?php namespace Model;

class Payment extends \core\DB{
	public $table='payment';

	public function paymentSum($userid){

		return $this->sum($this->table,'coin',[
			'userid'=>$userid
		]);	
	}

	public function paymentList($COND){
		$paymentWayConfig=\core\Conf::get('paymentWayConfig','common');

		$count=$this->count($this->table,@$COND['AND']);

		$paging=paging($count);

		$COND['LIMIT']=[$paging['keystart'],$paging['pagesize']];

		$dataArray=$this->select($this->table, [
		    'id','orderid','coin','way','time','state'			
		],
			$COND
		);

		foreach($dataArray as $key =>$Array){

			$way=$Array['way'] ? $paymentWayConfig[$Array['way']] : '';

			$dataArray[$key]['way']=$way;

			if($Array['state']==1) $dataArray[$key]['op']='成功';
			else {
				$paylink="?payment=paymentSelect&orderid=".$Array['orderid'];
				$dataArray[$key]['op']="<a href='$paylink'>去支付</a>";
			}
		}
		
		return [$dataArray,$paging];
	}

	public function paymentCreate($userid,$rmb){

		$orderid=date("YmdHis").millisecond();

		$result=$this->insert('payment',[
			'orderid'=>$orderid,'userid'=>$userid,'rmb'=>$rmb,'time'=>TIME
		]);

		if($result) return $orderid;

	}


	
	public function paymentListAdmin($COND){
		$paymentWayConfig=\core\Conf::get('paymentWayConfig','common');

		$count=$this->count($this->table,@$COND['AND']);

		$paging=paging($count);

		$COND['LIMIT']=[$paging['keystart'],$paging['pagesize']];

		$dataArray=$this->select($this->table, [
		    'id','userid','orderid','rmb','coin','way','time','state'			
		],
			$COND
		);

		foreach($dataArray as $key =>$Array){

			$way=$Array['way'] ? $paymentWayConfig[$Array['way']] : '';

			$dataArray[$key]['way']=$way;

			if($Array['state']==1) $dataArray[$key]['op']='成功';
			else {
				$paylink="?payment=paymentManual&orderid=".$Array['orderid'];
				$dataArray[$key]['op']="<a href='$paylink'>人工充值</a>";
			}
		}
		
		return [$dataArray,$paging];
	}

	public function paymentManual($orderid){
		$Array=$this->get($this->table,[
			'[>]user'=>['userid'=>'id']
		],[
			'userid','orderid','rmb','state',
			'phone','user.coin','active'
		],[
			'orderid'=>$orderid
		]);

		return $Array;
	}

	public function paymentManualSubmit($orderid){

		$this->action(function() use($orderid) {
			$Order=$this->get($this->table,[
				'userid','rmb',
			],[
				'orderid'=>$orderid
			]);

			$coin=$Order['rmb']*10;#充值的金币数量

			$A[]=$this->update('payment',[
				'coin'=>$coin,'way'=>'manual','state'=>1,
			],[
				'orderid'=>$orderid
			]);

			$A[]=$this->update('user',[
				'coin[+]'=>$coin
			],[
				'id'=>$Order['userid']
			]);

			if(!array_product($A)) return false;
		});

		return $this->get($this->table,'state',[
			'orderid'=>$orderid
		]);
	}

	public function paymentAlipay($out_trade_no){
		return $this->get('pay_alipay','*',[
			'out_trade_no'=>$out_trade_no
		]);
	}
}