<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190927115805 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Rapport ADD samletEnergibesparelse DOUBLE PRECISION DEFAULT NULL, ADD samletEnergibesparelseKr DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE Rapport_audit ADD samletEnergibesparelse DOUBLE PRECISION DEFAULT NULL, ADD samletEnergibesparelseKr DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE VirksomhedRapport ADD samletEnergibesparelse DOUBLE PRECISION DEFAULT NULL, ADD samletEnergibesparelseKr DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE VirksomhedRapport_audit ADD samletEnergibesparelse DOUBLE PRECISION DEFAULT NULL, ADD samletEnergibesparelseKr DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE Virksomhed CHANGE subsidy_size tilskudstorelse NUMERIC(10, 4) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Rapport DROP samletEnergibesparelse, DROP samletEnergibesparelseKr');
        $this->addSql('ALTER TABLE Rapport_audit DROP samletEnergibesparelse, DROP samletEnergibesparelseKr');
        $this->addSql('ALTER TABLE VirksomhedRapport DROP samletEnergibesparelse, DROP samletEnergibesparelseKr');
        $this->addSql('ALTER TABLE VirksomhedRapport_audit DROP samletEnergibesparelse, DROP samletEnergibesparelseKr');
        $this->addSql('ALTER TABLE Virksomhed CHANGE tilskudstorelse subsidy_size NUMERIC(10, 4) DEFAULT NULL');
    }
}
