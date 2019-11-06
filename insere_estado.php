<?php
	
	include("conexao.php");
	
	$nome_estado = $_POST["nome"];
	$uf = $_POST["uf"];
	
	$insercao = "INSERT INTO estado (nome_estado, uf)
						VALUES('$nome_estado', '$uf')";

	mysqli_query($conexao,$insercao)
		or die("0");
	
	echo "1";
	
?>