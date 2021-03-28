# PagTesouro
Formulário de integração com API do PagTesouro

[Versão 2.1.0 - Componente Joomla!](https://github.com/bitts/PagTesouro/wiki/Componente-Joomla)

<p align="left"><a href="https://downloads.joomla.org" target="_blank" rel="noopener noreferrer"><img src="https://downloads.joomla.org/images/homepage/joomla-logo.png" alt="Joomla Logo"></a></p>


## Créditos

### Author / Autores
[Marcelo Valvassori Bittencourt (bitts)](https://github.com/bitts)
### Init Project 
[Júlio César Vieira Malliotti (Malliotti)](https://github.com/malliotti)

# Sistema de Pagamento do Tesouro
O PagTesouro é um componente de processamento de pagamentos digitais gerido pela Secretaria do Tesouro Nacional (STN), um órgão vinculado ao Ministério da Economia e que tem como missão principal gerenciar as contas públicas de forma eficiente e transparente. No contexto do processo de Gerenciamento das Receitas da União, o componente PagTesouro atua no cenário de recolhimento de receitas de Órgãos e entidades da administração Pública Federal como taxas (custas judiciais, emissão de passaporte, etc.), aluguéis de imóveis públicos, serviços administrativos e educacionais, multas, entre outros, permitindo o pagamento em forma digital, assim como a impressão do boleto de pagamento. O pagamento pode ser feito pelas formas Pix, cartão de crédito e boleto de GRU Simples.

# Sobre o Sistema de Integração
Sistema simples para geração de GRU utilizando a API do PagTesouro. Projeto iniciado por Malliotti, transformado adaptado por Marcelo para utilização de PHP, ocultando assim dados como a url de requisição e a própria chave de autorização de acesso da Organização Militar vinculada. 

Aqueles interessados em realizar melhorias, fiquem a vontade, este é um projeto aberto e a utilização do Github visa centralizar melhorias para beneficio de todos.

Procure manter o projeto de forma que os clientes necessitem editar somente o arquivo JSON (facilitando assim atualização).

### Documentação de Referência
https://valpagtesouro.tesouro.gov.br/simulador/#/pages/api

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
- [Veja Documentação de como Instalar no Joomla!](https://github.com/bitts/PagTesouro/wiki/Componente-Joomla)
- [28/03/2021] 2.1 - Diversas melhoras como possibilidade de realizar backup do cadastro bem como organizar o(s) Token(s) por UGE, criando um "group" no select

# Primeiros passos antes da implementação
Siga os passos abaixo para que o sistema esteja funcional:

1 - Gere os Códigos Necessários (Setor Financeiro)

A - Solicite o Setor Financeiro de sua organização (usuário SIAFI válido) que gere um Token para cada uma das UGs sobre sua gerência, no SISGRU.
Aba PagTesouro / Autorização de uso do PagTesouro / inserir o código da UG, o período para utilização e setar situação "ativo".
    
B - Solicite o Setor Financeiro (usuário SIAFI válido) que gere os Códigos de Serviço correspondentes para cada UG., no SISGRU.
Aba PagTesouro / Catálago de serviços / Inserir o código da UG, código de recolhimento da GRU e o tipo de serviço. Após isso, selecione Incluir.

# Uso para sistema Joomla
- Acessar painel administrativo do Joomla
- Ir no Menu > Extesions > Manager > Install
- Na opção "Upload Package File" você precisa fazer o download do arquivo da versão [2.0](https://github.com/bitts/PagTesouro/releases/download/v2.0/INSTALADOR.zip) para o seu computador e depois escolher o arquivo para instalação;
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




