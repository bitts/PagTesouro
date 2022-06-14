<?php
/*
# Title: Sisteminha mixuruca de integração ao PagTesouro
# Description: sistema para geração de GRU do PagTesouro
# Author: Marcelo Valvassori Bittencourt
# E-mail: marcelo.valvassori.bittencourt@gmail.com
# version: 2.1
# Modificação: 17 MAR 2021
# Modificação: 28 MAR 2021
# Modificação: 10 ABR 2021
# Modificação: 25 MAR 2022
*
* This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

class PagTesouro{
    //url de requisição <cnf doc>
    private static $urlRequest = "https://pagtesouro.tesouro.gov.br/api/gru/solicitacao-pagamento";
    private static $debug = true;
    private static $version = 2.1;
    private static $urlRegister = "https://mbitts.com/pagtesouro/webservice.php";
    
    public function __construct() {
        $this->registra_pagtesouro();
    }
	
    public function createLinktoConfig(){
        try{
            $target = "/components/com_pagtesouro/";
            if(!is_dir($target)){
                $target = "../components/com_pagtesouro/";
                $link = getcwd();
                $tar = explode('/',$link);
                $tar = implode('/',$tar);
                if(!is_dir("{$tar}/components/com_pagtesouro/")){
                    mkdir("{$tar}/components/com_pagtesouro/", 0777);
                }

                $target = $tar . "/components/com_pagtesouro/";
                $link = getcwd()."/administrator/components/com_pagtesouro/";

                if(is_dir($link)){
                    $diretorio = dir($link);
                    while( $arquivo = $diretorio->read() ){
                        if( !in_array($arquivo, Array('.','..') )){
                            if($arquivo === "pagtesouro.json" && !file_exists("{$target}{$arquivo}")){
                                link("{$link}{$arquivo}", "{$target}{$arquivo}");
                            }
                        }
                    }
                    $diretorio->close();
                }
            }
        } catch (Exception $e) {
            //echo $e->getMessage();
        }
    }
    
    public function set_dataDB($values = Array()){

        $retorno = new stdClass();

        try{

            $db = JFactory::getDbo();
            $query = $db->getQuery(true);           
            
            $columns = array(
                'codigoServico',
                'referencia',
                'competencia',
                'vencimento',
                'cnpjCpf',
                'nomeContribuinte',
                'valorPrincipal',
                'valorDescontos',
                'valorOutrasDeducoes',
                'valorMulta',
                'valorJuros',
                'valorOutrosAcrescimos'
            );
            
            $pagamento = new stdClass();
            $pagamento->id = null;
            if(is_array($values)){
                
                $pagamento->codigoServico = $values['codigoServico'];
                $pagamento->referencia = $values['referencia'];
                $pagamento->competencia = $values['competencia'];
                $pagamento->cnpjCpf = $values['cnpjCpf'];
                $pagamento->nomeContribuinte = $values['nomeContribuinte'];
                $pagamento->valorPrincipal = $values['valorPrincipal'];
                $pagamento->valorDescontos = $values['valorDescontos'];
                $pagamento->valorOutrasDeducoes = $values['valorOutrasDeducoes'];
                $pagamento->valorMulta = $values['valorMulta'];
                $pagamento->valorJuros = $values['valorJuros'];
                $pagamento->valorOutrosAcrescimos = $values['valorOutrosAcrescimos'];
                
            }else if(is_object($values)){

                $pagamento->codigoServico = $values->codigoServico;
                $pagamento->referencia = $values->referencia;
                $pagamento->competencia = $values->competencia;
                $pagamento->cnpjCpf = $values->cnpjCpf;
                $pagamento->nomeContribuinte = $values->nomeContribuinte;
                $pagamento->valorPrincipal = $values->valorPrincipal;
                $pagamento->valorDescontos = $values->valorDescontos;
                $pagamento->valorOutrasDeducoes = $values->valorOutrasDeducoes;
                $pagamento->valorMulta = $values->valorMulta;
                $pagamento->valorJuros = $values->valorJuros;
                $pagamento->valorOutrosAcrescimos = $values->valorOutrosAcrescimos;

            }
            $pagamento->vencimento = HtmlHelper::date('now', Text::_('DATE_FORMAT_JS1'));
            $result = JFactory::getDbo()->insertObject('#__pagtesouro_docs', $pagamento);

            if(self::$debug)$retorno->sql = $db->replacePrefix((string) $query);    

            if($result){
                $retorno->insertID = $db->insertid();
                $retorno->success = "Conteúdo salvo em Banco de Dados com sucesso.";
            }else{
                $retorno->error[] = "Não foi possível salvar conteúdo em Banco de Dados.";
            }
        }catch (Exception $e){
			$retorno->error = $e;
		}

        return $retorno;
    }
    
    public function get_dataTokensDB($id = 1){
        $retorno = new stdClass();
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        try{
            
            $query
                ->select(array('tokens'))
                ->from($db->quoteName('#__pagtesouro_tokens'))
                ->where($db->quoteName('id') ." = ". (int)$id);
                
            //echo $query->dump();
            
            $db->setQuery($query);
            $retorno->result = $db->loadResult();
            if($retorno->result){
                $retorno->success = "Dados retornados com sucesso.";
            }else{
                $retorno->error = "Não foi possível retornar dados salvos em Dados com sucesso..";
            }
            if(self::$debug)$retorno->sql = $db->replacePrefix((string) $query);
            
        }catch (Exception $e){
			$retorno->error = $e;
		}
        return $retorno;
    }  

    public function upd_dataDB($data){
        $resposta = json_encode($data->result);
        $retorno = stdClass();
        $db = JFactory::getDbo();
        $id = (int)$data->insertDB;
        $query = $db->getQuery(true);
        try{
            $fields = array(
                $db->quoteName('methodo') . ' = ' . $db->quote($data->methodo),
                $db->quoteName('idPagamento') . ' = ' . $db->quote($resposta->idPagamento),
                $db->quoteName('dataCriacao') . ' = '. $db->quote($resposta->dataCriacao),
                $db->quoteName('proximaUrl') . ' = ' . $db->quote($resposta->proximaUrl),
                $db->quoteName('situacao') . ' = ' . $db->quote($resposta->situacao),
                $db->quoteName('status_code') . ' = ' . $db->quote($data->statuscode),
            );
            
            $conditions = array(
                $db->quoteName('id') . ' = '. $id
            );    
            
            $query->update($db->quoteName('#__pagtesouro_docs'))->set($fields)->where($conditions);
                
            //$retorno->sql = $query->dump();
            $retorno->sql = $db->replacePrefix((string) $query);
            
            $db->setQuery($query);
            $result = $db->loadResult();
            if($result){
                $retorno->success = "Conteudo salvo com sucesso.";
            }else{
                $retorno->error = "Não foi possível salvar conteudo.";
            }
        
        }catch (Exception $e){
            $retorno->error = $e;
        }
        return $retorno;
    }

    public function get_dataFile(){
        $retorno = new stdClass();
        try{

            $url = explode('/',getcwd());
            unset($url[count($url)-1]);
            unset($url[count($url)-1]);
            $url = implode('/',$url);

            $file_prm = $url . "/administrator/components/com_pagtesouro/pagtesouro.json";

            if(!file_exists($file_prm))$file_prm = $url . "/components/com_pagtesouro/pagtesouro.json";
            if(!file_exists($file_prm))die("Arquivo {$file_prm} não encontrado.");


            $parametros = null;
            if(file_exists($file_prm)){
                $parametros = json_decode( file_get_contents($file_prm), true);
            }else $retorno->error[] = "Arquivo {$file_prm} não encontrado.";

            if(!empty($parametros) && is_array($parametros)){
                $enviar = new stdClass();
                foreach($parametros as $prm){
                    foreach($prm['tokens'] as $tkn){
                        foreach($tkn['servicos'] as $srv){
                            if($srv['codigo'] == $retorno->campos->codigoServico){
                                $enviar->codigoServico = $srv['codigo'];
                                $retorno->Authorization = $enviar->token = $tkn['token'];
                            }
                        }
                    }
                }
            }else $retorno->error[] = "Erro na leitura do dados cadastrados no sistema. Verifique cadastro do Token.";

        }catch (Exception $e){
			$retorno->error = $e;
		}
        return $retorno;
    }

    //faz conexão com servidor do PagTesouro e envia a chave de autorização via cabeçalho/header da requisição, bem como define POST como metodo de envio
    public function gerar($params){
        $result = null;
        $dbg = new stdClass();
        try {

            //aqui é incrementado os dados vindos do formulário e definido o Token de acordo com o Serviço escolhido
            if (isset($params)) {
                $params['modoNavegacao'] = "2";
                $params['urlNotificacao'] = 'http://'. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                $params['urlRequest'] = self::$urlRequest;
                
                //removendo as mascaras
                $params['competencia'] = preg_replace('/[^0-9]/', '', $params['competencia'] );
                $params['referencia'] = preg_replace('/[^0-9]/', '', $params['referencia'] );
                $params['vencimento'] = preg_replace('/[^0-9]/', '', $params['vencimento'] );
                $params['cnpjCpf'] = preg_replace('/[^0-9]/', '', $params['cnpjCpf'] );

                $fields = json_encode($params);

                $dbg = $this->get_dataTokensDB();
                
                $dbg->campos = json_decode($fields);

                $dbg->insertDB = $this->set_dataDB($params);                

            }else $dbg->error[] = "Problemas no recebimento dos dados do formulário.";
        } catch (Exception $e) {
            $dbg->error[] = $e->getMessage();
        }

        if(!empty($dbg)){
            if(function_exists('file_get_contents')){
                //Utilizando file_get_contents como metodo de requisição ao Pagtesouro
                try {
                    $arrContextOptions = array(
                        "ssl" => array(
                            "verify_peer" => false,
                            "verify_peer_name" => false
                        ),
                        "http" => array(
                            "ignore_errors" => true,
                            "method" => "POST",
                            "header" => array(
                                'Content-Type: application/json; charset=utf-8',
                                'Content-Length: ' . strlen($fields),
                                'Authorization: '. $dbg->Authorization,
                                'Connection: close'
                            ),
                            "Authorization" => $dbg->Authorization,
                            "content" => $fields
                        )
                    );
                    $context = stream_context_create($arrContextOptions);
                    $result = file_get_contents(self::$urlRequest, false, $context);

                    if($result){
                        $status_line = $http_response_header[0];
                        preg_match('{HTTP\/\S*\s(\d{3})}', $status_line, $match);

                        $dbg->methodo = 'file_get_contents';
                        $dbg->result = $result;
                        $dbg->statuscode = $match[1];
                    }
                } catch (Exception $e) {
                    $dbg->error[] = $e->getMessage();
                }
            }

            if((!isset($dbg->result) || empty($dbg->result)) && function_exists('fopen')){
                //Utilizando alternativa do fopen como metodo de requisição ao Pagtesouro
                $arrContextOptions = array(
                    "ssl" => array(
                        "verify_peer" => false,
                        "verify_peer_name" => false,
                    ),
                    "http" => array(
                        "method" => "POST",
                        "header" => array(
                            'Content-Type: application/json; charset=utf-8',
                            'Content-Length: ' . strlen($fields),
                            'Authorization: '. $dbg->Authorization,
                            'Connection: close',
                        ),"Authorization" => $dbg->Authorization,
                        "content" => $fields
                    )
                );

                $context = stream_context_create($arrContextOptions);
                $fp = fopen(self::$urlRequest, 'rb', false, $context);
                if ($fp){
                    $response = stream_get_contents($fp);
                    if ($response !== false){
                            $stream = stream_get_meta_data($fp);
                            preg_match('{HTTP\/\S*\s(\d{3})}', $stream['wrapper_data'][0], $match);
                            $dbg->result = $response;
                            $dbg->statuscode = $match[1];
                            $dbg->methodo = 'fopen';
                    }
                } 
            }

            if((!isset($dbg->result) || empty($dbg->result)) && function_exists('curl_init')){
                //Utilizando alternativa do curl como metodo de requisição ao Pagtesouro
                try{

                    $arrContextOptions = array(
                        "Content-Type: application/json; charset=utf-8",
                        "Authorization: ". $dbg->Authorization
                    );

                    $ch = curl_init();             
                    
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $arrContextOptions);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

                    $result = curl_exec($ch);
                    if(!$result)$dbg->error[] = "Falha de conexão com o Servidor do PagTesouro";
                    else{
                        $dbg->result = $result;
                        $dbg->statuscode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                        $dbg->methodo = 'curl';
                    }

                } catch (Exception $e) {
                    $dbg->error[] = $e->getMessage();
                } finally {
                    curl_close($ch);
                }
            }

            if( !isset($dbg->result) || empty($dbg->result)) $dbg->error[] = "Não foi possível estabelecer conexão com nenhum dos metodos conhecidos.";

            if(!self::$debug){
                unset($dbg->campos);
                unset($dbg->Authorization);
                unset($dbg->methodo);
            } 
            $dbg->resultado = json_decode($dbg->result);
        } else $dbg->error[] = "Problemas ao enviar dados para o PagTesouro";
        
        if(isset($dbg->insertDB) && !empty($dbg->insertDB)){
            $dbg->retorno = $this->upd_dataDB($dbg);
        }

        echo new JResponseJson($dbg);
    }

    public function registra_pagtesouro(){
        $result = null;
        $dbg = new stdClass();
        
        $urlRequest = "https://mbitts.com/pagtesouro/webservice.php";

        $params['host'] = $_SERVER['SERVER_NAME'];
        $params['version'] = self::$version;

        $fields = json_encode($params);

        if(function_exists('file_get_contents') && !isset($dbg->result) || $dbg->result->status == false || empty($dbg->result) ) {
            $URL = self::$urlRegister . "?host={$params['host']}&version={$params['version']}";
            
            $result = json_decode(file_get_contents($URL));
            
            //if(!$result->status)$result = get_remote_data($URL);
            //if(!$result->status)$result = readfile($URL);            //needs "Allow_url_include" enabled
            //if(!$result->status && $result->status == false)$result = include($URL);             //needs "Allow_url_include" enabled
            //if(!$result->status && $result->status == false)$result = file_get_contents($URL);   
            //if(!$result->status && $result->status == false)$result = stream_get_contents(fopen($URL, "rb")); 
            
            if( $result->status ){
                $status_line = $http_response_header[0];
                preg_match('{HTTP\/\S*\s(\d{3})}', $status_line, $match);

                $dbg->methodo = 'file_get_contents';
                $dbg->result = $result;
                $dbg->statuscode = $match[1];
            }
        }

        if(!self::$debug){
            unset($dbg->campos);
            unset($dbg->Authorization);
            unset($dbg->methodo);
        }else $dbg->resultado = json_decode($dbg->result);
        
    }
}


//classe de importação do layout do formulário e substituição de tag pelos serviços informador no arquivo INI
class Template{
    protected $_file;
    protected $_data = array();

    public function __construct($file = null){
        $this->_file = $file;
    }

    public function set($key, $value){
        $this->_data[$key] = $value;
        return $this;
    }

    public function extract($template){
        foreach($this->_data as $rplc){
            if (preg_match_all("/{{(.*?)}}/", $template, $m)) {
                //print_r($m);
                foreach ($m[1] as $i => $varname) {
                    $tag = $m[0][$i];
                    $valor = sprintf('%s', $rplc);
                    $template = str_replace($tag, $valor, $template);
                }
            }
        }
        return $template;
    }

    public function render(){
        ob_start();
        include($this->_file);
        $template = ob_get_contents();
        ob_get_clean();
        return $this->extract($template);
    }
}
