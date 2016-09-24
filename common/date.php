<?php
// devine time zone
date_default_timezone_set("Asia/Jakarta");
// Devine time stamp
$times= 0; //pluss 10 * 3600

// devine date
$d= 1; $dx=date('d'); if (substr($dx, 0, 1)== 0) {$d= substr($dx, 1); } else {$d= $dx; }
$m= 1; $mx=date('m'); if (substr($mx, 0, 1)== 0) {$m= substr($mx, 1); } else {$m= $mx; }
$y=date('y');

// devine else
$dY= date('Y');
$time= date('h:i:s', time() + $times);
$tima= date('h:i:sa', time() + $times);
$dmy= date('dmy'); 
$day= date('w'); 
$stamp= date('Y-m-d h:i:s', time() + $times);
?>
