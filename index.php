<?php
	include "class/conexao.php";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<link href="css/base.css" rel="stylesheet">
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/myform.css" rel="stylesheet">
	<title>CRUD com PHP7</title>
	<script src="js/myform.js" type="text/javascript"></script>
	<style>
		.bold{
			font-weight: bold;
		}
	</style>
</head>
<body>
	<div class="container">
		<?php
			if(isset($_GET['p'])){
				$pagina = $_GET['p'].".php";
				if(is_file("content/$pagina"))
					include("content/$pagina");
				else
					include("content/404.php");

			}else
				include("content/inicial.php");
		?>
	</div>
</body>
</html>