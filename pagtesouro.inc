<?php
/*
;# Title: Sisteminha mixuruca de integração ao PagTesouro
;# Description: sistema para geração de GRU do PagTesouro
;# Author: 2º Ten Marcelo Valvassori BITTENCOURT
;# E-mail: marcelo.valvassori.bittencourt@gmail.com
;# version: 1.1
;# Modificação: 18 FEV 2021
;*
;* This version may have been modified pursuant
;* to the GNU General Public License, and as distributed it includes or
;* is derivative of works licensed under the GNU General Public License or
;* other free or open source software licenses.


;Modifique os valores que acredita serem necessários
;Caso seja desenvolvedor ou possua conhecimento afins participe do projeto em https://github.com/bitts/PagTesouro
*/
$parametros = '[
    {
        "token" : "Bearer eyJhbGciOiJSUzI1NiJ9.eyJzdWIiOiIxNjAwODYifQ.fY4bWesL85B_vFSOmRUyfrawte-SjSuqKcFQTfyfMQVFKyl6gfJKX63o_wElLkb3MHXl5xmQG9zlQasv5V561uq-R8uV6Gi35iXy36hk6wdc8LyLk-WgVD5TN4fyCCrZ5VH6tuayM7xmZ3fPyPdfJFknCCao48E2skbptEHS-8VUjFKAUObd_oFblDsyc8jC0cYPfX7p8IbO1kdeibqBbu-wpnGczsmoWftMkmS82Y-U9EqcRcY5IN10IcVFg_IJ7Mo5SeH3snfrcOMVP-DMjUH0MefmHUqN0eMGlBbeZK1rHxvRXfB7Ual9PORzyhuTO5kzIYK90EW1sT2qNl4TXA",
        "servicos" : [
            {
                "codigo" : 701,
                "descricao": "701 - INDENIZAÇÕES"
            },
            {
                "codigo": 702,
                "descricao" : "702 - INDENIZAÇÕES USO IMOVEIS"
            }
        ]
    },
    {
        "token" : "Bearer eyJhbGciOiJSUzI1NiJ9.eyJzdWIiOiIxNjAwODYifQ.fY4bWesL85B_vFSOmRUyfrawte-SjSuqKcFQTfyfMQVFKyl6gfJKX63o_wElLkb3MHXl5xmQG9zlQasv5V561uq-R8uV6Gi35iXy36hk6wdc8LyLk-WgVD5TN4fyCCrZ5VH6tuayM7xmZ3fPyPdfJFknCCao48E2skbptEHS-8VUjFKAUObd_oFblDsyc8jC0cYPfX7p8IbO1kdeibqBbu-wpnGczsmoWftMkmS82Y-U9EqcRcY5IN10IcVFg_IJ7Mo5SeH3snfrcOMVP-DMjUH0MefmHUqN0eMGlBbeZK1rHxvRXfB7Ual9PORzyhuTO5kzIYK90EW1sT2qNl4TXA",
        "servicos" : [
            {
                "codigo" : 701,
                "descricao": "701 - INDENIZAÇÕES"
            },
            {
                "codigo": 702,
                "descricao" : "702 - INDENIZAÇÕES USO IMOVEIS"
            }
        ]
    }
    
]';
?>