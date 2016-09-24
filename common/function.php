<?php
// convert minute to hh:mm
function mintoh($num){
	$min= $num % 60;
	$hou= ($num - $min) / 60;
	$min= sprintf("%02d", $min);
	$hou= sprintf("%02d", $hou);
	return $hou.":".$min;
}
// convert hh:mm to minutes
function htomin($num){
	$temp= explode(":", $num);
	$min= (60 * $temp[0]) + $temp[1];
	return $min;
}
// generate token
function gtoken($cbg, $jab, $usr){
	include("./../../preconfig/s_date.php");
	$njab= strlen($jab);
	$xcbg= substr($cbg, -2); 
	$ld= strlen($d); if($ld==1){$d= "0".$d; }
	$lm= strlen($m); if($lm==1){$m= "0".$m; }

	$xxx= $njab.$jab.$usr;
	$yyy= $d.$m.$xcbg.$y;
	$yyy= dechex($yyy);
	$yy= dechex($yyy);
	return $xxx."-".$yyy;
}
// gen legend
function legend($d, $w, $i){
echo "<table cellpadding=0 cellspacing=0 border=1 width=100%> \n".
	 "	<tr align=\"center\"> \n".
	 "		<td width=20 bgcolor=\"red\">&nbsp;</td><td> &lt;".$d."' </td> \n".
	 "		<td width=20 bgcolor=\"yellow\">&nbsp;</td><td> ".$d."'-".$w."' </td> \n".
	 "		<td width=20 bgcolor=\"green\">&nbsp;</td><td> ".$w."'-".$i."' </td> \n".
	 "		<td width=20 bgcolor=\"transparent\">&nbsp;</td><td> &gt;".$i."' </td> \n".
	 "	</tr> \n".
	 "</table> \n";
}
// footer
function footer(){
	$curY= date('Y');
	echo "	<!-- Footer --> \n";
//	echo "	<footer class=\"w3-container w3-theme-dark w3-padding-16\" style=\"bottom:10px;position:absolute\"> \n";
	echo "	<footer class=\"w3-container w3-theme-dark w3-padding-16\"\"> \n";
	echo "		<p>&copy;Tulus Sanyata. All right reserved &reg;2013-$curY</p> \n";
//	echo "		<div style=\"position:relative;bottom:55px;\" class=\"w3-tooltip w3-right\"> \n";
//	echo "		<span class=\"w3-text w3-theme-light w3-padding\">Go To Top</span>  \n";
//	echo "		<a class=\"w3-text-white\" href=\"#myHeader\"><span class=\"w3-xlarge\"> \n";
//	echo "		&#9650;</span></a> \n";
//	echo "		</div> \n";
	echo "	</footer> \n";
}
// agama
function opreligi(){
	$agama= array("Islam", "Nasrani", "Hindu", "Budha", "Konghuchu");
	foreach($agama as $val){
		echo "<option value=\"".$val."\">".$val."</option> \n";
	}
}
// calendar view
function draw_calendar($month, $year, $str, $menu){
	$xmth= $month - 1;
	// Draw table for Calendar 
	$calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';

	// Draw Calendar table headings 
//	$headings = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
	$headings = array('Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu');
	$calendar.= '<tr class="calendar-row">';
	$calendar.= '<td class="calendar-day-head" height=48>'.implode('</td><td class="calendar-day-head">',$headings).'</td>';
	$calendar.= '</tr>';

	//days and weeks variable for now ... 
	$running_day = date('w',mktime(0,0,0,$month,1,$year));
	$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
	$days_in_this_week = 1;
	$day_counter = 0;
	$dates_array = array();

	// row for week one 
	$calendar.= '<tr class="calendar-row">';

	// Display "blank" days until the first of the current week 
	for($x = 0; $x < $running_day; $x++):
		$calendar.= '<td class="calendar-day-np" height=48>&nbsp;</td>';
		$days_in_this_week++;
	endfor;

	// Show days.... 
	for($list_day = 1; $list_day <= $days_in_month; $list_day++):
		if($list_day==date('d') && $month==date('n'))
		{
			$currentday='currentday';
		}else
		{
			$currentday='';
		}
		$calendar.= '<td class="calendar-day '.$currentday.'" height=48>';
		
			// Add in the day number
			if($list_day<date('d') && $month==date('n'))
			{
				$showtoday='<div align="right" class="w3-badge" id="_'.$list_day.'" onclick="callJsLink(\'rem_'.$menu.'_'.$str.'\', '.$list_day.', '.$month.', '.$year.')"></div>';
				$showtoday.='<div><strong class="overday">'.$list_day.'</strong><div>';
//				$showtoday.='<div valign="top" class="day-info"><small>'.$list_day.'</small></div>';
			}else
			{
//				$showtoday=$list_day;
//				$showtoday='<div align="right" class="w3-badge" id="_'.$list_day.'" onclick="callJsLink(\'rem_do_proses\', '.$list_day.')\"></div>';
				$showtoday='<div align="right" class="w3-badge" id="_'.$list_day.'" onclick="callJsLink(\'rem_'.$menu.'_'.$str.'\', '.$list_day.', '.$month.', '.$year.');"></div>';
				$showtoday.='<div><strong class="overday">'.$list_day.'</strong><div>';
			}
			$calendar.= '<div class="day-number">'.$showtoday.'</div>';

		// Draw table end
		$calendar.= '</td>';
		if($running_day == 6):
			$calendar.= '</tr> ';
			if(($day_counter+1) != $days_in_month):
				$calendar.= '<tr class="calendar-row">';
			endif;
			$running_day = -1;
			$days_in_this_week = 0;
		endif;
		$days_in_this_week++; $running_day++; $day_counter++;
	endfor;

	// Finish the rest of the days in the week
	if($days_in_this_week < 8):
		for($x = 1; $x <= (8 - $days_in_this_week); $x++):
			$calendar.= '<td class="calendar-day-np" height=48>&nbsp;</td>';
		endfor;
	endif;

	// Draw table final row
	$calendar.= '</tr>';
	
	// Draw additional information
//	$calendar.= '<tr><td colspan=7><span id="info"></span></td></tr>';

	// Draw table end the table 
	$calendar.= '</table>';
	
	// Finally all done, return result 
	return $calendar;
}
// month link
function draw_month($month, $start, $str, $menu){
	$nbln= array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
	$tabl= "<table cellpadding=10 cellspacing=0> \n";
	$curM= "";
	for($x=$start; $x<$start+6; $x++){
		if($month == $x) {$curM='currentday';} else {$curM='notCurrDay';}
		$tabl.= "<tr class=\"calendar-month\" height=48><td class=\"calendar-day-np ".$curM."\" width=80 align=\"center\" onclick=\"montJsLink('rem_".$menu."_".$str."', '".$x."');\">".$nbln[$x]."</td></tr> \n";
	}
	$tabl.= "</table> \n";
	return $tabl;
}
// get month for reminder
function getMonth($str){
	$str= str_replace(" ", "", $str);
	$nstr= explode("-", $str);
//	$mstr= explode("/", $nstr[0]);
//	$str= $mstr[2]."-".$mstr[1]."-".$mstr[0];
	$str= $nstr[1];
	return $str;
}
// get year for reminder
function getYear($str){
	$str= str_replace(" ", "", $str);
	$nstr= explode("-", $str);
//	$mstr= explode("/", $nstr[0]);
//	$str= $mstr[2]."-".$mstr[1]."-".$mstr[0];
	$str= $nstr[0];
	return $str;
}
// get jabatan
function getJab($str){
// calling necessary files
include("./../config/database.php"); 
include("./../config/session.php"); 
// get jabatan
$sql="SELECT `jabatan` FROM `data_manpower` WHERE `id`='$str';";
$result=mysql_query($sql);
while($row=mysql_fetch_array($result))
{
	$jab= $row['jabatan'];
}
	return $jab;
}
// get profile
function getProfile($str){
// calling necessary files
include("./../config/database.php"); 
include("./../config/session.php"); 
// get data jabatan
$sql="SELECT * FROM `data_jabatan` WHERE 1;";
$result=mysql_query($sql);
$jab= array();
while($row=mysql_fetch_array($result))
{
	$jab[$row['item']]= $row['keterangan'];
}
// get data manpower
$sql="SELECT * FROM `data_manpower` WHERE `id`='$str';";
$result=mysql_query($sql);
$data= array();
while($row=mysql_fetch_array($result))
{
	$data['id']= $row['id'];
	$data['nama']= $row['nama'];
	$data['gsm']= $row['gsm'];
	$data['email']= $row['email'];
	$data['photo']= $row['photo'];
	$data['jabatan']= $row['jabatan'];
}
echo "	<!-- start draw profile ".$str." -->\n";
echo "	<table border=1 width=320 class=\"w3-table\">".
	"<tr><td rowspan=5 width=33%>".
	"<a href=\"javascript:void(0)\" class=\"w3-border-bottom w3-large\" onclick=\"document.getElementById('profile').style.display='block'\"><img src=\"./../photo/".$data['photo']."\" style=\"height:120px;\"></a></td>".
	"<td>&nbsp;</td></tr>".
	"<tr><td><p>".ucfirst($data['nama'])."</p></td></tr>".
	"<tr><td>".$jab[$data['jabatan']]."</td></tr>".
	"<tr><td>".$data['gsm']."</td></tr>".
	"<tr><td>".$data['email']."</td></tr>".
	"</table> \n";
}
// edit profile
function editProfile($str){
// get data manpower
$sql="SELECT * FROM `data_manpower` WHERE `id`='$str';";
$result=mysql_query($sql);
$data= array();
while($row=mysql_fetch_array($result))
{
	$data['id']= $row['id'];
	$data['cbg']= $row['cabang'];
	$data['nama']= $row['nama'];
	$data['panggilan']= $row['nama_panggilan'];
	$data['user']= $row['inisial'];
	$data['gsm']= $row['gsm'];
	$data['email']= $row['email'];
	$data['photo']= $row['photo'];
	$data['jabatan']= $row['jabatan'];
}
	echo "<form action=\"./../upload/profile_proses.php\" method=\"post\" enctype=\"multipart/form-data\" name=\"form1\" id=\"form1\">  ".
		"<input name=\"cabang\" type=\"hidden\" value=\"".$data['cbg']."\">  ".
		"<input name=\"user\" type=\"hidden\" value=\"".$data['user']."\">  ".
		"<input name=\"menu\" type=\"hidden\" value=\"report\">  ".
		"<input name=\"theme\" type=\"hidden\" value=\"mail\">  ".
		"<input name=\"page\" type=\"hidden\" value=\"monitor\">  ".
		"<input name=\"id\" type=\"hidden\" value=\"".$data['id']."\">  ".
		"<div class=\"w3-half\">".
		"<div class=\"w3-group\">".
		"	<img src=\"./../photo/".$data['photo']."\" style=\"height:240px;\"><br>  ".
		"	<input name=\"photo\" type=\"file\" id=\"photo\" class=\"w3-btn w3-white\"><br>  ".
		"<p>Max file 1 MB</p>".
		"</div>".
		"</div>".
		"<div class=\"w3-half\">".
		"<div class=\"w3-group\">".
		"	<input class=\"w3-input w3-animate-input\" style=\"width:50%\" type=\"text\" name=\"nama\" value=\"".$data['nama']."\">".
		"	<label class=\"w3-label w3-validate\">Nama Lengkap</label>".
		"</div>".
		"<div class=\"w3-group\">".
		"	<input class=\"w3-input w3-animate-input\" style=\"width:50%\" type=\"text\" name=\"panggilan\" value=\"".$data['panggilan']."\">".
		"	<label class=\"w3-label w3-validate\">Nama Panggilan</label>".
		"</div>".
		"<div class=\"w3-group\">".
		"	<input class=\"w3-input w3-animate-input\" style=\"width:50%\" type=\"text\" name=\"gsm\" value=\"".$data['gsm']."\">".
		"	<label class=\"w3-label w3-validate\">Nomer GSM</label>".
		"</div>".
		"<div class=\"w3-group\">".
		"	<input class=\"w3-input w3-animate-input\" style=\"width:50%\" type=\"text\" name=\"email\" value=\"".$data['email']."\">".
		"	<label class=\"w3-label w3-validate\">Alamat E-mail</label>".
		"</div>".
		"</div>".
		"<input type=\"submit\" name=\"Submit\" value=\"Simpan\" class=\"w3-btn w3-green\"> ".
	"</form> \n".
	"<!--a class=\"w3-btn w3-red\" onclick=\"document.getElementById('profile').style.display='none'\">Cancel  <i class=\"fa fa-remove\"></i></a--> \n";
}
// get draw msg func
function drawMessage($str){
// calling necessary files
include("./../config/database.php"); 
include("./../config/session.php"); 
// get data internal message
$sql="SELECT * FROM `msg_internal` WHERE `untuk`=$str AND `status`='NN';";
$result=mysql_query($sql);
$num=mysql_num_rows($result);
if($num <= 0){
	echo "		<a id=\"myBtn\" href=\"javascript:void(0)\"><i class=\"w3-padding-left w3-padding-right fa fa-inbox\"> </i> Inbox </a> \n";
}else{
	echo "		<a id=\"myBtn\" onclick=\"myFunc('pesan')\" href=\"javascript:void(0)\"><i class=\"w3-padding-left w3-padding-right fa fa-inbox\"> </i> Inbox (".$num.") </a> \n";
}
}
// draw msg link
function linkMessage($str){
// calling necessary files
include("./../config/database.php"); 
include("./../config/session.php"); 
// get data manpower
$sql="SELECT * FROM `data_manpower`;";
$result=mysql_query($sql);
$idpel= array();
while($row=mysql_fetch_array($result))
{
	$idpel['nama'][$row['id']]= $row['nama'];
	$idpel['pang'][$row['id']]= $row['nama_panggilan'];
	$idpel['photo'][$row['id']]= $row['photo'];
}
// get data internal message
$sql="SELECT * FROM `msg_internal` WHERE `untuk`=$str AND `status`='NN' ;";
$result=mysql_query($sql);
$data= array();
while($row=mysql_fetch_array($result))
{
	$data[$row['id']]['dari']= $row['dari'];
	$data[$row['id']]['tgl']= $row['kirim'];
	$data[$row['id']]['judul']= $row['judul'];
	$data[$row['id']]['pesan']= $row['pesan'];
}
// print links
foreach($data as $key => $val) {
	// extracting few data
	$from= $idpel['nama'][$data[$key]['dari']];
	$poto= $idpel['photo'][$data[$key]['dari']];
	$pang= $idpel['pang'][$data[$key]['dari']];
	$mess= substr($data[$key]['pesan'], 0, 28);
	// print links
	echo "<a href=\"javascript:void(0)\" class=\"w3-border-bottom test w3-hover-light-grey\" onclick=\"myJsLink('mail', ".$key.");w3_close();\"> ".
	"	<div class=\"w3-container\"> ".
	"	<img class=\"w3-round w3-margin-right\" src=\"./../photo/".$poto."\" style=\"width:35px;\"><span class=\"w3-opacity w3-large\">".$pang."</span> ".
	"	<h6>Subject: ".$data[$key]['judul']."</h6> ".
	"	<p>".$mess."...</p> ".
	"	</div> ".
	"</a> \n";
	}
}
// draw msg full
function fullMessage_old($str){
// calling necessary files
include("./../config/database.php"); 
include("./../config/session.php"); 
// get data manpower
$sql="SELECT * FROM `data_manpower`;";
$result=mysql_query($sql);
$idpel= array();
while($row=mysql_fetch_array($result))
{
	$idpel['nama'][$row['id']]= $row['nama'];
	$idpel['pang'][$row['id']]= $row['nama_panggilan'];
	$idpel['photo'][$row['id']]= $row['photo'];
}
// get data internal message
$sql="SELECT * FROM `msg_internal` WHERE `untuk`=$str AND `status`='NN' ;";
$result=mysql_query($sql);
$data= array();
while($row=mysql_fetch_array($result))
{
	$data[$row['id']]['did']= $row['id'];
	$data[$row['id']]['dari']= $row['dari'];
	$data[$row['id']]['tgl']= $row['kirim'];
	$data[$row['id']]['judul']= $row['judul'];
	$data[$row['id']]['pesan']= $row['pesan'];
}
// print links
foreach($data as $key => $val) {
	// extracting few data
	$deid= $data[$key]['did'];
	$from= $idpel['nama'][$data[$key]['dari']];
	$poto= $idpel['photo'][$data[$key]['dari']];
	$pang= $idpel['pang'][$data[$key]['dari']];
	$nama= $idpel['nama'][$data[$key]['dari']];
	$miss= date_create($data[$key]['tgl']);
	$mess= date_format($miss,"D, j M Y");
	// print full message
	echo "<div id=\"".$pang."\" class=\"w3-container person\"> ".
	"	<br> ".
	"	<img class=\"w3-round  w3-animate-top\" src=\"./../photo/".$poto."\" style=\"width:120px;\"> ".
	"	<h5 class=\"w3-opacity\">Subject: ".$data[$key]['judul']."</h5> ".
	"	<h4><i class=\"fa fa-clock-o\"></i> From ".$nama.", ".$mess.".</h4> ".
	"	<a class=\"w3-btn w3-hover-dark-grey w3-light-grey\" onclick=\"mailFunction('read', ".$deid.");\">Read<i class=\"w3-padding-left fa fa-flag\"></i></a> ".
	"<a class=\"w3-btn w3-hover-dark-grey w3-light-grey\">Reply<i class=\"w3-padding-left fa fa-mail-reply\"></i></a> ".
	"<a class=\"w3-btn w3-hover-dark-grey w3-light-grey\">Forward<i class=\"w3-padding-left fa fa-arrow-right\"></i></a> ".
	"	<hr> ".
	"	<p>".$data[$key]['pesan']."</p> ".
	"</div> ";
	}

}
// draw msg full
function fullMessage($str){
// calling necessary files
include("./../../config/database.php"); 
include("./../../config/session.php"); 
// get data manpower
$sql="SELECT * FROM `data_manpower`;";
$result=mysql_query($sql);
$idpel= array();
while($row=mysql_fetch_array($result))
{
	$idpel['nama'][$row['id']]= $row['nama'];
	$idpel['pang'][$row['id']]= $row['nama_panggilan'];
	$idpel['photo'][$row['id']]= $row['photo'];
}
// get data internal message
$sql="SELECT * FROM `msg_internal` WHERE `id`=$str;";
$result=mysql_query($sql);
$data= array();
while($row=mysql_fetch_array($result))
{
	$data[$row['id']]['did']= $row['id'];
	$data[$row['id']]['dari']= $row['dari'];
	$data[$row['id']]['tgl']= $row['kirim'];
	$data[$row['id']]['judul']= $row['judul'];
	$data[$row['id']]['pesan']= $row['pesan'];
}
// print links
foreach($data as $key => $val) {
	// extracting few data
	$deid= $data[$key]['did'];
	$from= $idpel['nama'][$data[$key]['dari']];
	$poto= $idpel['photo'][$data[$key]['dari']];
	$pang= $idpel['pang'][$data[$key]['dari']];
	$nama= $idpel['nama'][$data[$key]['dari']];
	$miss= date_create($data[$key]['tgl']);
	$mess= date_format($miss,"D, j M Y");
	// print full message
	echo "<div id=\"".$pang."\" class=\"w3-container person\"> ".
	"	<br> ".
	"	<img class=\"w3-round  w3-animate-top\" src=\"./../../photo/".$poto."\" style=\"width:120px;\"> ".
	"	<h5 class=\"w3-opacity\">Subject: ".$data[$key]['judul']."</h5> ".
	"	<h4><i class=\"fa fa-clock-o\"></i> From ".$nama.", ".$mess.".</h4> ".
	"	<a class=\"w3-btn w3-hover-dark-grey w3-light-grey\" onclick=\"mailFunction('read', ".$deid.");\">Read<i class=\"w3-padding-left fa fa-flag\"></i></a> ".
	"<a class=\"w3-btn w3-hover-dark-grey w3-light-grey\">Reply<i class=\"w3-padding-left fa fa-mail-reply\"></i></a> ".
	"<a class=\"w3-btn w3-hover-dark-grey w3-light-grey\">Forward<i class=\"w3-padding-left fa fa-arrow-right\"></i></a> ".
	"	<hr> ".
	"	<p>".$data[$key]['pesan']."</p> ".
	"</div> ";
	}

}
// detail info
function showKendaraan($str){
// get unit data
$sql="SELECT * FROM `data_kendaraan` WHERE `no_chasis`='$str';";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);

