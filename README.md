# PagTesouro
Formulário de integração com API do PagTesouro

## Créditos

### Author / Autores
[Marcelo Valvassori Bittencourt (bitts)](https://github.com/bitts)
### Init Project 
[Júlio César Vieira Malliotti (Malliotti)](https://www.youtube.com/channel/UClmDhLPCpFlLQYe1sns9Dgw)

# About
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
    - [Não Validado] Adição de arquvio .htaccess com regras básicas para segurança ou para eviar erros de chamada
- [22/02/2021] 1.3 - [Validado] Funcional para diversos Token

# Uso
- Adicionar arquivos em um pasta dentro do Joomla;
- Editar arquivo pagtesouro.JSON
- Criar dentro do Joomla abertura para iframe e apontar para o arquivo index.php
- O arquivo pagtesouro.html é a template do formulário e PODE (não precisa) ser modificada para adequar-se melhor a realidade de onde deseja integrar o sisteminha
- Evite modificar arquivos como o pagtesouro.php ou o pagtesouro.html, se você realmente não sabe o que esta fazendo
- A descrição pode ser alterada no arquivo pagtesouro.json para facilitar o uso pelo cliente, no caso de varias UGs você pode editar para "UG 6666-6 | 701 - Indenizações" ao invés de utilizar somente "701 - INDENIZAÇÕES"


Abaixo alguns detalhes do NOVO arquivo de configuração (ARQUIVO: pagtesouro.json)

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

# Melhorias
- Modificar sistema para funcionar como um componente do Joomla


