# PagTesouro

[![GitHub license](https://img.shields.io/apm/l/vim-mode.svg)](LICENSE)

## Credits

### Author
[Marcelo Valvassori Bittencourt (bitts)](https://github.com/bitts)

# About
Sistema simples para geração de GRU utilizando a API do PagTesouro

# Versions
- [03/02/2021] 1.0 - Modificações básicas para funcionamento da API utilizando cURL do PHP, enviado os dados do formulário para classe PHP que trata os dados, inclui as chaves de autorização e URL para realizar as requisições ao PagTesouro.


# Uso
- Adicionar arquivos em um pasta dentro do Joomla;
- Editar arquivo pagtesouro.ini
- O arquivo pagtesouro.html é a template do formulário e pode ser modificada para adequar-se melhor a realizadade de onde deseja integrar basta que você mantena

```
; Configurações do sistema
[pagtesouro]

;[boolean] Utilizado para debugar sistema exibindos todos os tipos de mensagens e valores de variaveis do sistema
DEBUG =	false

;[string] Codigo de autenticação fornecido pelo PagTesouro conforme documentação de referencia
AUTHORIZATION = 'Bearer eyJhbGciOiJSUzI1NiJ9.eyJzdWIiOiIxNjAwODYifQ.fY4bWesL85B_vFSOmRUyfrawte-SjSuqKcFQTfyfMQVFKyl6gfJKX63o_wElLkb3MHXl5xmQG9zlQasv5V561uq-R8uV6Gi35iXy36hk6wdc8LyLk-WgVD5TN4fyCCrZ5VH6tuayM7xmZ3fPyPdfJFknCCao48E2skbptEHS-8VUjFKAUObd_oFblDsyc8jC0cYPfX7p8IbO1kdeibqBbu-wpnGczsmoWftMkmS82Y-U9EqcRcY5IN10IcVFg_IJ7Mo5SeH3snfrcOMVP-DMjUH0MefmHUqN0eMGlBbeZK1rHxvRXfB7Ual9PORzyhuTO5kzIYK90EW1sT2qNl4TXA'

;[string] Organização Militar 
OM = '1º CTA'

;[String] URL do retorno de mensagem do sistema
URLREQUEST =   'https://www.1cta.eb.mil.br/pagtesouro/'

;[array] codigo dos serviços 
; ** MUITO IMPORTANTE ** cadastrar codigos no padrão:
; SERVICO[] = 'CODIGONUMERICO - Descrição do Serviço para Usuário compreender'
; onde: CODIGONUMERICO é um número do tipo inteiro e deve ser seguido de espaço, traço e espaço, seguido da descrição
SERVICO[] =   '701 - INDENIZAÇÕES'
SERVICO[] =   '702 - INDENIZAÇÕES'
```