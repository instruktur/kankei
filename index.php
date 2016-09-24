<!DOCTYPE html>
<?php 
include("./config/database.php");
include("./config/session.php");

// identify the client ip, save to base
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
	mysql_query("INSERT INTO `rec_user` (`ip`) VALUES ('$ip');");
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	mysql_query("INSERT INTO `rec_user` (`ip`) VALUES ('$ip');");
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
	mysql_query("INSERT INTO `rec_user` (`ip`) VALUES ('$ip');");
}

// start paging
$show = 0;
// get cabang by ip address 
$qry = mysql_query("SELECT `cabang` FROM `rec_user` WHERE `ip`='$ip'; ");
$num = mysql_num_rows($qry);
$row = mysql_fetch_array($qry);
$cbg = $row['cabang'];
if($cbg != ""){$show= 1; }

// display when cabang found by ip address
if($show==1){
	$cbg = $row['cabang'];
	include("./common/init.php"); 
	include("./common/date.php"); 
	$link= "cbg=".$cbg."&d=".$d."&m=".$m."&y=".$y;
//	$cbg= @$_REQUEST['cbg'];
	?>
	<html>
		<head>
			<title><?php echo $Xtext['mTitle']; ?></title>
		</head>
		<frameset rows="0,*">
			<frame src="dummy.php" name="top" frameborder=0 noresize>
			<frame src="./login/?<?php echo $link; ?>&menu=login" name="main">
		</frameset>
	</html>
	<?php
}else{
//	include("./getIP.php");
	include("./common/init.php"); 
	?>
	<html>
		<head>
			<title><?php echo $Xtext['mTitle']; ?></title>
		</head>
		<frameset rows="0,*">
			<frame src="./dummy.php" name="top" frameborder=0 noresize>
			<frame src="./getIP.php?ip=<?php echo $ip; ?>" name="main">
		</frameset>
	</html>
	<?php
}
?>
