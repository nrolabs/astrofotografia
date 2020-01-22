<?php 

	session_start();
	
	include_once('api.php');

	include_once('decrypt.php');

	$decrypt = new Decrypt;

	$api = new APIEditorial;

	if (!isset($_SESSION['eid'])) {
		header("Refresh: 0; url=/login.php");
	 	?>
		<meta http-equiv="refresh" content="0; URL='./login.php'"/>
	 	<?php
	} else {

		if (isset($_GET['cid'])) {
			if (is_numeric($decrypt->sha1($_GET['cid']))) {

				$api->update_captura_cstatus_3_where_cid($decrypt->sha1($_GET['cid']));
			 
				$api->update_sys_sstatus_3_where_cid($decrypt->sha1($_GET['cid']));
	 
				?>
				<meta http-equiv="refresh" content="0; URL='./painel.php'"/>
				<?php
			}
		}
	}
?>