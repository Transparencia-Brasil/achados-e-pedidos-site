#Configuração do site:

Base de dados
1- criar a base de dados tblai
2- rodar o script sql/_schema.sql e se você quiser, pode inserir os dados das cidades / estados
3- popular base de dados auxiliares:
sql/hom_database_cidades_uf.sql
sql/hom_database_data.sql
4- oturos scripts:
sql/importador-agentes.sql
sql/pedidos_moderacoes_trigger.sql


PHP:
3- No arquivo config/app.php, configurar o acesso ao seu banco (a partir da lina 210)
4- No arq config/bootstrap.php, configurar a sua URL local na linha 201

Permissões nas pastas e arquivos de leitura e escrita:
5- /logs e todos os arquivos que estão dentro
6- /tmp e todas as subpastas e arquivos dentro

#Inicialização local do site:

docker-compose up -d
Acessar: http://localhost:8080

# CakePHP Application Skeleton

[![Build Status](https://api.travis-ci.org/cakephp/app.png)](https://travis-ci.org/cakephp/app)
[![License](https://poser.pugx.org/cakephp/app/license.svg)](https://packagist.org/packages/cakephp/app)

A skeleton for creating applications with [CakePHP](http://cakephp.org) 3.0.

## Configuration

Read and edit `config/app.php` and setup the 'Datasources' and any other
configuration relevant for your application.
