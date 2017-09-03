<?php
	include "class/conexao.php";

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

			$senha = md5(md5($_SESSION[senha]));

			$sql_code = "INSERT INTO 
				usuario (
				nome,
				sobrenome,
				email,
				senha,
				sexo,
				niveldeacesso,
				datadecadastro)
				VALUES(
				'$_SESSION[nome]',
				'$_SESSION[sobrenome]',
				'$_SESSION[email]',
				'$senha',
				'$_SESSION[sexo]',
				'$_SESSION[niveldeacesso]',
				NOW()
				)";

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
	}else
		$erro = null;

?>
<h1>Cadastrar Usuário</h1>
<?php
	if($erro){
		echo "<div class='erro'>";
		foreach($erro as $valor)
			echo "$valor <br>";

		echo "</div>";
	}
?>
<a href="index.php?p=inicial">< Voltar</a>
<p class="espaco"></p>
<form action="index.php?p=cadastro" method="POST">

	<label for="nome">Nome</label>
	<input type="text" name="nome" value="<?php if($erro) echo $_SESSION['nome'];?>" required>
	<p class="espaco"></p>

	<label for="sobrenome">Sobrenome</label>
	<input type="text" name="sobrenome" value="<?php if($erro) echo $_SESSION['sobrenome'];?>"  required>
	<p class="espaco"></p>

	<label for="email">E-mail</label>
	<input type="email" name="email" value="<?php if($erro) echo $_SESSION['email'];?>"  required>
	<p class="espaco"></p>

	<label for="sexo">Sexo</label>
	<select name="sexo">
		<option value="">Selecione</option>
		<option value="1"<?php if($erro && $_SESSION['sexo'] == 1) echo "selected";?> >Masculino</option>
		<option value="2" <?php if($erro && $_SESSION['sexo'] == 2) echo "selected";?> >Feminino</option>
	</select>
	<p class="espaco"></p>

	<label for="niveldeacesso">Nível de Acesso</label>
	<select name="niveldeacesso">
		<option value="">Selecione</option>
		<option value="1" <?php if($erro && $_SESSION['niveldeacesso'] == 1) echo "selected";?> >Básico</option>
		<option value="2" <?php if($erro && $_SESSION['niveldeacesso'] == 2) echo "selected";?> >Admin</option>
	</select>
	<p class="espaco"></p>

	<label for="senha">Senha</label>
	A senha deve ter entre 8 e 16 caracteres.
	<input type="password" name="senha" required>
	<p class="espaco"></p>

	<label for="rsenha">Repita a senha</label>
	<input type="password" name="rsenha" required>
	<p class="espaco"></p>

	<input type="submit" name="confirmar" value="Salvar">
</form>