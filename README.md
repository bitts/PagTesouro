# PagTesouro
Formulário de integração com API do PagTesouro

[Versão 2.0 - Plugin Joomla!](https://github.com/bitts/PagTesouro/wiki/Plugin-Joomla!)

<p align="left"><a href="https://downloads.joomla.org" target="_blank" rel="noopener noreferrer"><img src="https://downloads.joomla.org/images/homepage/joomla-logo.png" alt="Joomla Logo"></a></p>

[extensions.joomla.org - PagTesouro](https://extensions.joomla.org/index.php?option=com_jed&view=extension&layout=default&id=15302&Itemid=145)


## Créditos

### Author / Autores
[Marcelo Valvassori Bittencourt (bitts)](https://github.com/bitts)

# Sistema de Pagamento do Tesouro
O PagTesouro é um componente de processamento de pagamentos digitais gerido pela Secretaria do Tesouro Nacional (STN), um órgão vinculado ao Ministério da Economia e que tem como missão principal gerenciar as contas públicas de forma eficiente e transparente. No contexto do processo de Gerenciamento das Receitas da União, o componente PagTesouro atua no cenário de recolhimento de receitas de Órgãos e entidades da administração Pública Federal como taxas (custas judiciais, emissão de passaporte, etc.), aluguéis de imóveis públicos, serviços administrativos e educacionais, multas, entre outros, permitindo o pagamento em forma digital, assim como a impressão do boleto de pagamento. O pagamento pode ser feito pelas formas Pix, cartão de crédito e boleto de GRU Simples.

# Sobre o Sistema de Integração
Sistema simples para geração de GRU utilizando a API do PagTesouro. Projeto iniciado por [Malliotti](https://github.com/malliotti), transformado adaptado por Marcelo para utilização de PHP, ocultando assim dados como a url de requisição e a própria chave de autorização de acesso da Organização Militar vinculada. O projeto evoluiu para se tornar um plugin do Joomla para facilitar para todos aqueles que necessitam deste recurso integrado ao Portal/Site.

### Documentação de Referência
https://valpagtesouro.tesouro.gov.br/simulador/#/pages/api

# Versions
- [14/03/2021] 2.0 [Validado] Plugin do Joomla! https://github.com/bitts/PagTesouro/releases/download/v2.0/INSTALADOR.zip
    

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
- Na opção "Install from URL" basta você informar a url "https://github.com/bitts/PagTesouro/releases/download/v2.0/INSTALADOR.zip" e clicar em "Check and Install", pronto já estara instalado o plugin Joomla do PagTesouro
- Vá no Menu "Components" > "PagTesouro", para adicionar ou remover seus Tokens e Serviços




