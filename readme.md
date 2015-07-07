# Setting up Symfony

```
git clone git@github.com:aakb/aaplus.git htdocs
composer install
```

# Create Database & update schema

```
php app/console doctrine:database:create
php app/console doctrine:schema:update --force
```

# Import data

1. Copy Excel files from Dropbox into the fixtures folder:

    ```
    mkdir -p src/AppBundle/DataFixtures/Data/Excel
    rm src/AppBundle/DataFixtures/Data/Excel/*.xlsm
	rm src/AppBundle/DataFixtures/Data/fixtures/*
    cp -v ~/Dropbox*/Dokumentation/Websites/Aa+/Dokumenter/fixtures/*.xlsm src/AppBundle/DataFixtures/Data/Excel
    ```

2. Load the fixtures (inside Vagrant box):

    ```
    php app/console doctrine:fixtures:load --purge-with-truncate
    ```

# Run unit tests

1. [Install PHPUnit](https://phpunit.de/manual/current/en/installation.html) if not already done

2. Import fixtures and generate unit test data (see above)

    ```
    DUMP_UNITTEST_DATA=php php app/console doctrine:fixtures:load --purge-with-truncate --no-interaction
    ```

3. Run unit tests

    ```
    phpunit -c app src/AppBundle/Tests/Entity
    ```
