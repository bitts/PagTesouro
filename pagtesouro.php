<?php
defined('_JEXEC') or die;


try {

	$document   = & JFactory::getDocument();
	
	$styles= "<style>
		.fieldtoken{
			margin-botton: 50px;
			border: 1px solid #ccc;
			padding: 10px;
			margin-bottom: 20px;
		}
	</style>";

	$document->addCustomTag($styles);

	
	$script="<script type='text/javascript'>
		var j = jQuery.noConflict();
		j(document).ready(function($){
		
			$.ajax({
				url: '". JUri::base() ."components/com_pagtesouro/pagtesouro.json',
				success: function(resposta){
					populate(resposta);
				},
				error: function (jqXHR, textStatus, errorThrown) {
				}
			});
			
			function populate(obj){ 
				if(obj){
					
					obj.map(function(item){					
						var _html = $('<fieldset />').addClass('fieldtoken');
						_html.append(
							$('<p />').append(
								$('<input />',{'type':'text', 'placeholder':'Informe aqui o Token', 'name': 'token'}).css({'width':'98%'}).addClass('form-control').val(item.token)
							)
						);
						
						var tb_srv = $('<table />').addClass('servicos').css({'width':'100%'});
						tb_srv.append(
							$('<tr />').append(
								$('<td />', {'colspan':'3'}).append(
									$('<button />').text('Adicionar Serviço').click(function(){
										$(this).closest('table').append(
											$('<tr />').addClass('item_servico').append(
												$('<td />').css({'width':'125px'}).append(
													$('<input />',{'type':'text', 'placeholder':'Código', 'name': 'cod_servico'}).css({'width':'auto'}).addClass('cod_servico form-control')
												),
												$('<td />').append(
													$('<input />',{'type':'text', 'placeholder':'Descrição do Serviço', 'name': 'servico'}).css({'width':'98%'}).addClass('servico form-control')
												),
												$('<td />').css({'width':'60px'}).append(
													$('<button />').text('X').click(function(){
														$(this).closest('tr').remove();
													})
												)
											)
										)
									})
								)
							)
						);
						if(item && item.servicos)
						item.servicos.map(function(itm){
							tb_srv.append(
								$('<tr />').addClass('item_servico').append(
									$('<td />').css({'width':'125px'}).append(
										$('<input />',{'type':'text', 'placeholder':'Código', 'name': 'cod_servico'}).css({'width':'auto'}).addClass('cod_servico form-control').val(itm.codigo)
									),
									$('<td />').append(
										$('<input />',{'type':'text', 'placeholder':'Descrição do Serviço', 'name': 'servico'}).css({'width':'98%'}).addClass('servico form-control').val(itm.descricao)
									),
									$('<td />').css({'width':'60px'}).append(
										$('<button />').text('X').click(function(){
											$(this).closest('tr').remove();
										})
									)
								)

							);
						});
						
						_html.append(
							tb_srv,
							$('<button />').css({'float':'right'}).text('Remover').click(function(){
								$(this).closest('fieldset.fieldtoken').remove();
							})
						);
						
						$('div.token').append(_html);
					});					
					
					
				}
			}
				
			
			$('.add_token').on('click', function(){
				$('.token').append(
					$('<fieldset>').addClass('fieldtoken').append(
						$('<p />').append(
							$('<input />',{'type':'text', 'placeholder':'Informe aqui o Token', 'name': 'token'}).css({'width':'98%'}).addClass('form-control')
						),
						$('<table />').addClass('servicos').css({'width':'100%'}).append(
							$('<tr />').append(
								$('<td />', {'colspan':'3'}).append(
									$('<button />').text('Adicionar Serviço').click(function(){
										$(this).closest('table').append(
											$('<tr />').addClass('item_servico').append(
												$('<td />').css({'width':'125px'}).append(
													$('<input />',{'type':'text', 'placeholder':'Código', 'name': 'cod_servico'}).css({'width':'auto'}).addClass('cod_servico form-control')
												),
												$('<td />').append(
													$('<input />',{'type':'text', 'placeholder':'Descrição do Serviço', 'name': 'servico'}).css({'width':'98%'}).addClass('servico form-control')
												),
												$('<td />').css({'width':'60px'}).append(
													$('<button />').text('X').click(function(){
														$(this).closest('tr').remove();
													})
												)
											)
										)
									})
								)
							)
						),
						$('<button />').css({'float':'right'}).text('Remover').click(function(){
							$(this).closest('fieldset.fieldtoken').remove();
						})
					)
				)
			});	
			
			function msg(text){
				let id = parseInt(Math.random() * 100);
				$('section#content')
					.prepend( 
						$('<div />').addClass('mensagem alert alert-danger msg_' + id).text(text).show(function(){
							setTimeout(function(){ $('.msg_'+ id ).remove() },5000);
						}) 
					);
			}
			$('.salvar_token').on('click', function(){
				var obj = Array();
				$('.fieldtoken').each(function(){
					let tk = $(this).find(\"input[name='token']\").val();
					
					if(tk === '')msg('Token não informado.');
					else {
						let serv = [];
						let srv = $(this).find('table.servicos tr.item_servico')
						if(srv.length)srv.each(function(){
							let cd = $(this).find(\"input[name='cod_servico']\").val();
							let sv = $(this).find(\"input[name='servico']\").val();
							if(cd!=='' && sv !== '')serv.push({'codigo':cd, 'descricao':sv});
							else msg('É preciso informar o código e a descrição do serviço');
						});
						obj.push({
							'token' : tk,
							'servicos' : serv
						})
					}
				});
				$.ajax({
					url: '". JUri::base() ."components/com_pagtesouro/pagtesouro-save.php',
					type: 'POST',
					data: {obj},
					success: function(resposta){
						let id = parseInt(Math.random() * 100);
						$('section#content')
							.prepend( 
								$('<div />').addClass('mensagem alert alert-success msg_s_' + id).text(resposta).show(function(){
									setTimeout(function(){ $('.msg_s_'+ id ).remove() },5000);
								}) 
							);
					},
					error: function (jqXHR, textStatus, errorThrown) {
						msg('Erro ao salvar conteudo no arquivo pagtesouro.json');
					}
			  	});				  
			});
		});			
	</script>";
	$document->addCustomTag($script);

	//echo "<button class='add_token'>Adicionar Token</button>";
	
	
} catch (Exception $e) {
	print 'Error: ' . $e->getMessage();
}
?>

<fieldset>
	<legend>Cadastro de Tokens do PagTesouro</legend>

	<p>
		<button class="add_token">Adicionar Token</button>
	</p>
	<div class="token"></div>
	
	<p>
		<button class="salvar_token">Salvar</button>
	</p>
</fieldset>