<!DOCTYPE html>

<html lang = "pt-BR">
	
	<head>
		
		<title>Cadastro</title>
		<meta charset = "UTF-8" />
		<script src= "jquery-3.4.1.min.js"></script>
		<script>
			
			var id = null;
			var filtro = null;
			
			$(function(){
				
				$(document).on("click",".cadastrar",function(){
					$.ajax({ 
						url: "insere_cidade.php",
						type: "post",
						data: {
								nome:$("input[name='nome_cidade']").val()
								},
						success: function(data){
							if(data==1){
								$("#resultado").html("Cadastro efetuado!");
							}else {
								console.log(data);
							}
						}
					});
				});
				
			});
		
		</script>
		
	</head>
	
	<body>
		
		<h3>Cadastro de Cidades</h3>
		
		
		<form> 
			
			<input type = "text" name = "nome_cidade" placeholder = "Nome..." /> <br /><br />
			<select>
				<legend>Cidades</legend>
				<?php
					
				?>
			</select>
			<input type = "button" class = "cadastrar" value = "Cadastrar" />
			
		</form>
		
		<br />
		
		<div id = "resultado"></div>
		
		<br />
		
		<h3>Cadastros</h3>
		<p>
		<form name='filtro'>
			<input type="text" name="nome_filtro" placeholder="filtrar por nome" />
			<button type="button" id="filtrar">Filtrar<button>
		</form>
		</p>
		
		<table border = '1'>
						
			<thead>
				<tr>
					<th>Nome</th>
					<th>Estado</th>
					<th>Ação</th>
				</tr>
			 </thead>
		
			<tbody id = 'identificador'></tbody>
					
		</table>
		<br /><br />
		
		<div id="paginacao">
		<?php
			
			include("conexao.php");
				

			include("paginacao_cidade.php");
			
		?>
		</div>
		
	</body>
	
</html>