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
	define("PAGE_NUM", 10);
	include 'dbop.php';
	header("Cache-Control: no-cache");
	header("Pragma: no-cache");
	header("Content-type: text/html; charset=utf-8");
	$mydb = new mydb();
	if(!$mydb->dbh){
		echo "数据库连接失败，请查看网络连接<br>";
	}
	else{
		if(!isset($_GET['total'])){
			$news_count = $mydb->query('select count(*) from article');
			$news_count = $news_count[0][0];
		}
		else{
			$news_count = $_GET['total'];
		}
		if(isset($_GET['n'])){
			$page = $_GET['n'];
		}
		else{
			$page=0;
		}
		$temp = $page *PAGE_NUM;
		$temp2 = PAGE_NUM;
		$sql = "select * from article limit {$temp}, {$temp2}";
		$news_array = $mydb->query($sql);
		echo <<<str1
		<table width = "100%">
		<tr><td>
		<table border="0" cellpadding="3" cellspacing="1" width="80%" align="left" >
str1;
			
		echo "<tr style=\"text-align: center; COLOR: #242424; BACKGROUND-COLOR: #808080; font-weight: bold\"><td>序号</td><td>作者</td><td>标题</td><td>创建时间</td><td>类别</td><td>操作</td>";
		$count = PAGE_NUM*$page+1;
		foreach ($news_array as $news){
			$sql ="select * from category where categoryID ={$news[5]} and isvalid=1";
			$category = $mydb->query($sql);
			if(count($category)==0){
				$parent = "分类已被删除<br>";
			}
			else{
				$parent = $category[0][1];
			}
			echo "<tr   bgcolor='#C0C0C0' style='text-align:center'>";
			echo "<td>".$count."</td>";
			echo "<td>".$news[2]."</td>";
			echo "<td>".$news[1]."</td>";
			echo "<td>".$news[3]."</td>";
			echo "<td>".$parent."</td>";
			echo "<td><a href='./pageOp.php?type=0&id=".$news[0]."'>查看</a>&nbsp<a href=\"./pageOp.php?type=1&id=".$news[0]."\">delete</a>&nbsp<a href=\"./pageEdit.php?id=".$news[0]."\">修改</a>";
			$count++;
		}
		echo "</table></td></tr><tr><td><span>分页</span>";
		for($i=0;$i<=($news_count-1)/PAGE_NUM;$i++){
			$page = $i+1;
			echo "<a href='./pageManage.php?total={$news_count}&n={$i}'>{$page}</a>&nbsp";
		}
		echo "</td></tr>";
	}
?>
