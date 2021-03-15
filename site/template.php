<?php
defined('_JEXEC') or die;


try {
	$document   = JFactory::getDocument();

	
	//$link = '<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" />';
	//$document->addCustomTag($link);
	$link = '<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />';
	$document->addCustomTag($link);
	
	$script="<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js'></script>";
	$document->addCustomTag($script);	
	
    	$script="<script src='https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js'></script>";
	$document->addCustomTag($script);
	
	$script="<script src='". JUri::base() . "/components/com_pagtesouro/pagtesouro.js'></script>";
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
		width: 100%;
	  }
        </style>";

	$document->addCustomTag($styles);

	
} catch (Exception $e) {
	print 'Error: ' . $e->getMessage();
}
?>

<section class="resume-section" id="gerarGuia">
    <div>	    
        <form id="form_principal">

            <div>
                <div>
                    <label for="input_codigoServico">Codigo do Servico</label>
                    <select id="input_codigoServico" required>
                        {{cod_servico}}
                    </select>
                </div> 
                <div>
                    <label for="input_referencia">Refer&ecirc;ncia</label>
                    <input id="input_referencia" type="text" placeholder="Preencher com o Mês (mm) e o Ano (yyyy) sem barras, exemplo '012021'">
                </div>
            </div> 

            <div>
                <div>
                    <label for="input_competencia">Compet&ecirc;ncia</label>
                    <input id="input_competencia" placeholder="MMAAAA da competência do pagamento, exemplo 012021" type="text" required>
                </div>
                <div>
                    <label for="input_vencimento">Vencimento</label>
                    <input id="input_vencimento" placeholder="DDMMAAAA da data de vencimento do pagamento, exemplo '01012021'" type="text" required>
                </div>
            </div>

            <div>
                <div>
                    <label for="input_cnpjCpf">CNPJ/CPF</label>
                    <input id="input_cnpjCpf" placeholder="CNPJ ou CPF referente ao pagamento, sem pontos, barras ou traços" type="text" required>
                </div>
                <div>
                    <label for="input_nomeContribuinte">Nome do Contribuinte</label>
                    <input id="input_nomeContribuinte" type="text" placeholder="Nome do contribuinte. Pode ser o nome da empresa" required>
                </div>
            </div>

            <div>
                <div>
                    <label for="input_valorPrincipal">Valor Principal </label>
                    <input id="input_valorPrincipal" placeholder="0.00" type="text" required>
                </div>
                <div>
                    <label for="input_valorDescontos">Valor dos Descontos</label>
                    <input id="input_valorDescontos" placeholder="0.00" type="text">
                </div>
            </div>

            <div>
                <div>
                    <label for="input_valorOutrasDeducoes">Valor de Outras Dedu&ccedil;&otilde;es</label>
                    <input id="input_valorOutrasDeducoes" placeholder="0.00" type="text">
                </div>
                <div>
                    <label for="input_valorMulta">Valor da Multa</label>
                    <input id="input_valorMulta" placeholder="0.00" type="text">
                </div>
            </div>

            <div>
                <div>
                    <label for="input_valorJuros">Valor dos Juros</label>
                    <input id="input_valorJuros" placeholder="0.00" type="text">
                </div>
                <div>
                    <label for="input_valorOutrosAcrescimos">Valor de Outros Acrescimos</label>
                    <input id="input_valorOutrosAcrescimos" placeholder="0.00" type="text">
                </div>                                             
            </div>

            <div>
                <div>
                    <button type="submit" class="btn btn-success btn-lg btn-block">GERAR GRU</button>
                </div>
            </div>

        </form>
    </div>
    
    <div id="dialog" class="dialog_pagtesouro" title="PagTesouro" style="display:none;">
        <iframe class="iframe-epag" src="" scrolling="no"></iframe>
    </div>
    
</section>