echo "			<table class=\"w3-table w3-striped w3-bordered\"> \n";
echo "			<thead> \n";
echo "				<tr class=\"w3-theme\"> \n";
echo "				  <th colspan=2>Informasi Kendaraan </th> \n";
echo "				</tr> \n";
echo "			</thead> \n";
echo "			<tbody> \n";
echo "				<tr> \n";
echo "				  <td>Tahun</td> \n";
echo "				  <td>".$row['tahun_mobil']."</td> \n";
echo "				</tr> \n";
echo "				<tr> \n";
echo "				  <td>Model</td> \n";
echo "				  <td>".$row['fmdl']."</td> \n";
echo "				</tr> \n";
echo "				<tr> \n";
echo "				  <td>Warna</td> \n";
echo "				  <td>".$row['warna']."</td> \n";
echo "				</tr> \n";
echo "				<tr> \n";
echo "				  <td>Nopol</td> \n";
echo "				  <td>".$row['no_polisi']."</td> \n";
echo "				</tr> \n";
echo "				<tr> \n";
echo "				  <td>Pembayaran</td> \n";
echo "				  <td>".$row['pembayaran']."</td> \n";
echo "				</tr> \n";
echo "			</tbody> \n";
echo "			</table> \n";
}
// info suret
function showPelanggan($str){
// get unit data
$sql="SELECT * FROM `data_pelanggan` WHERE `kode_bp`='$str';";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);

