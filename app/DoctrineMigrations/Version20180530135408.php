<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180530135408 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Tiltag DROP deleted_at');
        $this->addSql('ALTER TABLE Tiltag_audit DROP deleted_at');
        $this->addSql('ALTER TABLE BelysningTiltagDetail_NyStyring CHANGE deleted_at deactivated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE Bygning DROP deleted_at');
        $this->addSql('ALTER TABLE Bygning_audit DROP deleted_at');
        $this->addSql('ALTER TABLE Forsyningsvaerk DROP deletedAt');
        $this->addSql('ALTER TABLE Forsyningsvaerk_audit DROP deletedAt');
        $this->addSql('ALTER TABLE Klimaskaerm DROP deletedAt');
        $this->addSql('ALTER TABLE Pumpe DROP deletedAt');
        $this->addSql('ALTER TABLE Pumpe_audit DROP deletedAt');
        $this->addSql('ALTER TABLE Segment DROP deletedAt');
        $this->addSql('ALTER TABLE Segment_audit DROP deletedAt');
        $this->addSql('ALTER TABLE Solcelle DROP deletedAt');
        $this->addSql('ALTER TABLE Solcelle_audit DROP deletedAt');
        $this->addSql('ALTER TABLE Komponent DROP deletedAt');
        $this->addSql('ALTER TABLE NyttiggjortVarme DROP deletedAt');
        $this->addSql('ALTER TABLE NyttiggjortVarme_audit DROP deletedAt');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE BelysningTiltagDetail_NyStyring CHANGE deactivated_at deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE Bygning ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE Bygning_audit ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE Forsyningsvaerk ADD deletedAt DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE Forsyningsvaerk_audit ADD deletedAt DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE Klimaskaerm ADD deletedAt DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE Komponent ADD deletedAt DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE NyttiggjortVarme ADD deletedAt DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE NyttiggjortVarme_audit ADD deletedAt DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE Pumpe ADD deletedAt DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE Pumpe_audit ADD deletedAt DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE Segment ADD deletedAt DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE Segment_audit ADD deletedAt DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE Solcelle ADD deletedAt DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE Solcelle_audit ADD deletedAt DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE Tiltag ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE Tiltag_audit ADD deleted_at DATETIME DEFAULT NULL');
    }
}
