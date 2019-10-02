<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20191002135753 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Baseline DROP FOREIGN KEY FK_F6FB110206C32AA');
        $this->addSql('DROP INDEX UNIQ_F6FB1109D62CEA9 ON Baseline');
        $this->addSql('ALTER TABLE Baseline DROP virksomhed_id');
        $this->addSql('ALTER TABLE Baseline_audit DROP virksomhed_id');
        $this->addSql('ALTER TABLE VirksomhedKortlaegning DROP FOREIGN KEY FK_F9C1C5649D62CEA9');
        $this->addSql('DROP INDEX UNIQ_F9C1C5649D62CEA9 ON VirksomhedKortlaegning');
        $this->addSql('ALTER TABLE VirksomhedKortlaegning DROP virksomhed_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Baseline ADD virksomhed_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Baseline ADD CONSTRAINT FK_F6FB110206C32AA FOREIGN KEY (virksomhed_id) REFERENCES Virksomhed (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F6FB1109D62CEA9 ON Baseline (virksomhed_id)');
        $this->addSql('ALTER TABLE Baseline_audit ADD virksomhed_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE VirksomhedKortlaegning ADD virksomhed_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE VirksomhedKortlaegning ADD CONSTRAINT FK_F9C1C5649D62CEA9 FOREIGN KEY (virksomhed_id) REFERENCES Virksomhed (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F9C1C5649D62CEA9 ON VirksomhedKortlaegning (virksomhed_id)');
    }
}
