<?php
	function sessionVerify(){
		if(!isset($_SESSION['user_agent'])){
			$_SESSION['user_agent'] = md5($_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
		}
		else if($_SESSION['user_agent']!=md5($_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'])){
			session_regenerate_id();
		}
	}
	
	session_start();
	sessionVerify();
	
	if(!isset($_SESSION['USERNAME'])){
		header("Location: login.php");
	}
?>

<?php 
	header("Content-type: text/html; charset=utf-8");
	?>
<script type="text/javascript" src="./static/js/md5.js"></script>
<script type="text/javascript">
	function checkForm(){
		var passwordArea = document.getElementById('password');
		var confirmArea = document.getElementById('confirm');
		var password = passwordArea.value;
		var confirm = confirmArea.value;

		if(password==""){
			alert("密码不能为空");
			return false;
		}
		else if(confirm==""){
			alert("请填写确认密码");
		}
		else if(confirm!=password){
			alert("重复密码不一致");
			return false;
		}
		else{
			passwordArea.value =  faultylabs.MD5(password);
			confirmArea.value = faultylabs.MD5(confirm);
			return true;
		}
	}
</script>

<form id="userForm" method="post" action="./userOp.php?type=3" onsubmit="return checkForm();">
	密码   : <input type="password" name="password" id = "password"><br>
	确认密码:<input type="password" name="confirm" id="confirm"><br>
	<input type="submit" value="提交">
	</form>