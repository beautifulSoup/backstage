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
	header("Content-type: text/html; charset=utf-8");
	header("Cache-Control: no-cache");
	header("Pragma: no-cache");
	
	$mydb = new mydb();
	$sql = "select * from category where isvalid =1";
	$categories = $mydb->query($sql);
	echo "<table width='100%'><tr><td>";

	echo <<<func1
	<script type="text/javascript">
	function modify(id, name, parent){
		var url = "./categoryOp.php?type=2&id="+id;
		var form = document.getElementById('submitForm');
		form.action=url;
		var nameText = document.getElementById("name");
		var parentSelect = document.getElementById("parentCategory");
		nameText.value = name;
		parentSelect.value = parent;
		var button = document.getElementById('submitButton');
		button.value="修改";
		var cancleButton = document.getElementById('cancleButton');
		cancleButton.style.display="";
	
	}
	function cancleModify(){
		var url = "./categoryOp.php?type=1";
		var form = document.getElementById('submitForm');
		form.action=url;
		var nameText = document.getElementById("name");
		var parentSelect = document.getElementById("parentCategory");
		nameText.value = "";
		parentSelect.value = -2;
		var button = document.getElementById('submitButton');
		button.value="提交";
		var cancleButton = document.getElementById('cancleButton');
		cancleButton.style.display="none";

	}
	</script>
func1;
	echo "<div><table border='0' cellpadding='3' cellspacing='1' width='80%' align='left'><tr style=\"text-align: center; COLOR: #242424; BACKGROUND-COLOR: #808080; font-weight: bold\"><td>序号</td><td>分类名</td><td>父分类</td><td>操作</td></tr>";
	for($i=1;$i<count($categories);$i++){
		$sql ="select name from category where categoryID={$categories[$i][2]}";
		$tempArray = $mydb->query($sql);
		if(count($tempArray)==0){
			$parentName = "父分类已被删除";
		}
		else{
			$parentName = $tempArray[0][0];
		}
		
		echo "<tr bgcolor='#C0C0C0' style='text-align:center'><td>{$i}</td><td>{$categories[$i][1]}</td><td>{$parentName}</td><td><a href='categoryOp.php?type=0&id={$categories[$i][0]}'>删除</a>&nbsp<a href=\"javascript:modify({$categories[$i][0]}, '{$categories[$i][1]}', {$categories[$i][2]})\">修改</a></td></tr>";
	}
	echo "</table>";
			
			
			
			
			
	echo  "</div></td></tr>";
	echo <<<formHead
	
	<tr><td>
	
	<div>
		<span>添加分类</span>
		<script type="text/javascript">
			function checkForm(){
				var nameText = document.getElementById("name");
				var parentSelect = document.getElementById("parentCategory");
				if(nameText.value==""){
					alert("请填写分类名");
					return false;
				}
				else if(parentSelect.value=="-2"){
					alert("请选择父分类");
					return false;
				}
				return true;
			}
		</script>
		<FORM id="submitForm" method="POST" action="./categoryOp.php?type=1" onsubmit="return checkForm()";>
			<input type="text"  id="name" name="name"></input> 
			<select  id="parentCategory" name = "parentCategory">
			<option value="-2" selected="selected"></option>
formHead;
	for($i=0;$i<count($categories);$i++){
		echo "<option value='{$categories[$i][0]}'>{$categories[$i][1]}</option>";
		
	}
	echo <<<formTail
	</select>
	<input id = 'submitButton' type="submit" value="提交"></input>
	<button id = 'cancleButton' type="button" value="取消" onclick="cancleModify()" style="display:none;">取消</button>
	
	</FORM>
	</div>
	</td></tr>
</table>
	<a href="recycleBin.php">分类回收站</a>
formTail;
?>