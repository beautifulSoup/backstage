<?php
	header("Content-type: text/html; charset=utf-8");
	session_start();
	session_destroy();
	setcookie(session_name(),'', time()-3600);
	$_SESSION=array();
	echo '登出成功<br>';
	echo "<a href='./login.php'>返回</a>";
	