echo "			<table class=\"w3-table w3-striped w3-bordered\"> \n";
echo "			<thead> \n";
echo "				<tr class=\"w3-indigo\"> \n";
echo "				  <th colspan=2>Informasi Pelanggan</th> \n";
echo "				</tr> \n";
echo "			</thead> \n";
echo "			<tbody> \n";
echo "				<tr> \n";
echo "				  <td>Nama</td> \n";
echo "				  <td>".$row['nama_lengkap']."</td> \n";
echo "				</tr> \n";
echo "				<tr> \n";
echo "				  <td>PSTN</td> \n";
echo "				  <td>".$row['telepon']."</td> \n";
echo "				</tr> \n";
echo "				<tr> \n";
echo "				  <td>GSM</td> \n";
echo "				  <td>".$row['gsm']."</td> \n";
echo "				</tr> \n";
echo "				<tr> \n";
echo "				  <td>CDMA</td> \n";
echo "				  <td>".$row['cdma']."</td> \n";
echo "				</tr> \n";
echo "				<tr> \n";
echo "				  <td>Alamat</td> \n";
echo "				  <td>".$row['alamat_tinggal']."</td> \n";
echo "				</tr> \n";
echo "				<tr> \n";
echo "				  <td>Kota</td> \n";
echo "				  <td>".$row['kota_tinggal']."</td> \n";
echo "				</tr> \n";
echo "				<tr> \n";
echo "				  <td>Kode Pos</td> \n";
echo "				  <td>".$row['kode_tinggal']."</td> \n";
echo "				</tr> \n";
echo "			</tbody> \n";
echo "			</table> \n";
}
// draw invalid data btn
function invBtn($str, $id){
	// get status sdm==2
	$sql="SELECT `sdm` FROM `data_reminder_do` WHERE `kode_bp`='$str';";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	$sdm= $row['sdm'];
	// get unit data
	$sql="SELECT * FROM `data_pelanggan` WHERE `kode_bp`='$str';";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);

	if($sdm==2){
		echo "<button class=\"w3-btn w3-indigo\" type=\"button\" onclick=\"myEfunction(".$id.");\">EDIT ALAMAT</button> ";
		echo "<button class=\"w3-btn w3-blue w3-disabled\" onclick=\"alert('Data sudah di-Tag Invalid');window.close();\">DATA SET INVALID</button> ";
	}else{
		echo "<button class=\"w3-btn w3-indigo\" type=\"button\" onclick=\"myEfunction(".$id.");\">EDIT ALAMAT</button> ";
		echo "<button class=\"w3-btn w3-red\" type=\"button\" onclick=\"newJsLinkI('reminder', ".$id.");\">SET DATA INVALID</button> ";
	}
}
// draw add button obosolete
function addBtn($str, $id){
	echo "<div class=\"w3-padding w3-full\">";
	echo "<input type=\"button\" class=\"w3-btn w3-red w3-hover-lime\" value=\"ADD\"></input>";
	echo "</div> \n";
}
// draw data call
function formCall($str, $id){ 
// ger cabang array
include("./../../config/daftar_dealer.php");
// get data reminder
$sql="SELECT * FROM `data_reminder_do` WHERE `no_chasis`='$str';";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
$sdm= $row['sdm'];
$cal= $row['calls'];
$ack= $row['insure_know'];
$yes= $row['claim_yess'];
$cbg= $row['cabang'];
?>
	<div class="w3-full">
		<div class="w3-group">
		<?php
		$cals= array("NN" => "Belum ditelpon", "AO" => "1<sup>st</sup>", "AT" => "2<sup>nd</sup>", "AH" => "3<sup>rd</sup>", "AF" => "Gagal");
		foreach($cals as $key => $val){
			if($key== $cal){
				
		?>		
			<label class="w3-label w3-validate">Apakah Telepon Terhubung ?</label>
			<br>
			<input class="w3-radio" type="radio" name="ccall" value="<?php echo $key; ?>" checked>
			<label class="w3-validate"><?php echo $val; ?></label>
				<?php }else{ ?>
			<input class="w3-radio" type="radio" name="ccall" value="<?php echo $key; ?>">
			<label class="w3-validate"><?php echo $val; ?></label>
		<?php } }  ?>	
		</div>
	</div>
	<div class="w3-full">
		<div class="w3-group">
			<input class="w3-input w3-animate-input" style="width:50%" type="text" name="ncall" value="<?php echo $row['call_info']; ?>">
			<label class="w3-label w3-validate">Keterangan Tidak Terhubung</label>
		</div>
	</div>
	<div class="w3-half">
	<div class="w3-group">
		<label class="w3-label w3-validate">Apakah mempunyai Asuransi ?</label>
		<br>
		<?php 
		$i= array("Tidak Tahu", "Tahu");
		foreach($i as $key => $val){
			if($ack==$key){
		?>
		<input class="w3-radio" type="radio" name="kasuransi" value="<?php echo $key; ?>" checked>
		<label class="w3-validate"><?php echo $val; ?></label>
		<?php }else{  ?>
		<input class="w3-radio" type="radio" name="kasuransi" value="<?php echo $key; ?>">
		<label class="w3-validate"><?php echo $val; ?></label>
		<?php } } ?>
	</div>
	</div>
	<div class="w3-half">
	<div class="w3-group">
		<input class="w3-input w3-animate-input" style="width:50%" type="text" name="nasuransi">
		<label class="w3-label w3-validate">Nama Asuransi</label>
	</div>
	</div>
	<div class="w3-full">
	<div class="w3-group">
		<label class="w3-label w3-validate">Apakah pernah Klaim Bodi ?</label>
		<br>
		<?php 
		if($yes== "NN"){$snn= "checked"; $shh= ""; $sot= "";}
		elseif($yes== "HH"){$shh= "checked"; $snn= ""; $sot= "";}
		elseif($yes== "OT"){$sot= "checked"; }else{$snn= ""; $shh= ""; }
		?>
		<input class="w3-radio" type="radio" name="hclaim" value="NN" <?php echo $snn; ?>>
		<label class="w3-validate">Belum Pernah Klaim</label>
		<br>
		<input class="w3-radio" type="radio" name="hclaim" value="HH" <?php echo $shh; ?>>
		<label class="w3-validate">Di <?php echo $ccb[$cbg]; ?></label>
		<input class="w3-radio" type="radio" name="hclaim" value="OT" <?php echo $sot; ?>>
		<label class="w3-validate">Lainnya</label>
	</div>
	<div class="w3-group">
		<input class="w3-input w3-animate-input" style="width:50%" type="text" name="nclaim">
		<label class="w3-label w3-validate">Nama Bengkel Tempat Klaim</label>
	</div>
	</div>
	<div class="w3-half">
	<div class="w3-group">
		<?php if($yes== "HH"){ ?>
		<input class="w3-radio" type="radio" name="oclaim" value="HH" checked>
		<label class="w3-validate"><?php echo $ccb[$cbg]; ?></label>
		<?php }else{ ?>
		<input class="w3-radio" type="radio" name="oclaim" value="NN" checked>
		<label class="w3-validate">Belum Pernah Claim</label>
		<?php } ?>
		<br>
		<input class="w3-radio" type="radio" name="oclaim" value="IN">
		<label class="w3-validate">Inisiatip</label>
		<input class="w3-radio" type="radio" name="oclaim" value="OT">
		<label class="w3-validate">Diarahkan</label>
		<br>
		<label class="w3-label w3-validate">Informasi ke Bengkel Lain</label>
	</div>
	</div>
	<div class="w3-half">
	<div class="w3-group">
		<br>
		<input class="w3-input w3-animate-input" style="width:50%" type="text" name="qclaim">
		<label class="w3-label w3-validate">Yang Mengarahkan</label>
	</div>
	</div>
	<?php if($sdm==0){ ?>
	<div class="w3-half">
	<div class="w3-group w3-center w3-right">
		<button class="w3-btn w3-orange w3-disabled" type="button">TERHUBUNG</button>
	</div>
	</div>
	<div class="w3-half">
	<div class="w3-group w3-center">
		<button class="w3-btn w3-indigo" type="button" onclick="myEfunction(<?php echo $id; ?>);">TIDAK TERHUBUNG</button>
	</div>
	</div>
	<?php } else { ?>
	<div class="w3-half">
	<div class="w3-group w3-center w3-right">
		<button class="w3-btn w3-orange w3-disabled" type="button">TERHUBUNG</button>
	</div>
	</div>
	<div class="w3-half">
	<div class="w3-group w3-center">
		<button class="w3-btn w3-indigo" type="button" onclick="myEfunction(<?php echo $id; ?>);">TIDAK TERHUBUNG</button>
	</div>
	</div>
	<?php } ?>
<?php }
// re-format date
function getRealDate($str){
	$str= str_replace("-", "|", $str);
	$mstr= explode("|", $str);
//	$mstr= explode("/", $nstr[0]);
	$str= $mstr[2]."-".$mstr[1]."-".$mstr[0];
	return $str;
}
function dmBtn($str, $id){ 
// ger cabang array
include("./../../config/daftar_dealer.php");
// get data reminder
$sql="SELECT * FROM `data_reminder_do` WHERE `no_chasis`='$str';";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
$sdm= $row['sdm'];
$cal= $row['calls'];
$ack= $row['insure_know'];
$yes= $row['claim_yess'];
$cbg= $row['cabang'];
?>
	<div class="w3-half">
	<div class="w3-group">
	<?php if($sdm==1){ ?>
		<button class="w3-btn w3-yellow w3-disabled" type="button">SEND DM</button>
	<?php } else { ?>
		<button class="w3-btn w3-yellow" type="button" onclick="mySfunction(<?php echo $id; ?>);">SEND DM</button>
	<?php } ?>
	</div>
	</div>
	<div class="w3-half">
	<div class="w3-group">
	<?php if($cal!=1){ ?>
		<button class="w3-btn w3-red w3-disabled" type="button">SEND SMS</button>
	<?php } else { ?>
		<button class="w3-btn w3-red" type="button" onclick="myMfunction(<?php echo $id; ?>);">SEND SMS</button>
	<?php } ?>
	</div>
	</div>
<?php
}

