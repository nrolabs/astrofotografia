<?php

/*
	if( isset($_POST["nome"]) && isset($_POST["email"]) && isset($_POST["descrição"]) && isset($_FILES["image"])){

	 
	$email = $_POST["email"];

	if (!is_dir("./upload/".$email) && strlen("./upload/".$email)>0)
            mkdir("./upload/".$email);


    $base_path 			= "./upload/".$email."/";


	if (!is_dir($base_path."/".date("YmdHis")) && strlen($base_path."/".date("YmdHis"))>0)
            mkdir($base_path."/".date("YmdHis"));


	$nome = $_POST["nome"];

	$descrição = $_POST["descrição"];

	$conteudo =  "Nome: ".$nome. "\n\n\nDescrição: ".$descrição;

	$arquivo = fopen($base_path."/".date("YmdHis")."/info.txt", 'w');
	fwrite($arquivo, $conteudo);
	fclose($arquivo);
 
	$errors = array();
	$allowed_ext = array('jpg','jpeg','png','gif');

 	$fileinfo = pathinfo($_FILES['image']['name']);
 
 	//getting the file extension 
 	$file_ext = $fileinfo['extension'];

	$file_name = $_FILES['image']['name'];
	//$file_ext  = strtolower(end(explode(".", $file_name)));
	$file_size = $_FILES['image']['size'];
	$file_tmp  = $_FILES['image']['tmp_name'];

	if (in_array($file_ext, $allowed_ext) === false ) {
		$errors[] = 'Extenstion not allowed';
	}
	if ($file_size > 2097152) {
		$errors[] = 'File size must be under 2mb';
	}
	if (empty($errors)) {
		if(move_uploaded_file($file_tmp, $base_path."/".date("YmdHis")."/".$file_name)){
			echo "Agradecemos por sua participação, se sua imagem for classificada aparecerá aqui em breve, boa sorte!";
		}
	}else{
		foreach ($errors as $error) {
			echo $error , '<br>';
		}
	}
 
	}
	*/
?>

<!DOCTYPE HTML>
<!--
	Multiverse by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3. license (html5up.net/license)
-->
<html>
	<head>
		<title>Astrofotografia Brasil</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<link rel="icon" href="favicon.png">
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
	</head>
	<body class="is-preload">
		<!-- Wrapper -->
			<div id="wrapper">
<?php
if(isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['mensagem'])){
    
    $subject = "Astrofotografia - ".$_POST['email'];
    $message = "<html><head><title>Nrọlabs - ".$_POST['email']."</title><style type='text/css'>* {margin: 0px;padding: 0px;}body {background: #f4f4f4;font-family: Courier New, monospace;color: #666;font-size: 16pt;}</style></head><body><br><table><tbody><tr><th>".$_POST['mensagem'].". ".$_POST['nome']. "</th></tr></tbody></table> </body></html>";
    // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    // More headers
    $headers .= 'From: <'.$_POST['email'].'>' . "\r\n";
    $headers .= 'Cc: <isakruas@gmail.com>'. "\r\n";

    mail('astrofotografia@nrolabs.com', $subject, $message, $headers);

	echo "<br /><nav>Obrigado por sua mensagem, entraremos em contato em breve.</nav><br />";
     
 }

