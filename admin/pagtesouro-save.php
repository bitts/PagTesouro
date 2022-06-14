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
# Modificação: 05 MAR 2022
# Modificação: 22 MAR 2022
*
* This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Response\JsonResponse;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;


//Salvar em arquivo (atencao as permissoes de escrito/leitura/gravacao)
$SV_FILE=false;
//Salvar em Banco de dados
$SV_DB=true;

$id = (int)1;

if( $SV_DB && isset($_REQUEST['select']) ){  //$db->quoteName('*') || $db->Quote('en-GB')

    $db = JFactory::getDbo();
	$query = $db->getQuery(true);
    $query
	    ->select(array('tokens'))
        ->from($db->quoteName('#__pagtesouro_tokens'))
        ->where($db->quoteName('id') ." = $id");
        
    //echo $query->dump();
    
    $db->setQuery($query);
    $result = $db->loadResult();
    if($result){
	    //$app->enqueueMessage("Conteudo retornado com sucesso.", "notice");
	    $result->success = "Dados salvos com sucesso.";
	}else{
		$result->error = "Não foi possível retornar dados salvos em Dados com sucesso..";
		//$app->enqueueMessage("Não foi possível salvar conteudo em Banco de Dados.", "error");
	}
	$result->sql = $db->replacePrefix((string) $query);
	
	echo new JResponseJson($result);
	
}


if( $SV_DB && isset($_REQUEST['update']) ){  

    $jinput = JFactory::getApplication()->input;
    $resultado = json_encode($jinput->get('obj', '{}', 'json' ));

    $date = JFactory::getDate();

/*
    $db = JFactory::getDbo();
	$query = $db->getQuery(true);
	
	$fields = array(
        $db->quoteName('tokens') . ' = ' . $db->quote($resultado),
        $db->quoteName('data_update') . ' = '. $date->toSql(), //date('Y-m-d H:i:s');
    );
    
    $conditions = array(
        "id = $id"
    );    
    
	$query->update($db->quoteName('#__pagtesouro_tokens'))->set($fields)->where($conditions);
        
    //$retorno->sql = $query->dump();
    $retorno->sql = $db->replacePrefix((string) $query);
    
    $db->setQuery($query);
    $result = $db->loadResult();
    if($result){
	    $retorno->success = "Conteudo salvo com sucesso.";
	}else{
		$retorno->error = "Não foi possível salvar conteudo.";
	}
	print_r($resultado);
	echo new JResponseJson($resultado);
	*/
	
	$updateNulls = true;

    $object = new stdClass();
    
    $object->id = $id;
    $object->tokens = $resultado;
    //$object->data_update = $date->toSql();


    // Update their details in the users table using id as the primary key.
    // You should provide forth parameter with value TRUE, if you would like to store the NULL values.
    $result = JFactory::getDbo()->updateObject('#__pagtesouro_tokens', $object, 'id', $updateNulls);
    
	echo new JResponseJson($resultado);
}


if( isset($_REQUEST['save']) ){

	if($SV_DB){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		
		$columns = array('tokens');

		$query
			->insert($db->quoteName('#__pagtesouro_tokens'))
			->columns($db->quoteName($columns))
			->values($db->quote($resultado));


		$db->setQuery($query);
		$result = $db->execute();
		if($result){
			$retorno->success = "Conteudo salvo em Banco de Dados com sucesso.";
		}else{
			$retorno->error = "Não foi possível salvar conteudo em Banco de Dados.";
		}
	}

	if($SV_FILE){
		try{
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
				$retorno->success = "Conteudo salvo com sucesso em arquivo ({$target}).";
			}else{
				$retorno->error = "Não foi possível salvar conteudo no arquivo {$target}.";
			}
		}catch (Exception $e){
			echo new JResponseJson($e);
		}
	}

	echo new JResponseJson($retorno);
}

