# PHP Challenge 20200916

Esta aplicação é uma API REST que utiliza dados do projeto Open Food Facts para popular sua base de dados

## Instalação e configuração da API

Faça o clone do respositório
```bash
git clone https://github.com/Ronildo-Sousa/php-challenge.git
```

Na pasta do projeto instale as dependências
```docker
docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v $(pwd):/var/www/html \
        -w /var/www/html \
        laravelsail/php81-composer:latest \
        composer install --ignore-platform-reqs
```

Crie o arquivo .env
```bash
cp .env.example .env
```

Inicialize o container do Laravel Sail
```bash
./vendor/bin/sail up -d
```

Crie a chave da aplicação
```bash
./vendor/bin/sail artisan key:generate
```

Execute as migrations e seeders
```bash
./vendor/bin/sail artisan migrate --seed
```

## Endpoints

Acesse a [documentação](http://localhost/api/documentation) para mais detalhes.

Método   | URI
--------- | ------
GET | localhost/api/products
GET | localhost/api/products/{code}
PUT | localhost/api/products/{code}
DELETE | localhost/api/products/{code}
