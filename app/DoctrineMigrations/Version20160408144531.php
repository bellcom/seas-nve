<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160408144531 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE BaselineKorrektion (id INT AUTO_INCREMENT NOT NULL, baseline_id INT DEFAULT NULL, datoForImplementering DATE NOT NULL, beskrivelse LONGTEXT NOT NULL, korrektionEl NUMERIC(10, 0) NOT NULL, korrektionGAF NUMERIC(10, 0) NOT NULL, korrektionGUF NUMERIC(10, 0) NOT NULL, kilde VARCHAR(255) NOT NULL, indvirkning TINYINT(1) NOT NULL, createdBy VARCHAR(255) DEFAULT NULL, updatedBy VARCHAR(255) DEFAULT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, INDEX IDX_49553E95DC280AA8 (baseline_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE BaselineKorrektion ADD CONSTRAINT FK_49553E95DC280AA8 FOREIGN KEY (baseline_id) REFERENCES Baseline (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE BaselineKorrektion');
    }
}
