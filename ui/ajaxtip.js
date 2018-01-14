
function inputAjax(inputname,tipid) {
	var inputvalue = document.getElementById(inputname).value;
	var postdata='tip='+inputname+'&'+inputname+'='+inputvalue;
	AJAX(postdata,tipid);
}
function sendVerify(tipid,mod) {
	var mobile = document.getElementById('mobile').value;
	/*if(mobileV(mobile)) return false;*/
	var postdata='tip=sendVerify&mobile='+mobile+'&mod='+mod;
	AJAX(postdata,tipid);
}
function checkVerify(tipid) {
	var verify = document.getElementById('verify').value;
	var postdata='tip=checkVerify&verify='+verify;
	AJAX(postdata,tipid);
}
function repasswordAjax(tipid) {
	var password = document.getElementById('password').value;
	var repassword = document.getElementById('repassword').value;
	var postdata='tip=repassword&password='+password+'&repassword='+repassword;
	AJAX(postdata,tipid);
}

//document.getElementById('getVerify').disabled=true;	//document.getElementById('getVerify').className='shixiao';
//document.getElementById('getVerify').setAttribute("readOnly",'true');//移除removeAttribute("readOnly");
/*
function passwordAjax(tipid) {
	var password = document.getElementById('password').value;
	var postdata='tip=password&password='+password;
	AJAX(postdata,tipid);
}
function phoneAjax(tipid) {
	var phone = document.getElementById('phone').value;
	var postdata='tip=phone&phone='+phone;
	AJAX(postdata,tipid);
}
function mobileAjax(tipid) {
	var mobile = document.getElementById('mobile').value;
	var postdata='tip=mobile&mobile='+mobile;
	AJAX(postdata,tipid);
}*/