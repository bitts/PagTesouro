<?php

/*
# Title: Sisteminha mixuruca de integração ao PagTesouro
# Description: sistema para geração de GRU do PagTesouro
# Author: Marcelo Valvassori Bittencourt
# E-mail: marcelo.valvassori.bittencourt@gmail.com
# version: 2.1
# Modificação: 17 MAR 2021
# Modificação: 28 MAR 2021
# Modificação: 05 MAR 2022
*
* This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;

if($_REQUEST && isset($_REQUEST['datatopagtesouro'])){
    include_once('class.pagtesouro.php');
    $obPagto = new PagTesouro();

    $jinput = JFactory::getApplication()->input;
    $resultado = json_encode($jinput->get('datatopagtesouro', '{}', 'json' ));

    $obPagto->gerar($resultado);
}