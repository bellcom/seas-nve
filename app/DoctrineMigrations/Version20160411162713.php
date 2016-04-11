<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160411162713 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE BaselineKorrektion CHANGE datoForImplementering datoForImplementering DATE DEFAULT NULL, CHANGE beskrivelse beskrivelse LONGTEXT DEFAULT NULL, CHANGE korrektionEl korrektionEl NUMERIC(10, 0) DEFAULT NULL, CHANGE korrektionGAF korrektionGAF NUMERIC(10, 0) DEFAULT NULL, CHANGE korrektionGUF korrektionGUF NUMERIC(10, 0) DEFAULT NULL, CHANGE kilde kilde VARCHAR(255) DEFAULT NULL, CHANGE indvirkning indvirkning TINYINT(1) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE BaselineKorrektion CHANGE datoForImplementering datoForImplementering DATE NOT NULL, CHANGE beskrivelse beskrivelse LONGTEXT NOT NULL COLLATE utf8_unicode_ci, CHANGE korrektionEl korrektionEl NUMERIC(10, 0) NOT NULL, CHANGE korrektionGAF korrektionGAF NUMERIC(10, 0) NOT NULL, CHANGE korrektionGUF korrektionGUF NUMERIC(10, 0) NOT NULL, CHANGE kilde kilde VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE indvirkning indvirkning TINYINT(1) NOT NULL');
    }
}
