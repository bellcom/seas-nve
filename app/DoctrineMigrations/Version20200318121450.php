<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20200318121450 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE TiltagDetail ADD laengdeVentileretRum DOUBLE PRECISION DEFAULT NULL, ADD breddeVentileretRum DOUBLE PRECISION DEFAULT NULL, ADD hoejdeVentileterRum VARCHAR(255) DEFAULT NULL, ADD antalPersoner INT DEFAULT NULL, ADD udeluftTilfoersel DOUBLE PRECISION DEFAULT NULL, ADD forurening VARCHAR(255) DEFAULT NULL, ADD kvalitet VARCHAR(255) DEFAULT NULL, ADD indDataFoer LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD indDataEfter LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD udeluftbehov LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD varmeForbrugMaaneligeFoer LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD varmeForbrugMaaneligeEfter LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD co2PpmIRum INT DEFAULT NULL');
        $this->addSql('ALTER TABLE TiltagDetail_audit ADD laengdeVentileretRum DOUBLE PRECISION DEFAULT NULL, ADD breddeVentileretRum DOUBLE PRECISION DEFAULT NULL, ADD hoejdeVentileterRum VARCHAR(255) DEFAULT NULL, ADD antalPersoner INT DEFAULT NULL, ADD udeluftTilfoersel DOUBLE PRECISION DEFAULT NULL, ADD forurening VARCHAR(255) DEFAULT NULL, ADD kvalitet VARCHAR(255) DEFAULT NULL, ADD indDataFoer LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD indDataEfter LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD udeluftbehov LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD varmeForbrugMaaneligeFoer LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD varmeForbrugMaaneligeEfter LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD co2PpmIRum INT DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE TiltagDetail DROP laengdeVentileretRum, DROP breddeVentileretRum, DROP hoejdeVentileterRum, DROP antalPersoner, DROP udeluftTilfoersel, DROP forurening, DROP kvalitet, DROP indDataFoer, DROP indDataEfter, DROP udeluftbehov, DROP varmeForbrugMaaneligeFoer, DROP varmeForbrugMaaneligeEfter, DROP co2PpmIRum');
        $this->addSql('ALTER TABLE TiltagDetail_audit DROP laengdeVentileretRum, DROP breddeVentileretRum, DROP hoejdeVentileterRum, DROP antalPersoner, DROP udeluftTilfoersel, DROP forurening, DROP kvalitet, DROP indDataFoer, DROP indDataEfter, DROP udeluftbehov, DROP varmeForbrugMaaneligeFoer, DROP varmeForbrugMaaneligeEfter, DROP co2PpmIRum');
    }
}
