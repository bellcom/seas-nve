<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160314145857 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE GraddageFordeling (id INT AUTO_INCREMENT NOT NULL, titel VARCHAR(255) DEFAULT NULL, januar DOUBLE PRECISION NOT NULL, februar DOUBLE PRECISION NOT NULL, marts DOUBLE PRECISION NOT NULL, april DOUBLE PRECISION NOT NULL, maj DOUBLE PRECISION NOT NULL, juni DOUBLE PRECISION NOT NULL, juli DOUBLE PRECISION NOT NULL, august DOUBLE PRECISION NOT NULL, september DOUBLE PRECISION NOT NULL, oktober DOUBLE PRECISION NOT NULL, november DOUBLE PRECISION NOT NULL, december DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Bygning ADD baseline_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Bygning ADD CONSTRAINT FK_FD908E37DC280AA8 FOREIGN KEY (baseline_id) REFERENCES Baseline (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FD908E37DC280AA8 ON Bygning (baseline_id)');
        $this->addSql('ALTER TABLE Bygning_audit ADD baseline_id INT DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE GraddageFordeling');
        $this->addSql('ALTER TABLE Bygning DROP FOREIGN KEY FK_FD908E37DC280AA8');
        $this->addSql('DROP INDEX UNIQ_FD908E37DC280AA8 ON Bygning');
        $this->addSql('ALTER TABLE Bygning DROP baseline_id');
        $this->addSql('ALTER TABLE Bygning_audit DROP baseline_id');
    }
}
