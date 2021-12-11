<?php 
error_reporting(E_ALL || ~ E_NOTICE);
session_start();
//$_SESSION["id"]="CN-001";//FOR DEBUGGING ONLY
if(!isset($_SESSION["id"])){
    die("NOT LOGGED YET");
}
function find_by_foreach($array,$find){
    foreach($array as $key => $v){
        if($v==$find){
            return $key;
        }
    }
}
include "contestinfo.php";
if(time()<$begintime){die("考试尚未开始。请在开始后刷新。");}
if(time()>$endtime){die("考试已经结束");}
if(!in_array($_POST["prob"],$problems)){die("INVALID SUBMISSION");}
$probid=find_by_foreach($problems,$_POST["prob"]);
$sizeb=$_FILES["file"]["size"];
if($sizeb>102400){die("INVALID SIZE:OVER 100KB");}
if($_FILES["file"]["error"]>0){echo "Error: ".$_FILES["file"]["error"]."<br />";die();}
// /opt/TOI/users/$_SESSION["id"]/$_POST["prob"]/$_POST["prob"].cpp
if(!file_exists("/opt/TOI/users/".$_SESSION["id"])){
    mkdir("/opt/TOI/users/".$_SESSION["id"]);
    for($i=0;$i<$problemcount;$i++){
        mkdir("/opt/TOI/users/".$_SESSION["id"]."/".$problems[$i]);
    }
}
move_uploaded_file($_FILES["file"]["tmp_name"],"/opt/TOI/users/".$_SESSION["id"]."/".$_POST["prob"]."/".$_POST["prob"].".cpp");
echo "已存储<a href=\"index.php\">返回</a><br><a href=\"readcode.php?prob=".$_POST["prob"]."\">查看代码</a>";
//需要在数据库中存储提交信息
$con=new \mysqli($dbhost,$dbuser,$dbpawd,$dbname);
$id=mysqli_real_escape_string($con,$_SESSION["id"]);
$time=time();
$con->query("INSERT INTO TOIsubmissions (id,time,prob) VALUES ('{$id}','{$time}','{$probid}');");
$con->close();
?>