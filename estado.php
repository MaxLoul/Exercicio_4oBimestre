<!DOCTYPE html>

<html lang = "pt-BR">
	
	<head>
		
		<title>Estados</title>
		<meta charset = "UTF-8" />
		<script src= "jquery-3.4.1.min.js"></script>
		<script>
			
			$(function(){
				
				paginacao(0);
				function paginacao(p) {
					$.ajax ({
						url: "carrega_estado.php",
						type: "post",
						data: {pg: p},
						success: function(matriz){
							
							$("#identificador").html("");
							if (matriz != null){
								
								for(i=0;i<matriz.length;i++){
									linha = "<tr>";
									linha += "<td class = 'nome'>" + matriz[i].nome + "</td>";
									linha += "<td class = 'uf'>" + matriz[i].uf + "</td>";
									linha += "</tr>";
									$("#identificador").append(linha);
								}
							}
						}
					});
				}
				
				$(".pg").click(function(){
					p = $(this).val();
					p = (p-1)*5;
					paginacao(p);
				});
				
				$(document).on("click",".cadastrar",function(){
					$.ajax({ 
						url: "insere_estado.php",
						type: "post",
						data: {nome:$("input[name='nome']").val(), uf:$("input[name='uf']").val()},
						success: function(data){
							if(data==1){
								$("#resultado").html("Estado cadastrado!");
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
		
		<h3>Cadastro de Estados</h3>
		
		<form>
			
			<input type = "text" name = "nome" placeholder = "Nome..." /> <br /><br />
			<input type = "text" name = "uf" placeholder = "UF..." /> <br /><br />
			
			<input type = "button" class = "cadastrar" value = "Cadastrar" />
			
		</form>
		
		<br />
		
		<div id = "resultado"></div>
		
		<br />
		
		<h3>Cidades</h3>
		
		<table border = '1'>
						
			<thead>
				<tr>
					<th>Nome</th>
					<th>UF</th>
					<th>Ação</th>
				</tr>
			 </thead>
		
			<tbody id = 'identificador'></tbody>
					
		</table>
		<br /><br />
		
		<?php
			
			include("conexao.php");
				

			include("paginacao_estado.php");
			
		?>
		
	</body>
	
</html>