<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20200526144324 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Tiltag ADD nutidsvaerdiSet LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD akkumuleretNutidsvaerdiSet LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD cashFlowSet LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE Tiltag_audit ADD nutidsvaerdiSet LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD akkumuleretNutidsvaerdiSet LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD cashFlowSet LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE Rapport ADD nutidsvaerdiSet LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD akkumuleretNutidsvaerdiSet LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE Rapport_audit ADD nutidsvaerdiSet LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD akkumuleretNutidsvaerdiSet LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE Configuration ADD nutidsvaerdiBeregnAar NUMERIC(10, 0) NOT NULL');
        $this->addSql('ALTER TABLE Configuration_audit ADD nutidsvaerdiBeregnAar NUMERIC(10, 0) DEFAULT NULL');
        $this->addSql('UPDATE Tiltag SET nutidsvaerdiSet = "a:0:{}" WHERE 1 = 1');
        $this->addSql('UPDATE Tiltag SET akkumuleretNutidsvaerdiSet = "a:0:{}" WHERE 1 = 1');
        $this->addSql('UPDATE Tiltag SET cashFlowSet = "a:0:{}" WHERE 1 = 1');
        $this->addSql('UPDATE Tiltag_audit SET nutidsvaerdiSet = "a:0:{}" WHERE 1 = 1');
        $this->addSql('UPDATE Tiltag_audit SET akkumuleretNutidsvaerdiSet = "a:0:{}" WHERE 1 = 1');
        $this->addSql('UPDATE Tiltag_audit SET cashFlowSet = "a:0:{}" WHERE 1 = 1');
        $this->addSql('UPDATE Rapport SET nutidsvaerdiSet = "a:0:{}" WHERE 1 = 1');
        $this->addSql('UPDATE Rapport SET akkumuleretNutidsvaerdiSet = "a:0:{}" WHERE 1 = 1');
        $this->addSql('UPDATE Rapport_audit SET nutidsvaerdiSet = "a:0:{}" WHERE 1 = 1');
        $this->addSql('UPDATE Rapport_audit SET akkumuleretNutidsvaerdiSet = "a:0:{}" WHERE 1 = 1');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Configuration DROP nutidsvaerdiBeregnAar');
        $this->addSql('ALTER TABLE Configuration_audit DROP nutidsvaerdiBeregnAar');
        $this->addSql('ALTER TABLE Rapport DROP nutidsvaerdiSet, DROP akkumuleretNutidsvaerdiSet');
        $this->addSql('ALTER TABLE Rapport_audit DROP nutidsvaerdiSet, DROP akkumuleretNutidsvaerdiSet');
        $this->addSql('ALTER TABLE Tiltag DROP nutidsvaerdiSet, DROP akkumuleretNutidsvaerdiSet, DROP cashFlowSet');
        $this->addSql('ALTER TABLE Tiltag_audit DROP nutidsvaerdiSet, DROP akkumuleretNutidsvaerdiSet, DROP cashFlowSet');
    }
}
