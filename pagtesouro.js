/*
# Title: Sisteminha mixuruca de integração ao PagTesouro
# Description: sistema para geração de GRU do PagTesouro
# Author: Marcelo Valvassori BITTENCOURT
# E-mail: marcelo.valvassori.bittencourt@gmail.com
# version: 2.1.1
# Modificação: 28 MAR 2021
# Modificação: 12 ABR 2021
*/
/**
 * 
 * @package     Joomla.PagTesouro
 * @subpackage  PagTesouro
 * @copyright   Copyright (C) 2021 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @since       1.0
 */

//jQuery(document).ready(function($){
jQuery(function($){
  
    'use strict';   
    
    var options = {
        owner: 'bitts',
        repo: 'pagtesouro',
        path: 'README.md'
    };
    $('#sobre').readme(options);

    $.get('https://api.github.com/repos/bitts/pagtesouro', function (response) {

        var url_download = 'https://github.com/bitts/PagTesouro/archive/refs/heads/main.zip';
        var git_update = new Date(response.pushed_at);
        var git_description = response.description;
        var git_url_user = response.owner.html_url;

        var current_date = new Date();

        var difference = Math.abs(current_date-git_update);
        var git_days_lastupdate = parseFloat(difference/(1000 * 3600 * 24)).toFixed(0);

        $('#update').append(
            $('<h2 />').css({'text-align':'center'}).append(
                git_description
            ),
            $('<p />').append(
                'Arquivo para Download : ',
                $('<a />',{'href': url_download, 'target':'_blank' }).text(url_download)
            ),
            $('<p />').append(
                'Data da última atualização do Sistema : ',                
                git_update.getDate()+ '/' + (git_update.getMonth()+1) + '/'+ git_update.getFullYear(),
                ' ('+ git_days_lastupdate + ' dias atrás)'
            ),
            $('<h3 />').append(
                'Atenção: em caso de erro ao tentar atualizar o componente, remova as pastas /administrator/components/com_patesouro e /components/com_pagtesouro e tente novamente.'
            )
        );
    });

    function msg(text, type){
        let id = parseInt(Math.random() * 100);
        let tipo = (!type || type === '')?'alert-danger':'alert-'+type;
        $('section#content')
            .prepend( 
                $('<div />').addClass('mensagem alert '+ tipo +' msg_' + id).text(text).show(function(){
                    setTimeout(function(){ $('.msg_'+ id ).remove() },5000);
                }) 
            );

        $('.subhead').append( 
            $('<div />').css({'margin': '0 5% 10px 5%'}).addClass('mensagem alert '+ tipo +' msg_' + id).text(text)
        );
    }

    $('header > div.container-title').text('PagTesouro Administração');
       
    var populate_pagtesouro = function(obj){ 
        if(obj){
            
            $('textarea.pagtesourojson').val('');
            $('.token fieldset').remove();

            if(typeof obj !== 'object')obj = JSON.parse(obj);
            
            let txt = JSON.stringify(obj, undefined, 4);
            $('textarea.pagtesourojson').val(txt);


            obj.map(function(item){
                var _html = $('<fieldset>').addClass('fielduge')
                _html.append(
                    $('<p />').append(
                        $('<input />',{'type':'text', 'placeholder':'Código UGE', 'name': 'uge_cod'}).css({'width':'10%'}).addClass('form-control').css({'margin-right':'5px'}).val(item.uge_cod),
                        $('<input />',{'type':'text', 'placeholder':'Nome da OM ', 'name': 'uge_descricao'}).css({'width':'78%'}).addClass('form-control').val(item.uge_descricao)
                    ),
                    $('<p />').append(
                        $('<button />')
                            .addClass('btn btn-small button-new btn-success add_token')
                            .append( 
                                $('<span />').addClass('icon-new icon-white'),
                                'Adicionar Token'
                            )
                            .css({'margin-bottom':'5px'})
                            .on('click', function(){
                                $(this).after(
                                    $('<div />').addClass('token').append(
                                        $('<fieldset>').addClass('fieldtoken').append(
                                            $('<p />').append(
                                                $('<input />',{'type':'text', 'placeholder':'Informe aqui o Token', 'name': 'token'}).css({'width':'98%'}).addClass('form-control')
                                            ),
                                            $('<table />').addClass('servicos').css({'width':'100%'}).append(
                                                $('<tr />').append(
                                                    $('<td />', {'colspan':'3'}).append(
                                                        $('<button />')
                                                            .addClass('btn btn-small button-new btn-success')
                                                            .append( 
                                                                $('<span />').addClass('icon-new icon-white'),
                                                                'Adicionar Serviço'
                                                            )	
                                                            .click(function(){
                                                                $(this).closest('table.servicos').append(
                                                                    $('<tr />').addClass('item_servico').append(
                                                                        $('<td />').css({'width':'125px'}).append(
                                                                            $('<input />',{'type':'text', 'placeholder':'Código do Serviço Cadastrado', 'name': 'cod_servico'}).css({'width':'auto'}).addClass('cod_servico form-control')
                                                                        ),
                                                                        $('<td />').append(
                                                                            $('<input />',{'type':'text', 'placeholder':'Descrição do Serviço Cadastrado - forneça uma descrição de forma amigável para uma melhor compreensão', 'name': 'servico'}).css({'width':'98%'}).addClass('servico form-control')
                                                                        ),
                                                                        $('<td />').css({'width':'60px'}).append(
                                                                            $('<button />')
                                                                                .css({
                                                                                    'padding': '5px 2px 5px 5px',
                                                                                    'margin-bottom': '10px',
                                                                                    'margin-left': '5px'
                                                                                })
                                                                                .append(
                                                                                    $('<span />').addClass('icon-trash')
                                                                                )
                                                                                .click(function(){
                                                                                    $(this).closest('tr').remove();
                                                                                })
                                                                        )
                                                                    )
                                                                )
                                                            })
                                                    )
                                                )
                                            ),
                                            $('<button />')
                                                .addClass('btn btn-small button-trash')
                                                .css({'float':'right'})
                                                .on('click',function(){
                                                    console.log('ok')
                                                    $(this).closest('.fieldtoken').remove();
                                                })
                                                .append(
                                                    $('<span />').addClass('icon-trash'),
                                                    'Remover'
                                                )
                                        )
                                    )
                                )
                            })
                    )
                );
                
                item.tokens.map(function(it){
                    var tb_token = $('<fieldset>').addClass('fieldtoken').append(
                            $('<p />').append(
                                $('<input />',{'type':'text', 'placeholder':'Informe aqui o Token', 'name': 'token'}).css({'width':'98%'}).addClass('form-control').val(it.token)
                            )
                        );

                    var tb_srv = $('<table />').addClass('servicos').css({'width':'100%'});
                    tb_srv.append(
                        $('<tr />').append(
                            $('<td />', {'colspan':'3'}).append(
                                $('<button />')
                                    .addClass('btn btn-small button-new btn-success')
                                    .append( 
                                        $('<span />').addClass('icon-new icon-white'),
                                        'Adicionar Serviço'
                                    )
                                    .click(function(){
                                        $(this).closest('table').append(
                                            $('<tr />').addClass('item_servico').append(
                                                $('<td />').css({'width':'125px'}).append(
                                                    $('<input />',{'type':'text', 'placeholder':'Código', 'name': 'cod_servico'}).css({'width':'auto'}).addClass('cod_servico form-control')
                                                ),
                                                $('<td />').append(
                                                    $('<input />',{'type':'text', 'placeholder':'Descrição do Serviço', 'name': 'servico'}).css({'width':'98%'}).addClass('servico form-control')
                                                ),
                                                $('<td />').css({'width':'60px'}).append(
                                                    $('<button />')
                                                    .css({
                                                        'padding': '5px', 
                                                        'margin-bottom': '10px', 
                                                        'margin-left': '5px'
                                                    })
                                                    .append(
                                                        $('<span />').addClass('icon-trash')
                                                    )
                                                    .click(function(){
                                                        $(this).closest('tr').remove();
                                                    })
                                                )
                                            )
                                        )
                                    })
                            )
                        )
                    );
                    if(it && it.servicos)
                    it.servicos.map(function(itm){
                        tb_srv.append(
                            $('<tr />').addClass('item_servico').append(
                                $('<td />').css({'width':'125px'}).append(
                                    $('<input />',{'type':'text', 'placeholder':'Código', 'name': 'cod_servico'}).css({'width':'auto'}).addClass('cod_servico form-control').val(itm.codigo)
                                ),
                                $('<td />').append(
                                    $('<input />',{'type':'text', 'placeholder':'Descrição do Serviço - forneça uma descrição de forma amigável para uma melhor compreensão', 'name': 'servico'}).css({'width':'98%'}).addClass('servico form-control').val(itm.descricao)
                                ),
                                $('<td />').css({'width':'60px'}).append(
                                    $('<button />')
                                        .css({
                                            'padding': '5px 2px 5px 5px',
                                            'margin-bottom': '10px',
                                            'margin-left': '5px'
                                        })
                                        .append(
                                            $('<span />').addClass('icon-trash')
                                        )										
                                        .click(function(){
                                            $(this).closest('tr').remove();
                                        })
                                )
                            )
                        );
                    });

                    _html.append(
                        $('<div />').addClass('token').append(
                            tb_token.append( 
                                tb_srv,
                                $('<button />')
                                    .addClass('btn btn-small button-trash')
                                    .css({'float':'right'})
                                    .on('click',function(){
                                        console.log('ok')
                                        $(this).closest('.fieldtoken').remove();
                                    })
                                    .append(
                                        $('<span />').addClass('icon-trash'),
                                        'Remover'
                                    )
                            ),
                            $('<button />')
                                .addClass('btn btn-small button-trash')
                                .css({'float':'left'})
                                .click(function(){
                                    $(this).closest('fieldset.fielduge').remove();
                                })
                                .append(
                                    $('<span />').addClass('icon-trash'),
                                    'Remover UGE'
                                )
                        )
                    );
                });
                    
                $('div.uge').append(_html);
            });
        }
    }        
    

    $('.btn_copiar')
        .addClass('btn btn-small')
        .append( $('<span />').addClass('icon-checkin'), ' Copiar' )
        .on('click', function(e){
            e.preventDefault();
            $('textarea.pagtesourojson').select();
            var copiar = document.execCommand('copy');
            if(copiar)msg('Copiado para a área de transferência', 'success');
            else msg('Não foi possível copiar conteudo da textarea.');
            return false;
        });

    $('.btn_load')
        .addClass('btn btn-small')
        .append( $('<span />').addClass('icon-publish'), ' Abrir' )
        .on('click', function(e){
            e.preventDefault();
            $('input[name=pagtesourojson]').trigger('click');
            $(this).remove();
        });

    $('.btn_download')
        .addClass('btn btn-small')
        .append( $('<span />').addClass('icon-archive'), ' Download' )
        .on('click', function(e){
            e.preventDefault();

            let text = $('textarea.pagtesourojson').val();
            let data = new Blob([text], {type: 'text/plain'});
            let url = window.URL.createObjectURL(data);
            let fileName = 'backup_pagtesouro.json';

            let a = document.createElement('a');
            a.setAttribute('download', fileName);
            a.setAttribute('href', url);
            a.click();
        });

    $('input[name=pagtesourojson]')
        .on('change', function(e){

            if (!this.files) {
                msg('Este browser não suporta a propriedade `files` para carrehar arquivos.');
                return;
            }

            var file = this.files;
            file = file[0];

            var allowed_types = [ 'application/json' ];
            if(allowed_types.indexOf(file.type) == -1) {
                msg('Error : Somente arquivo no formato json são permitidos');
                return;
            }

            var max_size_allowed = 2*1024*1024
            if(file.size > max_size_allowed) {
                msg('Error : Excedido o tamanho máximo do arquivo de backup (2MB).');
                return;
            }
            
            if (!window.File || !window.FileReader || !window.FileList || !window.Blob) {
                msg('Não é possível e suportado abrir o arquivo em seu navegador. Utilize outro navegador para esta ação.');
                return;
            }  

            var reader = new FileReader();
            var txt = reader.readAsText(file);

            reader.onload = function() {
                let json = reader.result;
                $('fieldset.fielduge').remove();
                $('textarea.pagtesourojson').val(json);
                populate_pagtesouro(json);
                URL.revokeObjectURL(reader);
            }
        });

    $.ajax({
        url: 'components/com_pagtesouro/pagtesouro.json',
        success: function(resposta){
            populate_pagtesouro(resposta);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            msg('Não foi possível retornar dados.');
        }
    });


    var btn_backup = $('<button />').addClass('backup btn btn-small button-save').append(
        $('<span />', {'aria-hidden':'true'}).addClass('icon-archive'),
        'Backup'
    ).on('click', function(e){
        e.preventDefault();

        let text = $('textarea.pagtesourojson').val();
        let data = new Blob([text], {type: 'text/plain'});
        let url = window.URL.createObjectURL(data);
        let fileName = 'backup_pagtesouro.json';

        let a = document.createElement('a');
        a.setAttribute('download', fileName);
        a.setAttribute('href', url);
        a.click();
    });

    var btn_form = $('<button />').addClass('backup btn btn-small button-open').append(
        $('<span />', {'aria-hidden':'true'}).addClass('icon-link'),
        'Formulário'
    ).on('click', function(e){
        e.preventDefault();

        let go_url = window.location.href.replace('administrator/index.php','')
        window.open(go_url, '_blank');
    })


    var btn_save = $('<button />').addClass('backup btn btn-small button-save').append(
        $('<span />', {'aria-hidden':'true'}).addClass('icon-save'),
        'Salvar Cadastro'
    ).css({'margin-left':'20px'}).on('click', function(e){
        e.preventDefault();
        var obj = Array();
        $('.fielduge').each(function(){
            let uge_cod = $(this).find("input[name='uge_cod']").val();
            let uge_descricao = $(this).find("input[name='uge_descricao']").val();
                       
            var objT = Array();
            $(this).find('.token').each(function(){
                
                let tk = $(this).find("input[name='token']").val();

                if(tk === '')msg('Token não informado.');
                else {
                    let serv = [];
                    let srv = $(this).find('table.servicos tr.item_servico')
                    if(srv.length)srv.each(function(){
                        let cd = $(this).find("input[name='cod_servico']").val();
                        let sv = $(this).find("input[name='servico']").val();
                        if(cd!=='' && sv !== '')serv.push({'codigo':cd, 'descricao':sv});
                        else msg('É preciso informar o código e a descrição do serviço');
                    });
                    objT.push({
                        'token' : tk,
                        'servicos' : serv
                    })
                }
            });
            obj.push({
                'uge_cod' : uge_cod,
                'uge_descricao' : uge_descricao,
                'tokens' : objT
            });
        });
        $.ajax({
            url: 'components/com_pagtesouro/pagtesouro-save.php',
            type: 'POST',
            data: {obj},
            success: function(resposta){
                msg(resposta, 'success');
                var txt = JSON.stringify(obj, undefined, 4);
                $('textarea.pagtesourojson').val(txt);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                msg('Erro ao salvar conteudo no arquivo pagtesouro.json');
            }
        });
    });

    var btn_addUGE = $('<button />').addClass('add_uge btn btn-small button-new btn-success').append(
        $('<span />', {'aria-hidden':'true'}).addClass('icon-new icon-white'),
        'Adicionar UGE'
    )
    .on('click', function(){
        $('.uge').append(
            $('<fieldset>').addClass('fielduge').append(
                $('<p />').append(
                    $('<input />',{'type':'text', 'placeholder':'Código UGE', 'name': 'uge_cod'}).css({'width':'10%'}).addClass('form-control').css({'margin-right':'5px'}),
                    $('<input />',{'type':'text', 'placeholder':'Nome da OM ', 'name': 'uge_descricao'}).css({'width':'78%'}).addClass('form-control')
                ),
                $('<p />').append(
                    $('<button />')
                        .addClass('btn btn-small button-new btn-success add_token')
                        .append( 
                            $('<span />').addClass('icon-new icon-white'),
                            'Adicionar Token'
                        )
                        .css({'margin-bottom':'5px'})
                        .on('click', function(){
                            $(this).after(
                                $('<div />').addClass('token').append(
                                    $('<fieldset>').addClass('fieldtoken').append(
                                        $('<p />').append(
                                            $('<input />',{'type':'text', 'placeholder':'Informe aqui o Token', 'name': 'token'}).css({'width':'98%'}).addClass('form-control')
                                        ),
                                        $('<table />').addClass('servicos').css({'width':'100%'}).append(
                                            $('<tr />').append(
                                                $('<td />', {'colspan':'3'}).append(
                                                    $('<button />')
                                                        .addClass('btn btn-small button-new btn-success')
                                                        .append( 
                                                            $('<span />').addClass('icon-new icon-white'),
                                                            'Adicionar Serviço'
                                                        )	
                                                        .click(function(){
                                                            $(this).closest('table.servicos').append(
                                                                $('<tr />').addClass('item_servico').append(
                                                                    $('<td />').css({'width':'125px'}).append(
                                                                        $('<input />',{'type':'text', 'placeholder':'Código', 'name': 'cod_servico'}).css({'width':'auto'}).addClass('cod_servico form-control')
                                                                    ),
                                                                    $('<td />').append(
                                                                        $('<input />',{'type':'text', 'placeholder':'Descrição do Serviço - forneça uma descrição de forma amigável para uma melhor compreensão', 'name': 'servico'}).css({'width':'98%'}).addClass('servico form-control')
                                                                    ),
                                                                    $('<td />').css({'width':'60px'}).append(
                                                                        $('<button />')
                                                                            .css({
                                                                                'padding': '5px 2px 5px 5px',
                                                                                'margin-bottom': '10px',
                                                                                'margin-left': '5px'
                                                                            })
                                                                            .append(
                                                                                $('<span />').addClass('icon-trash')
                                                                            )
                                                                            .click(function(){
                                                                                $(this).closest('tr').remove();
                                                                            })
                                                                    )
                                                                )
                                                            )
                                                        })
                                                )
                                            )
                                        ),
                                        $('<button />')
                                            .addClass('btn btn-small button-trash')
                                            .css({'float':'right'})
                                            .click(function(){
                                                $(this).closest('fieldset.fieldtoken').remove();
                                            })
                                            .append(
                                                $('<span />').addClass('icon-trash'),
                                                'Remover'
                                            )
                                    )
                                )
                            )
                        }),
                    $('<button />')
                        .addClass('btn btn-small button-trash')
                        .css({'float':'left', 'margin-right': '10px'})
                        .click(function(){
                            $(this).closest('fieldset.fielduge').remove();
                        })
                        .append(
                            $('<span />').addClass('icon-trash'),
                            'Remover UGE'
                        )
                )
            )
        )
    });

    $('.subhead').html('').append(
        $('<div />').addClass('container-fluid').append(
            $('<div />', {'id':'container-collapse'}).addClass('container-collapse'),
            $('<div />').addClass('row-fluid').append(
                $('<a />',{'id':'skiptarget'}).addClass('element-invisible').text('Main content begins here'),
                $('<div />', { 'role':'toolbar','aria-label':'Toolbar','id':'toolbar'}).addClass('btn-toolbar').append(
                    $('<div />').addClass('btn-wrapper').append(
                        btn_addUGE,
                        btn_backup,
                        btn_form,
                        btn_save
                    )
                )
            )
        )
    );
   

});	
