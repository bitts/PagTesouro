
<?php

/*
# Title: Sisteminha mixuruca de integração ao PagTesouro
# Description: sistema para geração de GRU do PagTesouro
# Author: Marcelo Valvassori Bittencourt
# E-mail: marcelo.valvassori.bittencourt@gmail.com
# version: 2.0
# Modificação: 16 MAR 2021
*
* This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/

defined('_JEXEC') or die;

try {

	$document   = & JFactory::getDocument();
	
	$styles= "<style>
		.header{
			height: 40px;
		}
		.container-title{
			font-size: x-large;
			color: white;
			margin: auto;
			padding: 10px 0 0 0;
		}
		
		.fieldtoken, .fielduge{
			margin-botton: 50px;
			border: 1px solid #ccc;
			padding: 10px;
			margin-bottom: 20px;
		}
		textarea.pagtesourojson{
			width: 98%;
			height: auto;
			min-height: 400px;
			margin-top:10px;
		}
		
	</style>";

	$document->addCustomTag($styles);

	$document->addCustomTag("<script src='https://cdnjs.cloudflare.com/ajax/libs/marked/2.0.1/marked.js'></script>");
	$document->addCustomTag("<script src='". JUri::base() ."components/com_pagtesouro/jquery.gh-readme.min.js'></script>");
	$document->addCustomTag("<script src='". JUri::base() ."components/com_pagtesouro/pagtesouro.js'></script>");
	

} catch (Exception $e) {
	print 'Error: ' . $e->getMessage();
}
?>

<ul class="nav nav-tabs" id="myTabTabs">
	<li class="active">
		<a href="#cadastro" data-toggle="tab">Cadastro</a>
	</li>
	<li class="">
		<a href="#sobre" data-toggle="tab">Sobre</a>
	</li>
	<li class="">
		<a href="#update" data-toggle="tab">Atualização</a>
	</li>
</ul>
<div class="tab-content" id="myTabContent">
	<div id="cadastro" class="tab-pane active">


		<fieldset>
			<legend>Cadastro de Tokens do PagTesouro</legend>

			<div class="uge"></div>

		</fieldset>


		<fieldset>
			<legend>Informações Cadastradas</legend>
			<button class="btn_copiar"></button>
			<button class="btn_download"></button>
			<button class="btn_load"></button>
			
			<input type="file" name="pagtesourojson" style="display:none" />
			
			<textarea class="pagtesourojson" disabled></textarea>
		</fieldset>

	</div>

	<div id="sobre" class="tab-pane"></div>	

	<div id="update" class="tab-pane"></div>	
</div>