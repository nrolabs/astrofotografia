<?php 

	error_reporting(0);
 	define('URL', "https://astrofotografia.nrolabs.com/upload/");
	session_start();
	//print_r(sha1(1));


	if (isset($_GET['sair'])) {
		session_cache_expire();
		session_unset();
		session_destroy();
		?>
		<meta http-equiv="refresh" content="0; URL='./?'"/>
		<?php

	}


	include_once('api.php');

	$api = new APIUpload;

	if (!isset($_SESSION['uid'])) {
		header("Refresh: 0; url=/login.php");
		?>
		<meta http-equiv="refresh" content="0; URL='./login.php'"/>
		<?php

	} else {
?>
<!DOCTYPE HTML>
<!--
	USUÁRIO by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
<head>
	<title>Astrofotografia Brasil - Usuário</title>
	<link rel="icon" href="favicon.png">
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<link rel="stylesheet" href="assets/css/main.css" />
</head>
<body class="is-preload">

	<!-- Wrapper -->
	<div id="wrapper">

		<!-- Main -->
		<div id="main">
			<div class="inner">
				<header id="header">
					<a href="" class="logo"><strong>ASTROFOTOGRAFIA BRASIL</strong> - USUÁRIO</a>
					<ul class="icons">
						<li>
							<span class="label">Olá, <?php echo $_SESSION['unome']; ?>.</span> 
						</li>
						<li>
							<a href="?sair" class="icon solid fa-window-close"><span class="label">SAIR</span></a>
						</li>
					</ul>

				</header>

				<blockquote>
				“Diante da vastidão do tempo e da imensidão do universo, é um imenso prazer para mim dividir um planeta e uma época com você.”
				<br />
				Carl Sagan
				</blockquote>

				<div class="row" style="text-align: center;">
					<br /><br /><br />
					<div class="col-4 col-12-medium"> 
					</div>
					<br /><br /><br />
					<div class="col-4 col-12-medium">
 						<a href="./painel.php" class="button primary large">PAINEL</a> 
					</div>
					<br /><br /><br />
					<div   class="col-4 col-12-medium">
					</div>
				</div>


				<!-- Content -->
				<section>
					<script type="text/javascript">
						
						setInterval(function(){

							if (document.getElementById('ucaptura').value=='') {
								document.getElementById('label_ucaptura').innerHTML ='SELECIONAR ARQUIVO';
								document.getElementById('label_ucaptura').style.background ='#fff';
								document.getElementById('label_ucaptura').style.color ='#000';
							} else {
								document.getElementById('label_ucaptura').innerHTML ='ARQUIVO SELECIONADO';
								document.getElementById('label_ucaptura').style.background ='#34a58e';
								document.getElementById('label_ucaptura').style.color ='#fff';
							}

						}, 3000);
					</script>


<?php 
	if(isset($_FILES["ucaptura"]) && isset($_POST['utitulo']) && isset($_POST['ucategoria']) && isset($_POST['udescricao'])) {
		


	//define('name', "1");
	define('date', date("Y-m-d H:i:s"));
	define('name', sha1(date));
	define('small_api', "http://localhost/astrofotografia/upload/thumb.php");
	define('base_path_full', "./full/");
	define('base_path_small', "./small/");
	define('max_filesize', "10485760"); //10mb
	define('allowed_ext', array('jpg')); //somente jpg

	 
 
		$file_size = $_FILES['ucaptura']['size'];

 		if ($file_size > max_filesize) {

			//die('Arquivo maior que o permitido');
?>
				<div class="box">
				Ops :( ! ... Tivemos alguns problemas ao processar sua solicitação.  O arquivo no qual selecionou excedeu o tamanho máximo permitido. Lamentamos pelo ocorrido, estamos trabalhando para possibilitar um maior armazenamento de arquivos em nossos servidores. Por favor, selecione uma imagem com no máximo 10MB.
			</div>
<?php


		} else {

			$fileinfo = pathinfo($_FILES['ucaptura']['name']);
			$file_ext = $fileinfo['extension'];

			if (in_array($file_ext, allowed_ext) === false ) {

				//die('Extensão não permitida');
?>
				<div class="box">
				Ops :( ! ... Tivemos alguns problemas ao processar sua solicitação. Só processamos imagens com extensão  <strong>.jpg</strong>. Por favor, selecione um arquivo adequado.

				</div>
<?php


			}  else {
	
				if (file_exists(base_path_full."/".name.".".$file_ext)) {

			//		die('O Arquivo já foi enviado');
?>
				<div class="box">
				Ops :( ! ... Tivemos alguns problemas ao processar sua solicitação, por favor tente novamente dentro de alguns instantes. Isto pode acontecer devido diversos fatores, como sobrecarga de nossos servidores eu erros de comunicação da sua internet.
				</div>
<?php

				} else {

					$file_name = $_FILES['ucaptura']['name'];
					$file_tmp  = $_FILES['ucaptura']['tmp_name'];

					$i = explode(".", $file_name);
					$file_ext  = $i[count($i)-1];

					if(move_uploaded_file($file_tmp, base_path_full."/".name.".".$file_ext)){
						//die ("Agradecemos por sua participação, se sua imagem for classificada aparecerá aqui em breve, boa sorte!");
						$curl = curl_init();
						curl_setopt_array($curl, [
						    CURLOPT_RETURNTRANSFER => 1,
						    CURLOPT_URL => small_api."?file=".base_path_full."/".name.".".$file_ext."&sizex=360",
						]);
						$resp = curl_exec($curl);
						curl_close($curl);

						if ($resp == true) {

							include_once('api.php');
							
							$query = "INSERT INTO `captura`(`cid`, `cpontos`, `cautor`, `ctitulo`, `ccategoria`, `cdescricao`, `csrcfull`, `csrcsmall`, `cstatus`, `cdata`) VALUES (null,0,'".$_SESSION['uid']."','".$_POST['utitulo']."','".$_POST['ucategoria']."','".$_POST['udescricao']."','".URL."/full/?l=".name."','".URL."/small/?l=".name."',0,'".date("Y-m-d H:i:s")."')";

							$api = new APIUpload;
							$sql = $api->insert_captura($query);

							if(isset($sql['success'])) {

?>
				<div class="box">
				Recebemos sua captura! Em breve analisaremos se está de acordo com nossa política editorial, caso tudo certo, será encaminhada para os avaliadores. Você poderá acompanhar o progresso deste processo em seu painel.
				</div>
<?php

								//die('Inserido no banco de dados');


							} else {
								unlink(base_path_full."/".name.".".$file_ext);
								unlink(base_path_small."/".name.".".$file_ext);
								//die('Não inserido no banco de dados');

?>
				<div class="box">>
				Ops :( ! ... Tivemos alguns problemas ao processar sua solicitação, por favor tente novamente dentro de alguns instantes. Isto pode acontecer devido diversos fatores, como sobrecarga de nossos servidores eu erros de comunicação da sua internet.
				</div>
<?php
							}

						}  else {

							unlink(base_path_full."/".name.".".$file_ext);

							if (file_exists(base_path_small."/".name.".".$file_ext)) {
								unlink(base_path_small."/".name.".".$file_ext);
							}
?>
				<div class="box">>
				Ops :( ! ... Tivemos alguns problemas ao processar sua solicitação, por favor tente novamente dentro de alguns instantes. Isto pode acontecer devido diversos fatores, como sobrecarga de nossos servidores eu erros de comunicação da sua internet.
				</div>
<?php
							//die('Erro na criação da miniatura');
						}
					}

				}
			}
		}
 










	} else {
?>
 

				<form method="post" action="" enctype="multipart/form-data">
					<div class="row gtr-uniform">
						<div class="col-6 col-12-xsmall">
							<input type="text" name="utitulo" id="utitulo" value="" placeholder="Título" required />
						</div>
						<div class="col-6 col-12-xsmall">
				 
							<input type="file" style="display: none !important;" name="ucaptura" id="ucaptura" value=""  required/>
							<label  style="background: #fff; height: 100%;text-align: center;padding-top: 1.7%; cursor: pointer;border-radius: 0.375em;" for='ucaptura' id="label_ucaptura">SELECIONAR ARQUIVO</label>

						</div>
						<!-- Break -->
						<div class="col-12">
							<select name="ucategoria" id="ucategoria" required>
								<option value="">- Categoria -</option>
								<option value="Manufacturing">Manufacturing</option>
								<option value="Shipping">Shipping</option>
								<option value="Administration">Administration</option>
								<option value="Human Resources">Human Resources</option>
							</select>
						</div>
 
						<!-- Break -->
						<div class="col-12">
							<textarea name="udescricao" id="udescricao" placeholder="Descrição" rows="6" required></textarea>
						</div>
						<!-- Break -->
						<div class="col-12">
							<ul class="actions">
								<li><input type="submit" value="SUBMETER " class="primary" /></li>
							 	 <li><input type="reset" value="APAGAR TODO FORMULÁRIO" /></li>
							</ul>
						</div>
					</div>
				</form>

<?php

}

?>
				<hr class="major" />


				 
 
				</section>
 
						<center>&copy; 2020 Nrọlabs Desenvolvimento de Softwares. <br />  Design by HTML5 UP.</center> 
						<br /><br />
 
			</div>
		</div>


	</div>

	<!-- Scripts -->
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/browser.min.js"></script>
	<script src="assets/js/breakpoints.min.js"></script>
	<script src="assets/js/util.js"></script>
	<script src="assets/js/main.js"></script>

</body>
</html>

<?php

}

?>