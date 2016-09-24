<?php
// min warn before start process
// =============|=======|===========|===============>
// 				^startt	^starto		^estart

$starto= 5; // bgbstart
$startt= $starto + 10; // bgastart

// min warn before stop process
// =============|===========|=======|===============>
// 				^stopt		^stopo	^estop

$stopo= 15; // bgastop
$stopt= $stopo + 15; // bgbstop

// MIN WARN TO STOP WASH
// =================================|===============|
// 									^HERE			^OTD
$washo= 15; // min before otd = wash OTD
$washx= 15; // leadtime washing
$otdwx= 10;	// min warn before ends

// MIN WARN TO STOP FINAL
// 						 |  LT WASH |
// =================|===============|===============|
// 					^HERE			^WASH ENDS		^OTD

$washw= 10; // min waiting for washing 
$finalw= $washo + $washx + $washw;

// min warn before final stop
// =========================|=======|===============>
// 							^finalo	^fstop

$finalx= 10; // min warn 
$finalo= $finalw + $finalx; // only bgafinal

// $nnow= date('H:i', time()); $nnow= htomin($nnow);
?>