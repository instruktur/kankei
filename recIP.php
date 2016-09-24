<?php
$cbg= @$_REQUEST['cabang'];
$ip= @$_REQUEST['ip'];
//echo $cbg;
include("./config/database.php");
include("./config/session.php");
mysql_query("INSERT INTO `rec_user` (`ip`) VALUES ('$ip');");
mysql_query("UPDATE `rec_user` SET `cabang`='$cbg' WHERE `ip`='$ip'; ");
echo "<script> var myWindow = window.open(\"./?\", \"main\", \"\");</script>";
?>