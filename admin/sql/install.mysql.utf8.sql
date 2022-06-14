--
-- Table structure for table `#__pagtesouro`
--
-- https://valpagtesouro.tesouro.gov.br/simulador/#/pages/api#solicita-pgto
-- 
-- create : 22/03/2022

CREATE TABLE IF NOT EXISTS `#__pagtesouro_docs` (
	`id` 					          INT(11) 		    NOT NULL AUTO_INCREMENT,	
    
  `codigoServico`     	  VARCHAR(15)     NOT NULL DEFAULT '',
  `referencia`       		  VARCHAR(255)    NOT NULL DEFAULT '',
  `competencia`       	  VARCHAR(10)     NOT NULL DEFAULT '',
  `vencimento`        	  DATE            NOT NULL DEFAULT '0000-00-00',
  `cnpjCpf`           	  VARCHAR(20)     NOT NULL DEFAULT '',
  `nomeContribuinte`  	  VARCHAR(255)    NOT NULL DEFAULT '',
  `valorPrincipal` 		    FLOAT 			    DEFAULT NULL,
  `valorDescontos`		    FLOAT 			    DEFAULT NULL,
  `valorOutrasDeducoes` 	FLOAT 			    DEFAULT NULL,
  `valorMulta` 			      FLOAT 			    DEFAULT NULL,
  `valorJuros` 			      FLOAT 			    DEFAULT NULL,
  `valorOutrosAcrescimos` FLOAT 			    DEFAULT NULL,
  `data_envio`      		  TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,

  `methodo`				        VARCHAR(20)     DEFAULT NULL,
  `idPagamento`	 		      VARCHAR(20)     DEFAULT NULL,
  `dataCriacao`			      VARCHAR(20)     DEFAULT NULL, 
  `proximaUrl`			      VARCHAR(255)    DEFAULT NULL,
  `situacao`				      VARCHAR(255)    DEFAULT NULL,
  `status_code`			      VARCHAR(5)      DEFAULT NULL,

	PRIMARY KEY  (`id`)
)  
ENGINE=InnoDB 
AUTO_INCREMENT=0 
DEFAULT CHARSET=utf8mb4 
DEFAULT COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__pagtesouro_tokens` (
	`id` 					INT(11) 		  NOT NULL AUTO_INCREMENT,	
  `tokens`      TEXT          NOT NULL DEFAULT '',
  `data_update` DATETIME      DEFAULT NULL,
  `data_save`   TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
	
  PRIMARY KEY  (`id`)
)  
ENGINE=InnoDB 
AUTO_INCREMENT=0 
DEFAULT CHARSET=utf8mb4 
DEFAULT COLLATE=utf8mb4_unicode_ci;


INSERT INTO `#__pagtesouro_tokens` (`tokens`) VALUES ('[{\"uge_cod\":\"11111111\",\"uge_descricao\":\"1\\u00ba Centro de Telem\\u00e1tica de \\u00c1rea\",\"tokens\":[{\"token\":\"333333333333333\",\"servicos\":[{\"codigo\":\"44444444\",\"descricao\":\"555555555\"}]}]},{\"uge_cod\":\"7777\",\"uge_descricao\":\"888888\",\"tokens\":[{\"token\":\"99999999999999999\",\"servicos\":[{\"codigo\":\"0000\",\"descricao\":\"000\"},{\"codigo\":\"1111\",\"descricao\":\"111\"},{\"codigo\":\"222\",\"descricao\":\"222\"}]}]}]');

