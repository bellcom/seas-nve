<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190916130111 extends AbstractMigration
{
    private $data = array();
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {

        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Virksomhed ADD bygninger_ean_number LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD bygninger_p_number LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', DROP ean_numbers, DROP p_numbers');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Virksomhed ADD ean_numbers TINYTEXT DEFAULT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:array)\', ADD p_numbers TINYTEXT DEFAULT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:array)\', DROP bygninger_ean_number, DROP bygninger_p_number');
    }
}
