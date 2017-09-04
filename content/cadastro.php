<?php
	include "class/conexao.php";

	$erro = null;

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
		if(!($erro)){

			$senha = md5(md5($_SESSION['senha']));

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
				unset($_SESSION['nome'],
				$_SESSION['sobrenome'],
				$_SESSION['email'],
				$_SESSION['senha'],
				$_SESSION['sexo'],
				$_SESSION['niveldeacesso'],
				$_SESSION['datadecadastro']);

				echo "<script> location.href='index.php?p=inicial'; </script>";
			}else
				$erro[] = $confirma;
		}
	}

?>
<div class="col-lg-6 col-lg-offset-3">
<a href="index.php?p=inicial" class="btn btn-default">VOLTAR</a>
<h1 class="text-center">Cadastrar Usuário</h1>
<?php
	if($erro){
		echo "<div class='alert-danger'>";
		foreach($erro as $valor)
			echo "$valor <br>";

		echo "</div>";
	}
?>
<form action="index.php?p=cadastro" method="POST" id="container-cadastro">
	<div id="container-nome" class="container-input">
		<label for="nome">Nome</label>
		<input autofocus id="nome" type="text" name="nome" class="form-input" value="<?php if($erro) echo $_SESSION['nome'];?>" required onfocus="formInputFocus(id)" onblur="formInputBlur(id)">
		<div class="line-input"></div>
	</div>

	<div id="container-sobrenome" class="container-input">
		<label for="sobrenome">Sobrenome</label>
		<input id="sobrenome" type="text" name="sobrenome" class="form-input" value="<?php if($erro) echo $_SESSION['sobrenome'];?>" required onfocus="formInputFocus(id)" onblur="formInputBlur(id)">
		<div class="line-input"></div>
	</div>

	<div id="container-email" class="container-input">
		<label for="email">E-mail</label>
		<input id="email" type="email" name="email" class="form-input" value="<?php if($erro) echo $_SESSION['email'];?>"  required onfocus="formInputFocus(id)" onblur="formInputBlur(id)">
		<div class="line-input"></div>
	</div>

	<div id="container-sexo" class="container-input">
		<label for="sexo">Sexo</label>
		<select id="sexo" name="sexo" class="form-input" required onfocus="formInputFocus(id)" onblur="formInputBlur(id)">
			<option value=""></option>
			<option value="1"<?php if($erro && $_SESSION['sexo'] == 1) echo "selected";?> >Masculino</option>
			<option value="2" <?php if($erro && $_SESSION['sexo'] == 2) echo "selected";?> >Feminino</option>
		</select>
		<div class="line-input"></div>
	</div>

	<div id="container-acesso" class="container-input">
		<label for="niveldeacesso">Nível de Acesso</label>
		<select id="niveldeacesso" name="niveldeacesso" class="form-input" onfocus="formInputFocus(id)" onblur="formInputBlur(id)">
			<option value=""></option>
			<option value="1" <?php if($erro && $_SESSION['niveldeacesso'] == 1) echo "selected";?> >Básico</option>
			<option value="2" <?php if($erro && $_SESSION['niveldeacesso'] == 2) echo "selected";?> >Admin</option>
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