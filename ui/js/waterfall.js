window.onload=function(){
	waterfall('waterfall','box');
}

function waterfall(parent,box){
	//将main下所有class为box的元素取出来
	var oParent=document.getElementById(parent);
	var oBoxs=getByClass(oParent,box);
	var oBoxW=oBoxs[0].offsetWidth;
	console.log(oBoxW);
    //var MAIN=document.getElementById("MAIN");
	var cols=Math.floor(document.body.offsetWidth/oBoxW);//var cols=2;
	var hArr=[];
	for(var i=0;i<oBoxs.length;i++){
		if(i<cols){
			hArr.push(oBoxs[i].offsetHeight);
		}else{
			var minH=Math.min.apply(null,hArr);
			//console.log(minH);
			var index=getMinhIndex(hArr,minH);
			oBoxs[i].style.position='absolute';
			oBoxs[i].style.top=minH+'px';
			//oBoxs[i].style.left=oBoxW*index+'px';
			oBoxs[i].style.left=oBoxs[index].offsetLeft+'px';
			hArr[index]+=oBoxs[i].offsetHeight;
		}
	}
	//console.log(hArr);
	//设置main的宽度
	var height=Math.max.apply(null,hArr);
	oParent.style.cssText='width:'+oBoxW*cols+'px;height:'+height+'px;margin:0 auto';

}

function getMinhIndex(arr,val){
	for(var i in arr){
		if(arr[i]==val){
			return i;
		}
	}
}

//根据class获取元素
function getByClass(parent,clsName){
	var boxArr=new Array(),//用来存储获取到的所有元素
		oElements=parent.getElementsByTagName('*');
	for(var i=0;i<oElements.length;i++){
		if(oElements[i].className==clsName){
			boxArr.push(oElements[i]);
		}
	}
	return boxArr;
}