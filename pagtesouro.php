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
DEFINE("DEBUG", false );

if(DEBUG){
    ini_set('display_errors', 1); 
    ini_set('display_startup_erros', 1);
    error_reporting( E_ALL );
}

DEFINE("URLREQUEST", DEBUG ? "https://valpagtesouro.tesouro.gov.br" :"https://pagtesouro.tesouro.gov.br" );

class PagTesouro{
    //url de requisição <cnf doc>
    private static $urlRequest = URLREQUEST. "/api/gru/solicitacao-pagamento";

    //faz conexão com servidor do PagTesouro e envia a chave de autorização via cabeçalho/header da requisição, bem como define POST como metodo de envio
    public function gerar($params, $file_prm = 'pagtesouro.json'){
        $result = null;
        $dbg = new stdClass();
        
        try {
            
            //aqui é incrementado os dados vindos do formulário e definido o Token de acordo com o Serviço escolhido
            if (isset($params)) {
                $params['modoNavegacao'] = "2";     
                $params['urlNotificacao'] = 'http://'. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                $params['urlRequest'] = self::$urlRequest;
                $fields = json_encode($params);
            
                $dbg->campos = json_decode($fields);

                $parametros = null;
                if(file_exists($file_prm)){
                    $parametros = json_decode( file_get_contents($file_prm), true);
                }else throw new Exception("Arquivo {$file_prm} não encontrado.");

                if(!empty($parametros) && is_array($parametros)){
                    $enviar = new stdClass();
                    foreach($parametros as $prm){
                        foreach($prm['servicos'] as $srv){
                            if($srv['codigo'] == $dbg->campos->codigoServico){
                                $enviar->codigoServico = $srv['codigo'];
                                $enviar->token = $prm['token'];
                            }
                        }
                    }
                    $dbg->Authorization = $enviar->token;
                }else throw new Exception("Arquivo {$file_prm} em branco ou incompleto, talvez até mesmo mal formatado. Verifique arquivo.");
                
            }else throw new Exception("Problemas no recebimento dos dados do formulário.");
        } catch (Exception $e) {
            $dbg->error[] = $e->getMessage();
        }
        
        if(function_exists('file_get_contents')){
            //Utilizando file_get_contents como metodo de requisição ao Pagtesouro
            try {
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
                        ),
                        "Authorization" => $dbg->Authorization,
                        "content" => $fields
                    )
                );
                $context = stream_context_create($arrContextOptions);
                $result = file_get_contents(self::$urlRequest, false, $context);

                if(!$result)throw new Exception("Falha de conexão com o Servidor do PagTesouro");
                else{
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
                    ),
                    "Authorization" => $dbg->Authorization,
                    "content" => $fields
                )
            );
            
            $context = stream_context_create($arrContextOptions);
            $fp = fopen(self::$urlRequest, 'rb', false, $context);
            if (!$fp)throw new Exception("Falha de conexão com o Servidor do PagTesouro");            
            
            $response = stream_get_contents($fp);
            if ($response === false){
                throw new Exception("Falha de conexão com o Servidor do PagTesouro");
            }else{
                $stream = stream_get_meta_data($fp);
                preg_match('{HTTP\/\S*\s(\d{3})}', $stream['wrapper_data'][0], $match);
                $dbg->result = $response;
                $dbg->statuscode = $match[1];
                $dbg->methodo = 'fopen';
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
                
                curl_setopt($ch, CURLOPT_URL, self::$urlRequest);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields); 
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $arrContextOptions);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                        
                $result = curl_exec($ch);
                if(!$result)throw new Exception("Falha de conexão com o Servidor do PagTesouro");
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


if(isset($_REQUEST['datatopagtesouro'])){
    $obPagto = new PagTesouro();
    $obPagto->gerar($_REQUEST['datatopagtesouro']);
}
