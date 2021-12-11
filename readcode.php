<?php 
error_reporting(E_ALL || ~ E_NOTICE);
session_start();
if(!isset($_SESSION["id"])){
    die("NOT LOGGED YET");
}
include "contestinfo.php";
if(!in_array($_GET["prob"],$problems)){die("INVALID QUERY");}
// /opt/TOI/users/$_SESSION["id"]/$_POST["prob"]/$_POST["prob"].cpp
if(!file_exists("/opt/TOI/users/".$_SESSION["id"]."/".$_GET["prob"]."/".$_GET["prob"].".cpp")){
    die("NOT UPLOADED YET.");
}
$s=file_get_contents("/opt/TOI/users/".$_SESSION["id"]."/".$_GET["prob"]."/".$_GET["prob"].".cpp");
echo "<a href=\"index.php\">返回</a><pre>".htmlspecialchars($s)."</pre>"
;
?>