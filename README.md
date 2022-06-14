# PagTesouro
Formulário de integração com API do PagTesouro

<a href="https://github.com/bitts/PagTesouro/wiki/Componente-Joomla"><img alt="GitHub release (latest by date)" src="https://img.shields.io/github/v/release/bitts/pagtesouro"></a>
<img alt="GitHub last commit" src="https://img.shields.io/github/last-commit/bitts/pagtesouro">
<img alt="GitHub Release Date" src="https://img.shields.io/github/release-date/bitts/pagtesouro">
<img alt="GitHub all releases" src="https://img.shields.io/github/downloads/bitts/pagtesouro/total">
<img alt="GitHub release (latest by date)" src="https://img.shields.io/github/downloads/bitts/pagtesouro/v2.1/total">
<img alt="GitHub repo size" src="https://img.shields.io/github/repo-size/bitts/pagtesouro">
<!-- img alt="Packagist License (custom server)" src="https://img.shields.io/packagist/l/bitts/pagtesouro" -->

<p align="left"><a href="https://downloads.joomla.org" target="_blank" rel="noopener noreferrer"><img src="https://downloads.joomla.org/images/homepage/joomla-logo.png" alt="Joomla Logo"></a></p>

# Necessita de Colaboradores!!!

## Formulário de Integração com o PagTesouro

### Acompanhamento do projeto
- Interface Administrativa:
    - [x] Cadastro de Tokens (Banco de Dados) 

        Melhorias: atualmente sando dados no formato string com o JSON contendo os dados (mudar para tabelas específicas?) 
    - [ ] Exibir dados cadastrados pelos usuário no formato padrão do Joomla de apresentação de listagens
    - [ ] Exibir mensagem de atualizações com base no GitHub e versão publicada
    - [ ] Personalização do CSS do formulário atráves da interface administrativa em nova aba de apresentação de opções

        Obs.: Verificar editores de css possíveis de integração e compatíveis com Joomla

- Interface Usuário:
    - [ ] Salvar dados submetidos no formulário em banco de dados
    - [ ] Consultar documento

## Créditos

