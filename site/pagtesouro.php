<?php 
/*
# Title: Sisteminha mixuruca de integração ao PagTesouro
# Description: sistema para geração de GRU do PagTesouro
# Author: Marcelo Valvassori Bittencourt
# E-mail: marcelo.valvassori.bittencourt@gmail.com
# version: 2.1
# Modificação: 02 FEV 2021
# Modificação: 10 MAR 2021
# Modificação: 17 MAR 2021
# Modificação: 28 MAR 2021
# Modificação: 10 ABR 2021
*
* This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/

include('class.pagtesouro.php');

try{

    $parametros = "";
    $pg = new PagTesouro();
    $pg->createLinktoConfig();

    $file_prm = getcwd() . "/administrator/components/com_pagtesouro/pagtesouro.json";
    if(!file_exists($file_prm))$file_prm = getcwd() . "/components/com_pagtesouro/pagtesouro.json";

    if( file_exists($file_prm) ){
        $parametros = json_decode( file_get_contents($file_prm), true);
    }

    $options = "";
    if(!empty($parametros) && is_array($parametros)){
        foreach($parametros as $prm){
            
            $options .= "<optgroup label='{$prm['uge_descricao']}'>";
            foreach($prm['tokens'] as $tkn){

                foreach($tkn['servicos'] as $srv){
                    if(isset($srv['codigo']) && isset($srv['descricao']))
                        $options .= "<option value='{$srv['codigo']}'>{$srv['descricao']}</option>";
                }
                
            }
            $options .= "</optgroup>";
        }
        $template = new Template('template.php');
        $template->set('cod_servico', $options);

        echo $template->render();
    }
    
} catch (Exception $e) {
    //echo 'O seguinte erro ocorreu no sistema: ' . $e->getMessage();
}
