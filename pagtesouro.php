<?php

ini_set('display_errors', 1); //ini_set('display_errors', 'On');
ini_set('display_startup_erros', 1);
//error_reporting( E_ERROR | E_ERROR | E_NOTICE );
error_reporting( E_ALL );

DEFINE('INI_FILE', 'pagtesouro.ini');

if(file_exists(INI_FILE)){
    $ini = parse_ini_file(INI_FILE, true);

    DEFINE("DEBUG", (isset($ini['pagtesouro']['DEBUG']) && !empty($ini['pagtesouro']['DEBUG'])) ? $ini['pagtesouro']['DEBUG'] : false );
    DEFINE("AUTHORIZATION", (isset($ini['pagtesouro']['AUTHORIZATION']) && !empty($ini['pagtesouro']['AUTHORIZATION'])) ? $ini['pagtesouro']['AUTHORIZATION'] : false );
    DEFINE("URLREQUEST", (isset($ini['pagtesouro']['URLREQUEST']) && !empty($ini['pagtesouro']['URLREQUEST'])) ? $ini['pagtesouro']['URLREQUEST'] : "https://valpagtesouro.tesouro.gov.br" );
    
}else echo "Não foi possivel abrir arquivo de configuração do Sistema";

/**
 * This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
class PagTesouro{
    //url de requisição <cnf doc>
    private static $urlRequest = URLREQUEST. "/api/gru/solicitacao-pagamento";
    //Chave de autorização correspondente à OM
    private static $Authorization = AUTHORIZATION;
    /**
     * Retrieves the return to server
     *
     * @param   array  $params An object containing the module parameters
     *
     * @access public
     * 
     * Conforme Documentação: https://valpagtesouro.tesouro.gov.br/simulador/#/pages/api
     * Requisição: POST https://valpagtesouro.tesouro.gov.br/api/gru/solicitacao-pagamento
     * HEADER Authorization: Bearer <token_jwt>
     *  BODY {
     *      "codigoServico": "23",
     *      "referencia": "321",
     *      "competencia": "102020",
     *      "vencimento": "26102020",
     *      "cnpjCpf": "00000000000191",
     *      "nomeContribuinte": "Empresa XYZ",
     *      "valorPrincipal": "100",
     *      "valorDescontos": "0",
     *      "valorOutrasDeducoes": "0",
     *      "valorMulta": "0",
     *      "valorJuros": "0",
     *      "valorOutrosAcrescimos": "0",
     *      "modoNavegacao": "2",
     *      "urlNotificacao": "https://valpagtesouro.tesouro.gov.br/api/simulador/ug/notificacao"
     *     }
     *     Resposta: {
     *          "idPagamento": "69sODSIDZuhtfCUoKkfOwW",
     *          "dataCriacao": "2020-10-26T14:16:00Z",
     *          "proximaUrl": "https://valpagtesouro.tesouro.gov.br/#/pagamento?idSessao=66706694-fce3-4a56-8172-8b4ed12508a4",
     *          "situacao": {
     *            "codigo": "CRIADO"
     *          }
     *     }
     * 
     */   
    public function layout($params){
        return '
            <section class="resume-section" id="gerarGuia">
                <div class="resume-section-content">
                    <h2 class="mb-5">Gerar guia</h2>
                    
                    <div class="d-flex flex-column flex-md-row justify-content-between mb-5">
                        <div class="flex-grow-1">
                            <div class="row">
                                <div class="col-12">                         
                                    <form class="form-group" id="form_principal">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <!-- <input id="input_codigoServico" type="text" class="form-control" required> -->
                                                    <label for="input_codigoServico">Codigo do Servico</label>
                                                    <select id="input_codigoServico" class="form-control" required>
                                                        <!-- 
                                                        Relacionar os serviços que são utilizados pela OM
                                                        -->
                                                        <option value="0">Selecione</option>
                                                        <option value="701">701 - INDENIZAÇÕES</option>
                                                        <option value="701">701 - INDENIZAÇÕES</option>
                                                        <option value="701">701 - INDENIZAÇÕES</option>
                                                    </select>
                                                </div> 
                                            </div> 
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="input_referencia">Refer&ecirc;ncia</label>
                                                    <input id="input_referencia" type="text" class="form-control" placeholder="Preencher com o Mês (mm) e o Ano (yyyy) sem barras, exemplo \'012021\'">
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
                                                    <input id="input_vencimento" placeholder="DDMMAAAA da data de vencimento do pagamento, exemplo \'01012021\'" type="text" class="form-control" required>
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

                                        <div class="row" style="display: none">
                                            <div class="col-md-6">
                                                <input id="input_modoNavegacao" type="hidden" class="form-control" value="2">
                                                <label for="input_modoNavegacao">Modo de Navegacao</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input id="input_urlNotificacao" type="hidden" class="form-control" value="https://localhost">
                                                <label for="input_urlNotificacao">Url Notificacao</label>
                                            </div>
                                        </div>

                                        <div class="row" style="display: none">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input id="input_modoNavegacao" type="hidden" class="form-control" value="2">
                                                    <label for="input_modoNavegacao">Modo de Navegacao</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input id="input_urlNotificacao" type="hidden" class="form-control" value="https://localhost">
                                                    <label for="input_urlNotificacao">Url Notificacao</label>
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
                                <div id="dialog" title="ATENÇÃO!">
                                    <iframe class="iframe-epag" src="" scrolling="no"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>';

    }

    public function __construct(){
        
    }

    public function gerar($params){
        $result = null;
        try {            
            if(!function_exists('curl_version'))die('sem curl');
            $ch = curl_init();

            if (isset($params)) {    
                $params['modoNavegacao'] = "2";     
                $params['urlNotificacao'] = self::$urlRequest;
                if(DEBUG)print_r($params);
                $fields = http_build_query($params);
            }
            
            $headers = array('Authorization :'. self::$Authorization);
     
            curl_setopt($ch, CURLOPT_URL, self::$urlRequest);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields); 
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                       
            $result = curl_exec($ch);
            if(!$result){ echo "Connection Failure"; }
            else if(DEBUG)print_r($result);
        } catch (Exception $e) {
            echo 'O seguinte erro ocorreu ao fazer requisição aos servidores: ' . $e->getMessage();
        } finally {
            curl_close($ch);
        }
        echo $result;
    }
}


$obPagto = new PagTesouro();
$obPagto->gerar($_REQUEST);