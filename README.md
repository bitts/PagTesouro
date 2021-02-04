# PagTesouro

[![GitHub license](https://img.shields.io/apm/l/vim-mode.svg)](LICENSE)

## Credits

### Author
[Marcelo Valvassori Bittencourt (bitts)](https://github.com/bitts)
### Init Project 
[Júlio César Vieira Malliotti (Malliotti)](https://www.youtube.com/channel/UClmDhLPCpFlLQYe1sns9Dgw)

# About
Sistema simples para geração de GRU utilizando a API do PagTesouro. Projeto iniciado por Malliotti, transformado adaptado por Marcelo para utilização de PHP, ocultando assim dados como a url de requisição e a própria chave de autorização de acesso da Organização Militar vinculada. 
Este sisteminha foi feito as pressas para atender as demandas de varias Organizações Militares e estará em constante melhorias.
Aqueles interessados em realizar melhorias, fiquem a vontade, este é um projeto aberto e a utilizaçção do Github visa centralizar melhorias para beneficio de todos.
Procure manter o projeto de forma que os clientes necessitem editar somente o arquivo INI (facilitando assim atualização deste sistema por parte daqueles que o utilizam).

# Versions
- [03/02/2021] 1.0 - Modificações básicas para funcionamento da API utilizando cURL do PHP, enviado os dados do formulário para classe PHP que trata os dados, inclui as chaves de autorização e URL para realizar as requisições ao PagTesouro.


# Uso
- Adicionar arquivos em um pasta dentro do Joomla;
- Editar arquivo pagtesouro.ini
- O arquivo pagtesouro.html é a template do formulário e pode ser modificada para adequar-se melhor a realizadade de onde deseja integrar o sisteminho


Abaixo alguns detalhes do arquivo de configuração

```
; Configurações do sistema
[pagtesouro]

;[boolean] Utilizado para debugar sistema exibindos todos os tipos de mensagens e valores de variaveis do sistema
DEBUG =	false

;[string] Codigo de autenticação fornecido pelo PagTesouro conforme documentação de referencia esta logo abaixo é utilizado no ambiente de desenvolvimento do PagTesouro
AUTHORIZATION = 'Bearer eyJhbGciOiJSUzI1NiJ9.eyJzdWIiOiIxNjAwODYifQ.fY4bWesL85B_vFSOmRUyfrawte-SjSuqKcFQTfyfMQVFKyl6gfJKX63o_wElLkb3MHXl5xmQG9zlQasv5V561uq-R8uV6Gi35iXy36hk6wdc8LyLk-WgVD5TN4fyCCrZ5VH6tuayM7xmZ3fPyPdfJFknCCao48E2skbptEHS-8VUjFKAUObd_oFblDsyc8jC0cYPfX7p8IbO1kdeibqBbu-wpnGczsmoWftMkmS82Y-U9EqcRcY5IN10IcVFg_IJ7Mo5SeH3snfrcOMVP-DMjUH0MefmHUqN0eMGlBbeZK1rHxvRXfB7Ual9PORzyhuTO5kzIYK90EW1sT2qNl4TXA'

;[String] URL do retorno de mensagem do sistema
URLREQUEST =   'https://www.1cta.eb.mil.br/pagtesouro/'

;[array] codigo dos serviços 
; ** MUITO IMPORTANTE ** cadastrar codigos no padrão:
; SERVICO[] = 'CODIGONUMERICO - Descrição do Serviço para Usuário compreender'
; onde: CODIGONUMERICO é um número do tipo inteiro e deve ser seguido de espaço, traço e espaço, seguido da descrição
SERVICO[] =   '701 - INDENIZAÇÕES'
SERVICO[] =   '702 - INDENIZAÇÕES'
```