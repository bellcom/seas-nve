<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161201160540 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Bygning ADD projekterende_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Bygning ADD CONSTRAINT FK_FD908E37A5FFAEA0 FOREIGN KEY (projekterende_id) REFERENCES fos_user (id)');
        $this->addSql('CREATE INDEX IDX_FD908E37A5FFAEA0 ON Bygning (projekterende_id)');
        $this->addSql('ALTER TABLE Bygning_audit ADD projekterende_id INT DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Bygning DROP FOREIGN KEY FK_FD908E37A5FFAEA0');
        $this->addSql('DROP INDEX IDX_FD908E37A5FFAEA0 ON Bygning');
        $this->addSql('ALTER TABLE Bygning DROP projekterende_id');
        $this->addSql('ALTER TABLE Bygning_audit DROP projekterende_id');
    }
}
