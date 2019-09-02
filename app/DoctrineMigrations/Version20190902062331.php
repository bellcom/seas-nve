<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190902062331 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Tiltag ADD besparelseCo2Braendstof NUMERIC(14, 4) DEFAULT NULL, CHANGE placering placering VARCHAR(10000) DEFAULT NULL');
        $this->addSql('ALTER TABLE Tiltag_audit ADD besparelseCo2Braendstof NUMERIC(14, 4) DEFAULT NULL, CHANGE placering placering VARCHAR(10000) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Tiltag DROP besparelseCo2Braendstof, CHANGE placering placering VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE Tiltag_audit DROP besparelseCo2Braendstof, CHANGE placering placering VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
    }
}
