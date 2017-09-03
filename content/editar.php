<?php
	include "class/conexao.php";

	if(!isset($_GET['usuario']) && !isset($_POST['confirmar']))
		echo "<script> alert('Codigo Inválido.'); location.href='index.php?p=inicial'; </script>";
	else{

	$usu_codigo = intval($_GET['usuario']);

	if(isset($_POST['confirmar'])){

		// 1 - Registro dos dados
		if(!isset($_SESSION))
			session_start();

		foreach ($_POST as $chave => $valor)
			$_SESSION[$chave] = $mysqli->real_escape_string($valor);

		// 2 - Validação dos dados
		if(strlen($_SESSION['nome']) == 0)
			$erro[] = "Preencha o nome.";

		if(strlen($_SESSION['sobrenome']) == 0)
			$erro[] = "Preencha o sobrenome.";

		if(substr_count($_SESSION['email'], '@') != 1 || substr_count($_SESSION['email'], '.') < 1 || substr_count($_SESSION['email'], '.') > 2)
			$erro[] = "Preencha o email corretamente.";

		if(strlen($_SESSION['niveldeacesso']) == 0)
			$erro[] = "Preencha o nível de acesso.";

		if(strlen($_SESSION['senha']) < 8 || strlen($_SESSION['senha']) > 16)
			$erro[] = "Preencha a senha corretamente.";

		if(strcmp($_SESSION['senha'],$_SESSION['rsenha']) != 0){
			$erro[] = "As senhas não combinam.";
		}

		// 3 - Inserção e Redirecionamento
		if(count($erro) == 0){

			$senha = md5(md5($_SESSION['senha']));

			$sql_code = "UPDATE usuario SET
				nome = '$_SESSION[nome]',
				sobrenome = '$_SESSION[sobrenome]',
				email = '$_SESSION[email]',
				senha = '$senha',
				sexo = '$_SESSION[sexo]',
				niveldeacesso = '$_SESSION[niveldeacesso]'
				WHERE codigo = '$usu_codigo'";

			$confirma = $mysqli->query($sql_code) or die ($mysqli->error);

			if($confirma){
				unset($_SESSION[nome],
				$_SESSION[sobrenome],
				$_SESSION[email],
				$_SESSION[senha],
				$_SESSION[sexo],
				$_SESSION[niveldeacesso],
				$_SESSION[datadecadastro]);

				echo "<script> location.href='index.php?p=inicial'; </script>";

			}else
				$erro[] = $confirma;

		}
	}else{
			$erro = null;
			$sql_code = "SELECT * FROM usuario WHERE codigo = '$usu_codigo'";
			$sql_query = $mysqli->query($sql_code) or die ($mysqli->error);
			$linha = $sql_query->fetch_assoc();

			if(!isset($_SESSION))
				session_start();

			$_SESSION['nome'] = $linha['nome'];
			$_SESSION['sobrenome'] = $linha['sobrenome'];
			$_SESSION['email'] = $linha['email'];
			$_SESSION['senha'] = $linha['senha'];
			$_SESSION['sexo'] = $linha['sexo'];
			$_SESSION['niveldeacesso'] = $linha['niveldeacesso'];

		}
?>
<h1>Editar Usuário</h1>
<?php
	if(count($erro) > 0){
		echo "<div class='erro'>";
		foreach($erro as $valor)
			echo "$valor <br>";

		echo "</div>";
	}
?>
<a href="index.php?p=inicial">< Voltar</a>
<p class="espaco"></p>
<form action="index.php?p=editar&usuario<?php echo $usu_codigo; ?>" method="POST">

	<label for="nome">Nome</label>
	<input type="text" name="nome" value="<?php echo $_SESSION['nome'] ?>" required>
	<p class="espaco"></p>

	<label for="sobrenome">Sobrenome</label>
	<input type="text" name="sobrenome" value="<?php echo $_SESSION['sobrenome'] ?>" required>
	<p class="espaco"></p>

	<label for="email">E-mail</label>
	<input type="email" name="email" value="<?php echo $_SESSION['email'] ?>" required>
	<p class="espaco"></p>

	<label for="sexo">Sexo</label>
	<select name="sexo">
		<option value="">Selecione</option>
		<option value="1" <?php if($_SESSION['sexo'] == 1) echo "selected"; ?>>Masculino</option>
		<option value="2" <?php if($_SESSION['sexo'] == 2) echo "selected"; ?>>Feminino</option>
	</select>
	<p class="espaco"></p>

	<label for="niveldeacesso">Nível de Acesso</label>
	<select name="niveldeacesso">
		<option value="">Selecione</option>
		<option value="1" <?php if($_SESSION['niveldeacesso'] == 1) echo "selected"; ?>>Básico</option>
		<option value="2" <?php if($_SESSION['niveldeacesso'] == 2) echo "selected"; ?>>Admin</option>
	</select>
	<p class="espaco"></p>

	<label for="senha">Senha</label>
	A senha deve ter entre 8 e 16 caracteres.
	<input type="password" name="senha" value="" required>
	<p class="espaco"></p>

	<label for="rsenha">Repita a senha</label>
	<input type="password" name="rsenha" value="" required>
	<p class="espaco"></p>

	<input type="submit" name="confirmar" value="Salvar">
</form>

<?php } ?>