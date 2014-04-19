var xmlHttp;
//var boardid;


$(document).ready(function(){
$('.edit_button').click(function () {
        var todo = $(this).attr('fol_id');
        var boardid = $(this).attr('id');
		var act = document.getElementById(boardid).innerHTML;
		if(act=="Follow"){
        $.ajax({ 
          url: 'addFollow.php',
          type: 'GET',
          data: 'bid=' + boardid,
          cache: false, 
          success: function(){
			//todo=$(this).attr('todo','unfollow');
            document.getElementById(boardid).innerHTML = "UnFollow";
          } 
        });
        return false;
    }
		if(act=="UnFollow"){
        $.ajax({ 
          url: 'deleteFollow.php',
          type: 'GET',
          data: 'bid=' + boardid,
          cache: false, 
          success: function(){
			//todo=$(this).attr('todo','unfollow');
            document.getElementById(boardid).innerHTML = "Follow";
          } 
        });
        return false;
    }
});
	
		
		
});

function addFollow(str){
//document.getElementById("follow").innerHTML = "UnFollow";
xmlHttp = GetXmlHttpObject();//调用下面的函数

if(xmlHttp==null){           //如果没有得到对象

   alert("Browser does not support HTTP Request!");
   return;

}
var url = "addFollow.php";//处理数据的php
url = url+"?bid="+str;
//url = url+"&sid="+Math.random();//产生随机数（好像是防止缓存）
xmlHttp.onreadystatechange = stateChangedAdd;//处理服务器响应的函数
xmlHttp.open("GET", url, true);//GET传值
xmlHttp.send(null);
}

function deleteFollow(str){
xmlHttp = GetXmlHttpObject();//调用下面的函数
if(xmlHttp==null){           //如果没有得到对象

   alert("Browser does not support HTTP Request!");
   return;

}
var url = "deleteFollow.php";//处理数据的php
url = url+"?bid="+str;
xmlHttp.onreadystatechange = stateChangedDelete;//处理服务器响应的函数
xmlHttp.open("GET", url, true);//GET传值
xmlHttp.send(null);
}

function stateChangedAdd(){
if(xmlHttp.readyState==4||xmlHttp.readyState=="complete"){

   document.getElementById(boardid).innerHTML = "unfollow";
  // document.getElementById(boardid).attr('onclick','').click(eval(function(){deleteFollow(boardid)}));
	//document.getElementById(boardid).click(function(){deleteFollow(boardid)});
}
}

function stateChangedDelete(){
if(xmlHttp.readyState==4||xmlHttp.readyState=="complete"){

   document.getElementById(boardid).innerHTML = "follow";
   document.getElementById(boardid).click(function(){addFollow(boardid)});
   //document.getElementById(boardid).attr('onclick','').click(eval(function(){addFollow(boardid)}));

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