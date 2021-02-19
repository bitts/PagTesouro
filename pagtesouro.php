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
include('pagtesouro.inc');


DEFINE("PARAMETROS", $parametros);
DEFINE("URLREQUEST", DEBUG ? "https://valpagtesouro.tesouro.gov.br" :"https://pagtesouro.tesouro.gov.br" );


class PagTesouro{
    //url de requisição <cnf doc>
    private static $urlRequest = URLREQUEST. "/api/gru/solicitacao-pagamento";
    //Parametros definidos pelo usuario no arquivo pagtesouro.inc
    private static $Parametros = PARAMETROS;

    //faz conexão com servidor do PagTesouro e envia a chave de autorização via cabeçalho/header da requisição, bem como define POST como metodo de envio
    public function gerar($params){
        $result = null;
        $dbg = new stdClass();
        try {            
            if(!function_exists('curl_version'))$dbg->error[] = 'Não esta instalado o curl do PHP em seu servidor.';
            $ch = curl_init();

            if (isset($params)) {    
                $params['modoNavegacao'] = "2";     
                $params['urlNotificacao'] = 'http://'. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                $params['urlRequest'] = self::$urlRequest;
                $fields = json_encode($params);
            
                $dbg->campos = json_decode($fields);

                $parametros = preg_replace('/\s\s+/', '', self::$Parametros);
                $parametros = json_decode($parametros, true);

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
                }else throw new Exception("Arquivo pagtesouro.inc em branco ou incompleto, talvez até mesmo mal formatado. Verifique arquivo pagtesouro.inc");
            }
            
            curl_setopt($ch, CURLOPT_URL, self::$urlRequest);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields); 
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json; charset=utf-8", "Authorization: ". $dbg->Authorization));
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                       
            $result = curl_exec($ch);
            if(!$result){ $dbg->error[] = "Falha de conexão com o Servidor do PagTesouro"; }
            
            $dbg->curl_result = $result;
            $dbg->curl_statuscode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        } catch (Exception $e) {
            $dbg->error[] = $e->getMessage();
        } finally {
            curl_close($ch);
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
