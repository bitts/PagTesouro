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
    private static $urlRequest = URLREQUEST. "api/gru/solicitacao-pagamento";
    //Chave de autorização correspondente à OM
    private static $Authorization = AUTHORIZATION;

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
                //$fields = http_build_query($params);
                $fields = json_encode($params);
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
            if(!$result){ echo "Connection Failure"; }
            else if(DEBUG){
                print_r($result);
                $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            }
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
