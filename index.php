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

$parametros = preg_replace('/\s\s+/', '', $parametros);
$parametros = json_decode($parametros, true);

try{
    $options = "";
    if(!empty($parametros) && is_array($parametros)){
        foreach($parametros as $prm){
            foreach($prm['servicos'] as $srv){
                if(isset($srv['codigo']) && isset($srv['descricao']))
                    $options .= "<option value='{$srv['codigo']}'>{$srv['descricao']}</option>";
            }
        }
        $template = new Template('pagtesouro.html');
        $template->set('cod_servico', $options);

        echo $template->render();
    }else throw new Exception("Arquivo pagtesouro.inc em branco ou incompleto, talvez até mesmo mal formatado. Verifique arquivo pagtesouro.inc");
} catch (Exception $e) {
    echo 'O seguinte erro ocorreu no sistema: ' . $e->getMessage();
}