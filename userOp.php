

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
	$mydb = new mydb();
	$type = $_GET['type'];
	switch($type){
		case 0:{   //删除用户
			$name = $_GET['username'];
			$sql = "delete from user where User = '{$name}'";
			$ret = $mydb->delete($sql);
			if($ret){
				echo "删除账户成功<br>";
			}
			else{
				echo "删除账户失败<br>";
			}
			
			break;
		}
		case 1:{   //修改用户
			$username = $_POST['username'];
			$password = $_POST['password'];
			$oldName = $_GET['username'];
			$sql = "update user set User ='{$username}', Password ='{$password}' where User = '{$oldName}'";
			echo $sql;
			$ret = $mydb->update($sql);
			if($ret){
				echo "修改账户成功<br>";
			}
			else{
				echo "修改账户失败<br>";
			}
			

			break;
		}
		case 2:{   //添加用户
			$username = $_POST['username'];
			$password = $_POST['password'];
			$sql = "insert into user(User, Password) values('{$username}', '{$password}')";
			$ret = $mydb->insert($sql);
			if($ret){
				echo "新建账户成功<br>";
			}
			else{
				echo "新建账户失败<br>";
			}
			
			break;
		}
		case 3:{
			session_start();
			$myname = $_SESSION['USERNAME'];
			echo $myname;
			$password = $_POST['password'];
			$sql = "update user set Password = '{$password}' where User ='{$myname}'";
			$ret = $mydb->update($sql);
			if($ret){
				echo "密码更改成功<br>";
			}
			else{
				echo "密码更改失败<br>";
			}
			
		}
	}
	?>
<a href='./userManage.php'>返回</a>