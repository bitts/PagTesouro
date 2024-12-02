<?php

/*
# Title: Sisteminha mixuruca de integração ao PagTesouro
# Description: sistema para geração de GRU do PagTesouro
# Author: Marcelo Valvassori Bittencourt
# E-mail: marcelo.valvassori.bittencourt@gmail.com
# version: 2.1.1.1
# Modificação: 17 MAR 2021
# Modificação: 28 MAR 2021
# Modificação: 12 ABR 2021
# Modificação: 05 MAR 2022
# Modificação: 01 DEZ 2024 (Modificações retiradas do Site da Prefeitura Militar da Zona Sul (possível criador francisco.justino@eb.mil.br)
*
* This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;


try {
    $document   = JFactory::getDocument();
    
    $link = '<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />';
    $document->addCustomTag($link);
    
    $script="<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js'></script>";
    $document->addCustomTag($script);	
    
    $script="<script src='https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js'></script>";
    $document->addCustomTag($script);

    $document->addCustomTag("<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js'></script>");
    $document->addCustomTag($script);
    
    $document->addCustomTag("<script src='". JUri::base() ."components/com_pagtesouro/template.js'></script>");
    $document->addCustomTag($script);
    
    
    $styles= "<style>
    .input-row {
        width: 100%;        
        font-size: 1.05rem;
        font-family: Calibre;
        border: 1px solid #ccc;
        padding: 10px;
        box-sizing: content-box;
        border-radius: 6px;
        margin-top: 15px;  
        min-width: 100px;     
    }
    
    .title-row {
        position: absolute;
  	    color: Goldenrod;  
        top: 20px; 
        left: 20px;
        font-size: 14px;     
        transition: 0.3s; 
    }
    .select-user {
        flex: 1;
        padding: 8px;
        margin-top: 5px;
        margin-bottom: 15px;
        font-size: 20px;
        font-weight: 400;
        margin-right: 10px;
        border: 1px solid blue;
        border-radius: 6px;
        width: 100%;
      }
    .input-container {
        float:left;
        position: relative; /* Contêiner com posição relativa para posicionar a etiqueta */
        flex: 1;/**/   
        margin-right: 5px;
        left: 20px;
    }
       
    input.input-row:focus,
    input.input-row:valid {
        color: rgb(6, 3, 11);
        border: 1px solid rgb(127, 157, 255);
    }
    
    input.input-row:focus ~ label.title-row,
    input.input-row:valid ~ label.title-row {
        position: absolute;
        top: 0;  /* Ajuste a posição superior conforme necessário */
        left: 5%;
        transform: translateY(-5%);
        background: white; /* Opcional: cor de fundo para a etiqueta */
        padding: 0 5px; /* Opcional: padding para o texto da etiqueta */
        font-size: 1rem; /* Opcional: tamanho da fonte da etiqueta */
        opacity: 1; 
        color: brue ; /*var(--third-bg-color);  Cor da etiqueta */
    }
     
    div.all{ padding: 25px; }
    .iframe-epag {
  		margin: 0;
  		padding: 0;
  		border: 0;
  		width: 100%; 
  		height: 98%;
    }

    #form_principal  #form_principal select{
      height: 38px !important;
      width: 98%;
    }
    button[type='submit']{
      width:33%;
      margin-top: 20px;
      height:30px
    }
    </style>";

    $document->addCustomTag($styles);

    
} catch (Exception $e) {
    print 'Error: ' . $e->getMessage();
}
?>

<section class="resume-section" id="gerarGuia">

  <form id="form_principal">
    <div class="row">
      <div class="input-container">
        
        <div class="row">
          <div class="input-container">
              <label for="input_codigoServico">Codigo do Servico</label>
              <select id="input_codigoServico" required>
                {{cod_servico}}
              </select>
          </div>
        </div>

        <div class="row">
          <div class="input-container">
            <input id="input_cnpjCpf" type="text" class='input-row' required />
            <label class='title-row'>CNPJ/CPF</label>
          </div>
          <div class="input-container">
            <input id="input_nomeContribuinte" type="text" class='input-row' size="48px" required />
            <label class='title-row'>Nome do Contribuinte</label>
          </div>
        </div>
        
        <div class="row">
          <div class="input-container">
            <input id="input_referencia" type="text" class='input-row' required />
            <label class='title-row'>Refer&ecirc;ncia</label>
          </div>
          <div class="input-container">
            <input id="input_competencia" type="text" class='input-row' required />
            <label class='title-row'>Compet&ecirc;ncia</label>
          </div>
          <div class="input-container">
            <input id="input_vencimento" type="text" class='input-row' required />
            <label class='title-row'>Vencimento</label>
          </div>
          <div class="input-container">
              <input id="input_valorPrincipal" type="text" class='input-row' required />
              <label class='title-row'>Valor</label>
          </div>
        </div>
        
        <div class="row">
          <div class="input-container">
            <input id="input_valorDescontos" type="text" class='input-row' />
            <label class='title-row'>Descontos</label>
          </div>
          <div class="input-container">
            <input id="input_valorOutrasDeducoes" type="text" class='input-row' />
            <label class='title-row'>Dedu&ccedil;&otilde;es</label>
          </div>
          <div class="input-container">
            <input id="input_valorMulta" type="text" class='input-row' />
            <label class='title-row'>Multa</label>
          </div>
          <div class="input-container">
            <input id="input_valorJuros" type="text" class='input-row' />
            <label class='title-row'>Juros</label>
          </div>
          <div class="input-container">
            <input id="input_valorOutrosAcrescimos" type="text" class='input-row' />
            <label class='title-row'>Acrescimos</label>
          </div>
        </div>
        
        <div>
            <button type="submit" class="btn btn-success btn-lg btn-block mt-5">GERAR GRU</button>
        </div>
        
      </div>
    </div>
  </form>

  <div id="dialog" class="dialog_pagtesouro" title="PagTesouro" style="display:none;">
    <iframe class="iframe-epag" src="/" scrolling="no"></iframe>
  </div>
    
</section>
