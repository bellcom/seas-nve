# Aa+

The installation instructions have been tested succesfully on an `Ubuntu 16.04 LTS` server.

## Installation

Make sure that you're running `PHP 5.6`:

```sh
php -v
```

Create a [MariaDB](https://mariadb.org/) (recommened) or a
[MySql](https://www.mysql.com/) database; you'll need the database
`host`, `name`, `user` and `password` shortly.

Clone the code:

```sh
git clone --branch=seas-nve https://github.com/mtm-aarhus/aaplus
cd aaplus
```

Install [`composer`](https://getcomposer.org/) packages (you'll be asked for `database` and `mailer` settings during the installation):

```
SYMFONY_ENV=prod composer install --no-dev --optimize-autoloader
```

Install assets and update the database schema:

```
SYMFONY_ENV=prod app/console assets:install --symlink
SYMFONY_ENV=prod app/console cache:clear --no-warmup
SYMFONY_ENV=prod app/console cache:warmup
SYMFONY_ENV=prod app/console doctrine:migrations:migrate --no-interaction
```

```sh
SYMFONY_ENV=prod app/console aaplus:post-migrate
SYMFONY_ENV=prod app/console aaplus:post-migrate:20160711133430
```

Set file system permissions: https://symfony.com/doc/2.7/setup/file_permissions.html

Create a super administrator user:

```sh
SYMFONY_ENV=prod app/console fos:user:create --super-admin
```

Finally, set up a web server as described on https://symfony.com/doc/2.7/setup/web_server_configuration.html.
