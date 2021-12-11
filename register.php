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
if(strlen($_POST["email"])>80){exit("TOO LONG EMAIL");}
if(strlen($_POST["email"])<6){exit("TOO SHORT EMAIL");}
if(strlen($_POST["nickname"])>19){exit("TOO LONG NICKNAME");}
if(strlen($_POST["nickname"])<2){exit("TOO SHORT NICKNAME");}
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
$password=hash("sha256",$_POST["passcode"]);
$salt=random(8);
$password=hash("sha256",$password.$salt);
$con=new \mysqli($dbhost,$dbuser,$dbpawd,$dbname);
if(!$con){
    die('数据库连接失败' . mysqli_error($con));
}
$nickname=mysqli_real_escape_string($con,$_POST["nickname"]);
$email=mysqli_real_escape_string($con,$_POST["email"]);
$con->query("INSERT INTO TOIusers (nickname,passcode,salt,email) VALUES ('{$nickname}','{$password}','{$salt}','{$email}')") or die("存入数据库失败" . mysqli_error());

//------------REGISTER DONE--------------
$dbid=null;
$result=$con->query("select id from TOIusers where passcode='{$password}' and salt='{$salt}';");
while($row=mysqli_fetch_array($result)){
    $dbid=$row["id"]; 
}
$con->close();
//--GET ID DONE--
include_once '../include/aliyun-php-sdk-core/Config.php';
use Dm\Request\V20151123 as Dm;            
$iClientProfile = DefaultProfile::getProfile("cn-hangzhou", $aliaccesskey, $aliaccesssecret);        
$client = new DefaultAcsClient($iClientProfile);    
$request = new Dm\SingleSendMailRequest();     
$request->setAccountName("no-reply@mailsend.tmysam.top");
$request->setFromAlias("TSStudio");
$request->setAddressType(1);
$request->setTagName("TSStudio");
$request->setReplyToAddress("true");
$request->setToAddress($email);
$request->setSubject("TOI Online 注册提醒");
$htmlbody='<div><h2>欢迎注册 TOI online 答题系统</h2>用户 '.$_POST["nickname"].'：<br>你的 ID 是：'.$dbid.'</div>';
$request->setHtmlBody($htmlbody);        
try {
    $response = $client->getAcsResponse($request);
}
catch (ClientException $e) {
    print_r($e->getErrorCode());   
    print_r($e->getErrorMessage());   
}
catch (ServerException $e) {        
    print_r($e->getErrorCode());   
    print_r($e->getErrorMessage());
}
?>
<script type="text/javascript"> 
    alert("注册成功，包含你的 ID (<?=$dbid?>) 的邮件已发送"); 
    window.location.href="loginform.html"; 
</script> 