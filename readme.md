# Aa+

Rådgiverværktøjet stilles vederlagsfrit til rådighed under henvisning til, at
dette vil bidrage til at fremme en lovlig kommunal interesse i
miljøet/energibesparelser, hvilket sker på baggrund af

Hortens juridiske vurdering (10.5.2019) af de kommunalretlige forhold vedrørende
Rådgiverværktøjet og efterfølgende interne vurdering af underleverandørers
immaterielle rettigheder jf. kontrakter og øvrige sagsdokumenter.

# Release

The installation instructions have been tested succesfully on an `Ubuntu 16.04 LTS` server.

Project has been adjusted for using for SEAS-NVE. Some values in code have been changed because of hardcoded values 
declaration. Example:
```
// @SEAS-NVE adaptation begin.
...
# Hardcoded values declaration.
...
// @SEAS-NVE adaptation end.
```
All these hardcoded cases should be refactored to use configuration/translation layer instead. See example:`src/AppBundle/Resources/translations/messages.da_SEASNVE.yml`   

## Installation

Make sure that your environment has proper software versions.
 1. PHP version `5.6`.
 2. Composer has version 1.6.3.
 3. Create a [MariaDB](https://mariadb.org/) (recommened) or a
[MySql](https://www.mysql.com/) database; you'll need the database
`host`, `name`, `user` and `password` shortly.

Clone the code:

```sh
git clone --branch=develop https://github.com/bellcom/seas-nve
cd seas-nve
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

№# Maintenance
№## Audit tables cleanup

The solution is keeping the record or audit of entries in special tables (suffixed by **_audit**).

By default the deletion of an entity does not remove the related records from audit tables.
In order to do a cleanup, a console command has been created:
```
SYMFONY_ENV=prod app/console seas-nve:audit-entities-cleanup
```

It is recommended to run this command periodically to keep the database tables clean.

## Known issues

After all installation steps it's possible you will get errors for some pages.

1. Configuration pages `/belysningtiltagdetail_nytarmatur` and `/belysningtiltagdetail_erstatningslyskilde` requires [`intl` php extension](https://www.php.net/manual/en/book.intl.php) on server.

2. General configuration page `/configuration`. Configuration entity has inconsistency in default values for keys `mtmFaellesomkostningerNulHvisArealMindreEnd` and `mtmFaellesomkostningerNulHvisTotalEntreprisesumMindreEnd`. You can update `Configuration` table manually and set these keys as nullable.

3. Create building page `/bygning/new` requires groups: `Aa+`, `Rådgiver`, `Interessent` in system. These groups are not created by default. You can add/(copy and rename) them in db (` fos_group` table) manually.

4. Project includes pdf converting process that based on [KnpSnappyBundle](https://github.com/KnpLabs/KnpSnappyBundle) component. It requires [wkhtmltopdf](https://wkhtmltopdf.org/)  `>= 0.12.2` tool to be install on server.

4.1 You may need to add you project host to `/etc/hosts`, to allow `wkhtmltopdf` tool resolves paths to images and sources from html content that going to be converted.

4.2 Allow system save temporary data to tmp folder. Check key `sys_temp_dir` and set it to accessible for webserver directory.

4.3 You might need a patched QT version of "wkhtmltopdf"

4.3 You might need to install one or more of these libraries:
  - libxrender1
  - libfontconfig1
  - libx11-dev
  - libjpeg62
  - libxtst6
  
See: https://github.com/barryvdh/laravel-snappy/issues/68#issuecomment-314012014