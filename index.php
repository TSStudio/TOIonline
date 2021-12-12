<?php 
session_start();
if(!isset($_SESSION["id"])){
    $user="未登录用户";
    $islogged=false;
}else{
    $user=$_SESSION["id"];
    $islogged=true;
}



?>
<html>
    <head>
        <title>TOIonline</title>
    </head>
    <body>
    <?php 
if($islogged){
    echo "已登录用户：".$user."<br><a href=\"logout.php\">登出</a>";
}else{
    echo "尚未登录，若要参加考试，请 <a href=\"loginform.html\">注册或登录</a>";
    die();
}
include "contestinfo.php";
echo "<br><h2>".$name."</h2>";
echo date("Y-m-d H:i:s",$begintime)."-".date("Y-m-d H:i:s",$endtime)."<br>";
if(time()>=$problemdownloadbegin){
    echo "现在你可以下载试题：<a href=\"".$problemdownload."\">点击此链接</a>";
}else{
    echo "试题下载尚未开始。开始时间：".date("Y-m-d h:i:sa",$problemdownloadbegin);
}
if(time()<$begintime){die("考试尚未开始。请在开始后刷新。");}
if(time()>$endtime){die("考试已经结束");}

echo "<br>试题解压缩密码：".$problemkey;
echo "<h4>试题情况</h4><table border=1>";
echo "<tr><td>题目名称</td><td>文件名</td><td>你的提交</td></tr>";
$con=new \mysqli($dbhost,$dbuser,$dbpawd,$dbname);
$id=mysqli_real_escape_string($con,$_SESSION["id"]);


for($i=0;$i<$problemcount;$i++){
    $result=$con->query("SELECT id FROM TOIsubmissions WHERE id={$id} and prob={$i} LIMIT 1;");
    if($result->num_rows>0){$p="已提交，<a href=\"readcode.php?prob=".$problems[$i]."\">查看代码</a>";}
    else {$p="未提交";}
    echo "<tr><td>".$problemnames[$i]."</td><td>".$problems[$i]."</td><td>".$p."</td></tr>";
    
}
$con->close();
echo "</table>"
?><br>
    <a href="submission.php">提交试题</a>
    </body>

</html>