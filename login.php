<?php
error_reporting(E_ALL || ~ E_NOTICE);
session_start();
if(isset($_REQUEST['authcode'])){
    if(strtolower($_REQUEST['authcode'])!=$_SESSION['authcode']){
        echo "<script language=\"javascript\">";
        echo "alert(\"验证码错误\");";
        echo "document.location=\"./reset.php\"";
        echo "</script>";
        exit();
    }
}
if(strlen($_POST["username"])==0){exit("TOO SHORT ID");}
if(strlen($_POST["passcode"])<2){exit("TOO SHORT PASSWORD");}
function random($length) {
    srand(date("s"));
    $possible_charactors = "0123456789abcdef";
    $string = "";
    while (strlen($string) < $length) {
        $string.= substr($possible_charactors, (rand() % (strlen($possible_charactors))) , 1);
    }
    return ($string);
}
include "contestinfo.php";
$con=new \mysqli($dbhost,$dbuser,$dbpawd,$dbname);
$id=mysqli_real_escape_string($con,$_POST["username"]);
$dbusername=null;
$dbpassword=null;
$dbnickname=null;
$dbsalt=null;
$result=$con->query("select nickname,id,passcode,salt from TOIusers where id ='{$id}';");
while($row=mysqli_fetch_array($result)){
    $dbusername=$row["id"]; 
    $dbpassword=$row["passcode"]; 
    $dbnickname=$row["nickname"];
    $dbsalt=$row["salt"];
}
if(is_null($dbusername)){
?>
    <script type="text/javascript">
        alert("用户名不存在");
        window.location.href="loginform.php";
    </script> 
<?php  
die();
}
$password=hash("sha256",$_POST["passcode"]);
$password=hash("sha256",$password.$dbsalt);
if($password!=$dbpassword){
?>
    <script type="text/javascript">
        alert("密码错误");
        window.location.href="loginform.php";
    </script> 
<?php  
die();
}
$con->close();
$_SESSION["id"]=$dbusername;
?>
<script type="text/javascript">
    window.location.href="index.php"; 
</script> 