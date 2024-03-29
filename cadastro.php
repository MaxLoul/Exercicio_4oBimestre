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
		////////////////CADASTRAR/////////////
				$(document).on("click",".cadastrar",function(){
					$.ajax({ 
						url: "insere.php",
						type: "post",
						data: {
								nome:$("input[name='nome']").val(), 
								email:$("input[name='email']").val(), 
								salario:$("input[name='salario']").val(), 
								sexo:$("input[name='sexo']:checked").val()
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
		//////////////////////////////////
				
		//////////////EXIBIR///////////////////
				$("#filtro").click(function(){
					$.ajax({
						url:"paginacao_cadastro.php",
						type:"post",
						data:{
							nome_filtro: $("input[name='nome_filtro']").val()
						},
						success: function(d){
							$("#paginacao").html(d);
							filtro = $("input[name='nome_filtro']"),val();
							paginacao(0);
						}
					});
				});
				
				paginacao(0);
				
				
				
				function paginacao(p) {
					$.ajax ({
						url: "carrega_cadastro.php",
						type: "post",
						data: {pg: p, nome_filtro: filtro},
						success: function(matriz){
							$("#identificador").html("");
							for(i=0;i<matriz.length;i++){
								linha = "<tr>";
								linha += "<td class = 'nome'>" + matriz[i].nome + "</td>";
								linha += "<td class = 'email'>" + matriz[i].email + "</td>";
								linha += "<td class = 'sexo'>" + matriz[i].sexo + "</td>";
								linha += "<td class = 'salario'>" + matriz[i].salario + "</td>";
								linha += "<td><button type = 'button' id = 'nome_alterar' class = 'alterar' value ='" + matriz[i].id_cadastro + "'>Alterar</button> | <button type = 'button' class ='remover' value ='" + matriz[i].id_cadastro + "'>Remover</button></td>";
								linha += "</tr>";
								$("#identificador").append(linha);
							}
						}
					});
				}
				
				$(document).on("click", ".pg", function(){
					p = $(this).val();
					p = (p-1)*5;
					paginacao(p);
				});
				
			//////////////////////////////////////////////
			
			///////////ALTERAÇÃO///////////////
				$(document).on("click",".alterar",function(){
					id = $(this).attr("value");
					$.ajax({
						url: "carrega_cadastro_alterar.php",
						type: "post",
						data: {id: id},
						success: function(vetor){
							$("input[name='nome']").val(vetor.nome);
							$("input[name='email']").val(vetor.email);
							if(vetor.sexo=='F'){
								$("input[name='sexo'][value='M']").attr("checked",false);
								$("input[name='sexo'][value='F']").attr("checked",true);
							}else {
								$("input[name='sexo'][value='F']").attr("checked",false);
								$("input[name='sexo'][value='M']").attr("checked",true);
							}
							$(".cadastrar").attr("class","alteracao");
							$(".alteracao").val("Alterar Cadastro");
						}
					});
				});			
				
				$(document).on("click",".alteracao",function(){
					$.ajax({ 
						url: "altera.php",
						type: "post",
						data: {id: id, nome:$("input[name='nome']").val(), email:$("input[name='email']").val(), sexo:$("input[name='sexo']:checked").val()},
						success: function(data){
							if(data==1){
								$("#resultado").html("Alteração efetuada!");
								paginacao(0);
								$("input[name='nome']").val("");
								$("input[name='email']").val("");
								$("input[name='sexo'][value='M']").attr("checked",false)
								$("input[name='sexo'][value='F']").attr("checked",false)
								$(".alteracao").attr("class","cadastrar");
								$(".cadastrar").val("Cadastrar");
							}else {
								console.log(data);
							}
						}
					});
				});
		/////////////////ALTERAR NOME////////////////
				$(document).on("click",".nome",function(){
					td = $(this);
					nome = td.html();
					td.html("<input type = 'text' name = 'nome' value = '" + nome + "' />");
					td.attr("class","nome_alterar");
				});
				
				$(document).on("blur",".nome_alterar",function(){
					td = $(this);
					id_linha = $(this).closest("tr").find("button").val();
					$.ajax({
						url: "altera_inline.php",
						type: "post",
						data: {coluna: 'nome', valor: $("#nome_alterar").val(), id: id_linha},
						success: function(){
							nome = $("#nome_alterar").val();
							td.html(nome);
							td.attr("class","nome");
						}
					});
				});
				
		//////////////ALTERAR SEXO///////////////
		$(document).on("click",".sexo",function(){
					td = $(this);
					sexo = td.html();
					sexo_input = ("<input type = 'radio' class='alterar_sexo' name = 'sexo' value = 'M' />");
					sexo_input += ("<input type = 'radio' class='alterar_sexo' name = 'sexo' value = 'F' />");
					if(sexo=="M"){
						$(".alterar_sexo[value='M']").prop("checked",true);
						$(".alterar_sexo[value='M']").prop("checked",false);
					}else{
						$(".alterar_sexo[value='M']").prop("checked",false);
						$(".alterar_sexo[value='M']").prop("checked",true);
					}
					td.attr("class","sexo_alterar");
				});
				
				$(document).on("blur",".sexo_alterar",function(){
					td = $(this);
					id_linha = $(this).closest("tr").find("button").val();
					$.ajax({
						url: "alterar_inline.php",
						type: "post",
						data: {coluna: 'sexo', valor: $(".alterar_sexo:checked").val(), id: id_linha},
						success: function(){
							sexo = $(".alterar_sexo:checked").val();
							td.html(sexo);
							td.attr("class","sexo");
						}
					});
				});
				
			////////////ALTERAR CIDADE/////////////
				$(document).on("click",".cidade",function(){
					td = $(this);
					cidade = td.html();
					select = "<select id='cidade_alterar'>";
					select += $("select[name='cidade_alterar']").html();
					select += "</select>";
					td.html(select);
					valor = $("option:contains('"+cidade+"')").val();
					$("#cod_cidade").val(valor);
					$("cod_cidade").focus();
					td.attr("class","nome_alterar");
				});
				
					$(document).on("blur",".cidade_alterar",function(){
					td = $(this);
					id_linha = $(this).closest("tr").find("button").val();
					$.ajax({
						url: "alterar_inline.php",
						type: "post",
						data: {coluna: 'cod_cidade', valor: $("#cidade_alterar").val(), id: id_linha},
						success: function(){
							cidade = $("#cidade_alterar").val();
							cidade + $("cidade_alterar").find("option[value='"+ cod_cidade +"']")
							cidade_estado = cidade_estado.split("/");
							cidade = cidade_estado[0];
							estado = cidade_estado[1];
							td.closest("tr").find(".estado").html(estado).html();
							td.html(cidade);
							td.attr("class","cidade");
						}
					});
				});
				
			});
		
		</script>
		
	</head>
	
	<body>
		
		<h3>Cadastro de Pessoas</h3>
		
		
		<form>
			
			<input type = "text" name = "nome" placeholder = "Nome..." /> <br /><br />
			<input type = "email" name = "email" placeholder = "E-mail..." /><br /><br />
			<input type = "number" name = "salario" placeholder = "Salario..." /><br /><br />
			Sexo: <br />
			M <input type = "radio" name = "sexo" value = "M" />
			F <input type = "radio" name = "sexo" value = "F" /><br /><br />
			
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
					<th>E-mail</th>
					<th>Sexo</th>
					<th>Salario</th>
					<th>Ação</th>
				</tr>
			 </thead>
		
			<tbody id = 'identificador'></tbody>
					
		</table>
		<br /><br />
		
		<div id="paginacao">
		<?php
			
			include("conexao.php");
				

			include("paginacao_cadastro.php");
			
		?>
		</div>
		
	</body>
	
</html>