<?php
defined('_JEXEC') or die;


try {
	$document   = JFactory::getDocument();

	
	$link = '<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" />';
	$document->addCustomTag($link);
	$link = '<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />';
	$document->addCustomTag($link);
	
	$script="<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js'></script>";
	$document->addCustomTag($script);	
	
    $script="<script src='https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js'></script>";
	$document->addCustomTag($script);
	
	$script="<script src='components/com_pagtesouro/pagtesouro.js'></script>";
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
          .page-footer{
            background-color:#2bbbad;
          }
          .img-responsive {
            max-width: 100%;
            height: auto;
            object-fit: cover;
          }
          html {
            height: 100%;
          }
          body {
            display: flex;
            flex-direction: column;
            min-height: 100%;
            padding: 2em;
          }
          #content {
            flex: 1;
            min-height: 100%;
          }
          #footer {
            position: left; 
            clear: both; 
            color: #ffffff; 
            background-color: rgb(75, 75, 75); 
            text-align:center; 
            height: 50px;	 
            line-height: 50px; 
            font-size: 80%; 
          }
		  #form_principal input{
		  	height: 38px !important;
		  }
        </style>";

	$document->addCustomTag($styles);

	
} catch (Exception $e) {
	print 'Error: ' . $e->getMessage();
}
?>

<section class="resume-section" id="gerarGuia">
	<div class="resume-section-content">
		<h2 class="mb-5">Gerar guia do Pagtesouro</h2>
		<div class="d-flex flex-column flex-md-row justify-content-between">
			<div class="flex-grow-1">

				<div class="row">
					<div class="col-12">                         
							<form class="form-group" id="form_principal">

							  <div class="row">
								  <div class="col-md-6">
									  <div class="form-group">
										  <label for="input_codigoServico">Codigo do Servico</label>
										  <select id="input_codigoServico" class="form-control" required>
											{{cod_servico}}
										  </select>
									  </div> 
								  </div> 
								  <div class="col-md-6">
									  <div class="form-group">
										<label for="input_referencia">Refer&ecirc;ncia</label>
										<input id="input_referencia" type="text" class="form-control" placeholder="Preencher com o Mês (mm) e o Ano (yyyy) sem barras, exemplo '012021'">
									  </div> 
								  </div>
							  </div> 

							  <div class="row">
								  <div class="col-md-6">
									<label for="input_competencia">Compet&ecirc;ncia</label>
									<input id="input_competencia" placeholder="MMAAAA da competência do pagamento, exemplo 012021" type="text" class="form-control" required>

								  </div>
								  <div class="col-md-6">
									<div class="form-group">
									  <label for="input_vencimento">Vencimento</label>
									  <input id="input_vencimento" placeholder="DDMMAAAA da data de vencimento do pagamento, exemplo '01012021'" type="text" class="form-control" required>
									</div>                                            
								  </div>
							  </div>

							  <div class="row">
								  <div class="col-md-6">
									<div class="form-group">
									  <label for="input_cnpjCpf">CNPJ/CPF</label>
									  <input id="input_cnpjCpf" placeholder="CNPJ ou CPF referente ao pagamento, sem pontos, barras ou traços" type="text" class="form-control" required>
									</div>                                            
								  </div>
								  <div class="col-md-6">
									<div class="form-group">
									  <label for="input_nomeContribuinte">Nome do Contribuinte</label>
									  <input id="input_nomeContribuinte" type="text" placeholder="Nome do contribuinte. Pode ser o nome da empresa" class="form-control" required>
									</div>                                              
								  </div>
								</div>


								<div class="row">
								  <div class="col-md-6">
									<div class="form-group">
									  <label for="input_valorPrincipal">Valor Principal </label>
									  <input id="input_valorPrincipal" placeholder="0.00" type="text" class="form-control" required>
									</div>         
								  </div>
								  <div class="col-md-6">
									<div class="form-group">
									  <label for="input_valorDescontos">Valor dos Descontos</label>
									  <input id="input_valorDescontos" placeholder="0.00" type="text" class="form-control">
									</div>                                             
								  </div>
								</div>

								<div class="row">
								  <div class="col-md-6">
									<div class="form-group">
									  <label for="input_valorOutrasDeducoes">Valor de Outras Dedu&ccedil;&otilde;es</label>
									  <input id="input_valorOutrasDeducoes" placeholder="0.00" type="text" class="form-control">
									</div>
								  </div>
								  <div class="col-md-6">
									<div class="form-group">
									  <label for="input_valorMulta">Valor da Multa</label>
									  <input id="input_valorMulta" placeholder="0.00" type="text" class="form-control">
									</div>
								  </div>
								</div>

							  <div class="row">
								  <div class="col-md-6">
									<div class="form-group">
									  <label for="input_valorJuros">Valor dos Juros</label>
									<input id="input_valorJuros" placeholder="0.00" type="text" class="form-control">
									</div>                                              
								  </div>
								  <div class="col-md-6">
									<div class="form-group">
									  <label for="input_valorOutrosAcrescimos">Valor de Outros Acrescimos</label>
									  <input id="input_valorOutrosAcrescimos" placeholder="0.00" type="text" class="form-control">
									</div>                                             
								</div>
							  </div>

							  <div class="row">
								  <div class="col-md-12">
									<div class="form-group">
									  <button type="submit" class="btn btn-success btn-lg btn-block">GERAR GRU</button>
									</div>
								  </div>
							  </div>

							</form>
						</div>
						<div id="dialog" class="dialog_pagtesouro" title="PagTesouro" style="display:none;">
						  <iframe class="iframe-epag" src="" scrolling="no"></iframe>
						</div>
					</div>
				</div>

			</div>
		</div>
</section>

