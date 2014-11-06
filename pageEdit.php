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

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Insert title here</title>
    <script type="text/javascript" src="./ueditor/ueditor.config.js"></script>
    <script type="text/javascript" src="./ueditor/ueditor.all.min.js"></script>
<script type=text/javascript>
	function reset(){
		var titleArea = document.getElementById("title");
		titleArea.value="";
		var ue = UE.getEditor('container');
		ue.setContent("");
		var category = document.getElementById("category");
		category.options[0].selected=true;
		return　false;
	}
	
	function checkForm(){
		var titleArea = document.getElementById("title");
		var ue = UE.getEditor('container');
		var category = document.getElementById("category");
		if(titleArea.value==""){
			alert("请输入文章标题");
			return false;
		}
		else if(ue.getContent()==""){
			alert("请选择文章内容");
			return false;
		}
		else if(category.value=='-2'){
			alert("请输入文章类别");
			return false;
		}
		else
			return true;
	}

	function preview(){
		var title = document.getElementById("title").value;
		var category = document.getElementById("category").value;
		var content = UE.getEditor('container').getContent();

		var win = window.open("./pageOp.php?type=3", ""); //
		win.document.writeln("<title>文章预览</title>");
		win.document.writeln("<h1 style=\"text-align:center\">"+title+"</h1><br>");
		win.document.writeln("<div>"+content+"</div><br>");
		return false;
	}

	<?php 
		require_once 'dbop.php';
		$content=null;
		if(isset($_GET['id'])){
			$mydb = new mydb();
			$id=$_GET['id'];
			$sql = "select * from article where id = ".$id;
			$article = $mydb->query($sql);
			if(!$article){
				echo "数据库查询失败<br>";
			}
			else{
				$a = $article[0];
				$title = $a[1];
				$content = $a[4];
				$category = $a[5];
				$sql = "select * from category where categoryID = ".$category;
				$temp = $mydb->query($sql);
				if(count($temp)==0||$temp[0][3]==0){
					$category = -2;
				}

				echo <<<func
				window.onload=function(){
					var titleArea = document.getElementById("title");
					var categorySelect = document.getElementById("category");
					titleArea.value = "{$title}";
					categorySelect.value = {$category};
				}
	
func;
			}
		}
	?>
		
		
	
</script>
</head>
<body>
	<FORM method="post" action="./pageOp.php?type=2<?php 
		if(isset($_GET['id'])){
			echo '&id='.$_GET['id'];
		}
	?>" onsubmit="return checkForm();">
	标题:<INPUT id="title" type="text" name="title" style="width:500px">
	类别:<select id="category" name="category">
		<option value='-2' selected="selected"></option>  <!-- default empty option -->
		<?php 
			$mydb=new mydb();
			$sql = "select * from category where isvalid=1";
			$categories = $mydb->query($sql);
			$count = count($categories);
			for($i=1;$i<$count;$i++){
				$value = $categories[$i][0]; //the id of the category
				$name = $categories[$i][1];
				echo "<option value='{$value}'>{$name}</option>";
			}
		
		?>
	</select><br>
	<script id="container" name="content" type="text/plain">
        <?php
        	if($content){ 
       			echo $content;
			}
		?>
    </script>

    <script type="text/javascript">
        var ue = UE.getEditor('container',{initialFrameHeight:300});

    </script>
    <INPUT type="submit" value="提交">
    <!--<button type="button" onclick="reset()">重置</button> -->
	<button type="button" onclick="preview()">预览</button>  
    </FORM>
  
</body>
</html>