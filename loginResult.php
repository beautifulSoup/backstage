<?php 


	function test_input($input){
		$input = trim($input);
		$input = stripslashes($input);
		$input = htmlspecialchars($input);
		$input = mysql_real_escape_string($input);
		return $input;
	}

	require_once 'dbop.php';
	require_once 'config.php';
	session_start();
	$mydb = new mydb();
	$username = test_input($_POST['username']);
	$password = test_input($_POST['password']);
	$sql = "select * from user where User='{$username}'";
	$temp = $mydb->query($sql);
	if(!$temp||count($temp)==0){
		$_SESSION['ERROR_NUM'] = USER_NOT_EXIST_ERROR; 
		header("Location: ./login.php");
	}
	else{
		$user = $temp[0];
		if($password!=$user[1]){
			$_SESSION['ERROR_NUM'] = PASSWORD_ERROR; 
			header("Location: ./login.php");
		}
		else{
			$_SESSION['USERNAME'] = $username;
			header("Location: ./backstageIndex.php");
			
		}
	}

?>