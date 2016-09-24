<?php  
$cbg= @$_REQUEST['cabang'];
$menu= @$_REQUEST['menu'];
$usr= @$_REQUEST['user'];
$theme= @$_REQUEST['theme'];
$page= @$_REQUEST['page'];
$did= @$_REQUEST['id'];

// re-format delivery date
function getDeldate($str){
	$str= str_replace(" ", "|", $str);
	$nstr= explode("|", $str);
	$mstr= explode("/", $nstr[0]);
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

    //get the csv file 
    $file = $_FILES['csv']['tmp_name']; 
    $handle = fopen($file,"r"); 
     
    //loop through the csv file and insert into database 
    do { 
        if ($data[0]) { 
		$pst= str_replace("'", "", $data[39]);
		$gsm= str_replace("'", "", $data[40]);
		$cdm= str_replace("'", "", $data[41]);
		$dde= getDeldate($data[49]);

		$no_spk= addslashes($data[2]); 
		$kode_type= addslashes($data[14]); 
		$nama_type= addslashes($data[15]); 
		$warna= addslashes($data[16]); $warna= ucwords($warna);
		$no_rangka= addslashes($data[17]); 
		$no_mesin= addslashes($data[18]); 
		$nama_sales= addslashes($data[19]); $nama_sales= ucwords($nama_sales);
		$pembayaran= addslashes($data[20]); 
		$tahun= addslashes($data[22]); 
		$no_polisi= addslashes($data[24]); 
		$nama_surat= addslashes($data[34]); $nama_surat= ucwords($nama_surat);
		$alamat_surat= addslashes($data[35]); $alamat_surat= ucwords($alamat_surat);
		$kode_pos_surat= addslashes($data[36]); 
		$kota_surat= addslashes($data[37]); $kota_surat= ucwords($kota_surat);
		$propinsi_surat= addslashes($data[38]); $propinsi_surat= ucwords($propinsi_surat);
		$telp_surat= addslashes($pst); 
		$gsm_surat= addslashes($gsm); 
		$cdma_surat= addslashes($cdm); 
		$supervisor= addslashes($data[42]); $supervisor= ucwords($supervisor);
		$delivery_customer= $dde; 
		// devine j_dm
		$date=date_create($dde);
		date_add($date,date_interval_create_from_date_string("24 days"));
		$jdm= date_format($date,"Y-m-d");
		// devine j_call
		date_add($date,date_interval_create_from_date_string("30 days"));
		$jcl= date_format($date,"Y-m-d");

//		mysql_query("INSERT INTO `data_sales` (`kode_type`, `nama_type`, `warna`, `no_rangka`, `no_mesin`, `nama_sales`, `pembayaran`, `tahun`, `no_polisi`, `nama_surat`, `alamat_surat`, `kode_pos_surat`, `kota_surat`, `propinsi_surat`, `telp_surat`, `gsm_surat`, `cdma_surat`, `supervisor`, `delivery_customer`, `record`, `j_dm`) VALUES 
//		('$kode_type', '$nama_type', '$warna', '$no_rangka', '$no_mesin', '$nama_sales', '$pembayaran', '$tahun', '$no_polisi', '$nama_surat', '$alamat_surat', '$kode_pos_surat', '$kota_surat', '$propinsi_surat', '$telp_surat', '$gsm_surat', '$cdma_surat', '$supervisor', '$delivery_customer', '$stm', '$jdm') 
//		"); 

		// insert data kendaraan
		mysql_query("INSERT INTO `data_kendaraan` 
		(`kode_bp`, `tahun_mobil`, `no_polisi`, `no_engine`, `no_chasis`, `mdl`, `fmdl`, `warna`, `deldate`, `records`, `pembayaran`, `cabang`, `isnew`) VALUES 
		('$no_spk', '$tahun', '$no_polisi', '$no_mesin', '$no_rangka', '$kode_type', '$nama_type', '$warna', '$delivery_customer', '$stm', '$pembayaran', '$cbg', 'YES'); "); 

		// insert data pelanggan
		$propin= $kota_surat." - ".$propinsi_surat;
		mysql_query("INSERT INTO `data_pelanggan` 
		(`cabang`, `nama_lengkap`, `alamat_tinggal`, `kota_tinggal`, `kode_tinggal`, `telepon`, `gsm`, `cdma`, `kode_gr`, `kode_bp`) VALUES 
		('$cbg', '$nama_surat', '$alamat_surat', '$propin', '$kode_pos_surat', '$telp_surat', '$gsm_surat', '$cdma_surat', '$no_spk', '$no_spk'); "); 

		// insert data reminder
		mysql_query("INSERT INTO `data_reminder_do` 
		(`kode_bp`, `no_chasis`, `records`, `j_dm`, `cabang`, `j_call`) VALUES 
		('$no_spk', '$no_rangka', '$stm', '$jdm', '$cbg', '$jcl'); "); 

        } 
    } 
	while ($data = fgetcsv($handle,1000,";"," ")); 
    // 
//	$link= "cabang=".$cbg."&menu=".$menu."&success=1&pre=".$stm;
//	$link= "./../".$theme."/?page=".$page."&cbg=".$cbg."&d=".$d."&m=".$m."&y=".$y."&id=".$did."&user=".$usr."&menu=".$menu."&logdo=".$stm;
	$link= "./../mail/?page=".$page."&cbg=".$cbg."&d=".$d."&m=".$m."&y=".$y."&id=".$did."&user=".$usr."&menu=".$menu."&logdo=".$stm;
    //redirect 
//	echo $link;
    header("Location: $link"); die; 
} 

?> 
