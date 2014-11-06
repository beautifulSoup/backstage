<?php
	define("PAGE_NUM", 20);
	include 'dbop.php';
	header("Cache-Control: no-cache");
	header("Pragma: no-cache");
	header("Content-type: text/html; charset=utf-8");
	$mydb = new mydb();
	$c = $_GET['category'];
	if(!$mydb->dbh){
		echo "数据库连接失败，请查看网络连接<br>";
	}
	else{
		if(!isset($_GET['total'])){
			$sql = "select count(*) from article where parentID={$c}";
			$news_count = $mydb->query($sql);
			//echo $sql."<br>";
			$news_count = $news_count[0][0];
			//echo $news_count."<br>";
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
		$sql = "select * from (select * from article where parentID={$c}) as temptable limit {$temp}, {$temp2}";
		//echo $sql;
		$news_array = $mydb->query($sql);
		//echo count($news_array);
		echo <<<str1
		<table width = "100%">
		<tr><td>
		<table border="0" cellpadding="3" cellspacing="1" width="80%" align="left" >
str1;
			
		echo "<tr style=\"text-align: left; font-weight: bold\"><td>序号</td><td>标题</td><td>创建时间</td>";
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
			echo "<tr   style='text-align:left'>";
			echo "<td>".$count."</td>";
			echo "<td><a href='./pageView?id={$news[0]}'>{$news[1]}</td>";
			echo "<td>".$news[3]."</td>";
			$count++;
		}
		echo "</table></td></tr><tr><td><span>分页</span>";
		for($i=0;$i<=($news_count-1)/PAGE_NUM;$i++){
			$page = $i+1;
			echo "<a href='./listView.php?category={$c}&total={$news_count}&n={$i}'>{$page}</a>&nbsp";
		}
		echo "</td></tr>";
	}
?>
