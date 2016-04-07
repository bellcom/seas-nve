<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160407153200 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Forsyningsvaerk ADD deletedAt DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE Forsyningsvaerk_audit ADD deletedAt DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE Klimaskaerm ADD deletedAt DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE Pumpe ADD deletedAt DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE Pumpe_audit ADD deletedAt DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE Segment ADD deletedAt DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE Segment_audit ADD deletedAt DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE Solcelle ADD deletedAt DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE Solcelle_audit ADD deletedAt DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE NyttiggjortVarme ADD deletedAt DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE NyttiggjortVarme_audit ADD deletedAt DATETIME DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Forsyningsvaerk DROP deletedAt');
        $this->addSql('ALTER TABLE Forsyningsvaerk_audit DROP deletedAt');
        $this->addSql('ALTER TABLE Klimaskaerm DROP deletedAt');
        $this->addSql('ALTER TABLE NyttiggjortVarme DROP deletedAt');
        $this->addSql('ALTER TABLE NyttiggjortVarme_audit DROP deletedAt');
        $this->addSql('ALTER TABLE Pumpe DROP deletedAt');
        $this->addSql('ALTER TABLE Pumpe_audit DROP deletedAt');
        $this->addSql('ALTER TABLE Segment DROP deletedAt');
        $this->addSql('ALTER TABLE Segment_audit DROP deletedAt');
        $this->addSql('ALTER TABLE Solcelle DROP deletedAt');
        $this->addSql('ALTER TABLE Solcelle_audit DROP deletedAt');
    }
}