### Author / Autores
[Marcelo Valvassori Bittencourt (bitts)](https://github.com/bitts)
### Init Project / Software Tester
[Júlio César Vieira Malliotti (Malliotti)](https://github.com/malliotti)

### Colaboração Direta
[Marcos Luiz Rezende de Melo (mlrmelo)](https://github.com/mlrmelo)

### Colaboração Indireta
[Rafael Menezes (rafaelms87)](https://github.com/rafaelms87)

# Sistema de Pagamento do Tesouro
O PagTesouro é um componente de processamento de pagamentos digitais gerido pela Secretaria do Tesouro Nacional (STN), um órgão vinculado ao Ministério da Economia e que tem como missão principal gerenciar as contas públicas de forma eficiente e transparente. No contexto do processo de Gerenciamento das Receitas da União, o componente PagTesouro atua no cenário de recolhimento de receitas de Órgãos e entidades da administração Pública Federal como taxas (custas judiciais, emissão de passaporte, etc.), aluguéis de imóveis públicos, serviços administrativos e educacionais, multas, entre outros, permitindo o pagamento em forma digital, assim como a impressão do boleto de pagamento. O pagamento pode ser feito pelas formas Pix, cartão de crédito e boleto de GRU Simples.

# Sobre o Sistema de Integração
Sistema simples para geração de GRU utilizando a API do PagTesouro. Projeto iniciado por Malliotti, transformado adaptado por Marcelo para utilização de PHP, ocultando assim dados como a url de requisição e a própria chave de autorização de acesso da Organização Militar vinculada. 

Aqueles interessados em realizar melhorias, fiquem a vontade, este é um projeto aberto e a utilização do Github visa centralizar melhorias para beneficio de todos.

Procure manter o projeto de forma que os clientes necessitem editar somente o arquivo JSON (facilitando assim atualização).

### Documentação de Referência
https://valpagtesouro.tesouro.gov.br/simulador/#/pages/api

https://pagtesouro.tesouro.gov.br/docs/api-psp/

# Versions
- [03/02/2021] 1.0 - Modificações básicas para funcionamento da API utilizando cURL do PHP, enviado os dados do formulário para classe PHP que trata os dados, inclui as chaves de autorização e URL para realizar as requisições ao PagTesouro.
- [19/02/2021] 1.1 - Alterado sistema para funcionar com vários Tokens
- [20/02/2021] 1.2 - Alteração para configurações em arquivo json 
    - [Validado] Alterado para cadastramento dos dados de Tokens e Serviços para o arquivo pagtesouro.json
    - [Validado] Adicionado novas formas de envio dos dados ao PagTesouro (file_get_contents e fopen, além do curl como última alternativa já que em muitos servidores algumas dessas bibliotecas podem não estarem habilitadas por default no PHP)
    - [Validado] Adição de arquvio .htaccess com regras básicas para segurança ou para eviar erros de chamada
- [22/02/2021] 1.3 - [Validado] Funcional para diversos Token
- [01/02/2021] 1.4 - [Validado] Sistema para hospedagem simples
- [16/03/2021] 2.0 Funciona como componente do Joomla! 
- [Veja Documentação de como Instalar no Joomla!](https://github.com/bitts/PagTesouro/wiki/Componente-Joomla---Inslata%C3%A7%C3%A3o)
- [28/03/2021] 2.1 - Diversas melhoras:

    - Exportar cadastro realizado na interface Administrativa (backup do pagtesouro.json)

    - No formulário de geração o(s) Serviço(s) agora é(são) apresentados por UGE (optgroup do select)

    - Diversas melhoras na interface de administração para se adptar mais ao padrão Joomla!

    - Aplicação de mascara nos campos do formulário de geração

    - Formulário de geração mais compacto

    - Na interface administrativa aba para acompanhar atualizações do Componente do PagTesouro

    - Também na interface administrativa aba com conteudo do arquivo README.me mais atual direto do Github
- [05/03/2022] 2.2 - Correções para possível publicação no site [Extensions Directory](https://extensions.joomla.org/)
- [15/03/2022] 2.2 - Publicação no site [Extensions Directory](https://extensions.joomla.org/extension/contacts-and-feedback/forms/formulario-de-integracao-pagtesouro/)
    - Modificação da abertura do retorno do Pagtesouro de iframe para windows.open (abertura em nova janela)
- [14/06/2022] 3.0 - Melhorias na interface de administração modificando a sistemática para salvamento das informações em Banco de Dados.


# Primeiros passos antes da implementação
[Passo a Passo - Material de Rafael Menezes](https://github.com/rafaelms87/pagtesouro/files/6236911/Passo.a.Passo.pdf)

Resumo

Siga os passos abaixo para que o sistema esteja funcional:

1 - Gere os Códigos Necessários (Setor Financeiro)

A - Solicite o Setor Financeiro de sua organização (usuário SIAFI válido) que gere um Token para cada uma das UGs sobre sua gerência, no SISGRU.
Aba PagTesouro / Autorização de uso do PagTesouro / inserir o código da UG, o período para utilização e setar situação "ativo".
    
B - Solicite o Setor Financeiro (usuário SIAFI válido) que gere os Códigos de Serviço correspondentes para cada UG., no SISGRU.
Aba PagTesouro / Catálago de serviços / Inserir o código da UG, código de recolhimento da GRU e o tipo de serviço. Após isso, selecione Incluir.

# Uso para sistema Joomla
- Acessar painel administrativo do Joomla
- Ir no Menu > Extesions > Manager > Install
- Na opção "Upload Package File" você precisa fazer o download do arquivo da versão [2.2](https://github.com/bitts/PagTesouro/archive/refs/tags/v2.2.zip) para o seu computador e depois escolher o arquivo para instalação;
- Vá no Menu "Components" > "PagTesouro", para adicionar ou remover seus Tokens e Serviços
- Em caso de dificuldades veja documentação do sistema ou a interpretação das [mensagens](https://github.com/bitts/PagTesouro/wiki/Erros-e-mensagens-do-Sistema-do-Sistema) do sistema

# Uso para hospedagem simples
- Realize o download do sistema na versão [v1.4](https://github.com/bitts/PagTesouro/archive/v1.4.zip)
- Adicionar os arquivos em um pasta dentro do Joomla
- Editar arquivo pagtesouro.JSON

Caso você utilize Joomla é quer colocar o conteudo deste formulário de forma integrada em seu site
- Criar dentro do Joomla um [conteudo do tipo iframe](https://github.com/bitts/PagTesouro/wiki/Incluindo-um-conte%C3%BAdo-do-tipo-Iframe-no-Joomla) e aponte para o arquivo index.php
- O arquivo pagtesouro.html é a template do formulário e PODE (não precisa) ser modificada para adequar-se melhor a realidade de onde deseja integrar o sisteminha
- Evite modificar arquivos como o pagtesouro.php ou o pagtesouro.html, se você realmente não sabe o que esta fazendo
- A descrição pode ser alterada no arquivo pagtesouro.json para facilitar o uso pelo cliente, no caso de varias UGs você pode editar para "UG 6666-6 | 701 - Indenizações" ao invés de utilizar somente "701 - INDENIZAÇÕES"
- Abaixo alguns detalhes do arquivo de configuração para hospedagens simples onde é preciso editar o arquivo (ARQUIVO: pagtesouro.json)

```
[
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
]
```
* Valide o seu arquivo JSON em https://jsonlint.com/

# Em utilização por 

- [CMA - Colégio Militar de Manaus](https://www.cmm.eb.mil.br/?option=com_pagtesouro)

- [AMAN - Academia Militar das Agulhas Negras](http://www.aman.eb.mil.br/?option=com_pagtesouro)

- [EsSLog - Escola de Sargentos de Logística](http://www.esslog.eb.mil.br/?option=com_pagtesouro)

- [1º BIS - 1º Batalhão de Infantaria de Selva (Amv)](https://www.1bis.eb.mil.br/?option=com_pagtesouro)

- [12º BSup - 12º Batalhão de Suprimento](https://www.12bsup.eb.mil.br/?option=com_pagtesouro)

- [CCFEx - Centro de Capacitação Física do Exército](http://www.ccfex.eb.mil.br/?option=com_pagtesouro)

- [CMA - Comando Militar da Amazônia](https://www.cma.eb.mil.br/?option=com_pagtesouro)

- [EsAO - Escola de Aperfeiçoamento de Oficiais](http://www.esao.eb.mil.br/?option=com_pagtesouro)

- [EsACosAAe - Escola de Artilharia de Costa e Antiaérea](http://www.esacosaae.eb.mil.br/?option=com_pagtesouro)

- [CRO 12 - Comissão Regional de Obras da 12ª Região Militar](https://www.cro12.eb.mil.br/?option=com_pagtesouro)

- [EsIE - Escola de Instrução Especializada](http://www.esie.eb.mil.br/?option=com_pagtesouro)

- [2ª Bda Inf Sl - 2ª Brigada de Infantaria de Selva](https://www.2bdainfsl.eb.mil.br/?option=com_pagtesouro)

- [CEP/FDC - Centro de Estudos de Pessoal e Forte Duque de Caxias](http://www.cep.eb.mil.br/?option=com_pagtesouro)

- [IME - Instituto Militar de Engenharia](http://www.ime.eb.mil.br/?option=com_pagtesouro)

- [CML - Comando Militar do Leste](http://www.cml.eb.mil.br/?option=com_pagtesouro)

- [HCE - Hospital Central do Exército](http://www.hce.eb.mil.br/?option=com_pagtesouro)

- [CMRJ - Colégio Militar do Rio de Janeiro](http://www.cmrj.eb.mil.br/?option=com_pagtesouro)

- [CMM - Colégio Militar de Manaus](https://www.cmm.eb.mil.br/?option=com_pagtesouro)

- [54º BIS - 54º Batalhão de Infantaria de Selva](https://www.54bis.eb.mil.br/?option=com_pagtesouro)

- [16ª Bda Inf Sl - 16ª Brigada de Infantaria de Selva](https://www.16bdainfsl.eb.mil.br/?option=com_pagtesouro)

- [HGuT - Hospital de Guarnição de Tabatinga](https://www.hgut.eb.mil.br/?option=com_pagtesouro)

- [2ª RM - 2ª Região Militar](http://www.2rm.eb.mil.br/?option=com_pagtesouro)

- [HGuPV - Hospital de Guarnição de Porto Velho](https://www.hgupv.eb.mil.br/?option=com_pagtesouro)

- [36º BI Mec - 36º Batalhão de Infantaria Mecanizado.](http://www.36bimec.eb.mil.br/?option=com_pagtesouro)

- [17ª Bda Inf Sl - Comando da 17ª Brigada de Infantaria de Selva](https://www.17bdainfsl.eb.mil.br/?option=com_pagtesouro)

- [1° Esqd C L - 1° Esquadrão de Cavalaria Leve](http://www.1esqdcl.eb.mil.br/?option=com_pagtesouro)

- [7º BEC - 7º Batalhão de Engenharia de Construção](https://www.7bec.eb.mil.br/?option=com_pagtesouro)

- [8º BIS - 8º Batalhão de Infantaria de Selva](https://www.8bis.eb.mil.br/?option=com_pagtesouro)

- [HMAM - Hospital Militar de Área de Manaus](https://www.hmam.eb.mil.br/?option=com_pagtesouro)

- [47º BI - 47º Batalhão de Infantaria](https://www.47bi.eb.mil.br/?option=com_pagtesouro)

- [6º BIS - 6º Batalhão de Infantaria de Selva](https://www.6bis.eb.mil.br/?option=com_pagtesouro)

- [7° BIB - 7° Batalhão de Infantaria Blindado](http://www.7bib.eb.mil.br/?option=com_pagtesouro)

- [4º BIS - 4º Batalhão de Infantaria de Selva](https://www.4bis.eb.mil.br/?option=com_pagtesouro)

- [4º BAvEx - 4º Batalhão de Aviação do Exército](https://www.4bavex.eb.mil.br/pt/?option=com_pagtesouro)

- [12ª RM - 12ª Região Militar](https://www.12rm.eb.mil.br/?option=com_pagtesouro)

- [HGeRJ - Hospital Geral do Rio de Janeiro.](http://www.hgerj.eb.mil.br/?option=com_pagtesouro)

[]()

[]()

[]()







