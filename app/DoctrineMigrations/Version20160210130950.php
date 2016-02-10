<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160210130950 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Bilag ADD tiltag_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Bilag ADD CONSTRAINT FK_4CC2D8E4C3E4D9C4 FOREIGN KEY (tiltag_id) REFERENCES Tiltag (id)');
        $this->addSql('CREATE INDEX IDX_4CC2D8E4C3E4D9C4 ON Bilag (tiltag_id)');
        $this->addSql('ALTER TABLE Bilag_audit ADD tiltag_id INT DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Bilag DROP FOREIGN KEY FK_4CC2D8E4C3E4D9C4');
        $this->addSql('DROP INDEX IDX_4CC2D8E4C3E4D9C4 ON Bilag');
        $this->addSql('ALTER TABLE Bilag DROP tiltag_id');
        $this->addSql('ALTER TABLE Bilag_audit DROP tiltag_id');
    }
}
