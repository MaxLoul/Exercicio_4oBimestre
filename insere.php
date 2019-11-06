<?php
	
	include("conexao.php");
	
	$nome = $_POST["nome"];
	$email = $_POST["email"];
	$sexo = $_POST["sexo"];
	$salario = $_POST["salario"];
	
	$insercao = "INSERT INTO cadastro (nome, email, sexo, salario)
						VALUES('$nome', '$email', '$sexo', '$salario')";

	mysqli_query($conexao,$insercao)
		or die($insercao);
	
	echo "1";
	
?>