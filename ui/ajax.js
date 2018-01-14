//if(document.getElementById('result').innerHTML=="ok") document.orderform.Submit.disabled=true;
function disappear(){
	setTimeout("document.getElementById('result').innerHTML='';",1500) // 这个是主要参数，设置消失的时间
}

function stateChange(tipid) {
	if(XHR.readyState<4) {
		document.getElementById(tipid).innerHTML="waiting...";
	} else if(XHR.readyState==4) {//4 = "loaded"
		if(XHR.status==200) document.getElementById(tipid).innerHTML=XHR.responseText;
	}
}

function ajaxUpdate(table,primary,mk,field,value) {

	var postdata='table='+table+'&primary='+primary+'&mk='+mk+'&field='+field+'&value='+value;

	AJAX(postdata,'result');
}

//if(XHR==null) alert("Your browser does not support XMLHTTP.");
function AJAX(postdata,tipid) {//alert(postdata);
	var ajaxurl='http://'+window.location.host+'/?ajax';

	if(window.XMLHttpRequest) XHR=new XMLHttpRequest();//code for Firefox, Opera, IE7, etc.

	else if(window.ActiveXObject) XHR=new ActiveXObject("Microsoft.XMLHTTP");//code for IE6, IE5

	XHR.open("POST",ajaxurl,true);//POST解决换行丢失问题,TRUE为异步传输

	XHR.setRequestHeader("Content-Type","application/x-www-form-urlencoded;");//XHR.SetRequestHeader("Content-Type","text/html; charset=utf-8");

	XHR.onreadystatechange=function() {
		stateChange(tipid);
	};

	XHR.send(postdata);//disappear();
}


function activeSwitch(thisone) {
	if(thisone.value==1) thisone.value=0;
	else thisone.value=1;
}

function jsMsg(error) { 
	console.log(error);//alert(error);
}

function countdown(btn,waiting) {
	if(waiting==0) {
		btn.removeAttribute("disabled");
		btn.innerHTML="获取短信";
	} else {
		btn.setAttribute("disabled", true);
		btn.innerHTML=" 重新发送(" + waiting + ")秒 ";
		waiting--;
		setTimeout(function() { countdown(btn,waiting) },1000);
	}
}

function Submiting(thisForm){
	thisForm.Submit.readOnly=true;//thisForm.Submit.setAttribute("readOnly",'true');
	thisForm.Submit.value='正 在 提 交  . .';
	//thisForm.submit();
	//return true;
}