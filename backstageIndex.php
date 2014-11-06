<!doctype html>
<html>
<head>
<meta charset = "utf-8">
<title>后台</title>
<style type="text/css">
#container{
	width:100%;
	margin:0 auto;
}
#header{
	height:80px;
}
#des{
	padding:20px 0px 50px 50px;
}
#content{
	height:600px;
	margin-top:20px;
}
#status{
	margin-left:1000px;
	margin-top:-30px;
}
#status a:link{
	color:#000;
}
#status a:visited{
	color:#000;
}
.content_left{
	height:400px;
	width:200px;
	margin:20px;
	float:left;
}
.content_left ul{
    list-style-type:none;
	margin:0;
	padding:0;	
}
.content_left ul a:link,a:visited{
	display:block;
	color:#fff;
	background-color:#bebebe;
	font-weight:bold;
	text-align:center;
	padding:4px;
	text-decoration:none;
	
}
.content_left ul a:hover,a:active{
	background:#cc0000;
}
#innerPage{
	width:720px;
	margin:10px ;
	float:left;
}
#footer{
	height:40px;
	margin-top:20px;
}
.clear{
	border:solid 1px #000;
	
}

</style>

<script type="text/javascript">
	var whichPage=0;
	var pageArray = new Array('./pageManage.php?n=0','./pageEdit.php' ,'./categoryManage.php', './userManage.php', './changePassword.php');


	function flush(){
		var innerPage = document.getElementById('innerPage');
		console.debug(whichPage);
		innerPage.innerHTML="<iframe src='"+pageArray[whichPage]+"' frameborder='no' width=1000 height=1000></iframe>";
	}
	
	function set(num){
		whichPage = num;
		console.info(num);
		flush();
	}

</script>
<?php
	function sessionVerify(){
		if(!isset($_SESSION['user_agent'])){
			$_SESSION['user_agent'] = md5($_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
		}
		else if($_SESSION['user_agent']!=md5($_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'])){
			session_regenerate_id();
		}
	}
	
	$isadmin = 0;
	session_start();
	sessionVerify();
	
	if(!isset($_SESSION['USERNAME'])){
		header("Location: login.php");
	}
	else{
		$username = $_SESSION['USERNAME'];

		if($username=='0000'){ //管理员用户登录 需要显示用户管理选项
			$isadmin =1;
		}
	}

?>
</head>
<body>
<div class = "container">
	<div id = "header">
	<div id  = "des">后台管理系统</div>
	</div>
	<div class = "clear"></div>
	<div id = "status">
		<a id='user' href='./backstageIndex.php'><?php 
			echo $username;
		?></a>
		<a href = "./logout.php">注销 </a>
	</div>

<div id = "content">
	<div class  = "content_left">
<!--
<table>
<tr>
<td><a href="javascript:void(set(0))">文章管理</a></td>
</tr>
<tr>
<td><a href="javascript:void(set(1))">文章新建</a></td>
</tr>
<tr>
<td><a href="javascript:void(set(2))">分类管理</a></td>
</tr>
</table>
-->
		<ul>
			<li><a href="javascript:void(set(0))">文章管理</a></li>
			<li><a href="javascript:void(set(1))">文章新建</a></li>
			<li><a href="javascript:void(set(2))">分类管理</a></li>
			<li><a href="javascript:void(set(4))">更改密码</a></li>
			
<?php 
	if($isadmin == 1){
		echo "<li><a href='javascript:void(set(3))'>用户管理</a></li>";
	}
			
			
?>

		</ul>
   </div>

 <div id  = "content_main">
<div id='innerPage' class="twodiv">

</div>
</div>
</div>
<div id = "footer"></div>
</div>
</body>
<script type="text/javascript">
	flush();
</script>