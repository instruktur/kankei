<?php  
$cbg= @$_REQUEST['cabang'];
$menu= @$_REQUEST['menu'];
$usr= @$_REQUEST['user'];
$theme= @$_REQUEST['theme'];
$page= @$_REQUEST['page'];
$did= @$_REQUEST['id'];

// re-format policy date
function getDeldate($str){
	$str= str_replace(" ", "|", $str);
	$nstr= explode("|", $str);
	$mstr= explode("/", $nstr[0]);
	$str= $mstr[2]."-".$mstr[1]."-".$mstr[0];
	return $str;
}
function getStadate($str){
	$str= str_replace("-", "|", $str);
	$str= str_replace(" ", "", $str);
	$nstr= explode("|", $str);
	$mstr= explode("/", $nstr[0]);
	$str= $mstr[2]."-".$mstr[1]."-".$mstr[0];
	return $str;
}
function getEnddate($str){
	$str= str_replace("-", "|", $str);
	$str= str_replace(" ", "", $str);
	$nstr= explode("|", $str);
	$mstr= explode("/", $nstr[1]);
	$str= $mstr[2]."-".$mstr[1]."-".$mstr[0];
	return $str;
}

//connect to the database 
include("./../config/database.php");
include("./../config/session.php");
//$connect = mysql_connect("localhost","root","system"); 
//mysql_select_db("im_isystem",$connect); //select the table 

//generate stamping
include("./../common/date.php");
$stm= $stamp;

if ($_FILES['csv']['size'] > 0) { 
	// set operation time
	ini_set('max_execution_time', 120);
    //get the csv file 
    $file = $_FILES['csv']['tmp_name']; 
    $handle = fopen($file,"r"); 
     
    //loop through the csv file and insert into database 
    do { 
//        if ($data[0]) { 
        if ($data[0]) { 
		$gsm= str_replace("`", "", $data[51]);
		$pst= str_replace("`", "", $data[50]);
		$cdm= str_replace("`", "", $data[52]);
		$tgl= getDeldate($data[28]);
		$inv= getDeldate($data[38]);
		$thn= substr($inv, 0, 4);
		$sta= getStadate($data[16]);
		$end= getEnddate($data[16]);

		$nomer_order= addslashes($data[0]); 
		$kode_langgan= addslashes($data[1]); 
		$nomer_polisi= addslashes($data[5]); 
		$tahun_mobil= addslashes($data[6]); 
		$mdl= addslashes($data[7]); 
		$fmdl= addslashes($data[9]); 
		$kode_warna= addslashes($data[10]); 
		$warna= addslashes($data[11]); 
		$no_chasis= addslashes($data[12]); 
		$no_engine= addslashes($data[13]); 
		$asuransi= addslashes($data[14]); 
		$no_polis= addslashes($data[15]); 
		$jangka_polis= addslashes($data[16]); 
		$groups= addslashes($data[26]); 
		$tgl_wo= addslashes($tgl); 
		$no_dok_klaim= addslashes($data[30]); 
		$tgl_invoice= addslashes($inv); 
		$sa= addslashes($data[39]); 
		$nama_surat= addslashes($data[47]); 
		$alamat_surat= addslashes($data[48]); 
		$kota_surat= addslashes($data[49]); 
		$pstn_surat= addslashes($pst); 
		$gsm_surat= addslashes($gsm); 
		$cdma_surat= addslashes($cdm); 
		$polis_start= addslashes($sta); 
		$polis_end= addslashes($end); 
		// devine j_tm
		$date=date_create($inv);
		date_add($date,date_interval_create_from_date_string("3 months"));
		$jtm= date_format($date,"Y-m-d");
		date_add($date,date_interval_create_from_date_string("2 months"));
		$jfm= date_format($date,"Y-m-d");

		// insert data kendaraan
		mysql_query("INSERT INTO `data_kendaraan` 
		(`kode_bp`, `tahun_mobil`, `no_polisi`, `no_engine`, `no_chasis`, `mdl`, `fmdl`, `warna`, `records`, `cabang`) VALUES 
		('$kode_langgan', '$tahun_mobil', '$nomer_polisi', '$no_engine', '$no_chasis', '$mdl', '$fmdl', '$warna', '$stm', '$cbg'); "); 

		// insert reminder
		mysql_query("INSERT INTO `data_reminder_so` (`kode_bp`, `cabang`, `no_chasis`, `nomer_order`, `records`, `j_call`, `sa`, `groups`, `tgl_invoice`) VALUES 
		('$kode_langgan', '$cbg', '$no_chasis', '$nomer_order', '$stm', '$jfm', '$sa', '$groups', '$tgl_invoice') 
		"); 

		// get kode langgan
		$sql="SELECT * FROM `data_kendaraan` WHERE `no_chasis`='$no_chasis';";
		$result=mysql_query($sql);
		$row=mysql_fetch_array($result);
		$kodebp= $row['kode_bp'];
		
		mysql_query("UPDATE `data_pelanggan` SET `kode_bp`='$kode_langgan', `nama_lengkap`='$nama_surat', `alamat_tinggal`='$alamat_surat', `kota_tinggal`='$kota_surat', `telepon`='$pstn_surat', `gsm`='$gsm_surat', `cdma`='$cdma_surat' WHERE `kode_bp`='$kodebp';");
		mysql_query("UPDATE `data_kendaraan` SET `kode_bp`='$kode_langgan', `no_polisi`='$nomer_polisi', `nama_asuransi`='$asuransi', `tgl_polis`='$polis_start', `tgl_habis`='$polis_end' WHERE `no_chasis`='$no_chasis';");

		// insert data kendaraan
		mysql_query("INSERT INTO `data_pelanggan` 
		(`cabang`, `nama_lengkap`, `alamat_tinggal`, `kota_tinggal`, `telepon`, `gsm`, `cdma`, `kode_bp`) VALUES 
		('$cbg', '$nama_surat', '$alamat_surat', '$kota_surat', '$pstn_surat', '$gsm_surat', '$cdma_surat', '$kode_langgan'); "); 

		// insert data pelanggan
		mysql_query("INSERT INTO `data_pelanggan` 
		(`cabang`, `nama_lengkap`, `alamat_tinggal`, `kota_tinggal`, `telepon`, `gsm`, `cdma`, `kode_bp`) VALUES 
		('$cbg', '$nama_surat', '$alamat_surat', '$kota_surat', '$pstn_surat', '$gsm_surat', '$cdma_surat', '$kode_langgan'); "); 
		} 
    } 
	// write to base
	while ($data = fgetcsv($handle,10000,";"," ")); 

    // 
//	$link= "cabang=".$cbg."&menu=".$menu."&success=1";
	$link= "./../mail/?page=".$page."&cbg=".$cbg."&d=".$d."&m=".$m."&y=".$y."&id=".$did."&user=".$usr."&menu=".$menu."&logso=".$stm;
    //redirect 
//	echo $link;
    header("Location: $link"); die; 
} 

?> 
