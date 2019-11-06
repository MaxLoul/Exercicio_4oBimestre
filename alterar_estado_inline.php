<?php
	
	include("conexao.php");
	
	$coluna = $_POST["coluna"];
	$valor = $_POST["valor"];
	$id = $_POST["id"];
	
	$alteracao = "UPDATE estado SET 
				$coluna = '$nome'
				WHERE id_estado = '$id'";

	mysqli_query($conexao,$alteracao)
		or die(mysqli_error($conexao));
	
	echo "1";
	
?>