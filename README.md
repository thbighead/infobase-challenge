# Infobase Challenge

Execute o seguinte comando na pasta raíz do proejto via terminal:

```
php -r "file_exists('.env') || copy('.env.example', '.env');"
```

Configure o arquivo `.env` criado dando atenção às credenciais do banco que ficam nos campos com prefixo `DB_`. Você
deve criar a base de dados que informar nestes campos da maneira que preferir. Será necessário configurar um
*maildriver* nos campos que têm prefixo `MAIL_`.

A seguir execute os seguintes comandos em ordem:

```
composer install
php artisan key:generate
php artisan migrate --seed
```