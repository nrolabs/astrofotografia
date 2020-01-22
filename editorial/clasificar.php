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
				$all_sys_cid = $api->all_from_sys_where_cid($decrypt->sha1($_GET['cid']));

				//print_r($all_sys_cid );
				$cpontos = 0;

				for ($i=0; $i < count($all_sys_cid); $i++) { 
					$cpontos = $cpontos + $all_sys_cid[$i]['cpontos'];
					//print_r($all_sys_cid[$i]['cpontos']);
				}

				//print_r($cpontos);
				$cpontos = ceil(($cpontos/count($all_sys_cid)));

				//print_r($cpontos);

				$api->update_captura_sstatus_2_cpontos_where_cid($decrypt->sha1($_GET['cid']), $cpontos);

			 
				$api->update_sys_sstatus_2_where_cid($decrypt->sha1($_GET['cid']));
	 

				?>
				<meta http-equiv="refresh" content="0; URL='./painel.php'"/>
				<?php


			}
		}
	}
?>