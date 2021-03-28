<?php 
/*
# Title: Sisteminha mixuruca de integração ao PagTesouro
# Description: sistema para geração de GRU do PagTesouro
# Author: Marcelo Valvassori BITTENCOURT
# E-mail: marcelo.valvassori.bittencourt@gmail.com
# version: 2.1
# Modificação: 02 FEV 2021
# Modificação: 10 MAR 2021
# Modificação: 17 MAR 2021
# Modificação: 28 MAR 2021
*
* This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/

$target = getcwd()."/pagtesouro.json";

$arry = $_REQUEST['obj'];

$Itens = [];
foreach($arry as $a){
	$obj = new stdClass();
	
	$obj->uge_cod = $a['uge_cod'];
	$obj->uge_descricao = $a['uge_descricao'];

	foreach($a['tokens'] as $tk){
		$objT = new stdClass();
		$objT->token = $tk['token'];
		foreach($tk['servicos'] as $s){
			$objT->servicos[] = (object)$s;
		}		
		$obj->tokens[] = $objT;
	}
	
 	$Itens[] = $obj;
}

if(file_put_contents($target, json_encode($Itens))){
	echo "Conteudo salvo com sucesso.";
}else{
	echo "Não foi possível salvar conteudo no arquivo pagtesouro.json.";
}
