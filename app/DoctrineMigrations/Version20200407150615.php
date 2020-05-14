<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20200407150615 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE TiltagDetail ADD energiTypePrimaerFoer VARCHAR(255) DEFAULT NULL, ADD energiForbrugPrimaerFoer LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD varmePumpeForbrug LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE TiltagDetail_audit ADD energiTypePrimaerFoer VARCHAR(255) DEFAULT NULL, ADD energiForbrugPrimaerFoer LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD varmePumpeForbrug LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE Configuration ADD varmeEnergiFaktor LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', ADD varmePumpeFaktor LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE Configuration_audit ADD varmeEnergiFaktor LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD varmePumpeFaktor LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('UPDATE Configuration SET varmePumpeFaktor="a:0:{}" WHERE varmePumpeFaktor = ""');
        $this->addSql('UPDATE Configuration_audit SET varmePumpeFaktor="a:0:{}" WHERE varmePumpeFaktor = ""');
        $this->addSql('UPDATE Configuration SET varmeEnergiFaktor="a:0:{}" WHERE varmeEnergiFaktor = ""');
        $this->addSql('UPDATE Configuration_audit SET varmeEnergiFaktor="a:0:{}" WHERE varmeEnergiFaktor = ""');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Configuration DROP varmeEnergiFaktor, DROP varmePumpeFaktor');
        $this->addSql('ALTER TABLE Configuration_audit DROP varmeEnergiFaktor, DROP varmePumpeFaktor');
        $this->addSql('ALTER TABLE TiltagDetail DROP energiTypePrimaerFoer, DROP energiForbrugPrimaerFoer, DROP varmePumpeForbrug');
        $this->addSql('ALTER TABLE TiltagDetail_audit DROP energiTypePrimaerFoer, DROP energiForbrugPrimaerFoer, DROP varmePumpeForbrug');
    }
}
