<?php

$target = getcwd()."/pagtesouro.json";

$arry = $_REQUEST['obj'];

$Itens = [];
foreach($arry as $a){
	$obj = new stdClass();
	$obj->token = $a['token'];
	foreach($a['servicos'] as $s){
		$obj->servicos[] = (object)$s;
	}
 	$Itens[] = $obj;
}

if(file_put_contents($target, json_encode($Itens))){
	echo "Conteudo salvo com sucesso.";
}else{
	echo "Não foi possível salvar conteudo no arquivo pagtesouro.json.";
}
