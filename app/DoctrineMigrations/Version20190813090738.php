<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190813090738 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Bygning ADD cvr_number VARCHAR(255) DEFAULT NULL, ADD ean_number VARCHAR(255) DEFAULT NULL, ADD p_number VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE Bygning_audit ADD cvr_number VARCHAR(255) DEFAULT NULL, ADD ean_number VARCHAR(255) DEFAULT NULL, ADD p_number VARCHAR(255) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Bygning DROP cvr_number, DROP ean_number, DROP p_number');
        $this->addSql('ALTER TABLE Bygning_audit DROP cvr_number, DROP ean_number, DROP p_number');
    }
}
