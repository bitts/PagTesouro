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
*
* This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/

class PagTesouro{
    //url de requisição <cnf doc>
    private static $urlRequest = "https://pagtesouro.tesouro.gov.br/api/gru/solicitacao-pagamento";
    private static $debug = false;
    
    public function __construct() {

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
                                                @link("{$link}{$arquivo}", "{$target}{$arquivo}");
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
    
    //faz conexão com servidor do PagTesouro e envia a chave de autorização via cabeçalho/header da requisição, bem como define POST como metodo de envio
    public function gerar($params){
        $result = null;
        $dbg = new stdClass();

        $url = explode('/',getcwd());
		unset($url[count($url)-1]);
		unset($url[count($url)-1]);
		$url = implode('/',$url);

        $file_prm = $url . "/administrator/components/com_pagtesouro/pagtesouro.json";

        if(!file_exists($file_prm))$file_prm = $url . "/components/com_pagtesouro/pagtesouro.json";
        if(!file_exists($file_prm))die("Arquivo {$file_prm} não encontrado.");
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

                $dbg->campos = json_decode($fields);

                $parametros = null;
                if(file_exists($file_prm)){
                    $parametros = json_decode( file_get_contents($file_prm), true);
                }else $dbg->error[] = "Arquivo {$file_prm} não encontrado.";

                if(!empty($parametros) && is_array($parametros)){
                    $enviar = new stdClass();
                    foreach($parametros as $prm){
                        foreach($prm['tokens'] as $tkn){
                            foreach($tkn['servicos'] as $srv){
                                if($srv['codigo'] == $dbg->campos->codigoServico){
                                    $enviar->codigoServico = $srv['codigo'];
                                    $dbg->Authorization = $enviar->token = $tkn['token'];
                                }
                            }
                        }
                    }
                }else $dbg->error[] = "Erro na leitura do dados cadastrados no sistema. Verifique cadastro do Token.";

            }else $dbg->error[] = "Problemas no recebimento dos dados do formulário.";
        } catch (Exception $e) {
            $dbg->error[] = $e->getMessage();
        }

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
                );$context = stream_context_create($arrContextOptions);
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
        }else $dbg->resultado = json_decode($dbg->result);
        
        echo json_encode($dbg);
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
