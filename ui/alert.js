
function phoneV(value){
	var patrn=/^[0-9- ０-９－　]{11}$/;
	if(!patrn.exec(value)) {
		window.alert('手机号格式不正确');
		return true;
	}
}
function mobileV(value){
	var patrn=/^[0-9- ０-９－　]{11}$/;
	if(!patrn.exec(value)) {
		window.alert('手机号格式不正确');
		return true;
	}
}
function passwordV(value){
	var patrn=/^.{6,20}$/;
	if(!patrn.exec(value)) {
		window.alert('密码长度6位以上');
		return true;
	}
}
function verifyV(value){
	var patrn=/^[0-9]{4}$/;
	if(!patrn.exec(value)) {
		window.alert('请输入验证码');
		return true;
	}
}
function termV(checked){
	if(checked==false) {
		window.alert('请先阅读相关协议条款');
		return true;
	}
}