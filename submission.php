<?php session_start(); ?>
<html>
<head>
<title>提交程序</title>
</head>
<?php
error_reporting(E_ALL || ~E_NOTICE);
include('contestinfo.php');
//$_SESSION["id"]="CN-001";//FOR DEBUGGING ONLY
if(!isset($_SESSION["id"])){
    die("NOT LOGGED YET");
}
if(time()<$begintime){die("考试尚未开始。请在开始后刷新。");}
if(time()>$endtime){die("考试已经结束");}
?>
<a href="index.php">Back</a><br>
<?php
echo $_SESSION["id"];
?>
提示：请使用 文件输入输出<br>
<form action="uploadprocess.php" method="post" enctype="multipart/form-data">
<select name="prob">
<?php 
for($i=0;$i<$problemcount;$i++){
    echo '<option value="'.$problems[$i].'">'.$problems[$i].'</option>';
}
?>
</select>
<label for="file">Filename:</label>
<input type="file" name="file" id="file" accept=".cpp"/> 
<br/>
<input type="submit" name="submit" value="Submit" />
</form>
</html>