function myXfunction($a, $b, $c, $d, $m, $y, $j, $k, $l, $n){
	include("./../../config/im_config_server.php"); 
	include("./../../config/im_config_database.php"); 

	$conn = @mysql_connect ($host, $user, $pswd)
			 or die ("Koneksi s_f gagal: " . mysql_error());
	$tbl= $c."_manpower";

	mysql_select_db($ddb, $conn);
	$sql= mysql_query("SELECT `jabatan`, `inisial` FROM `$tbl` WHERE `id`=$j ;");
	while($row= mysql_fetch_array($sql)){
		$adm= $row['jabatan']; 
		$usr= $row['inisial'];
	}
	$p= array(0 => "AIQ", 1 => "PSP", 2 => "MAS", 3 => "WASH", 4 => "SETTING", 5=> "REPORT", 6=> "TWC");
	$jab= strtolower($adm);
	$menu= strtolower($p[$b]);
	$xFile= $menu.".php";
	$link= "a=$a&b=$b&c=$c&n=$n&d=$d&m=$m&y=$y&j=$j&k=$k&l=home";
	if($adm== "INS"){
		$xFile= $menu.".php?x=teknisi&xx=".$usr;
	}
	if($adm== "TEK"){
		$xFile= $menu."_base_tek.php?".$link."&x=".$usr;
	}
	if($adm== "SA"){
		$xFile= $menu."_base_sa.php?".$link."&x=sa&xx=".$usr;
	}
	if($adm== "PART" OR $adm== "BILL"){
		$xFile= $menu."_base_pb.php?".$link."&x=pb&xx=".$usr;
	}
	if($adm== "CR"){
		$xFile= $menu."_home_cr_base.php?".$link."&x=cr&xx=".$usr;
	}

	echo "		<script>\n";
	echo "	 	function loadXMLDoc() {\n".
	 " 			var xmlhttp = new XMLHttpRequest();\n".
	 " 			xmlhttp.onreadystatechange = function() {\n".
	 " 				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {\n".
	 " 					myFunction(xmlhttp);\n".
	 " 				}\n".
	 " 			};\n".
	 " 			var url= \"./".$xFile."\";\n".
	 " 			xmlhttp.open(\"GET\", url, true);\n".
	 " 			xmlhttp.send();\n".
	 " 			setTimeout('loadXMLDoc()', 5000);\n".
	 " 			}\n".
	 "		</script> \n";

	 // special case
	if($l=="stall"){$yFile= "page_panel";}else{
		$yFile= $menu."_home_".$jab;
	 }
	include("./".$yFile.".php");
}
?>