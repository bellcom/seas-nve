<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190830060103 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Tiltag DROP besparelseInvestering, DROP besparelseVedligehold');
        $this->addSql('ALTER TABLE Tiltag_audit DROP besparelseInvestering, DROP besparelseVedligehold');
        $this->addSql('ALTER TABLE Rapport ADD co2BesparelseBraendstof DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE Rapport_audit ADD co2BesparelseBraendstof DOUBLE PRECISION DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Rapport DROP co2BesparelseBraendstof');
        $this->addSql('ALTER TABLE Rapport_audit DROP co2BesparelseBraendstof');
        $this->addSql('ALTER TABLE Tiltag ADD besparelseInvestering NUMERIC(14, 4) DEFAULT NULL, ADD besparelseVedligehold NUMERIC(14, 4) DEFAULT NULL');
        $this->addSql('ALTER TABLE Tiltag_audit ADD besparelseInvestering NUMERIC(14, 4) DEFAULT NULL, ADD besparelseVedligehold NUMERIC(14, 4) DEFAULT NULL');
    }
}
