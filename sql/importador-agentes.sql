-- Importando csv com órgãos públicos

-- DROP TEMPORARY TABLE IF EXISTS tmp_import;

-- criando tabela temporária para receber csv
CREATE TEMPORARY TABLE tmp_import (
Codigo INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
Poder Varchar(150) NULL,
NivelFederativo Varchar(150) NULL,
UF Varchar(150) NULL,
Cidade Varchar(500) NULL,
Nome Varchar(1200) NULL,
Descricao VARCHAR(1200) NULL,
Link VARCHAR(1200) NULL
);

-- importando tabela temporária (ignorar warnings)

LOAD DATA LOCAL INFILE '~/Desktop/trabalho/transparencia brasil/importacoes/agentes1.csv' INTO TABLE tmp_import
CHARACTER SET UTF8
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"' 
LINES TERMINATED BY '\r\n'
IGNORE 1 LINES
SET Codigo = null;

-- Algumas cidades têm apóstrofo, e aí o join por cidade não funciona. Precisa substituir por `

-- substituindo apostofro das cidades
-- vou colocar em nova tabela, com o apóstrofo substituído

CREATE TEMPORARY TABLE IF NOT EXISTS import_table
 (select Codigo
		,Poder
        ,NivelFederativo
        ,UF
        ,REPLACE(Cidade, '''', '`') AS Cidade
        ,Nome
        ,Descricao
        ,Link
  from tmp_import);
  
-- checa onde o join não funcionou (supsotamente, cidades do csv que não estão no banco)
-- retorna 34 linhas
  
select i.Codigo,
		i.Nome,
		i.UF,
        i.Cidade,
        c.Nome,
        c.CodigoUF
from import_table i
inner join uf
on i.UF = uf.Sigla
left join cidade c
on i.Cidade = c.Nome and uf.Codigo = c.CodigoUF
where c.Nome is NULL and Cidade != ''
limit 100;

-- select i.Codigo,i.Nome,i.UF,i.Cidade,c.Nome,c.CodigoUF from import_table i inner join uf on i.UF = uf.Sigla left join cidade c on i.Cidade = c.Nome and uf.Codigo = c.CodigoUF where c.Nome is NULL and Cidade != '' limit 100;