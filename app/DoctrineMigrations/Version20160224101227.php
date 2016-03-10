<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160224101227 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Tiltag CHANGE risikovurderingAendringIBesparelseFaktor risikovurderingAendringIBesparelseFaktor DOUBLE PRECISION DEFAULT NULL, CHANGE risikovurderingOekonomiskKompenseringIftInvesteringFaktor risikovurderingOekonomiskKompenseringIftInvesteringFaktor DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE Tiltag_audit CHANGE risikovurderingAendringIBesparelseFaktor risikovurderingAendringIBesparelseFaktor DOUBLE PRECISION DEFAULT NULL, CHANGE risikovurderingOekonomiskKompenseringIftInvesteringFaktor risikovurderingOekonomiskKompenseringIftInvesteringFaktor DOUBLE PRECISION DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Tiltag CHANGE risikovurderingAendringIBesparelseFaktor risikovurderingAendringIBesparelseFaktor NUMERIC(10, 0) DEFAULT NULL, CHANGE risikovurderingOekonomiskKompenseringIftInvesteringFaktor risikovurderingOekonomiskKompenseringIftInvesteringFaktor NUMERIC(10, 0) DEFAULT NULL');
        $this->addSql('ALTER TABLE Tiltag_audit CHANGE risikovurderingAendringIBesparelseFaktor risikovurderingAendringIBesparelseFaktor NUMERIC(10, 0) DEFAULT NULL, CHANGE risikovurderingOekonomiskKompenseringIftInvesteringFaktor risikovurderingOekonomiskKompenseringIftInvesteringFaktor NUMERIC(10, 0) DEFAULT NULL');
    }
}
