<?php 
/*
# Title: Sisteminha mixuruca de integração ao PagTesouro
# Description: sistema para geração de GRU do PagTesouro
# Author: 2º Ten Marcelo Valvassori BITTENCOURT
# E-mail: marcelo.valvassori.bittencourt@gmail.com
# version: 1.0
# Modificação: 02 FEV 2021
*
* This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/
include('pagtesouro.php');

$ini = parse_ini_file('pagtesouro.ini', true);
$servicos = $ini['pagtesouro']['SERVICO'];
$options = "";
foreach($servicos as $sv){
    $sv = explode('-', $sv);
    if(!empty($sv[0]))$codigo = trim(preg_replace('/\s\s+/',' ', $sv[0]));
    if(!empty($sv[1]))$descricao = trim(preg_replace('/\s\s+/',' ', $sv[1]));
    if(isset($codigo) && isset($descricao))$options .= "<option value='{$codigo}'>{$descricao}</option>";
}
$template = new Template('pagtesouro.html');
$template->set('cod_servico', $options);

echo $template->render();
