# Configuracao do site

## Base de dados

1. Criar a base de dados `tblai`.
2. Rodar o script principal:

```
sql/_schema.sql
```

3. (Opcional) Inserir dados de cidades e estados:

```
sql/hom_database_cidades_uf.sql
sql/hom_database_data.sql
```

4. Outros scripts:

```
sql/importador-agentes.sql
sql/pedidos_moderacoes_trigger.sql
```

## PHP

1. Em `config/app.php`, configurar o acesso ao banco (a partir da linha 210).
2. Em `config/bootstrap.php`, configurar a URL local (linha 201).

## Permissoes de pastas

Garantir leitura e escrita em:

- /logs e todos os arquivos dentro
- /tmp e todas as subpastas e arquivos dentro

# Inicializacao local do site

Subir containers:

```
docker-compose up -d
```

Acessar:

- http://localhost:8080

# CakePHP Application Skeleton

A skeleton for creating applications with CakePHP 3.0.

## Configuration

Read and edit `config/app.php` and setup the `Datasources` and any other configuration relevant for your application.
