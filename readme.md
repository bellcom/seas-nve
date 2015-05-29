# Setting up Symfony

`git clone git@github.com:aakb/aaplus.git htdocs`
`composer install`

# Create Database & update schema

`php app/console doctrine:database:create`
`php app/console doctrine:schema:update --force`


# Import data

To import data for the reference tables please add csv files from Dropbox (Aaplus/Dokumentation/Export) 
to AppBundle/DataFixtures/Data and run the import
 
`php app/console doctrine:fixtures:load --purge-with-truncate`



