var xmlHttp;
function showUser(str){
xmlHttp = GetXmlHttpObject();//调用下面的函数
if(xmlHttp==null){           //如果没有得到对象

   alert("Browser does not support HTTP Request!");
   return;

}
var url = str+".php";//处理数据的php
//url = url+"?q="+str;
//url = url+"&sid="+Math.random();//产生随机数（好像是防止缓存）
xmlHttp.onreadystatechange = stateChanged;//处理服务器响应的函数
xmlHttp.open("GET", url, true);//GET传值
xmlHttp.send(null);
}
function stateChanged(){
if(xmlHttp.readyState==4||xmlHttp.readyState=="complete"){

   document.getElementById("txtHint").innerHTML = xmlHttp.responseText;

}
}
function GetXmlHttpObject(){//可以当作通用的函数
var xmlHttp = null;
try{
  
   //Firefox,Opera 8.0+,Safafi
   xmlHttp = new XMLHttpRequest();

}
catch (e){

   //Internet Explorer
   try{
  
    xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
  
   }
   catch(e){
  
    xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
  
   }

}
return xmlHttp;
}