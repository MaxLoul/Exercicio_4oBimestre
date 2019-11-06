<?php
	
	include("conexao.php");
	
	$nome_cidade = $_POST["cidade"];
	
	$insercao = "INSERT INTO cidade (nome_cidade)
						VALUES('$nome_cidade')";

	mysqli_query($conexao,$insercao)
		or die($insercao);
	
	echo "1";
	
?>