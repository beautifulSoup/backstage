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
		var usernameArea = document.getElementById('username');
		var passwordArea = document.getElementById('password');
		var confirmArea = document.getElementById('confirm');
		var username = usernameArea.value;
		var password = passwordArea.value;
		var confirm = confirmArea.value;
		if(username==""){
			alert("用户名不能为空");
			return false;
		}
		else if(password==""){
			alert("密码不能为空");
			return false;
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

<?php 
	if(isset($_GET['username'])){
		$name = $_GET['username'];
		echo <<<func1
			<script type="text/javascript">
				window.onload=function(){
					var usernameArea = document.getElementById('username');
					usernameArea.value = '{$name}';
					var formArea = document.getElementById('userForm');
					formArea.action = './userOp.php?type=1&username={$name}';
				}
			</script>
func1;
	}

?>
	
	
<form id="userForm" method="post" action="./userOp.php?type=2" onsubmit="return checkForm();">
	用户名: <input type="text" name = "username" id = "username"><br>
	密码   : <input type="password" name="password" id = "password"><br>
	确认密码:<input type="password" name="confirm" id="confirm"><br>
	<input type="submit" value="提交">
	</form>
<a href='./userManage.php'>返回</a>