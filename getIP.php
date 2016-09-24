<?php 
$ip= @$_REQUEST['ip'];
include("./common/init.php");
include("./common/function.php");
include("./config/daftar_dealer.php");
include("./model/getIP_model.php");
?>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="icon" href="./img/icon.ico">
		<!-- w3 CSS -->
		<link rel="stylesheet" href="./css/w3.css">
		<link rel="stylesheet" href="./css/w3-theme-black.css">
		<link rel="stylesheet" href="./css/font-awesome.min.css">
	</head>
	<body>
	<script languge="javascript" src="./js/daftar_dealer.js"></script> 
	<script>
		function getFunction(cbg, ip) {
			var link= "./recIP.php?cabang="+ cbg + "&ip=" + ip;
//			alert(link);
			var myWindow = window.open(link, "top", "");
		}
	</script>
	<!-- Header -->
	<header class="w3-container w3-theme w3-padding" id="myHeader">
		<div class="w3-center">
			<h4><i>Brought to you by Nasmoco <?php echo $ccb["nr20"]; ?></i></h4>
			<h1 class="w3-xxxlarge w3-animate-bottom"><?php echo $Xtext['ims']; ?></h1>
		</div>
	</header>
	<div class="w3-row-padding w3-center w3-margin-top">
		<div class="w3-quarter">
			<div class="w3-card-2 w3-padding-top" style="min-height:420px">
				<h4>Silakan Pilih Cabang</h4><br>
				<div class="w3-center">
					<div class="w3-dropdown-hover">
						<button class="w3-btn w3-theme w3-large">Pilih Disini &#9660;</button>
						<div class="w3-dropdown-content w3-light-grey w3-grey w3-left-align">
						<?php foreach($ccb as $key => $val) { echo "\n";?>
						<a href="javascript:void(0)" onclick="getFunction('<?php echo $key; ?>', '<?php echo $ip; ?>');"><?php echo $val; ?></a>
						<?php echo "\n"; } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="w3-quarter">
			<div class="w3-card-2 w3-padding-top" style="min-height:420px">
				<h4>Get</h4><br>
				<i class="w3-margin-bottom w3-text-theme" style="font-size:120px"> &#32566;</i>
			</div>
		</div>
		<div class="w3-quarter">
			<div class="w3-card-2 w3-padding-top" style="min-height:420px">
				<h4 class="w3-text-">Keep</h4><br>
				<i class="w3-margin-bottom w3-text-theme" style="font-size:120px"> &#20445;&#23384;</i>
			</div>
		</div>
		<div class="w3-quarter">
			<div class="w3-card-2 w3-padding-top" style="min-height:420px">
				<h4>Grow</h4><br>
				<i class="w3-margin-bottom w3-text-theme" style="font-size:120px"> &#33457;</i>
			</div>
		</div>
	</div>
	<br>
	<?php footer(); ?>
	</body>
</html>