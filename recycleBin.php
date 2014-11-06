
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
	$mydb =  new mydb();
	$sql = "select * from category where isvalid = 0";
	$results = $mydb->query($sql);
	echo "<table width='100%' ><tr><td>";
	echo "<table border='0' cellpadding='3' cellspacing='1' width='80%' align='left'><tr style=\"text-align: center; COLOR: #242424; BACKGROUND-COLOR: #808080; font-weight: bold\"><td>序号</td><td>分类名</td><td>父分类</td><td>操作</td></tr>";
	for($i=0;$i<count($results);$i++){
		$sql ="select name from category where categoryID={$results[$i][2]}";
		$tempArray = $mydb->query($sql);
		if(count($tempArray)==0){
			$parentName="父分类已被删除";
		}
		else{
			$parentName = $tempArray[0][0];
		}
		$temp = $i+1;
		echo "<tr bgcolor='#C0C0C0' style='text-align:center'><td>{$temp}</td><td>{$results[$i][1]}</td><td>{$parentName}</td><td><a href='categoryOp.php?type=3&id={$results[$i][0]}'>还原</a>&nbsp<a href='categoryOp.php?type=4&id={$results[$i][0]}'>删除</a></td></tr>";
	}
	echo "</table></td></tr>";
	
	echo "<tr><td><a href='./categoryManage.php'>返回</a></td></tr>";