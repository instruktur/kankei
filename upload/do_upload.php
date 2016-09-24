			<br>
			<div class="w3-row-padding">
				<div class="w3-full">
					<div class="w3-card-4">
						<div class="w3-container w3-blue">
						<h6>Upload Data Penjualan</h6>
						</div>
					</div>
				</div>
			</div>
			<div class="w3-row-padding">
				<div class="w3-full w3-white">
					<div class="w3-card-4 w3-container">
					  <br>
						<form action="./../upload/do_proses.php" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
						  <input name="cabang" type="hidden" value="<?php echo $cbg; ?>"> 
						  <input name="user" type="hidden" value="<?php echo $usr; ?>"> 
						  <input name="menu" type="hidden" value="<?php echo $menu; ?>"> 
						  <input name="theme" type="hidden" value="<?php echo $theme; ?>"> 
						  <input name="page" type="hidden" value="<?php echo $page; ?>"> 
						  <input name="id" type="hidden" value="<?php echo $did; ?>"> 
						  <input name="csv" type="file" id="csv" class="w3-btn w3-white"> 
						  <input type="submit" name="Submit" value="Submit DO" class="w3-btn w3-blue"> 
						</form> 
					</div>
				</div>
				<div class="w3-card-4">
					<div class="w3-container w3-lime">
						<span id="uStatus">&nbsp;<?php if (!empty($_REQUEST['logdo'])) {echo "<b>Log ID : ".$_REQUEST['logdo']."</b>"; } ?></span>
					</div>
				</div>
			</div>
