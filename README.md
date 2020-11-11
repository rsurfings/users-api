# Users API
[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](https://opensource.org/licenses/MIT)
This repository allows the creation of a Docker environment that meets
[Lumen 8.x](https://lumen.laravel.com/docs/8.x#server-requirements) requirements.

## Architecture
![Architecture overview](support/docs/architecture.png "Architecture")

## Uso
### Começo rápido
Os comandos devem ser executados na pasta de destino clonada

```
# Repositório de clonagem
$ git clone https://github.com/rsurfings/users-api.git <sua-pasta>
```

```
# Construindo containers
$ cd <sua-pasta> && docker-compose up --build
```

```
# Instalando
$ docker-compose exec users-api composer install
```

```
# Testando
$ docker-compose exec users-api ./vendor/bin/phpunit --testdox
```

```
# Testar a api em chamada externa é necessário criar as tabelas fazendo as migrações
$ docker-compose exec users-api php artisan migrate
```

## Problema

Temos 2 tipos de usuários(users), os comuns(consumers) e lojistas(sellers), ambos têm carteira com dinheiro e realizam transferências(transactions) entre eles. Vamos nos atentar **somente** ao fluxo de transferência(transactions) entre dois usuários(users).

Requisitos:

- Para ambos tipos de usuário, precisamos do Nome Completo, CPF, e-mail e Senha. CPF/CNPJ e e-mails devem ser únicos no sistema. Sendo assim, seu sistema deve permitir apenas um cadastro com o mesmo CPF ou endereço de e-mail.

- Usuários podem enviar dinheiro (efetuar transferência) para lojistas e entre usuários. 

- Lojistas **só recebem** transferências, não enviam dinheiro para ninguém.

- Antes de finalizar a transferência, deve-se consultar um serviço autorizador externo, use este mock para simular (https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6).

- A operação de transferência deve ser uma transação (ou seja, revertida em qualquer caso de inconsistência) e o dinheiro deve voltar para a carteira do usuário que envia. 

- No recebimento de pagamento, o usuário ou lojista precisa receber notificação enviada por um serviço de terceiro e eventualmente este serviço pode estar indisponível/instável. Use este mock para simular o envio (https://run.mocky.io/v3/b19f7b9f-9cbf-4fc6-ad22-dc30601aec04).

- Este serviço deve ser RESTFul.

### Payload

POST /transaction

```json
{
    "value" : 100.00,
    "payer" : 4,
    "payee" : 15
}
```

## Instrução

- A API é mapeada para a porta 8000 em seu localhost, para [chamadas de API](http://localhost:8000) a requisição GET localhost:8000/ vai retornar a versão do framework em execução.

- Você pode usar o [Postman](https://www.postman.com/downloads) para testar as chamadas de API

- A [documentação da API](http://localhost:8001) está disponível no formato [swegger 2.0](https://swagger.io/tools/swagger-editor)

- Os Dockerfiles estão localizados na pasta support/docker

- O arquivo de documentação está localizado na pasta support/docs

- Usamos Redis para cache e sua porta padrão 6379

## Materiais úteis
- http://br.phptherightway.com/
- https://www.php-fig.org/psr/psr-12/
- https://www.atlassian.com/continuous-delivery/software-testing/types-of-software-testing
- https://github.com/exakat/php-static-analysis-tools
- https://martinfowler.com/articles/microservices.html
- https://docs.docker.com/develop/develop-images/dockerfile_best-practices/
- https://lumen.laravel.com/docs/8.x
