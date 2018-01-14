<?php namespace Model;

class Cash extends \core\DB{
	public $table='user_cash';

	public function cashSum($userid){

		$coinSum=$this->sum($this->table,'coin',[
			'userid'=>$userid
		]);

		return $coinSum/10;
	}

	public function usercoin($userid){
		global $coinhold;

		$coin = $this->get('user','coin',[
			'id'=>$userid
		]);

		$gameHold=$this->sum('game',[
			'[>]gamecake'=>['gameid'=>'gameid']
		],'market10',[
			'userid'=>$userid,'endtime[>]'=>TIME,'owner[!]'=>$userid
		]);

		$ready=$coin-$gameHold-$coinhold;

		$ready= $ready>0 ? $ready : 0;
		$coinhold=$coin > $coinhold ? $coinhold : $coin;

		return compact('coin','gameHold','coinhold','ready');
	}

	public function cashList($userid){

		$AND['userid']=$userid;

		$count=$this->count($this->table,$AND);

		$paging=paging($count);

		$dataArray=$this->select($this->table, [
		    'id','userid','coin','rmb','time','memo','state'
		], [
			'AND'=>$AND,
		    'ORDER' => ['state'=>'ASC','id'=>'DESC'],
		    'LIMIT'=>[$paging['keystart'],$paging['pagesize']]
		]);##print_r($dataArray);exit;

		return [$dataArray,$paging];
	}

	public function cashSubmit($userid,$cash,$snapshot,$time){

		$this->action(function() use($userid,$cash,$snapshot,$time) {
			global $cashfee;
			#给推荐人20%的金币奖励
			$coin=$cash*10;
			$coinReward=$coin*$cashfee;#提现奖励
			$rmb=$cash*(1-$cashfee);#实际到账

			$A[]=$this->update('user',[
				'coin[-]'=>$coin
			],[
				'id'=>$userid
			]);

		    $A[]=$cashid=$this->APPEND([
				'userid'=>$userid,
				'coin'=>$coin,
				'rmb'=>$rmb,
				'snapshot'=>$snapshot,
				'time'=>$time,
			]);

			$recommend=$this->get('user','recommend',[
				'id'=>$userid
			]);

			if($recommend) {

				$A[]=$this->insert('user_reward',[
					'userid'=>$recommend,
					'coin'=>$coinReward,
					'time'=>TIME,
					'from'=>$userid,
					'cashid'=>$cashid
				]);
				$A[]=$this->update('user',[
					'coin[+]'=>$coinReward
				],[
					'id'=>$recommend
				]);
			}
			
		    if(!array_product($A)) return false;
		});
		return true;
	}

	public function bankInfo($userid){
		$table='user_bank';

		$Array=$this->get($table,[
			'bank','bankcard','truename','cityname','branch','citycode'
		],[
			'userid'=>$userid,
		]);

		$len['branch']=mb_strlen($Array['branch'],'utf-8');
		$len['truename']=mb_strlen($Array['truename'],'utf-8');
		$len['bank']=strlen($Array['bank']);
		$len['bankcard']=strlen($Array['bankcard']);
		
		$msg='';
		if($len['branch']<2) $msg.="支行信息不完整<br>";
		if($len['truename']<2) $msg.="您的真实姓名不完善<br>";
		if($len['bank']<4) $msg.="开户行未选择<br>";
		if($len['bankcard']<10) $msg.="银行卡号不完整<br>";
		if(!$Array['citycode']) $msg.="省市区县未选择";

		if($msg) show($msg,'?user=userBank');
		
		return json_encode($Array);
	}

    public function cashCancel($id){

        $this->action(function() use($id) {
            $Cash=$this->ONE($id);

            $Reward=$this->get('user_reward',[
                'id','userid','coin',
            ],[
                'cashid'=>$id,'from'=>$Cash['userid'],'time'=>$Cash['time']
            ]);

            $A[]=$this->update('user',[
                'coin[+]'=>$Cash['coin']
            ],[
                'id'=>$Cash['userid']
            ]);

            $A[]=$this->update('user',[
                'coin[-]'=>$Reward['coin']
            ],[
                'id'=>$Reward['userid']
            ]);

            $A[]=$this->delete('user_cash',[
                'id'=>$id
            ]);

            $A[]=$this->delete('user_reward',[
                'id'=>$Reward['id']
            ]);

            #dump($A);exit;
            if(!array_product($A)) return false;
        });
        return true;
    }

    public function cashListAdmin($COND){

        $count=$this->count($this->table,@$COND['AND']);

        $paging=paging($count);

        $COND['LIMIT']=[$paging['keystart'],$paging['pagesize']];

        $dataArray=$this->select($this->table,[
            '[>]user_bank' => ['userid' => 'userid'],
        ],[
            'id',$this->table.'.userid','coin','rmb',$this->table.'.time','memo','snapshot','state',
            'bank','bankcard','truename','cityname','branch',
        ],
            $COND
        );#dump($dataArray);exit;

        foreach ($dataArray as $key => $Array) {
            $User=$this->get('user',[
                'phone','nickname','fullname'
            ],[
                'id'=>$Array['userid']
            ]);
            array_merge($dataArray[$key],$User);
            $dataArray[$key]=array_merge($dataArray[$key],$User);

            $dataArray[$key]['rmb']=floor($Array['rmb']);

            $dataArray[$key]['bankname']=\Ctrl\Pool::bankname($Array['bank']);

            $Snapshot=json_decode($Array['snapshot'],true);

            if(is_array($Snapshot)) $Snapshot['bankname']=\Ctrl\Pool::bankname($Snapshot['bank']);
            #else $Snapshot=['fullname'=>'','bank'=>'','bankcard'=>'','bankname'=>''];
            
            $dataArray[$key]['Snapshot']=$Snapshot;
        }#dump($dataArray);exit;

        return [$dataArray,$paging];
    }
}