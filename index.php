<?php 
include('pagtesouro.php');

$ini = parse_ini_file('pagtesouro.ini', true);
$servicos = $ini['pagtesouro']['SERVICO'];
$options = "";
foreach($servicos as $sv){
    $sv = explode('-', $sv);
    if(!empty($sv[0]))$codigo = trim(preg_replace('/\s\s+/',' ', $sv[0]));
    if(!empty($sv[1]))$descricao = trim(preg_replace('/\s\s+/',' ', $sv[1]));
    if(isset($codigo) && isset($descricao))$options .= "<option value='{$codigo}'>{$descricao}</option>";
}
$template = new Template('pagtesouro.html');
$template->set('cod_servico', $options);

echo $template->render();
