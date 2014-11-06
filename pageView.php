<?php
	include("dbop.php");
	date_default_timezone_set('PRC');
	header("Content-type: text/html; charset=utf-8");
	$mydb = new mydb();
	$id = $_GET['id'];
	$sql = "select * from article where id = ".$id;
	$article = $mydb->query($sql);
	if(!$article){
		echo "查询数据库失败<br>";
	}
	else{
		echo "<title>".$article[0][1]."</title>";
		echo "<h1 style=\"text-align:center\">".$article[0][1]."</h1>";
		echo "<body><div>".$article[0][4]."</div></body>";
	}	
