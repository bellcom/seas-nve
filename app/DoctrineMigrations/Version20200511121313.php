<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20200511121313 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Tiltag DROP tilskudsstoerrelse, DROP samletTilskud');
        $this->addSql('ALTER TABLE Tiltag_audit DROP tilskudsstoerrelse, DROP samletTilskud');
        $this->addSql('ALTER TABLE Rapport DROP samletTilskud');
        $this->addSql('ALTER TABLE Rapport_audit DROP samletTilskud');
        $this->addSql('ALTER TABLE Virksomhed DROP tilskudstorelse');
        $this->addSql('ALTER TABLE VirksomhedRapport DROP samletTilskud');
        $this->addSql('ALTER TABLE VirksomhedRapport_audit DROP samletTilskud');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Rapport ADD samletTilskud DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE Rapport_audit ADD samletTilskud DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE Tiltag ADD tilskudsstoerrelse DOUBLE PRECISION DEFAULT NULL, ADD samletTilskud DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE Tiltag_audit ADD tilskudsstoerrelse DOUBLE PRECISION DEFAULT NULL, ADD samletTilskud DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE Virksomhed ADD tilskudstorelse NUMERIC(10, 4) DEFAULT NULL');
        $this->addSql('ALTER TABLE VirksomhedRapport ADD samletTilskud DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE VirksomhedRapport_audit ADD samletTilskud DOUBLE PRECISION DEFAULT NULL');
    }
}
