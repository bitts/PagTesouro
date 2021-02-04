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

DEFINE('INI_FILE', 'pagtesouro.ini');

if(file_exists(INI_FILE)){
    $ini = parse_ini_file(INI_FILE, true);

    DEFINE("DEBUG", (isset($ini['pagtesouro']['DEBUG']) && !empty($ini['pagtesouro']['DEBUG'])) ? $ini['pagtesouro']['DEBUG'] : false );
    
    if(DEBUG){
        ini_set('display_errors', 1); //ini_set('display_errors', 'On');
        ini_set('display_startup_erros', 1);
        error_reporting( E_ALL );
    }
    //Se estiver no modo debug utiliza a chave de desenvolvimento
    DEFINE("AUTHORIZATION", (isset($ini['pagtesouro']['AUTHORIZATION']) && !empty($ini['pagtesouro']['AUTHORIZATION'])) ? $ini['pagtesouro']['AUTHORIZATION'] : 'Bearer eyJhbGciOiJSUzI1NiJ9.eyJzdWIiOiIxNjAwODYifQ.fY4bWesL85B_vFSOmRUyfrawte-SjSuqKcFQTfyfMQVFKyl6gfJKX63o_wElLkb3MHXl5xmQG9zlQasv5V561uq-R8uV6Gi35iXy36hk6wdc8LyLk-WgVD5TN4fyCCrZ5VH6tuayM7xmZ3fPyPdfJFknCCao48E2skbptEHS-8VUjFKAUObd_oFblDsyc8jC0cYPfX7p8IbO1kdeibqBbu-wpnGczsmoWftMkmS82Y-U9EqcRcY5IN10IcVFg_IJ7Mo5SeH3snfrcOMVP-DMjUH0MefmHUqN0eMGlBbeZK1rHxvRXfB7Ual9PORzyhuTO5kzIYK90EW1sT2qNl4TXA' );
    //se estiver no modo debug utiliza a url de desenvolvimento
    DEFINE("URLREQUEST", (isset($ini['pagtesouro']['DEBUG']) && !empty($ini['pagtesouro']['DEBUG']) && $ini['pagtesouro']['DEBUG']) ? "https://valpagtesouro.tesouro.gov.br" :"https://pagtesouro.tesouro.gov.br" );

    DEFINE("URLRETORNO", (isset($ini['pagtesouro']['URLRETORNO']) && !empty($ini['pagtesouro']['URLRETORNO']) && $ini['pagtesouro']['URLRETORNO']) ? $ini['pagtesouro']['URLRETORNO'] :"http://localhost/" );
    
}else echo "Não foi possivel abrir arquivo de configuração do Sistema";

class PagTesouro{
    //url de requisição <cnf doc>
    private static $urlRequest = URLREQUEST. "/api/gru/solicitacao-pagamento";
    //Chave de autorização correspondente à OM
    private static $Authorization = AUTHORIZATION;

    //faz conexão com servidor do PagTesouro e envia a chave de autorização via cabeçalho/header da requisição, bem como define POST como metodo de envio
    public function gerar($params){
        $result = null;
        $dbg = new stdClass();
        try {            
            if(!function_exists('curl_version'))$dbg->error[] = 'Não esta instalado o curl do PHP em seu servidor.';
            $ch = curl_init();

            if (isset($params)) {    
                $params['modoNavegacao'] = "2";     
                $params['urlNotificacao'] = URLRETORNO;
                $params['urlRequest'] = self::$urlRequest;
                $fields = json_encode($params);
                if(DEBUG){
                    $dbg->campos = json_decode($fields);
                    $dbg->Authorization = self::$Authorization;
                }
            }
            
            curl_setopt($ch, CURLOPT_URL, self::$urlRequest);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields); 
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json; charset=utf-8", "Authorization: ". self::$Authorization));
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                       
            $result = curl_exec($ch);
            if(!$result){ $dbg->error[] = "Falha de conexão com o Servidor do PagTesouro"; }
            
            $dbg->curl_result = $result;
            $dbg->curl_statuscode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        } catch (Exception $e) {
            $dbg->error[] = 'O seguinte erro ocorreu ao fazer requisição aos servidores: ' . $e->getMessage();
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
