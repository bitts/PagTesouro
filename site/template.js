/*
# Title: Sisteminha mixuruca de integração ao PagTesouro
# Description: sistema para geração de GRU do PagTesouro
# Author: Marcelo Valvassori Bittencourt
# E-mail: marcelo.valvassori.bittencourt@gmail.com
# version: 2.1.1
# Modificação: 02 FEV 2021
# Modificação: 10 MAR 2021
# Modificação: 17 MAR 2021
# Modificação: 28 MAR 2021
# Modificação: 12 ABR 2021
# Modificação: 30 MAR 2022
*
* This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/

/**
 * @package     Joomla.PagTesouro
 * @subpackage  PagTesouro
 * @copyright   Copyright (C) 2021 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @since       1.0
 */

jQuery(function($){

    'use strict';   

    var jPagTesouro = {
        debug : false,
        iframe : false,
        init : function(url){
            jPagTesouro.fm_form();
            jPagTesouro.vl_form();                
        },
        fm_form : function(){
            $('#input_valorPrincipal, #input_valorDescontos, #input_valorOutrasDeducoes, #input_valorMulta, #input_valorOutrosAcrescimos, #input_valorJuros')
                .css({'width':'100px','text-align':'center','margin':'0 5px 0 5px'})
                .maskMoney({ decimal: '.', thousands: '', precision: 2 });

            $('#input_competencia').css({'width':'150px','text-align':'center'}).mask('00/0000');
            $('#input_vencimento').css({'width':'150px','text-align':'center'}).mask('00/00/0000');
            $('#input_referencia').mask('9#');

            $('#input_cnpjCpf').css({'width':'150px','text-align':'center'}).mask('000.000.000-00', {
                onKeyPress : function(cpfcnpj, e, field, options) {
                  const masks = ['000.000.000-000', '00.000.000/0000-00'];
                  const mask = (cpfcnpj.length > 14) ? masks[1] : masks[0];
                  $('#input_cnpjCpf').mask(mask, options);
                }
            });           
            
        },
        vl_form : function(){
            $('#form_principal').submit(function(e){
                e.preventDefault();
                $('.menssage').remove();
                jPagTesouro.ac_form();
            });
        },
        ac_form : function(){
            try{
                $.ajax({
                    url: 'index.php?option=com_pagtesouro&format=json&get=true&save=true',
                    //url: 'components/com_pagtesouro/call.php',
                    type: 'post',
                    data: { 
                        datatopagtesouro : { 
                            'codigoServico': $('#input_codigoServico').val(),
                            'referencia': $('#input_referencia').val(),
                            'competencia': $('#input_competencia').val(),
                            'vencimento': $('#input_vencimento').val(),
                            'cnpjCpf': $('#input_cnpjCpf').val(),
                            'nomeContribuinte': $('#input_nomeContribuinte').val(),
                            'valorPrincipal': $('#input_valorPrincipal').val(),
                            'valorDescontos': $('#input_valorDescontos').val(),
                            'valorOutrasDeducoes': $('#input_valorOutrasDeducoes').val(),
                            'valorMulta': $('#input_valorMulta').val(),
                            'valorJuros': $('#input_valorJuros').val(),
                            'valorOutrosAcrescimos': $('#input_valorOutrosAcrescimos').val(),
                            'modoNavegacao': $('#input_modoNavegacao').val()
                            //, 'urlRetorno' : 
                        }
                    },            
                    success: function(_resposta){
                        if(_resposta){
                            var _rst = JSON.parse(_resposta);
                            if(jPagTesouro.debug)console.log(_rst);

                            if(_rst.error){
                                $.map(_rst.error, function(value) {
                                    $('#gerarGuia').prepend( $('<div />').addClass('menssage alert alert-danger').text(value) );
                                });
                                setTimeout(function(){ $('.menssage').remove() },5000);
                            }

                            if(_rst.result){
                                var result = (typeof _rst.result == 'object')?_rst.result:JSON.parse(_rst.result);
                                if(result && result.length){
                                    $.map(result, function(obj){
                                        $('#gerarGuia').prepend( $('<div />').addClass('menssage alert alert-danger').text(obj.descricao) );
                                    });
                                    $('html, body').animate({
                                        scrollTop: $('#page-top').offset().top
                                    }, 1000);
                                    setTimeout(function(){ $('.menssage').remove() },10000);
                                }
                                if(result.proximaUrl) {
                                    if(jPagTesouro.iframe){
                                        $( '.iframe-epag' ).attr('src',result.proximaUrl);
                                        setTimeout(function(){ 
                                            $( '.dialog_pagtesouro' ).show().dialog({width: 800,height: 800}); 
                                        },1000);
                                    } else {
                                        window.open(result.proximaUrl, "_blank");
                                    }
                                }
                            }
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        if (jqXHR.status = 400){
                            resposta = jQuery.parseJSON(jqXHR.responseText);
                            var toastHTML = '<span><br><h7>ERROR: ' + resposta[0].codigo + '</h7><hr>' + resposta[0].descricao + '</span>';
                            if(jPagTesouro.debug)console.log(toastHTML);                    
                        }
                    }     
                });
            }catch (e) {
                if(jPagTesouro.debug)console.log(e)
            }
        }

    };

    jPagTesouro.init();  

});