?>


				 
				 






				<!-- Header -->
					<header id="header">
						<h1><a href=""><strong>Astrofotografia Brasil</strong> by Nrọlabs</a></h1>
						<nav>
							<ul>
								<li><a href="#footer" class="icon solid fa-info-circle">Sobre</a></li>
							</ul>
						</nav>
					</header>
				<!-- Main -->
					<div id="main">
						<article class="thumb">
							<a href="images/fulls/1.jpg" class="image"><img src="images/thumbs/1.jpg" alt="" /></a>
							<h2>Magna feugiat lorem</h2>
							<p>Nunc blandit nisi ligula magna sodales lectus elementum non. Integer id venenatis velit.</p>
						</article>
						<article class="thumb">
							<a href="images/fulls/2.jpg" class="image"><img src="images/thumbs/2.jpg" alt="" /></a>
							<h2>Nisl adipiscing</h2>
							<p>Nunc blandit nisi ligula magna sodales lectus elementum non. Integer id venenatis velit.</p>
						</article>
						<article class="thumb">
							<a href="images/fulls/3.jpg" class="image"><img src="images/thumbs/3.jpg" alt="" /></a>
							<h2>Tempus aliquam veroeros</h2>
							<p>Nunc blandit nisi ligula magna sodales lectus elementum non. Integer id venenatis velit.</p>
						</article>
						<article class="thumb">
							<a href="images/fulls/4.jpg" class="image"><img src="images/thumbs/4.jpg" alt="" /></a>
							<h2>Aliquam ipsum sed dolore</h2>
							<p>Nunc blandit nisi ligula magna sodales lectus elementum non. Integer id venenatis velit.</p>
						</article>
						<article class="thumb">
							<a href="images/fulls/5.jpg" class="image"><img src="images/thumbs/5.jpg" alt="" /></a>
							<h2>Cursis aliquam nisl</h2>
							<p>Nunc blandit nisi ligula magna sodales lectus elementum non. Integer id venenatis velit.</p>
						</article>
						<article class="thumb">
							<a href="images/fulls/6.jpg" class="image"><img src="images/thumbs/6.jpg" alt="" /></a>
							<h2>Sed consequat phasellus</h2>
							<p>Nunc blandit nisi ligula magna sodales lectus elementum non. Integer id venenatis velit.</p>
						</article>
						<article class="thumb">
							<a href="images/fulls/7.jpg" class="image"><img src="images/thumbs/7.jpg" alt="" /></a>
							<h2>Mauris id tellus arcu</h2>
							<p>Nunc blandit nisi ligula magna sodales lectus elementum non. Integer id venenatis velit.</p>
						</article>
						<article class="thumb">
							<a href="images/fulls/8.jpg" class="image"><img src="images/thumbs/8.jpg" alt="" /></a>
							<h2>Nunc vehicula id nulla</h2>
							<p>Nunc blandit nisi ligula magna sodales lectus elementum non. Integer id venenatis velit.</p>
						</article>
						<article class="thumb">
							<a href="images/fulls/9.jpg" class="image"><img src="images/thumbs/9.jpg" alt="" /></a>
							<h2>Neque et faucibus viverra</h2>
							<p>Nunc blandit nisi ligula magna sodales lectus elementum non. Integer id venenatis velit.</p>
						</article>
						<article class="thumb">
							<a href="images/fulls/1.jpg" class="image"><img src="images/thumbs/1.jpg" alt="" /></a>
							<h2>Mattis ante fermentum</h2>
							<p>Nunc blandit nisi ligula magna sodales lectus elementum non. Integer id venenatis velit.</p>
						</article>
						<article class="thumb">
							<a href="images/fulls/11.jpg" class="image"><img src="images/thumbs/11.jpg" alt="" /></a>
							<h2>Sed ac elementum arcu</h2>
							<p>Nunc blandit nisi ligula magna sodales lectus elementum non. Integer id venenatis velit.</p>
						</article>
						<article class="thumb">
							<a href="images/fulls/12.jpg" class="image"><img src="images/thumbs/12.jpg" alt="" /></a>
							<h2>Vehicula id nulla dignissim</h2>
							<p>Nunc blandit nisi ligula magna sodales lectus elementum non. Integer id venenatis velit.</p>
						</article>
					</div>

				<!-- Footer -->
					<footer id="footer" class="panel">
						<div class="inner split">
							<div>
								<section>
									<h2>O que é esta plataforma?</h2>
									<p><strong>Astrofotografia - Brasil</strong> é uma plataforma para divulgação de astrofotografias feitas por profissionais e/ou amadores no território brasileiro, nesta perspectiva, objetiva incentivar a  participação da comunidade brasileira em observações e registros de corpos celestes e fenômenos astronômicos. Periodicamente são incluídas novas fotos.
									</p>
								</section>
								<!--section>
									<h2>Follow me on ...</h2>
									<ul class="icons">
										<li><a href="#" class="icon brands fa-twitter"><span class="label">Twitter</span></a></li>
										<li><a href="#" class="icon brands fa-facebook-f"><span class="label">Facebook</span></a></li>
										<li><a href="#" class="icon brands fa-instagram"><span class="label">Instagram</span></a></li>
										<li><a href="#" class="icon brands fa-github"><span class="label">GitHub</span></a></li>
										<li><a href="#" class="icon brands fa-dribbble"><span class="label">Dribbble</span></a></li>
										<li><a href="#" class="icon brands fa-linkedin-in"><span class="label">LinkedIn</span></a></li>
									</ul>
								</section-->
								<p class="copyright">
									&copy; 2020 Nrọlabs Desenvolvimento de Softwares. 
									<br />
									Design by HTML5 UP.
									<br />
									Icons made by Surang
								</p>
							</div>
							<div>
								<section>
									<h2>Deseja ver sua astrofotografia aqui? Envie-nos uma mensagem.</h2> 
									<form method="post" action="" enctype="multipart/form-data">
										<div class="fields">
											<div class="field half">
												<input type="text" name="nome" id="nome" placeholder="Nome" required />
											</div>
											<div class="field half">
												<input type="text" name="email" id="email" placeholder="Email" required />
											</div>
											<div class="field">
												<textarea name="mensagem" id="mensagem" rows="4" placeholder="Mensagem" required></textarea>
											</div>
											<!--div class="field">
												<input type="file" style="display: none !important;" name="image" id="image"  required/>
												<label for='image' id="label_image">Selecionar Arquivo</label>
											</div-->
										</div>
										<ul class="actions">
											<li><input type="submit" value="Enviar" class="primary" /></li>
											<li><input type="reset" value="Apagar" /></li>
										 
										</ul>
									</form>
								</section>
							</div>
						</div>
					</footer>

			</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.poptrox.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>