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
	require_once 'dbop.php';
	header("Content-type: text/html; charset=utf-8");
	header("Cache-Control: no-cache");
	header("Pragma: no-cache");
	$mydb = new mydb();
	$sql = "select * from user where User <> 'admin'";
	$users = $mydb->query($sql);
	echo "<table width='100%'><tr><td>";
	echo "<div><table border='0' cellpadding='3' cellspacing='1' width='80%' align='left'><tr style=\"text-align: center; COLOR: #242424; BACKGROUND-COLOR: #808080; font-weight: bold\"><td>序号</td><td>用户名</td><td>操作</td></tr>";
	for($i=0;$i<count($users);$i++){
		$count=$i+1;
		echo "<tr bgcolor='#C0C0C0' style='text-align:center'><td>{$count}</td><td>{$users[$i][0]}</td><td><a href='./userOp.php?type=0&username={$users[$i][0]}'>删除</a>&nbsp&nbsp<a href='./userAdd.php?username={$users[$i][0]}'>修改</a></td></tr>";
		
	}
	echo "</table></td></tr>";
	echo "<tr><td><a href='./userAdd.php'>添加用户</a></td></tr>";
	
	
	
