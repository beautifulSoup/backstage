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
	include("dbop.php");
	date_default_timezone_set('PRC');
	header("Content-type: text/html; charset=utf-8");
	$type= $_GET['type'];
	$mydb = new mydb();
	if($type==0){   //查看文章
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
	}
	else if($type==1){   //删除文章
		$id = $_GET['id'];
		$sql = "delete from article where id =".$id;
		$ret = $mydb->delete($sql);
		if(!$ret){
			echo "删除文章失败, 请重试<br>";
		}
		else{
			echo "删除文章成功<br>";
		}
	}
	else if($type==2){   
		if(!isset($_GET['id'])){ //添加文章
			$title = $_POST['title'];
			$content = $_POST['content'];
			$category = $_POST['category'];
			$author = 'admin'; //here should to get user name from session;
			$date = date('Y-m-d H:i:s',time());
			$sql = 'insert into article(title,author, date, content, parentID) values(\''.$title.'\', \''.$author.'\', \''.$date.'\', \''.$content.'\','.$category.')';
			//echo $sql.'<br>';
			if($mydb->insert($sql)){
				echo '添加文章成功<br>';
			
			}
			else{
				echo '添加文章失败<br>';
			}
		}
		else{   //修改文章
			$id = $_GET['id'];
			$title = $_POST['title'];
			$content = $_POST['content'];
			$category = $_POST['category'];
			$sql = "update article set title ='{$title}', content='{$content}', parentID ={$category} where id = {$id}";
			//echo $sql;
			if($mydb->update($sql)){
				echo '更新成功<br>';
				
			}
			else{
				echo '更新失败<br>';
			}
		}

	}
	else if($type==3){  //预览文章
		
	}
	echo "<a href='./pageManage.php?n=0'>返回</a><br>";

?>
