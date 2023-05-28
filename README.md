# Purchase Records API

Implementation of SUNAT purchase records using DDD.

## Start dev environment

1. Run the docker container services:

```
docker-compose up
```

2. To enter the web container use:

```
docker exec -it invoicing-web-1 sh
```

3. Install dependencies (on sh):

```
composer install
```

4. Clone the `.env.example` file to `.env` and replace the variables for your own.
5. Run the migrations (on sh):

```
php artisan migrate
```

6. Enter to `http://localhost:8090` to use the api.

## Build the docs

1. Install node.
2. Run `npm install -g swagger-cli`
3. Go to docs folder and run `swagger-cli bundle openapi.yml --outfile _build/openapi.yml --type yaml`
4. You can check the full overview of openapi docs on `docs/_build/openapi.yml`
