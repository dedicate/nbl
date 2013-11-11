
var photoroll={};
photoroll.Ajax=function(url,obj){
	var httpRequest;
	if (window.ActiveXObject){
		try{
			httpRequest = new ActiveXObject("Microsoft.XMLHTTP");  //IE新版本
		}catch (e){
			try{
				httpRequest = new ActiveXObject("Msxml2.XMLHTTP");  //IE旧版本
			}catch (e){}
		}
	}else if(window.XMLHttpRequest){
		httpRequest = new XMLHttpRequest();  //mozilla浏览器
		if (httpRequest.overrideMimeType) {//设置MiME类别 
			httpRequest.overrideMimeType('text/xml'); 
		} 
	}
	if (!httpRequest){
		alert('不能创建XMLHTTP实例');
		obj.onComplete();
	}
	httpRequest.onreadystatechange = function(){
		if (httpRequest.readyState == 4){
			obj['onComplete'](httpRequest);
		}
	}
	if(url.indexOf('machineDate')==-1) 
		url+=(url.indexOf('?')==-1?"?":"&")+("machineDate="+new Date().getTime());
		url+=(url.indexOf('?')==-1?"?":"&")+obj.parameters;
	if(obj.asynchronous==true) 
		httpRequest.open(obj.method, url); 
	else 
		httpRequest.open(obj.method, url,false);
        httpRequest.send(null);
    return httpRequest;
};

function getContent( url, pars, updateElemID){
	//var url="module/wajax.php"
	photoroll.Ajax(url,{
		method  : "POST",
		parameters : pars,
		asynchronous : true,
		onFailure : function(httpRequest){alert("网络连接失败!");},
		onComplete  : function(httpRequest){
			if(httpRequest.status==200){
				showResponse(httpRequest,updateElemID)
			}
		}
	});
}

function $I(element)
{
	return document.getElementById(element);
}

function showResponse(httpRequest,updateElemID)
{
	$I(updateElemID).innerHTML = httpRequest.responseText;
}



function changePic(id,vid,first)
{	
	getContent('../module/Ajax.php', 'act=setpic&id='+id+'&first='+first, vid);
}

function changeBody(id,vid)
{	
	getContent('../module/Ajax.php', 'act=setbody&id='+id, vid);
}