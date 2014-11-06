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
	switch ($type){
		case 0:{  //删除分类
			$id = $_GET['id'];
			$sql = "update category set isvalid=0 where categoryID = {$id}";
			$ret = $mydb->update($sql);
			if($ret){
				echo "删除分类成功<br>";
			}
			else{
				echo "删除分类失败<br>";
			}
			break;
		}
		case 1:{ //添加分类
			$name = $_POST['name'];
			$parent = $_POST['parentCategory'];
			$sql = "insert into category(name, parentID) values('{$name}', {$parent})";
			$ret = $mydb->insert($sql);
			if($ret){
				echo "插入分类成功<br>";
			}
			else{
				echo "插入分类失败<br>";
			}
			break;
		}
		case 2:{  //更新分类
			$id = $_GET['id'];
			$name = $_POST['name'];
			$parent = $_POST['parentCategory'];
			$sql = "update category set name='{$name}', parentID={$parent} where categoryID={$id}";
			$ret = $mydb->update($sql);
			if($ret){
				echo "更新分类成功<br>";
			}
			else{
				echo "更新分类失败<br>";
			}
			break;
		}
		case 3:{  //还原分类
			$id = $_GET['id'];
			$sql = "update category set isvalid = 1 where categoryID = {$id}";
			$ret = $mydb->update($sql);
			if($ret){
				echo "还原成功<br>";
			}
			else{
				echo "还原失败<br>";
			}
			break;
		}
		case 4:{ //彻底删除分类
			$id = $_GET['id'];
			$sql = "delete from category where categoryID= {$id}";
			$ret = $mydb->delete($sql);
			if($ret){
				echo "删除成功<br>";
				
			}
			else{
				echo "删除失败<br>";
			}
			break;
		}
	}
	if($type==3 || $type == 4){
	 	echo "<a href ='./recycleBin.php'>返回</a>";
	}
	else{
		echo "<a href ='./categoryManage.php'>返回</a>";
	}


?>