<?php
	include "class/conexao.php";

	$erro = null;

	if(isset($_POST['confirmar'])){
		$user_codigo = intval($_GET['usuario']);
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
		if(!($erro)){

			$senha = md5(md5($_SESSION['senha']));
			$sql_code = "UPDATE usuario SET
				nome = '$_SESSION[nome]',
				sobrenome = '$_SESSION[sobrenome]',
				email = '$_SESSION[email]',
				senha = '$senha',
				sexo = '$_SESSION[sexo]',
				niveldeacesso = '$_SESSION[niveldeacesso]'
				WHERE codigo = '$user_codigo'";

			if($mysqli->query($sql_code) == true){
				echo "
					<script>
						alert('Usuário atualizado com sucesso!');
						location.href='index.php?p=inicial';
					</script>";
			}
			else
				echo "
					<script>
						alert('Erro ao atualizar usuário.');
					</script>";
		}
	}elseif(isset($_GET['usuario'])){
			$user_codigo = intval($_GET['usuario']);
			$sql_code = "SELECT * FROM usuario WHERE codigo = '$user_codigo'";
			$sql_query = $mysqli->query($sql_code);
			if($sql_query->num_rows > 0){
				$linha = $sql_query->fetch_assoc();

				if(!isset($_SESSION))
					session_start();

				$_SESSION['nome'] = $linha['nome'];
				$_SESSION['sobrenome'] = $linha['sobrenome'];
				$_SESSION['email'] = $linha['email'];
				$_SESSION['senha'] = $linha['senha'];
				$_SESSION['sexo'] = $linha['sexo'];
				$_SESSION['niveldeacesso'] = $linha['niveldeacesso'];
			} else
				echo "
					<script>
						alert('Código Inválido');
						location.href='index.php';
					</script>";
	}else
		echo "<script>location.href='content/404.php';</script>";
?>
<div class="col-lg-6 col-lg-offset-3">
<a href="index.php?p=inicial" class="btn btn-default">< Voltar</a>
<h1 class="text-center">Editar Usuário</h1>
<?php
	if(count($erro) > 0){
		echo "<div class='erro'>";
		foreach($erro as $valor)
			echo "$valor <br>";

		echo "</div>";
	}
?>
<p class="espaco"></p>
<form action="index.php?p=editar&usuario=<?php echo $user_codigo; ?>" method="POST">
	<div id="container-nome" class="container-input focused-input">
		<label for="nome">Nome</label>
		<input id="nome" type="text" name="nome" class="form-input" value="<?php echo $_SESSION['nome'];?>" required onfocus="formInputFocus(id)" onblur="formInputBlur(id)"">
		<div class="line-input"></div>
	</div>

	<div id="container-sobrenome" class="container-input focused-input">
		<label for="sobrenome">Sobrenome</label>
		<input id="sobrenome" type="text" name="sobrenome" class="form-input" value="<?php echo $_SESSION['sobrenome'];?>" required onfocus="formInputFocus(id)" onblur="formInputBlur(id)">
		<div class="line-input"></div>
	</div>

	<div id="container-email" class="container-input focused-input">
		<label for="email">E-mail</label>
		<input id="email" type="email" name="email" class="form-input" value="<?php echo $_SESSION['email'];?>"  required onfocus="formInputFocus(id)" onblur="formInputBlur(id)">
		<div class="line-input"></div>
	</div>

	<div id="container-sexo" class="container-input focused-input">
		<label for="sexo">Sexo</label>
		<select id="sexo" name="sexo" class="form-input" required onfocus="formInputFocus(id)" onblur="formInputBlur(id)">
			<option value=""></option>
			<option value="1"<?php if($_SESSION['sexo'] == 1) echo "selected";?> >Masculino</option>
			<option value="2" <?php if($_SESSION['sexo'] == 2) echo "selected";?> >Feminino</option>
		</select>
		<div class="line-input"></div>
	</div>

	<div id="container-acesso" class="container-input focused-input">
		<label for="niveldeacesso">Nível de Acesso</label>
		<select id="niveldeacesso" name="niveldeacesso" class="form-input" onfocus="formInputFocus(id)" onblur="formInputBlur(id)">
			<option value=""></option>
			<option value="1" <?php if($_SESSION['niveldeacesso'] == 1) echo "selected";?> >Básico</option>
			<option value="2" <?php if($_SESSION['niveldeacesso'] == 2) echo "selected";?> >Admin</option>
		</select>
		<div class="line-input"></div>
	</div>

	<div id="container-senha" class="container-input">
		<label for="senha">Senha</label>
		<input id="senha" type="password" name="senha" class="form-input" required onfocus="formInputFocus(id)" onblur="formInputBlur(id)">
		<div class="line-input"></div>
	</div>

	<div id="container-rsenha" class="container-input">
		<label for="rsenha">Repita a senha</label>
		<input id="rsenha" type="password" name="rsenha" class="form-input" required onfocus="formInputFocus(id)" onblur="formInputBlur(id)">
		<div class="line-input"></div>
	</div>
	<input type="submit" name="confirmar" class="btn btn-success btn-block" value="SALVAR">
</form>
</div>