<?php

/*
# Title: Sisteminha mixuruca de integração ao PagTesouro
# Description: sistema para geração de GRU do PagTesouro
# Author: Marcelo Valvassori Bittencourt
# E-mail: marcelo.valvassori.bittencourt@gmail.com
# version: 2.1.1
# Modificação: 17 MAR 2021
# Modificação: 28 MAR 2021
# Modificação: 12 ABR 2021
# Modificação: 05 MAR 2022
*
* This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/

defined('_JEXEC') or die;

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
    div.all{ padding: 25px; }
        .iframe-epag {
		margin: 0;
		padding: 0;
		border: 0;
		width: 100%;
		height: 98%;
    }

    #form_principal input, #form_principal select{
        height: 38px !important;
        width: 98%;
    }
    .table_datas, .table_valores, .table_contribuinte{
        text-align:center;
        border:0;
        width:100%;
        
    }
    .table_datas td, .table_valores td, .table_contribuinte td, .table_datas tr, .table_valores tr, .table_contribuinte tr{
        border: 0;
    }    
    .table_contribuinte input#input_nomeContribuinte{
        width:65%;
    }
    button[type='submit']{
        margin-top: 20px;
        height:40px
    }
    </style>";

	$document->addCustomTag($styles);

	
} catch (Exception $e) {
	print 'Error: ' . $e->getMessage();
}
?>

<section class="resume-section" id="gerarGuia">
    <form id="form_principal">

        <div>
            <label for="input_codigoServico">Codigo do Servico</label>
            <select id="input_codigoServico" required>
                {{cod_servico}}
            </select>
        </div> 

        <table class="table_datas">
            <thead>
                <tr style="text-align:center">
                    <td>Refer&ecirc;ncia</td>
                    <td>Compet&ecirc;ncia</td>
                    <td>Vencimento</td>
                </tr>
            </thead>
            </tbody>
                <tr>
                    <td>
                        <input id="input_referencia" type="text" >
                    </td>
                
                    <td>
                        <input id="input_competencia" type="text" required>
                    </td>
                
                    <td>
                        <input id="input_vencimento" type="text" required>
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="table_contribuinte">
            <thead>
                <tr style="text-align:center">
                    <td for="input_cnpjCpf">CNPJ/CPF - Nome do Contribuinte</td>
                </tr>
            </thead>
            </tbody>
                <tr>
                    <td>
                        <input id="input_cnpjCpf" type="text" required>
                        <input id="input_nomeContribuinte" type="text" placeholder="Nome do contribuinte. Pode ser o nome da empresa" required >
                    </td>
                </tr>
            </tbody>
        </table>

        <div style="text-align:center;">
            <label for="input_nomeContribuinte">Valor Principal</label>
            <input id="input_valorPrincipal" type="text" required>
        </div>

        <div style="text-align:center;">
            <table class="table_valores">
                <thead>
                    <tr style="text-align:center">
                        <td>Descontos</td>
                        <td>Outras Dedu&ccedil;&otilde;es</td>
                        <td>Multa</td>
                        <td>Juros</td>
                        <td>Outros Acrescimos</td>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <input id="input_valorDescontos" type="text">
                    </td>
                    <td>
                        <input id="input_valorOutrasDeducoes" type="text">
                    </td>
                    <td>
                        <input id="input_valorMulta" type="text">
                    </td>
                    <td>
                        <input id="input_valorJuros" type="text">
                    </td>
                    <td>
                        <input id="input_valorOutrosAcrescimos" type="text">
                    </td>   
                </tr>                                          
            </table>
        </div>

        <div>
            <button type="submit" class="btn btn-success btn-lg btn-block">GERAR GRU</button>
        </div>

    </form>
    
    <div id="dialog" class="dialog_pagtesouro" title="PagTesouro" style="display:none;">
        <iframe class="iframe-epag" src="" scrolling="no"></iframe>
    </div>
    
</section>

