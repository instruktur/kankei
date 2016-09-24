<?php  
$cbg= @$_REQUEST['cabang'];
$menu= @$_REQUEST['menu'];
$usr= @$_REQUEST['user'];
$theme= @$_REQUEST['theme'];
$page= @$_REQUEST['page'];
$did= @$_REQUEST['id'];

$nama= @$_REQUEST['nama'];
$pang= @$_REQUEST['panggilan'];
$gsm= @$_REQUEST['gsm'];
$email= @$_REQUEST['email'];

//connect to the database 
include("./../config/database.php");
include("./../config/session.php");
//$connect = mysql_connect("localhost","root","system"); 
//mysql_select_db("im_isystem",$connect); //select the table 

//generate stamping => digunakan utk nama file photo
include("./../common/date.php");
$stm= $stamp;
$photoN= str_replace(" ", "", $stm);

// get photo uploaded info
// Ambil Data yang Dikirim dari Form
//$nama_file = $_FILES['photo']['name'];
$photoS= $_FILES['photo']['size'];
$photoY= $_FILES['photo']['type'];
$photoF= $_FILES['photo']['tmp_name'];

// path
$fname= basename($_FILES["photo"]["name"]);
$path=  "./../photo/".$fname;

if (($photoS > 0) AND ($photoY== "image/jpeg" || $photoY == "image/png")) { 
//if (($photoS > 0 AND $photoS < 30000000) AND $photoY== "image/jpeg") { 
	if(move_uploaded_file($photoF, $path)){
//	if(move_uploaded_file($_FILES["photo"]["tmp_name"], $path)){
		// Update data manpower
		mysql_query("UPDATE `data_manpower` SET `nama`='$nama',`nama_panggilan`='$pang',`gsm`='$gsm',`email`='$email',`photo`='$fname' WHERE `id`='$did'; "); 

		// Insert log
		$fp=fopen("./../logs/ims_logs.txt","a"); $aksi= "Update Profile and photo $jab $usr ";
		$pdtbl  = "$usr~$d/$m/$dY~$tima~$aksi\n";
		fwrite($fp,$pdtbl);
		mysql_query("INSERT INTO `log_user` (`cabang`, `user`, `tgl`, `bln`, `thn`, `jam`, `record`) VALUES ('$cbg', '$usr', '$d', '$m', '$y', '$tima', '$aksi');");
		$log= "Sukses Update Profile And Photo";
        } else {$log= "Gagal Update Profile dan Photo"; }
    } else {
		// Update data manpower
		mysql_query("UPDATE `data_manpower` SET `nama`='$nama',`nama_panggilan`='$pang',`gsm`='$gsm',`email`='$email' WHERE `id`='$did'; "); 

		// Insert log
		$fp=fopen("./../logs/ims_logs.txt","a"); $aksi= "Update Profile $jab $usr ";
		$pdtbl  = "$usr~$d/$m/$dY~$tima~$aksi\n";
		fwrite($fp,$pdtbl);
		mysql_query("INSERT INTO `log_user` (`cabang`, `user`, `tgl`, `bln`, `thn`, `jam`, `record`) VALUES ('$cbg', '$usr', '$d', '$m', '$y', '$tima', '$aksi');");
		$log= "Sukses Update Profile";
		}
    // create redirect link
	$link= "./../mail/?page=".$page."&cbg=".$cbg."&d=".$d."&m=".$m."&y=".$y."&id=".$did."&user=".$usr."&menu=".$menu."&logpo=".$log;
    //redirect 
//	echo $link;
    header("Location: $link"); die; 
?> 
