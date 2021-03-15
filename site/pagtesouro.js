
var j = jQuery.noConflict();
j(document).ready(function($){
	var jPagTesouro = {
	  debug : false,
	  url : 'components/com_pagtesouro/pagtesouro.php',
	  init : function(){
		jPagTesouro.fm_form();
		jPagTesouro.vl_form();                
	  },
	  fm_form : function(){
		  $('#input_valorPrincipal').maskMoney();
		  $('#input_valorDescontos, #input_valorOutrasDeducoes, #input_valorMulta, #input_valorOutrosAcrescimos')
			.maskMoney({ decimal: '.', thousands: '', precision: 2 });
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
			  url: jPagTesouro.url,
			  type: 'POST',
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
					  $( '.iframe-epag' ).attr('src',result.proximaUrl);
					  setTimeout(function(){ $( '.dialog_pagtesouro' ).show().dialog({width: 800,height: 800}); },1000)
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