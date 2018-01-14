<?php namespace Ctrl;

class Cash extends \core\CTRL{

	public function cash(){

		$holdArray=$this->M->usercoin(USER);#dump($coinArray);exit;

		return compact('holdArray');
	}

	public function cashList(){

		$L=new \core\Link;
		$Link=$L->setlink();

		LIST($dataArray,$paging)=$this->M->cashList(USER);

		$cashSum=$this->M->cashSum(USER);

		return compact('dataArray','paging','Link','cashSum');
	}

	public function cashSubmit(){

		$Re=new \core\Regular;
		$rmb=$Re->int($this->rmb) or show('金额输入有误');

		$usercoin=$this->M->usercoin(USER);#dump($usercoin);exit;

		$cashReady=$usercoin['ready']/10;

		if($rmb <100 ) show('金额不足100元');

		else if($rmb%100 != 0) show('提现金额必须是100的倍数');

		else if($rmb > $cashReady) show('超出可提现金额');

		$snapshot=$this->M->bankInfo(USER);

		$success=$this->M->cashSubmit(USER,$rmb,$snapshot,TIME);

		if($success) show('提现申请已提交,<br>我们将在48小时内完成审核');
		else show('系统操作失败');
	}

    public function cashCancel(){

        $id=get('id');

        $success=$this->M->cashCancel($id);

        if($success) Go(); else show('失败');
    }

    public function cashListAdmin(){

        $L=new \core\Link;
        $COND['ORDER']=$L->order('time');
        $Link=$L->setlink('time','id');#dump($Link);exit;

        $state=get('state');
        $userid=get('userid');

        if($state) $COND['AND']['state']=$state;
        if($userid) $COND['AND'][$this->M->table.'.userid']=$userid;

        LIST($dataArray,$paging)=$this->M->cashListAdmin($COND);

        return compact('dataArray','paging','Link','state');#通过assign返回Link
    }
}