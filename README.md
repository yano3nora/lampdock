lampdock.
===============

> posted: 2019.06.04  
> author: hyano@ampware.jp

## OVERVIEW
The Docker boilerplate for LAMP environment.

### Composition.
- php 7.2.x
- apache 2.4.x
- mysql 5.7.x

### DEPLOYMENT
```sh
# Set .env file.
$ cp .env.development .env

# Build containers.
$ docker-compose build
$ docker-compose run --rm db mysqld --initialize  # Only at first build.
$ docker-compose up

# Login to app container.
$ docker-compose exec web bash

# e.g. Install PHP framework that like the Laravel ...
app> composer create-project --prefer-dist laravel/laravel laravel
app> cd laravel
app> php artisan key:generate --show
     > base64:xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
app> exit

# Fix web root setting by env.
$ vi .env
  > # WEB_ROOT=/var/www/html
  > WEB_ROOT=/var/www/laravel/public

# Fix framework setting by env.
#
# ## NOTE ##
# laravel/.env is ignored,
# if there is a system environment variable of the same name.
# ##########
#
$ vi .env
  > APP_KEY=base64:xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
  > DB_HOST=db

# Rebuild containers.
$ docker-compose down
$ docker-compose build
$ docker-compose up
```
