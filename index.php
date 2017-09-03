<?php
	include "class/conexao.php";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<link rel="css/bootstrap.min.css" type="text/css">
	<title>CRUD com PHP7</title>
</head>
<body>
	<div>
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