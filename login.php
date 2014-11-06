<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<!--
<meta name="viewport" content="width=1000, initial-scale=1.0, maximum-scale=1.0">
<link href="static/css/vendor/bootstrap.min.css" rel="stylesheet">
<link href="static/css/flat-ui.css" rel="stylesheet">


<link rel="stylesheet" href="static/css/mystyle.css" type="text/css" />
-->
<style type="text/css">
.login-form {
  position: relative;
  padding: 24px 23px 20px;
  background-color: #edeff1;
  border-radius: 6px;
  }
  
</style>
<title>Insert title here</title>

<script type="text/javascript" src="./static/js/md5.js"></script>
<script type="text/javascript">
	function login(){
		var userText = document.getElementById('username');
		var passwordText = document.getElementById('password');
		var username = userText.value;
		var password = passwordText.value;
		if(username==""){
			alert("请输入用户名");
			return false;
		}
		else if(password==""){
			alert("请输入密码");
			return false;
		}
		passwordText.value = faultylabs.MD5(password);
		return true;
		
	}
</script>
</head>
<body style="background: #6495ED">

<div style="width: 80%; height: 200px">

<FORM style="text-align:center;float:right;top:200px;width : 250px;height: 150px" class="login-form" method="post" action="./loginResult.php"  onsubmit="return login();">
	
	<span style="font-size: 18px;color:#000000;float:left">用户登录</span><br>
	<hr>
	<?php 
	require_once 'config.php';
	session_start();
	if(isset($_SESSION['ERROR_NUM'])){
		$errorNum = $_SESSION['ERROR_NUM'];
		if($errorNum == USER_NOT_EXIST_ERROR){
			echo "<span style='color:#EE0000'>用户名不存在</span><br>";
			$_SESSION['ERROR_NUM']=NO_ERROR;
		}
		else if($errorNum == PASSWORD_ERROR){
			echo "<span style='font-size:14px;color:#EE0000'>密码错误</span><br>";
			$_SESSION['ERROR_NUM']=NO_ERROR;
		}
	}
			
	?>
	用户名:<input style="margin: 10px 0" type="text" id = "username" name="username"></input><br>
	密 码    :<input style="margin: 5px 0" type="password" id = "password" name="password"></input>
	<input style="background:#D1EEEE;width:90%;margin: 7px 0" type="submit" value="登录"></input>
</FORM>
</div>
</body>
</html>